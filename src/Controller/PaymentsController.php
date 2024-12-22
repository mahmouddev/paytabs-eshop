<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\ModelAwareTrait;
use Cake\Http\Client;
use Cake\Http\Exception\BadRequestException;
use Cake\Log\Log;
use Cake\Routing\Router;
use Cake\Validation\Validator;

/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 */
class PaymentsController extends AppController
{

    use ModelAwareTrait;

    public $Orders;
    public $Products;

    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();


        // Load the Orders model
        $this->Orders = $this->fetchModel('Orders');

        // Load the Products model
        $this->Products = $this->fetchModel('Products');

        $this->Authentication->allowUnauthenticated(['initializeHostedPaymentPage', 'return']);
    }


    public function initializeHostedPaymentPage()
    {

        $this->request->allowMethod(['post']); // Ensure the method is POST

        $data = $this->request->getData();

        if (empty($data['cart']) || empty($data['customer']) || empty($data['deliveryOption'])) {
            throw new BadRequestException("Invalid request data.");
        }

        // Validate dynamic data
        $errors = $this->validatePaymentData($data);

        if (!empty($errors)) {
            // Return validation errors
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'errors' => $errors
            ]));
        }

        $session = $this->request->getSession();
        $session->write('user.cart_id', $data['cart_id']);

        // Create an HTTP Client instance
        $http = new Client();

        // Define the endpoint URL
        $url = Configure::read('Paytabs.url');

        // Prepare the payload
        $paymentData = [
            "framed"            => true,
            "framed_return_top" => true,
            "profile_id"        =>  Configure::read('Paytabs.profileId'),
            "tran_type"         => "sale",
            "tran_class"        => "ecom",
            "cart_id"           => $data['cart_id'],
            "cart_currency"     => "EGP",
            "cart_amount"       => $data['total'],
            "cart_description"  => "Purchasing some gads from ESHOP",
            "paypage_lang"      => "en",
            "customer_details"  => [
                "name"     => $data['customer']['firstName']. ' ' .$data['customer']['lastName'],
                "email"    => $data['customer']['email'],
                "phone"    => $data['customer']['phone'],
                "country"  => $data['customer']['country'],
                "state"    => $data['customer']['state'],
                "city"     => $data['customer']['city'],
                "street1"  => $data['customer']['street1'],
                "zip"      => $data['customer']['zip'],
            ],
            "return"   => Router::url(['controller' => 'Payments', 'action' => 'return' , '_https' => true], true),
        ];

        if($data['deliveryOption'] == 'shipping'){
            $paymentData['shipping_details'] = [
                "name"     => $data['customer']['firstName']. ' ' .$data['customer']['lastName'] ." shipping",
                "email"    => $data['customer']['email'],
                "phone"    => $data['customer']['phone'],
                "country"  => $data['customer']['country'],
                "state"    => $data['customer']['state'],
                "city"     => $data['customer']['city'],
                "street1"  => $data['customer']['street1'],
                "zip"      => $data['customer']['zip'],
            ];
        }else{
            $paymentData['hide_shipping'] = true;
        }

        // Send a POST request
        $response = $http->post($url, json_encode($paymentData), [
            'headers' => [
                'Authorization' => Configure::read('Paytabs.key'),
                'Content-Type'  => 'application/json',
            ]
        ]);

        $paymentUrl = '';
        // Handle the response
        if ($response->isOk()) {

            // Decode the JSON response
            $result = $response->getJson();
            $paymentUrl = $result['redirect_url'];

            $order = $this->Orders->newEmptyEntity();

            $orderData = [
                'cart_id'          => $data['cart_id'],
                'guest_email'      => $data['customer']['email'],
                'guest_name'       => $data['customer']['firstName']. ' ' .$data['customer']['lastName'],
                'guest_phone'      => $data['customer']['phone'],
                'total'            => $data['total'],
                'delivery_method'  => $data['deliveryOption'],
                'shipping_address' => $data['customer']['country'] . ' ,'. $data['customer']['city']. ' ,'. $data['customer']['state']. ' ,'. $data['customer']['street1'],
                'payments' => [
                    [
                        'amount' => $data['total'],
                        'payment_method' => 'paytabs',
                        'transaction_id' => $result['tran_ref']
                    ]
                ]
            ];


            foreach ($data['cart'] as $cartItem) {
                $orderData['order_items'][] = [
                    'product_id' => $cartItem['id'],
                    'quantity'   => $cartItem['quantity'],
                    'price'      => $cartItem['price'],
                    'subtotal'   => $cartItem['quantity'] * $cartItem['price']
                ];
            }

            $order = $this->Orders->newEntity($orderData, [
                'associated' => ['OrderItems', 'Payments'], // Save nested data
            ]);

            if(!$response = $this->Orders->save($order)){

                return $this->response
                    ->withType('application/json')
                    ->withStringBody(json_encode([
                        'success' => false,
                        'error' => 'There is error saving order data'
                ]));
            }

        } else {
            // Handle error response
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'paymentUrl' => $response->getStringBody()
            ]));
        }

        // Return the success response
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'success' => true,
                'paymentUrl' => $paymentUrl
            ]));

    }

    public function return(){

        // Get the POST data
        $postData = $this->request->getData();

        $isValedRequest = $this->isValidRedirect($postData);

        // pr( $isValedRequest);
        // pr( $postData);
        // die;

        // analysis the response & update order
        if($isValedRequest){
            $transactionRefrance = $postData['tranRef'];
        }

        $paymentInstanse = $this->Payments->find()
                                ->where(['transaction_id' => $transactionRefrance ])
                                ->first();

        if($paymentInstanse ){

            $order = $this->Orders->find()
                            ->where(['id' => $paymentInstanse['order_id']])
                            ->contain(['OrderItems' => ['Products']])
                            ->first();

            // Get the connection
            $connection = ConnectionManager::get('default');

            // Start the transaction
            $connection->begin();

            try {

                // Update payment status
                $this->Payments->patchEntity($paymentInstanse, ['status' => 'paid']);
                $this->Payments->save($paymentInstanse);

                if($order){

                    // Update order status
                    $this->Orders->patchEntity($order, ['status' => 'paid']);
                    $this->Orders->save($order);

                    $productIds = array_map(function ($item) {
                        return $item->product_id;
                    }, $order->order_items);

                    // Decrement quantity
                    // Apply to specific products with positive quantity
                    $this->Products->updateAll(
                        [
                            'quantity = quantity - 1'
                        ],
                        [
                            'id IN' => $productIds,
                            'quantity >' => 0
                        ]
                    );

                }

                // Commit the transaction if everything is successful
                $connection->commit();

            }catch (\Exception $e) {

                // Rollback the transaction if there was an error
                $connection->rollback();

                // Log the error for debugging
                Log::error($e->getMessage());

                $this->Flash->error('Invalid username or password');

            }
        }

        // pr(compact('order' , 'postData'));
        // die;

        $this->set(compact('order' , 'postData'));
        // clean local cart items
        // Set a custom layout for this action
        // $this->viewBuilder()->setLayout('blank');

    }

    private function isValidRedirect($postValues){

        if (empty($postValues) || !array_key_exists('signature', $postValues)) {
            return false;
        }

        $serverKey = Configure::read('Paytabs.key');

        // Request body include a signature post Form URL encoded field
        // 'signature' (hexadecimal encoding for hmac of sorted post form fields)
        $requestSignature = $postValues["signature"];
        unset($postValues["signature"]);
        $fields = array_filter($postValues);

        // Sort form fields
        ksort($fields);

        // Generate URL-encoded query string of Post fields except signature field.
        $query = http_build_query($fields);

        return $this->isGenuine($query, $requestSignature, $serverKey);
    }

    private function isGenuine($data, $requestSignature, $serverKey)
    {
        $signature = hash_hmac('sha256', $data, $serverKey);

        if (hash_equals($signature, $requestSignature) === TRUE) {
            // VALID Redirect
            return true;
        } else {
            // INVALID Redirect
            return false;
        }
    }

    private function validatePaymentData(array $data)
    {
        $validator = new Validator();

        // Validate cart_id
        $validator
            ->scalar('cart_id')
            ->requirePresence('cart_id', 'create')
            ->notEmptyString('cart_id', 'Cart ID is required');

        // Validate total
        $validator
            ->decimal('total')
            ->requirePresence('total', 'create')
            ->notEmptyString('total', 'Total amount is required')
            ->greaterThan('total', 0, 'Total amount must be greater than zero');

        // Validate deliveryOption
        $validator
            ->scalar('deliveryOption')
            ->requirePresence('deliveryOption', 'create')
            ->notEmptyString('deliveryOption', 'Delivery option is required');

        // Define a nested validator for `customer`
        $customerValidator = new Validator();
        $customerValidator
            ->scalar('firstName')
            ->requirePresence('firstName', 'create')
            ->notEmptyString('firstName', 'Customer first name is required')

            ->scalar('lastName')
            ->requirePresence('lastName', 'create')
            ->notEmptyString('lastName', 'Customer last name is required')

            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email', 'Customer email is required')

            ->scalar('phone')
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone', 'Customer phone is required')

            ->scalar('country')
            ->requirePresence('country', 'create')
            ->notEmptyString('country', 'Customer country is required')

            ->scalar('state')
            ->requirePresence('state', 'create')
            ->notEmptyString('state', 'Customer state is required')

            ->scalar('city')
            ->requirePresence('city', 'create')
            ->notEmptyString('city', 'Customer city is required')

            ->scalar('street1')
            ->requirePresence('street1', 'create')
            ->notEmptyString('street1', 'Customer street address is required')

            ->scalar('zip')
            ->requirePresence('zip', 'create')
            ->notEmptyString('zip', 'Customer ZIP code is required');

        // Add the nested validator
        $validator->addNested('customer', $customerValidator);

        return $validator->validate($data);
    }

}

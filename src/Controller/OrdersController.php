<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $session = $this->request->getSession();
        $userCartId = $session->read('user.cart_id');

        // Set pagination options
        $this->paginate = [
            'limit' => 5, // Number of items per page
            'order' => [
                'Orders.created' => 'desc'
            ]
        ];
        $query = $this->Orders->find()
            ->where(['cart_id' => $userCartId ?? '' ])
            ->contain(['Users']);

        $orders = $this->paginate($query);

        $this->set(compact('orders'));
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, contain: ['Users', 'OrderItems' => ['Products'], 'Payments', 'Refunds']);
        $this->set(compact('order'));
    }


}

<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\ModelAwareTrait;

/**
 * Home Controller
 *
 */
class HomeController extends AppController
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

        // Load the Products model
        $this->Products = $this->fetchModel('Products');

        $this->Authentication->allowUnauthenticated(['index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Products->find();
        $products = $this->paginate($query);

        $this->set(compact('products'));
    }
}

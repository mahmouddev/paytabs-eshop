<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Refunds Controller
 *
 * @property \App\Model\Table\RefundsTable $Refunds
 */
class RefundsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Refunds->find()
            ->contain(['Orders']);
        $refunds = $this->paginate($query);

        $this->set(compact('refunds'));
    }

    /**
     * View method
     *
     * @param string|null $id Refund id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $refund = $this->Refunds->get($id, contain: ['Orders']);
        $this->set(compact('refund'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $refund = $this->Refunds->newEmptyEntity();
        if ($this->request->is('post')) {
            $refund = $this->Refunds->patchEntity($refund, $this->request->getData());
            if ($this->Refunds->save($refund)) {
                $this->Flash->success(__('The refund has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The refund could not be saved. Please, try again.'));
        }
        $orders = $this->Refunds->Orders->find('list', limit: 200)->all();
        $this->set(compact('refund', 'orders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Refund id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $refund = $this->Refunds->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $refund = $this->Refunds->patchEntity($refund, $this->request->getData());
            if ($this->Refunds->save($refund)) {
                $this->Flash->success(__('The refund has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The refund could not be saved. Please, try again.'));
        }
        $orders = $this->Refunds->Orders->find('list', limit: 200)->all();
        $this->set(compact('refund', 'orders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Refund id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $refund = $this->Refunds->get($id);
        if ($this->Refunds->delete($refund)) {
            $this->Flash->success(__('The refund has been deleted.'));
        } else {
            $this->Flash->error(__('The refund could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

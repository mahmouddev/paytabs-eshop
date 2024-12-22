<?php
declare(strict_types=1);

namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ModelAwareTrait;


/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class AuthController extends AppController
{
    use ModelAwareTrait;

    public $Users;

    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        // Load the Users model
        $this->Users = $this->fetchModel('Users');

        $this->Authentication->allowUnauthenticated(['login', 'createUser']);
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function login()
    {

        $result = $this->Authentication->getResult();

        // If the user is logged in send them away.
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? '/home';
            return $this->redirect($target);
        }
        if ($this->request->is('post')) {
            $this->Flash->error('Invalid username or password');
        }


    }


    public function me(){

        $user = $this->request->getAttribute('identity');

        pr($user);

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'id' => $user->get('id'),
                'email' => $user->get('email'),
            ]));
    }


    public function createUser(){

        $this->request->allowMethod(['post']);
        $user = $this->Users->newEmptyEntity();
        $user = $this->Users->patchEntity($user, $this->request->getData());

        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been saved.'));

        return $this->response->withType('application/json')
                ->withStringBody(json_encode([
                    'user' => ['id' => $user->id, 'email' => $user->email],
                ]));
            }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }

}

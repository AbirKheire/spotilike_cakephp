<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);

        // Autoriser certaines actions sans être connecté
        $this->Authentication->addUnauthenticatedActions(['login', 'register']);
        $this->Authentication->addUnauthenticatedActions(['login', 'add']);
        $this->Authorization->skipAuthorization(); // 👈 pour ces actions seulement


    }

    /**
     * Index method
     */
    public function index()

    {
        $this->Authorization->skipAuthorization();

        $users = $this->paginate($this->Users->find());
        $this->set(compact('users'));
    }

    /**
     * Login method
     */
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
    
        $result = $this->Authentication->getResult();
        $this->Authorization->skipAuthorization();

        if ($result->isValid()) {
            $user = $this->request->getAttribute('identity');
    
            // Redirection personnalisée selon le rôle
            if ($user->get('role') === 'admin') {
                return $this->redirect(['controller' => 'Requests', 'action' => 'index']);
            } else {
                return $this->redirect(['controller' => 'Artists', 'action' => 'index']);
            }
        }
    
        // En cas de POST invalide
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Invalid username/password.');
        }
    }
    
    

    /**
     * Logout method
     */
    public function logout()
    {
        $result = $this->Authentication->getResult();
        $this->Authorization->skipAuthorization();

        if ($result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    /**
     * Register method
     */
    public function register()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['role'] = 'user';

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success('Your account has been successfully created');
                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error("Error.");
        }

        $this->set(compact('user'));
    }

    /**
     * View method
     */
    public function view($id = null)
    {
        
        $user = $this->Users->get($id, contain: ['Favorites', 'Requests']);
        $this->set(compact('user'));
    }

    /**
     * Add method
     */
    public function add()
    {
        $this->Authorization->skipAuthorization();
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success("Utilisateur ajouté.");
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error("Error.");
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success("Utilisateur modifié.");
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error("Error");
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success("User has been deleted");
        } else {
            $this->Flash->error("Error");
        }

        return $this->redirect(['action' => 'index']);
    }
}

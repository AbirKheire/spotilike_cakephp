<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Favorites Controller
 *
 * @property \App\Model\Table\FavoritesTable $Favorites
 */
class FavoritesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->Authorization->skipAuthorization();

        $query = $this->Favorites->find()
            ->contain(['Users', 'Albums', 'Artists']);
        $favorites = $this->paginate($query);

        $this->set(compact('favorites'));
    }

    /**
     * View method
     *
     * @param string|null $id Favorite id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();

        $favorite = $this->Favorites->get($id, contain: ['Users', 'Albums', 'Artists']);
        $this->set(compact('favorite'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $favorite = $this->Favorites->newEmptyEntity();
        $this->Authorization->authorize($favorite); // 🔒 
        if ($this->request->is('post')) {
            $favorite = $this->Favorites->patchEntity($favorite, $this->request->getData());
            if ($this->Favorites->save($favorite)) {
                $this->Flash->success(__('The favorite has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The favorite could not be saved. Please, try again.'));
        }
        $users = $this->Favorites->Users->find('list', limit: 200)->all();
        $albums = $this->Favorites->Albums->find('list', limit: 200)->all();
        $artists = $this->Favorites->Artists->find('list', limit: 200)->all();
        $this->set(compact('favorite', 'users', 'albums', 'artists'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Favorite id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $favorite = $this->Favorites->get($id, contain: []);
        $this->Authorization->authorize($favorite); // 🔒 

        if ($this->request->is(['patch', 'post', 'put'])) {
            $favorite = $this->Favorites->patchEntity($favorite, $this->request->getData());
            if ($this->Favorites->save($favorite)) {
                $this->Flash->success(__('The favorite has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The favorite could not be saved. Please, try again.'));
        }
        $users = $this->Favorites->Users->find('list', limit: 200)->all();
        $albums = $this->Favorites->Albums->find('list', limit: 200)->all();
        $artists = $this->Favorites->Artists->find('list', limit: 200)->all();
        $this->set(compact('favorite', 'users', 'albums', 'artists'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Favorite id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $favorite = $this->Favorites->get($id);
        $this->Authorization->authorize($favorite); // 🔒 

        if ($this->Favorites->delete($favorite)) {
            $this->Flash->success(__('The favorite has been deleted.'));
        } else {
            $this->Flash->error(__('The favorite could not be deleted'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function toggle($type, $id)
{
    $userId = $this->request->getAttribute('identity')->id;

    if ($type === 'artist') {
        $exists = $this->Favorites->find()
            ->where(['user_id' => $userId, 'artist_id' => $id])
            ->first();

        if ($exists) {
            $this->Favorites->delete($exists);
            $this->Flash->success('Removed artist from favorites');
        } else {
            $favorite = $this->Favorites->newEmptyEntity();
            $favorite->user_id = $userId;
            $favorite->artist_id = $id;
            $this->Favorites->save($favorite);
            $this->Flash->success('Artist added to favorites');
        }

        return $this->redirect(['controller' => 'Artists', 'action' => 'view', $id]);
    }

    if ($type === 'album') {
        $exists = $this->Favorites->find()
            ->where(['user_id' => $userId, 'album_id' => $id])
            ->first();

        if ($exists) {
            $this->Favorites->delete($exists);
            $this->Flash->success('Album removed from favorites');
        } else {
            $favorite = $this->Favorites->newEmptyEntity();
            $favorite->user_id = $userId;
            $favorite->album_id = $id;
            $this->Favorites->save($favorite);
            $this->Flash->success('Album added to favorites.');
        }

        return $this->redirect(['controller' => 'Albums', 'action' => 'view', $id]);
    }

    $this->Flash->error('Error');
    return $this->redirect($this->referer());
}

}

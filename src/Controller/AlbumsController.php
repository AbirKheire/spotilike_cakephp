<?php
// src/Controller/AlbumsController.php

declare(strict_types=1);

namespace App\Controller;

class AlbumsController extends AppController
{
    public function index()
    {
        $this->Authorization->skipAuthorization();

        $query = $this->Albums->find()->contain(['Artists']);
        $albums = $this->paginate($query);

        $album = $this->Albums->newEmptyEntity();
        $artists = $this->Albums->Artists->find('list')->all();

        $this->set(compact('albums', 'album', 'artists'));
    }

    public function view($id = null)
    {
        $this->Authorization->skipAuthorization();

        $album = $this->Albums->get($id, [
            'contain' => ['Artists', 'Favorites'],
        ]);

        $this->set(compact('album'));
    }

    public function add()
    {
        $album = $this->Albums->newEmptyEntity();
        $this->Authorization->authorize($album); 
        $album->user_id = $this->Authentication->getIdentity()->get('id');



        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $album = $this->Albums->patchEntity($album, $data);

            if ($this->Albums->save($album)) {
                $this->Flash->success("The album has been added with success");
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error("Error");
        }

        $artists = $this->Albums->Artists->find('list')->all();
        $this->set(compact('album', 'artists'));
    }

    public function edit($id = null)
    {
        $album = $this->Albums->get($id, contain: []);
        $this->Authorization->authorize($album);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $album = $this->Albums->patchEntity($album, $data);
            if ($this->Albums->save($album)) {
                $this->Flash->success(__('L’album a été modifié.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Error. Cannot edit the album'));
        }

        $artists = $this->Albums->Artists->find('list')->all();
        $this->set(compact('album', 'artists'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $album = $this->Albums->get($id);
        $this->Authorization->authorize($album); 

        if ($this->Albums->delete($album)) {
            $this->Flash->success(__('The album has been deleted'));
        } else {
            $this->Flash->error(__('Error'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

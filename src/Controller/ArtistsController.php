<?php
// src/Controller/ArtistsController.php

declare(strict_types=1);

namespace App\Controller;

class ArtistsController extends AppController
{
    public function index()
    {
        $this->Authorization->skipAuthorization();

        $userId = $this->Authentication->getIdentity()->get('id');

        $query = $this->Artists->find()
            ->where(['Artists.user_id' => $userId])
            ->contain(['Albums']);
        
        $this->Authorization->skipAuthorization(); 

        $artists = $this->paginate($query);
        $this->set(compact('artists'));
    }
    
    
    

    public function view($id = null)
    {
        if ($id === null) {
            $this->Flash->error("Aucun artiste sélectionné.");
            return $this->redirect(['action' => 'index']);
        }
    
        $artist = $this->Artists->get($id, [
            'contain' => ['Albums', 'Favorites'],
        ]);
    
        $this->Authorization->authorize($artist); // 🔒 vérifie que l'utilisateur est bien propriétaire
    
        $this->set(compact('artist'));
    }
    

    public function add()
    {
        $artist = $this->Artists->newEmptyEntity();
        $this->Authorization->authorize($artist);
    
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $userId = $this->Authentication->getIdentity()->get('id');
    
            $existing = $this->Artists->find()
                ->where([
                    'name' => $data['name'],
                    'user_id' => $userId
                ])
                ->first();
    
            if ($existing) {
                $this->Flash->error("Artist with this name already exists");
                return $this->redirect(['action' => 'index']);
            }
    
            $artist = $this->Artists->patchEntity($artist, $data);
            $artist->user_id = $userId;
    
            if ($this->Artists->save($artist)) {
                $this->Flash->success(__('Artisty added successfully'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Error. Could not add a new artists :('));
        }
    
        $this->set(compact('artist'));
    }
    

    public function edit($id = null)
    {
        $artist = $this->Artists->get($id, contain: []);
        $this->Authorization->authorize($artist); 
        if ($this->request->is(['patch', 'post', 'put'])) {
            $artist = $this->Artists->patchEntity($artist, $this->request->getData());
            if ($this->Artists->save($artist)) {
                $this->Flash->success(__('The artist has been saved successfully !'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The artist could not be saved'));
        }
        $this->set(compact('artist'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $artist = $this->Artists->get($id);
        $this->Authorization->authorize($artist); 
        if ($this->Artists->delete($artist)) {
            $this->Flash->success(__('The artist has been deleted'));
        } else {
            $this->Flash->error(__('The artist could not be deleted'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

<?php
// src/Controller/RequestsController.php

declare(strict_types=1);

namespace App\Controller;

class RequestsController extends AppController
{
    public function index()
    {
        $this->Authorization->skipAuthorization();

        $identity = $this->Authentication->getIdentity();
        if (!$identity || $identity->get('role') !== 'admin') {
            $this->Flash->error("Restricted access");
            return $this->redirect(['controller' => 'Artists', 'action' => 'index']);
        }

        $requests = $this->Requests->find('all')
            ->contain(['Users'])
            ->where(['Requests.status' => 'pending'])
            ->order(['Requests.created' => 'DESC']);

        $this->set(compact('requests'));
    }


    public function accept($id = null)
{
    $request = $this->Requests->get($id);
    $this->Authorization->authorize($request); 

    $data = json_decode($request->content, true);

    if ($request->type === 'artist') {
        $artistTable = $this->fetchTable('Artists');

        $existingArtist = $artistTable->find()
            ->where(['name' => $data['name']])
            ->first();

        if (!$existingArtist) {
            $artist = $artistTable->newEmptyEntity();
            $artist = $artistTable->patchEntity($artist, [
                'name' => $data['name'] ?? '',
                'genre' => $data['genre'] ?? '',
                'validated' => 1,
                'user_id' => $request->user_id 

            ]);

            if ($artistTable->save($artist)) {
                $this->Flash->success("Artist added successfully !");
            } else {
                $this->Flash->error("Error. Could not add the artist");
                debug($artist->getErrors());
                return $this->redirect(['action' => 'index']);
            }
        } else {
            $this->Flash->info("The artist already exists");
        }

    } elseif ($request->type === 'album') {
        $albumTable = $this->fetchTable('Albums');
        $artistTable = $this->fetchTable('Artists');

        $artist = $artistTable->find()
            ->where(['name' => $data['artist_name'] ?? ''])
            ->first();
            
            if (empty($data['artist_name'])) {
                $this->Flash->error("Artist's name is required");
                return $this->redirect(['action' => 'index']);
            }
            

            if (!$artist) {
                $artist = $artistTable->newEmptyEntity();
                $artist = $artistTable->patchEntity($artist, [
                    'name' => $data['artist_name'] ?? '',
                    'genre' => $data['genre'] ?? 'Autre',
                    'validated' => 1
                ]);
            
                if (!$artistTable->save($artist)) {
                    $this->Flash->error("Error");
                    debug($artist->getErrors());
                    return $this->redirect(['action' => 'index']);
                }
            }
            

        $album = $albumTable->newEmptyEntity();
        $album = $albumTable->patchEntity($album, [
            'title' => $data['title'] ?? '',
            'release_year' => $data['release_year'] ?? '',
            'spotify_url' => $data['spotify_url'] ?? '',
            'artist_id' => $artist->id ?? null,
            'validated' => 1,
            'user_id' => $request->user_id 

        ]);

        if ($albumTable->save($album)) {
            $this->Flash->success("Album added successfully");
        } else {
            $this->Flash->error("Error");
            debug($album->getErrors());
            return $this->redirect(['action' => 'index']);
        }
    }

    $request->status = 'accepted';
    $this->Requests->save($request);

    return $this->redirect(['action' => 'index']);
}

    
    
    
    public function add()
    {
        $request = $this->Requests->newEmptyEntity();
        $this->Authorization->authorize($request); // 🔒 

    
        if ($this->request->is('post')) {
            $data = $this->request->getData();
    
            // Création du contenu JSON selon le type
            if ($data['type'] === 'album') {
                $content = json_encode([
                    'title' => $data['content_name'],
                    'genre' => $data['content_genre'],
                    'spotify_url' => $data['spotify_url'] ?? null,
                    'release_year' => $data['release_year'] ?? null,
                    'artist_id' => $data['artist_id'] ?? null,
                    'artist_name' => $data['artist_name'] ?? null,
                ]);
            } else {
                $content = json_encode([
                    'name' => $data['content_name'],
                    'genre' => $data['content_genre'],
                    'spotify_url' => $data['spotify_url'] ?? null,
                ]);
            }
    
            $requestData = [
                'type' => $data['type'],
                'content' => $content,
                'status' => 'pending',
                'user_id' => $this->Authentication->getIdentity()->get('id')
            ];
    
            $request = $this->Requests->patchEntity($request, $requestData);
    
            if ($this->Requests->save($request)) {
                $this->Flash->success("Request sent !");
                return $this->redirect(['controller' => 'Artists', 'action' => 'index']);
            }
    
            $this->Flash->error("Error");
        }
    
        $artistTable = $this->fetchTable('Artists');
        $artistsList = $artistTable->find('list')
            ->where(['validated' => 1])
            ->order(['name' => 'ASC'])
            ->toArray();
    
        $this->set(compact('request', 'artistsList'));
    }
    
    
    

    public function myRequests()
    {
        $this->Authorization->skipAuthorization();

        $identity = $this->Authentication->getIdentity();
        if (!$identity) {
            $this->Flash->error("Connecte-toi d'abord.");
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $requests = $this->Requests->find('all')
            ->where(['user_id' => $identity->get('id')])
            ->order(['Requests.created' => 'DESC'])
            ->all();


        $this->set(compact('requests'));
    }


    public function reject($id = null)
{
    $request = $this->Requests->get($id);
    $this->Authorization->authorize($request); 


    // Changer le statut de la demande à "rejected"
    $request->status = 'rejected';

    if ($this->Requests->save($request)) {
        $this->Flash->success("La demande a été rejetée avec succès.");
    } else {
        $this->Flash->error("Erreur lors du rejet de la demande.");
    }

    return $this->redirect(['action' => 'index']);
}

}

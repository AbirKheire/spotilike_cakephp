<?php
// src/Controller/StatsController.php

declare(strict_types=1);

namespace App\Controller;

class StatsController extends AppController
{
    public function index()
    {
        $this->Authorization->skipAuthorization();
    
        $identity = $this->Authentication->getIdentity();
        $userId = $identity ? $identity->get('id') : null;
        $isAdmin = $identity && $identity->get('role') === 'admin';
    
        $filter = $isAdmin ? [] : ['Favorites.user_id' => $userId];
    
        $topArtists = $this->fetchTable('Artists')
            ->find()
            ->select([
                'id',
                'name',
                'favorites_count' => $this->fetchTable('Favorites')->find()->func()->count('*')
            ])
            ->leftJoinWith('Favorites')
            ->where($filter)
            ->group('Artists.id')
            ->orderDesc('favorites_count')
            ->limit(5)
            ->all();
    
       
    
        $topAlbums = $this->fetchTable('Albums')
            ->find()
            ->select([
                'id',
                'title',
                'favorites_count' => $this->fetchTable('Favorites')->find()->func()->count('*')
            ])
            ->leftJoinWith('Favorites')
            ->where($filter)
            ->group('Albums.id')
            ->orderDesc('favorites_count')
            ->limit(5)
            ->all();
    
    
        $topUsers = [];
        if ($isAdmin) {
            $topUsers = $this->fetchTable('Users')
                ->find()
                ->select([
                    'id',
                    'username',
                    'favorites_count' => $this->fetchTable('Favorites')->find()->func()->count('*')
                ])
                ->leftJoinWith('Favorites')
                ->group('Users.id')
                ->orderDesc('favorites_count')
                ->limit(5)
                ->all();
        }
    
        $this->set(compact('topArtists', 'topAlbums', 'topUsers', 'isAdmin'));
    }
}    
<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Album extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'title' => true,
        'release_year' => true,
        'spotify_id' => true,
        'spotify_url' => true, 
        'artist_id' => true,
        'validated' => true, 
        'created' => true,
        'modified' => true,
        'artist' => true,
        'favorites' => true,
    ];
}

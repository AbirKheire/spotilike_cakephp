<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Artist Entity
 *
 * @property int $id
 * @property string $name
 * @property string $genre
 * @property string|null $bio
 * @property string|null $player
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Album[] $albums
 * @property \App\Model\Entity\Favorite[] $favorites
 */
class Artist extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'genre' => true,
        'validated' => true,
        'created' => true,
        'modified' => true,
        'spotify_url' => true,
        '*' => true,
        'id' => false,

    ];


    
}

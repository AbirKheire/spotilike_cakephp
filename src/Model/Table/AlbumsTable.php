<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class AlbumsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('albums');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Artists', [
            'foreignKey' => 'artist_id',
            'joinType' => 'INNER',
        ]);

        $this->hasMany('Favorites', [
            'foreignKey' => 'album_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title', 'Le titre est requis.');

        $validator
            ->integer('release_year')
            ->requirePresence('release_year', 'create')
            ->notEmptyString('release_year', 'L’année de sortie est requise.');

        $validator
            ->scalar('spotify_url')
            ->maxLength('spotify_url', 255)
            ->requirePresence('spotify_url', 'create')
            ->notEmptyString('spotify_url', 'Le lien Spotify est requis.');

        $validator
            ->integer('artist_id')
            ->requirePresence('artist_id', 'create')
            ->notEmptyString('artist_id', 'Un artiste est requis.');

        $validator
            ->boolean('validated')
            ->allowEmptyString('validated'); // ou ->requirePresence('validated', 'create') si tu veux le forcer
        

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['artist_id'], 'Artists'), ['errorField' => 'artist_id']);
        return $rules;
    }
}

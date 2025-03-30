<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Artist;
use Authorization\IdentityInterface;

class ArtistPolicy
{
    public function canAdd(IdentityInterface $user, Artist $artist): bool
    {
        // Tous les utilisateurs authentifiés peuvent ajouter des artistes
        return true;
    }

    public function canEdit(IdentityInterface $user, Artist $artist): bool
    {
        return $this->isAuthor($user, $artist);
    }

    public function canDelete(IdentityInterface $user, Artist $artist): bool
    {
        return $this->isAuthor($user, $artist);
    }

    public function canView(IdentityInterface $user, Artist $artist): bool
    {
        return $this->isAuthor($user, $artist);
    }

    protected function isAuthor(IdentityInterface $user, Artist $artist): bool
    {
        // Option 1 : si tu veux éviter l'erreur Intelephense
        return $artist->user_id === $user->get('id');

        // Option 2 : si tu veux utiliser getIdentifier() proprement
        // return $artist->user_id === $user->getIdentifier();
    }
}

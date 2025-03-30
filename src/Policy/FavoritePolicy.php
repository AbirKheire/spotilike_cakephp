<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Favorite;
use Authorization\IdentityInterface;

class FavoritePolicy
{
    public function canAdd(IdentityInterface $user, Favorite $favorite): bool
    {
        // Tout utilisateur connecté peut ajouter un favori
        return true;
    }

    public function canEdit(IdentityInterface $user, Favorite $favorite): bool
    {
        // Peu courant d’éditer un favori, mais on garde la logique cohérente
        return $this->isOwner($user, $favorite);
    }

    public function canDelete(IdentityInterface $user, Favorite $favorite): bool
    {
        return $this->isOwner($user, $favorite);
    }

    public function canView(IdentityInterface $user, Favorite $favorite): bool
    {
        return $this->isOwner($user, $favorite);
    }

    protected function isOwner(IdentityInterface $user, Favorite $favorite): bool
    {
        return $favorite->user_id === $user->get('id');
    }
}

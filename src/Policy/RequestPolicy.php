<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Request;
use Authorization\IdentityInterface;

class RequestPolicy
{
    public function canAdd(IdentityInterface $user, Request $request): bool
    {
        // Tous les utilisateurs connectés peuvent faire une demande
        return true;
    }

    public function canEdit(IdentityInterface $user, Request $request): bool
    {
        return $this->isOwner($user, $request);
    }

    public function canDelete(IdentityInterface $user, Request $request): bool
    {
        return $this->isOwner($user, $request);
    }

    public function canView(IdentityInterface $user, Request $request): bool
    {
        return $this->isOwner($user, $request);
    }

    protected function isOwner(IdentityInterface $user, Request $request): bool
    {
        return $request->user_id === $user->get('id');
    }
    public function canReject(IdentityInterface $user, \App\Model\Entity\Request $request): bool
{
    // Seuls les admins peuvent rejeter une demande
    return $user->get('role') === 'admin';
}

protected function isAdmin(IdentityInterface $user): bool
{
    return $user->get('role') === 'admin';
}

public function canAccept(IdentityInterface $user, \App\Model\Entity\Request $request): bool
{
    // Seuls les admins peuvent accepter une demande
    return $user->get('role') === 'admin';
}



}

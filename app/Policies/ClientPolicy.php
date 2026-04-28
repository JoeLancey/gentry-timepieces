<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client;

class ClientPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Client $client): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff']);
    }

    public function update(User $user, Client $client): bool
    {
        return in_array($user->role, ['admin', 'staff']);
    }

    public function delete(User $user, Client $client): bool
    {
        // Prevent deletion if client has active transactions
        if ($client->transactions()->exists()) {
            return false;
        }
        return $user->role === 'admin';
    }

    public function restore(User $user, Client $client): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Client $client): bool
    {
        return $user->role === 'admin';
    }
}

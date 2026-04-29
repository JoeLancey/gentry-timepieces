<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Watch;

class WatchPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Watch $watch): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Watch $watch): bool
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Watch $watch): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Watch $watch): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Watch $watch): bool
    {
        return $user->role === 'admin';
    }
}

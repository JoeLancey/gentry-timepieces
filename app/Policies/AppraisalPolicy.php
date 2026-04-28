<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Appraisal;

class AppraisalPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Appraisal $appraisal): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'appraiser']);
    }

    public function update(User $user, Appraisal $appraisal): bool
    {
        // Only the assigned appraiser or admin can update
        return $user->id === $appraisal->appraiser_id || $user->role === 'admin';
    }

    public function delete(User $user, Appraisal $appraisal): bool
    {
        return $user->role === 'admin';
    }

    public function restore(User $user, Appraisal $appraisal): bool
    {
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Appraisal $appraisal): bool
    {
        return $user->role === 'admin';
    }
}

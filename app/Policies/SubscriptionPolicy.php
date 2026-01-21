<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'super_admin';
    }

    public function view(User $user, Subscription $subscription): bool
    {
        return $user->role === 'super_admin';
    }

    public function create(User $user): bool
    {
        return $user->role === 'super_admin';
    }

    public function update(User $user, Subscription $subscription): bool
    {
        return $user->role === 'super_admin';
    }

    public function delete(User $user, Subscription $subscription): bool
    {
        return $user->role === 'super_admin';
    }
}


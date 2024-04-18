<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    public function view(User $user, Order $order): bool{
        return $user->id == $order->user_id || $user->role === 'admin';
    }

    public function create(User $user): bool{
        return true;
    }

    public function update(User $user, Order $order): bool{
        return $user->role === 'admin';
    }

    public function delete(User $user, Order $order): bool{
        return $user->id === $order->user_id || $user->role === 'admin';
    }

    public function restore(User $user, Order $order): bool{
        return $user->role === 'admin';
    }

    public function forceDelete(User $user, Order $order): bool{
        return $user->role === 'admin';
    }
}

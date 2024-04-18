<?php

namespace App\Policies;

use App\Models\Blog;
use App\Models\User;

class BlogPolicy
{
    public function viewAny(User $user): bool{
        return true;
    }
    public function view(User $user, Blog $blog): bool{
        return true;
    }
    public function create(User $user): bool{
        return true;
    }

    public function update(User $user, Blog $blog): bool{
        return $user->id === $blog->user_id || $user->role === 'admin';
    }

    public function delete(User $user, Blog $blog): bool{
        return $user->id === $blog->user_id || $user->role === 'admin';
    }

    public function restore(User $user, Blog $blog): bool{
      return $user->role === 'admin';
    }

    public function forceDelete(User $user, Blog $blog): bool{
        return $user->role === 'admin';
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use App\Models\role;
use Illuminate\Auth\Access\Response;

class rolespolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, role $role): bool
    {
        return $user->hasRole('admin') ;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, role $role): bool
    {
        return $user->hasRole('admin') ;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, role $role): bool
    {
        return $user->hasRole('admin') ;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, role $role): bool
    {
        return $user->hasRole('admin') ;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, role $role): bool
    {
        return $user->hasRole('admin') ;
    }
}

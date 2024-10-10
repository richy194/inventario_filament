<?php

namespace App\Policies;

use App\Models\User;
use App\Models\producto;
use Illuminate\Auth\Access\Response;

class productopolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('empleado');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, producto $producto): bool
    {
        return $user->hasRole('admin') || $user->hasRole('empleado');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('empleado');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, producto $producto): bool
    {
        return $user->hasRole('admin') || $user->hasRole('empleado');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, producto $producto): bool
    {
        return $user->hasRole('admin') || $user->hasRole('empleado');
    }
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, producto $producto): bool
    {
        return $user->hasRole('admin') || $user->hasRole('empleado');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, producto $producto): bool
    {
        return $user->hasRole('admin') || $user->hasRole('empleado');
    }
}

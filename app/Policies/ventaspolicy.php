<?php

namespace App\Policies;

use App\Models\User;
use App\Models\venta;
use Illuminate\Auth\Access\Response;

class ventaspolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_ventas');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, venta $venta): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_ventas');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_ventas');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, venta $venta): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_ventas');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, venta $venta): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_ventas');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, venta $venta): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_ventas');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, venta $venta): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_ventas');
    }
}

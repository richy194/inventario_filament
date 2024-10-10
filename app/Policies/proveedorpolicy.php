<?php

namespace App\Policies;

use App\Models\User;
use App\Models\proveedor;
use Illuminate\Auth\Access\Response;

class proveedorpolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_compras');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, proveedor $proveedor): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_compras');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_compras');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, proveedor $proveedor): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_compras');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, proveedor $proveedor): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_compras');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, proveedor $proveedor): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_compras');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, proveedor $proveedor): bool
    {
        return $user->hasRole('admin') || $user->hasRole('admin_compras');
    }
}

<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-role');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $model): bool
    {
        return $user->can('view-role');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-role');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Role $model): bool
    {
        // First check if user has edit-role permission
        if (!$user->can('edit-role')) {
            return false;
        }
        
        // Admin can update any role
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // Manager can update roles but not admin role
        if ($user->hasRole('manager')) {
            return $model->name !== 'admin';
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $model): bool
    {
        // First check if user has delete-role permission
        if (!$user->can('delete-role')) {
            return false;
        }
        
        // Admin can delete any role except admin role
        if ($user->hasRole('admin')) {
            return $model->name !== 'admin';
        }
        
        // Manager can delete roles but not admin role
        if ($user->hasRole('manager')) {
            return $model->name !== 'admin';
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $model): bool
    {
        return false;
    }
}
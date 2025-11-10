<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-permission');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permission $model): bool
    {
        return $user->can('view-permission');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-permission');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission $model): bool
    {
        // First check if user has edit-permission permission
        if (!$user->can('edit-permission')) {
            return false;
        }
        
        // Admin can update any permission
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // Manager can update permissions but not core system permissions
        if ($user->hasRole('manager')) {
            // Prevent editing critical system permissions
            $corePermissions = [
                'view-user', 'create-user', 'edit-user', 'delete-user',
                'view-role', 'create-role', 'edit-role', 'delete-role',
                'view-permission', 'create-permission', 'edit-permission', 'delete-permission'
            ];
            return !in_array($model->name, $corePermissions);
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission $model): bool
    {
        // First check if user has delete-permission permission
        if (!$user->can('delete-permission')) {
            return false;
        }
        
        // Admin can delete permissions but not core system permissions
        if ($user->hasRole('admin')) {
            // Prevent deleting critical system permissions
            $corePermissions = [
                'view-user', 'create-user', 'edit-user', 'delete-user',
                'view-role', 'create-role', 'edit-role', 'delete-role',
                'view-permission', 'create-permission', 'edit-permission', 'delete-permission'
            ];
            return !in_array($model->name, $corePermissions);
        }
        
        // Manager can delete permissions but not core system permissions
        if ($user->hasRole('manager')) {
            $corePermissions = [
                'view-user', 'create-user', 'edit-user', 'delete-user',
                'view-role', 'create-role', 'edit-role', 'delete-role',
                'view-permission', 'create-permission', 'edit-permission', 'delete-permission'
            ];
            return !in_array($model->name, $corePermissions);
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Permission $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Permission $model): bool
    {
        return false;
    }
}
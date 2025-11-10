<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-user');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->can('view-user');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-user');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        // First check if user has edit-user permission
        if (!$user->can('edit-user')) {
            return false;
        }
        
        // Admin can update any user
        if ($user->hasRole('admin')) {
            return true;
        }
        
        // Manager can update users but not other admins
        if ($user->hasRole('manager')) {
            return !$model->hasRole('admin');
        }
        
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // First check if user has delete-user permission
        if (!$user->can('delete-user')) {
            return false;
        }
        
        // Admin can delete any user except themselves
        if ($user->hasRole('admin')) {
            return $user->id !== $model->id;
        }
        
        // Manager can delete users but not admins or themselves
        if ($user->hasRole('manager')) {
            return !$model->hasRole('admin') && $user->id !== $model->id;
        }
        
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}

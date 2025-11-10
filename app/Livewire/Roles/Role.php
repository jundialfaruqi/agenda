<?php

namespace App\Livewire\Roles;

use Spatie\Permission\Models\Role as RoleModel;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Data Role')]

class Role extends Component
{
    use WithPagination;

    public function deleteRole($roleId)
    {
        try {
            $role = RoleModel::findOrFail($roleId);
            
            // Memeriksa apakah pengguna memiliki izin untuk menghapus role
            $this->authorize('delete', $role);
            
            // Memeriksa apakah role adalah admin role
            if ($role->name === 'admin') {
                $message = 'Role admin tidak dapat dihapus.';
                session()->flash('error', $message);
                $this->dispatch('toast-error', message: $message);
                return;
            }
            
            // Menyimpan nama role sebelum dihapus
            $roleName = $role->name;

            // Menghapus role
            $role->delete();
            
            $message = "Role '{$roleName}' berhasil dihapus.";
            session()->flash('success', $message);
            $this->dispatch('toast-success', message: $message);
            
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $message = 'Anda tidak memiliki izin untuk menghapus role ini.';
            session()->flash('error', $message);
            $this->dispatch('toast-error', message: $message);
        } catch (\Exception $e) {
            $message = 'Terjadi kesalahan saat menghapus role.';
            session()->flash('error', $message);
            $this->dispatch('toast-error', message: $message);
        }
    }

    public function render()
    {
        $roles = RoleModel::withCount('users')
            ->latest()
            ->paginate(10);
        
        // Statistics data
        $totalRoles = RoleModel::count();
        $newRoles = RoleModel::where('created_at', '>=', now()->subDays(30))->count();
        $rolesWithUsers = RoleModel::has('users')->count();
        
        return view('livewire.roles.role', compact('roles', 'totalRoles', 'newRoles', 'rolesWithUsers'));
    }
}
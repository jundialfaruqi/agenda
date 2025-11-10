<?php

namespace App\Livewire\Permissions;

use Spatie\Permission\Models\Permission as PermissionModel;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Data Permission')]

class Permission extends Component
{
    use WithPagination;

    public function deletePermission($permissionId)
    {
        try {
            $permission = PermissionModel::findOrFail($permissionId);
            
            // Memeriksa apakah pengguna memiliki izin untuk menghapus permission
            $this->authorize('delete', $permission);
            
            // Menyimpan nama permission sebelum dihapus
            $permissionName = $permission->name;

            // Menghapus permission
            $permission->delete();
            
            $message = "Permission '{$permissionName}' berhasil dihapus.";
            session()->flash('success', $message);
            $this->dispatch('toast-success', message: $message);
            
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $message = 'Anda tidak memiliki izin untuk menghapus permission ini.';
            session()->flash('error', $message);
            $this->dispatch('toast-error', message: $message);
        } catch (\Exception $e) {
            $message = 'Terjadi kesalahan saat menghapus permission.';
            session()->flash('error', $message);
            $this->dispatch('toast-error', message: $message);
        }
    }

    public function render()
    {
        $permissions = PermissionModel::withCount('roles')
            ->orderBy('group', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(10);

        // Compute per-group offsets so numbering continues across pages
        $pageItems = collect($permissions->items());
        $pageGroups = $pageItems->groupBy(function ($p) {
            return $p->group; // keep null if no group
        });

        $groupOffsets = [];
        foreach ($pageGroups as $group => $items) {
            // Items are already ordered by name asc; first item on this page for the group
            $firstName = $items->first()->name;

            $query = PermissionModel::query();
            $displayKey = $group ?? 'Other Permissions';
            if ($group === null) {
                $query->whereNull('group');
            } else {
                $query->where('group', $group);
            }
            // Count how many items in this group come before the first item on this page
            $offset = $query->where('name', '<', $firstName)->count();
            $groupOffsets[$displayKey] = $offset;
        }

        // Statistics data
        $totalPermissions = PermissionModel::count();
        $newPermissions = PermissionModel::where('created_at', '>=', now()->subDays(30))->count();
        $permissionsWithRoles = PermissionModel::has('roles')->count();
        
        return view('livewire.permissions.permission', compact('permissions', 'totalPermissions', 'newPermissions', 'permissionsWithRoles', 'groupOffsets'));
    }
}
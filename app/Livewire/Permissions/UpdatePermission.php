<?php

namespace App\Livewire\Permissions;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Title;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Illuminate\Validation\Rule;

#[Title('Edit Permission')]

class UpdatePermission extends Component
{
    #[Locked]
    public Permission $permission;
    public $name = '';
    public $selectedRoles = [];
    public $group = '';
    public $title = 'Edit Permission';

    public function mount(Permission $permission)
    {
        // Authorization check
        $this->authorize('update', $permission);
        
        $this->permission = $permission;
        $this->name = $permission->name;
        $this->selectedRoles = $permission->roles->pluck('name')->toArray();
        $this->group = $permission->group;
    }

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($this->permission->id), 'regex:/^[a-z]+(-[a-z]+)*$/'],
            'selectedRoles' => 'array',
            'selectedRoles.*' => 'exists:roles,name',
            'group' => 'nullable|string|max:100',
        ];
    }

    protected $messages = [
        'name.required' => 'Nama permission wajib diisi.',
        'name.unique' => 'Nama permission sudah digunakan.',
        'name.regex' => 'Nama permission harus huruf kecil semua, tidak boleh ada spasi, dan menggunakan tanda hubung (-) untuk memisahkan kata. Contoh: edit-role, view-user.',
        'selectedRoles.*.exists' => 'Role yang dipilih tidak valid.',
    ];

    public function save()
    {
        // Authorization check
        $this->authorize('update', $this->permission);
        
        // Validation errors will be handled by Livewire automatically
        $this->validate();

        try {
            $this->permission->update([
                'name' => $this->name,
                'group' => $this->group ?: null,
            ]);

            // Sync roles - first remove from all roles, then assign to selected ones
            $allRoles = Role::all();
            foreach ($allRoles as $role) {
                $role->revokePermissionTo($this->permission);
            }

            // Assign to selected roles
            if (!empty($this->selectedRoles)) {
                foreach ($this->selectedRoles as $roleName) {
                    $role = Role::where('name', $roleName)->first();
                    if ($role) {
                        $role->givePermissionTo($this->permission);
                    }
                }
            }

            // Session flash for toast on redirect page
            session()->flash('success', 'Permission berhasil diperbarui!');
            
            return redirect()->route('permissions.index');
            
        } catch (\Exception $e) {
            // Only show toast for system errors, not validation errors
            session()->flash('error', 'Gagal memperbarui permission: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $roles = Role::all();
        $groups = Permission::query()->select('group')->distinct()->pluck('group')->filter()->values();
        return view('livewire.permissions.update-permission', compact('roles', 'groups'));
    }
}
<?php

namespace App\Livewire\Permissions;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tambah Permission Baru')]

class CreatePermission extends Component
{
    public $name = '';
    public $selectedRoles = [];
    public $group = '';
    public $title = 'Tambah Permission Baru';

    protected $rules = [
        'name' => 'required|string|max:255|unique:permissions,name|regex:/^[a-z]+(-[a-z]+)*$/',
        'selectedRoles' => 'array',
        'group' => 'nullable|string|max:100',
    ];

    protected $messages = [
        'name.required' => 'Nama permission wajib diisi.',
        'name.unique' => 'Nama permission sudah digunakan.',
        'name.regex' => 'Nama permission harus huruf kecil semua, tidak boleh ada spasi, dan menggunakan tanda hubung (-) untuk memisahkan kata. Contoh: edit-role, view-user.',
    ];

    public function save()
    {
        // Check authorization
        $this->authorize('create', Permission::class);
        
        // Validation errors will be handled by Livewire automatically
        $this->validate();

        try {
            $permission = Permission::create([
                'name' => $this->name,
                'guard_name' => 'web',
                'group' => $this->group ?: null,
            ]);

            // Assign permission to selected roles if any
            if (!empty($this->selectedRoles)) {
                foreach ($this->selectedRoles as $roleName) {
                    $role = Role::where('name', $roleName)->first();
                    if ($role) {
                        $role->givePermissionTo($permission);
                    }
                }
            }

            // Session flash for toast on redirect page
            session()->flash('success', 'Permission berhasil ditambahkan!');
            
            return redirect()->route('permissions.index');
            
        } catch (\Exception $e) {
            // Only show toast for system errors, not validation errors
            session()->flash('error', 'Gagal menambahkan permission: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $roles = Role::all();
        $groups = Permission::query()->select('group')->distinct()->pluck('group')->filter()->values();
        return view('livewire.permissions.create-permission', compact('roles', 'groups'));
    }
}
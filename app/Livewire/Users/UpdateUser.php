<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

#[Title('Edit User')]

class UpdateUser extends Component
{
    #[Locked]
    public User $user;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $selectedRoles = [];
    public $title = 'Edit User';

    public function mount(User $user)
    {
        // Authorization check
        $this->authorize('update', $user);
        
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->selectedRoles = $user->roles->pluck('name')->toArray();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'password' => 'nullable|string|min:8|confirmed|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'selectedRoles' => 'required|array|min:1',
            'selectedRoles.*' => 'exists:roles,name',
        ];
    }

    protected $messages = [
        'name.required' => 'Nama wajib diisi.',
        'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
        'password.regex' => 'Password harus mengandung huruf dan angka.',
        'selectedRoles.required' => 'Pilih minimal satu role.',
        'selectedRoles.min' => 'Pilih minimal satu role.',
        'selectedRoles.*.exists' => 'Role yang dipilih tidak valid.',
    ];

    public function save()
    {
        // Authorization check
        $this->authorize('update', $this->user);
        
        // Validation errors will be handled by Livewire automatically
        $this->validate();

        try {
            $updateData = [
                'name' => $this->name,
                'email' => $this->email,
            ];

            // Only update password if provided
            if (!empty($this->password)) {
                $updateData['password'] = Hash::make($this->password);
            }

            $this->user->update($updateData);

            // Sync roles
            $this->user->syncRoles($this->selectedRoles);

            // Session flash for toast on redirect page
            session()->flash('success', 'User berhasil diperbarui!');
            
            return redirect()->route('users.index');
            
        } catch (\Exception $e) {
            // Only show toast for system errors, not validation errors
            session()->flash('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $roles = Role::all();
        return view('livewire.users.update-user', compact('roles'));
    }
}

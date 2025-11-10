<?php

namespace App\Livewire\Users;

use App\Models\User as UserModel;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

#[Title('Data User')]

class User extends Component
{
    use WithPagination;

    public function deleteUser($userId)
    {
        try {
            $user = UserModel::findOrFail($userId);

            // Memeriksa apakah pengguna memiliki izin untuk menghapus user
            $this->authorize('delete', $user);

            // Memeriksa apakah pengguna mencoba menghapus akun mereka sendiri
            if ($user->id === Auth::id()) {
                $message = 'Anda tidak dapat menghapus akun Anda sendiri.';
                session()->flash('error', $message);
                $this->dispatch('toast-error', message: $message);
                return;
            }

            // Menyimpan nama user sebelum dihapus
            $userName = $user->name;

            // Menghapus user
            $user->delete();

            $message = "User '{$userName}' berhasil dihapus.";
            session()->flash('success', $message);
            $this->dispatch('toast-success', message: $message);
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            $message = 'Anda tidak memiliki izin untuk menghapus user ini.';
            session()->flash('error', $message);
            $this->dispatch('toast-error', message: $message);
        } catch (\Exception $e) {
            $message = 'Terjadi kesalahan saat menghapus user.';
            session()->flash('error', $message);
            $this->dispatch('toast-error', message: $message);
        }
    }

    public function render()
    {
        $users = UserModel::with('roles')->select('id', 'name', 'email', 'created_at')
            ->latest()
            ->paginate(10);

        // Statistics data
        $totalUsers = UserModel::count();
        $newUsers = UserModel::where('created_at', '>=', now()->subDays(30))->count();
        $roleUserTotal = UserModel::whereHas('roles', function ($query) {
            $query->whereIn('name', ['user']);
        })->count();

        return view('livewire.users.user', compact('users', 'totalUsers', 'newUsers', 'roleUserTotal'));
    }
}

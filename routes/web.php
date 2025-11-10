<?php

use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\MasjidUser\MyMasjid;
use App\Livewire\Users\User;
use App\Livewire\Users\CreateUser;
use App\Livewire\Users\UpdateUser;
use App\Livewire\Roles\Role;
use App\Livewire\Roles\CreateRole;
use App\Livewire\Roles\UpdateRole;
use App\Livewire\Permissions\Permission;
use App\Livewire\Permissions\CreatePermission;
use App\Livewire\Permissions\UpdatePermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
});

// Route user, roles, permissions untuk admin dan manager
Route::middleware(['auth', 'role:admin|manager'])->group(function () {
    Route::get('users', User::class)->name('users.index');
    Route::get('users/create', CreateUser::class)->name('users.create');
    Route::get('users/{user}/edit', UpdateUser::class)->name('users.edit');

    Route::get('roles', Role::class)->name('roles.index');
    Route::get('roles/create', CreateRole::class)->name('roles.create');
    Route::get('roles/{role}/edit', UpdateRole::class)->name('roles.edit');

    Route::get('permissions', Permission::class)->name('permissions.index');
    Route::get('permissions/create', CreatePermission::class)->name('permissions.create');
    Route::get('permissions/{permission}/edit', UpdatePermission::class)->name('permissions.edit');
});

// Route masjid untuk user
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('my-masjid', MyMasjid::class)->name('masjid.user');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard.index');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    })->name('logout');
});

// Halaman Template Statis Untuk Testing
Route::group([], function () {
    Route::get('/home', function () {
        return view('static.landing-page');
    })->name('home');

    //     Route::get('/login', function () {
    //         return view('static.login');
    //     })->name('login');

    //     Route::get('/dashboard', function () {
    //         return view('static.dashboard');
    //     })->name('dashboard');


    Route::get('/ttd', function () {
        return view('ttd');
    })->name('ttd');
});

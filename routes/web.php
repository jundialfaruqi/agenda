<?php

use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Users\User;
use App\Livewire\Users\CreateUser;
use App\Livewire\Users\UpdateUser;
use App\Livewire\Roles\Role;
use App\Livewire\Roles\CreateRole;
use App\Livewire\Roles\UpdateRole;
use App\Livewire\Permissions\Permission;
use App\Livewire\Permissions\CreatePermission;
use App\Livewire\Permissions\UpdatePermission;
use App\Livewire\Dashboard\DashboardIndex;
use App\Livewire\Opd\OpdIndex;
use App\Livewire\Opd\OpdCreate;
use App\Livewire\Opd\OpdEdit;
use App\Livewire\Agenda\AgendaIndex;
use App\Livewire\Agenda\AgendaCreate;
use App\Livewire\Agenda\AgendaEdit;
use App\Livewire\Agenda\AgendaDetail;
use App\Livewire\Agenda\AgendaRekap;
use App\Livewire\Public\AttendanceForm;
use App\Livewire\Public\AttendanceSuccess;
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

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', DashboardIndex::class)->name('dashboard.index');

    // OPD Management Routes
    Route::get('opd', OpdIndex::class)->name('opd.index');
    Route::get('opd/create', OpdCreate::class)->name('opd.create');
    Route::get('opd/{opd}/edit', OpdEdit::class)->name('opd.edit');

    // Agenda Management Routes
    Route::get('agenda', AgendaIndex::class)->name('agenda.index');
    Route::get('agenda/create', AgendaCreate::class)->name('agenda.create');
    Route::get('agenda/{agenda}/edit', AgendaEdit::class)->name('agenda.edit');
    Route::get('agenda/{agenda}/detail', AgendaDetail::class)->name('agenda.detail');
    Route::get('agenda/{agenda}/rekap', AgendaRekap::class)->name('agenda.rekap');

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

// Public Attendance Routes (No Authentication Required)
Route::group([], function () {
    Route::get('/absensi/{agendaId}/{slug}', AttendanceForm::class)->name('attendance.form');
Route::get('/absensi/success/{agendaId}', AttendanceSuccess::class)->name('attendance.success');
// Halaman statis setelah absensi berhasil
Route::get('/absensi-berhasil', function () {
    return view('static.absensi-berhasil');
})->name('attendance.static.success');
});

# Routing & API Documentation - Agenda & Absensi QR Code

## 1. Route Overview

### 1.1 Authentication Routes

```php
// Laravel Breeze/Fortify routes (existing)
/login          - Login page
/register       - Registration page  
/password/reset - Password reset
/email/verify   - Email verification
```

### 1.2 Admin Routes (Authenticated)

```php
// Dashboard
GET|HEAD   dashboard .................... dashboard › DashboardIndex

// OPD Management
GET|HEAD   opd .......................... opd.index › OpdIndex
GET|HEAD   opd/create ................... opd.create › OpdCreate
POST       opd .......................... opd.store › OpdStore
GET|HEAD   opd/{opd}/edit ............... opd.edit › OpdEdit
PUT|PATCH  opd/{opd} .................... opd.update › OpdUpdate
DELETE     opd/{opd} .................... opd.destroy › OpdDestroy

// Agenda Management
GET|HEAD   agenda ....................... agenda.index › AgendaIndex
GET|HEAD   agenda/create ................ agenda.create › AgendaCreate
POST       agenda ....................... agenda.store › AgendaStore
GET|HEAD   agenda/{agenda}/edit ......... agenda.edit › AgendaEdit
PUT|PATCH  agenda/{agenda} .............. agenda.update › AgendaUpdate
DELETE     agenda/{agenda} .............. agenda.destroy › AgendaDestroy
GET|HEAD   agenda/{agenda}/detail ....... agenda.detail › AgendaDetail
GET|HEAD   agenda/{agenda}/rekap ........ agenda.rekap › AgendaRekap
GET|HEAD   agenda/{agenda}/pdf .......... agenda.pdf › AgendaPdfExport

// User Management (existing)
GET|HEAD   users ........................ users.index › UserIndex
GET|HEAD   users/create ................. users.create › UserCreate
POST       users ........................ users.store › UserStore
GET|HEAD   users/{user}/edit ............ users.edit › UserEdit
PUT|PATCH  users/{user} .................. users.update › UserUpdate
DELETE     users/{user} ................. users.destroy › UserDestroy

// Role Management (existing)
GET|HEAD   roles ........................ roles.index › RoleIndex
GET|HEAD   roles/create ................. roles.create › RoleCreate
POST       roles ........................ roles.store › RoleStore
GET|HEAD   roles/{role}/edit ............ roles.edit › RoleEdit
PUT|PATCH  roles/{role} .................. roles.update › RoleUpdate
DELETE     roles/{role} ................. roles.destroy › RoleDestroy

// Permission Management (existing)
GET|HEAD   permissions .................. permissions.index › PermissionIndex
GET|HEAD   permissions/create ............. permissions.create › PermissionCreate
POST       permissions .................. permissions.store › PermissionStore
GET|HEAD   permissions/{permission}/edit .. permissions.edit › PermissionEdit
PUT|PATCH  permissions/{permission} ...... permissions.update › PermissionUpdate
DELETE     permissions/{permission} ..... permissions.destroy › PermissionDestroy
```

### 1.3 Public Routes (No Authentication)

```php
// Attendance Form (Accessed via QR Code)
GET|HEAD   attendance/{slug} .............. attendance.form › AttendanceForm
POST       attendance/{slug} .............. attendance.store › AttendanceStore

// Success Page
GET|HEAD   attendance-success ............. attendance.success › AttendanceSuccess
```

### 1.4 API Routes (Optional for Mobile/External Integration)

```php
// API Routes (routes/api.php)
GET|HEAD   api/agenda/{agenda}/attendance.. api.agenda.attendance › ApiAgendaAttendance
POST       api/attendance ................. api.attendance.store › ApiAttendanceStore
GET|HEAD   api/opd ........................ api.opd.index › ApiOpdIndex
```

## 2. Route Implementation

### 2.1 Web Routes (routes/web.php)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\DashboardIndex;
use App\Livewire\Opd\OpdIndex;
use App\Livewire\Opd\OpdCreate;
use App\Livewire\Opd\OpdEdit;
use App\Livewire\Agenda\AgendaIndex;
use App\Livewire\Agenda\AgendaCreate;
use App\Livewire\Agenda\AgendaEdit;
use App\Livewire\Agenda\AgendaDetail;
use App\Livewire\Agenda\AgendaRekap;
use App\Http\Controllers\AgendaController;
use App\Livewire\Public\AttendanceForm;
use App\Livewire\Public\AttendanceSuccess;

// Dashboard
Route::get('/dashboard', DashboardIndex::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// OPD Management Routes
Route::prefix('opd')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', OpdIndex::class)->name('opd.index');
    Route::get('/create', OpdCreate::class)->name('opd.create');
    Route::post('/', [OpdController::class, 'store'])->name('opd.store');
    Route::get('/{opd}/edit', OpdEdit::class)->name('opd.edit');
    Route::put('/{opd}', [OpdController::class, 'update'])->name('opd.update');
    Route::delete('/{opd}', [OpdController::class, 'destroy'])->name('opd.destroy');
});

// Agenda Management Routes
Route::prefix('agenda')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', AgendaIndex::class)->name('agenda.index');
    Route::get('/create', AgendaCreate::class)->name('agenda.create');
    Route::post('/', [AgendaController::class, 'store'])->name('agenda.store');
    Route::get('/{agenda}/edit', AgendaEdit::class)->name('agenda.edit');
    Route::put('/{agenda}', [AgendaController::class, 'update'])->name('agenda.update');
    Route::delete('/{agenda}', [AgendaController::class, 'destroy'])->name('agenda.destroy');
    Route::get('/{agenda}/detail', AgendaDetail::class)->name('agenda.detail');
    Route::get('/{agenda}/rekap', AgendaRekap::class)->name('agenda.rekap');
    Route::get('/{agenda}/pdf', [AgendaController::class, 'exportPdf'])->name('agenda.pdf');
});

// Public Attendance Routes (No Authentication Required)
Route::get('/attendance/{slug}', AttendanceForm::class)->name('attendance.form');
Route::post('/attendance/{slug}', [AttendanceController::class, 'store'])->name('attendance.store');
Route::get('/attendance-success', AttendanceSuccess::class)->name('attendance.success');
```

### 2.2 API Routes (routes/api.php)

```php
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OpdController;
use App\Http\Controllers\Api\AgendaController;
use App\Http\Controllers\Api\AttendanceController;

// Public API Routes (for QR code scanning)
Route::get('/agenda/{agenda}/attendance', [AgendaController::class, 'getAttendanceData']);
Route::post('/attendance', [AttendanceController::class, 'store']);

// Protected API Routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/opd', [OpdController::class, 'index']);
    Route::get('/agenda', [AgendaController::class, 'index']);
    Route::get('/agenda/{agenda}', [AgendaController::class, 'show']);
});
```

## 3. Controller Implementation

### 3.1 AgendaController (app/Http/Controllers/AgendaController.php)

```php
<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Services\PdfExportService;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'opd_id' => 'required|exists:tb_opd,id',
            'name' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'link_paparan' => 'nullable|url',
            'link_zoom' => 'nullable|url',
            'catatan' => 'nullable|string'
        ]);

        // Generate unique slug
        $slug = \Str::slug($validated['name'] . '-' . date('Y-m-d'));
        $validated['slug'] = $slug;
        $validated['user_id'] = auth()->id();

        // Create agenda
        $agenda = Agenda::create($validated);

        // Generate QR Code (handled by Livewire component)
        // Redirect to detail page with QR code
        return redirect()->route('agenda.detail', $agenda)
            ->with('success', 'Agenda berhasil dibuat dan QR Code telah dihasilkan.');
    }

    public function update(Request $request, Agenda $agenda)
    {
        $this->authorize('update', $agenda);

        $validated = $request->validate([
            'opd_id' => 'required|exists:tb_opd,id',
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'link_paparan' => 'nullable|url',
            'link_zoom' => 'nullable|url',
            'catatan' => 'nullable|string'
        ]);

        // Update slug if name changed
        if ($agenda->name !== $validated['name']) {
            $validated['slug'] = \Str::slug($validated['name'] . '-' . $validated['date']);
        }

        $agenda->update($validated);

        return redirect()->route('agenda.index')
            ->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $this->authorize('delete', $agenda);

        // Delete associated QR code file
        if ($agenda->barcode) {
            \Storage::disk('public')->delete($agenda->barcode);
        }

        $agenda->delete();

        return redirect()->route('agenda.index')
            ->with('success', 'Agenda berhasil dihapus.');
    }

    public function exportPdf(Agenda $agenda)
    {
        $this->authorize('view', $agenda);

        $pdfService = new PdfExportService();
        return $pdfService->exportAttendanceReport($agenda->id);
    }
}
```

### 3.2 AttendanceController (app/Http/Controllers/AttendanceController.php)

```php
<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Absensi;
use App\Services\SignatureService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function store(Request $request, $slug)
    {
        $agenda = Agenda::where('slug', $slug)->firstOrFail();

        // Check if agenda is still valid (not past date)
        if ($agenda->date < now()->toDateString()) {
            return redirect()->back()
                ->with('error', 'Agenda ini sudah berakhir.');
        }

        $validated = $request->validate([
            'nip_nik' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'asal_daerah' => 'required|in:dalam_kota,luar_kota',
            'telp' => 'required|string|max:20',
            'opd_id' => 'required_if:asal_daerah,dalam_kota|exists:tb_opd,id',
            'instansi' => 'required_if:asal_daerah,luar_kota|string|max:255',
            'ttd' => 'required|string'
        ]);

        // Check for duplicate attendance (same NIP/NIK for same agenda)
        $existingAttendance = Absensi::where('agenda_id', $agenda->id)
            ->where('nip_nik', $validated['nip_nik'])
            ->first();

        if ($existingAttendance) {
            return redirect()->back()
                ->with('error', 'Anda sudah melakukan absensi untuk agenda ini.');
        }

        $validated['agenda_id'] = $agenda->id;

        // Handle digital signature
        if ($request->has('ttd')) {
            $signatureService = new SignatureService();
            $signaturePath = $signatureService->saveSignature(
                $validated['ttd'],
                time() // Temporary ID, will be updated after creation
            );
            $validated['ttd'] = $signaturePath;
        }

        // Create attendance record
        $absensi = Absensi::create($validated);

        // Update signature filename with actual ID
        if ($absensi->ttd) {
            $newSignaturePath = $signatureService->saveSignature(
                $request->input('ttd'),
                $absensi->id
            );
            $absensi->update(['ttd' => $newSignaturePath]);
        }

        return redirect()->route('attendance.success')
            ->with('success', 'Absensi berhasil disimpan. Terima kasih atas kehadiran Anda.');
    }
}
```

## 4. Livewire Component Routes

### 4.1 Component Registration

Livewire components are automatically registered based on their class names and locations:

```php
// app/Livewire/Dashboard/DashboardIndex.php
// Automatically registered as: dashboard.dashboard-index
// Route: Route::get('/dashboard', DashboardIndex::class)->name('dashboard');

// app/Livewire/Opd/OpdIndex.php
// Automatically registered as: opd.opd-index
// Route: Route::get('/opd', OpdIndex::class)->name('opd.index');

// app/Livewire/Agenda/AgendaCreate.php
// Automatically registered as: agenda.agenda-create
// Route: Route::get('/agenda/create', AgendaCreate::class)->name('agenda.create');
```

### 4.2 Component Parameters

```php
// For components with route parameters
// app/Livewire/Opd/OpdEdit.php
// Route: Route::get('/opd/{opd}/edit', OpdEdit::class)->name('opd.edit');

// The component will receive the Opd model automatically
class OpdEdit extends Component
{
    public Opd $opd;
    
    public function mount(Opd $opd)
    {
        $this->opd = $opd;
    }
}
```

## 5. Middleware Configuration

### 5.1 Route Middleware

```php
// Applied to all admin routes
Route::middleware(['auth', 'verified'])->group(function () {
    // All admin routes here
});

// Applied to specific routes
Route::get('/agenda/{agenda}/pdf', [AgendaController::class, 'exportPdf'])
    ->middleware(['auth', 'verified', 'can:export,agenda'])
    ->name('agenda.pdf');
```

### 5.2 Custom Middleware (if needed)

```php
// app/Http/Middleware/EnsureAgendaIsActive.php
namespace App\Http\Middleware;

use Closure;
use App\Models\Agenda;

class EnsureAgendaIsActive
{
    public function handle($request, Closure $next)
    {
        $agenda = Agenda::find($request->route('agenda'));
        
        if (!$agenda || $agenda->date < now()->toDateString()) {
            return redirect()->route('agenda.index')
                ->with('error', 'Agenda ini tidak aktif atau sudah berakhir.');
        }
        
        return $next($request);
    }
}
```

## 6. Route Model Binding

### 6.1 Implicit Binding

```php
// Route: /agenda/{agenda}
// Will automatically resolve Agenda model by ID or slug
Route::get('/agenda/{agenda}', AgendaDetail::class)->name('agenda.detail');

// In component:
public function mount(Agenda $agenda)
{
    $this->agenda = $agenda;
}
```

### 6.2 Custom Binding (for slug)

```php
// app/Providers/RouteServiceProvider.php
public function boot()
{
    parent::boot();
    
    Route::bind('agenda', function ($value) {
        return Agenda::where('slug', $value)->firstOrFail();
    });
}
```

## 7. URL Generation

### 7.1 Named Routes

```php
// Generate URLs in views
route('agenda.index')           // /agenda
route('agenda.detail', $agenda) // /agenda/{agenda-slug}/detail
route('attendance.form', ['slug' => $agenda->slug]) // /attendance/{agenda-slug}

// Generate QR Code URLs
$url = route('attendance.form', ['slug' => $agenda->slug]);
```

### 7.2 Asset URLs

```php
// For QR codes and signatures
asset('storage/' . $agenda->barcode)     // Public QR code
asset('storage/' . $attendance->ttd)   // Public signature
```

## 8. Error Handling

### 8.1 404 Handling

```php
// For missing agendas
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
```

### 8.2 Custom Error Pages

```php
// resources/views/errors/404.blade.php
@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
    <p class="text-xl text-gray-600 mb-8">Halaman yang Anda cari tidak ditemukan.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
</div>
@endsection
```

This routing documentation provides a complete guide for implementing all necessary routes for the Agenda & Absensi QR Code application.

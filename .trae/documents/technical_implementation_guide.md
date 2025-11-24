# Technical Implementation Guide - Agenda & Absensi QR Code

## 1. Database Schema Implementation

### 1.1 Create Migration Files

```bash
# Create migrations for tb_opd, tb_agenda, tb_absensi
php artisan make:migration create_opds_table
php artisan make:migration create_agendas_table
php artisan make:migration create_absensis_table
```

### 1.2 Migration Structure

#### tb_opd (OPD Management)
```php
// database/migrations/xxxx_create_opds_table.php
Schema::create('tb_opd', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('singkatan');
    $table->text('alamat');
    $table->string('telp');
    $table->string('logo')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

#### tb_agenda (Agenda Management)
```php
// database/migrations/xxxx_create_agendas_table.php
Schema::create('tb_agenda', function (Blueprint $table) {
    $table->id();
    $table->foreignId('opd_id')->constrained('tb_opd');
    $table->string('name');
    $table->string('slug')->unique();
    $table->date('date');
    $table->time('jam_mulai');
    $table->time('jam_selesai');
    $table->string('link_paparan')->nullable();
    $table->string('link_zoom')->nullable();
    $table->string('barcode')->nullable();
    $table->text('catatan')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

#### tb_absensi (Attendance)
```php
// database/migrations/xxxx_create_absensis_table.php
Schema::create('tb_absensi', function (Blueprint $table) {
    $table->id();
    $table->foreignId('agenda_id')->constrained('tb_agenda');
    $table->string('nip_nik');
    $table->string('name');
    $table->enum('asal_daerah', ['dalam_kota', 'luar_kota']);
    $table->string('telp');
    $table->foreignId('opd_id')->nullable()->constrained('tb_opd');
    $table->string('instansi')->nullable();
    $table->string('ttd')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

## 2. Model Implementation

### 2.1 OPD Model (app/Models/Opd.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opd extends Model
{
    use SoftDeletes;

    protected $table = 'tb_opd';
    
    protected $fillable = [
        'name',
        'singkatan', 
        'alamat',
        'telp',
        'logo'
    ];

    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}
```

### 2.2 Agenda Model (app/Models/Agenda.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use SoftDeletes;

    protected $table = 'tb_agenda';
    
    protected $fillable = [
        'opd_id',
        'name',
        'slug',
        'date',
        'jam_mulai',
        'jam_selesai',
        'link_paparan',
        'link_zoom',
        'barcode',
        'catatan'
    ];

    protected $casts = [
        'date' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i'
    ];

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
}
```

### 2.3 Absensi Model (app/Models/Absensi.php)
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absensi extends Model
{
    use SoftDeletes;

    protected $table = 'tb_absensi';
    
    protected $fillable = [
        'agenda_id',
        'nip_nik',
        'name',
        'asal_daerah',
        'telp',
        'opd_id',
        'instansi',
        'ttd'
    ];

    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class);
    }
}
```

## 3. Livewire Components Implementation

### 3.1 OPD Management Components

```bash
# Create Livewire components
php artisan make:livewire opd.opd-index
php artisan make:livewire opd.opd-create
php artisan make:livewire opd.opd-edit
```

### 3.2 Agenda Management Components

```bash
php artisan make:livewire agenda.agenda-index
php artisan make:livewire agenda.agenda-create
php artisan make:livewire agenda.agenda-edit
php artisan make:livewire agenda.agenda-detail
```

### 3.3 Dashboard Component

```bash
php artisan make:livewire dashboard.dashboard-index
```

### 3.4 Public Attendance Components

```bash
php artisan make:livewire public.attendance-form
php artisan make:livewire public.attendance-success
```

## 4. Routing Implementation

### 4.1 Admin Routes (routes/web.php)
```php
// OPD Management Routes
Route::prefix('opd')->middleware(['auth'])->group(function () {
    Route::get('/', App\Livewire\Opd\OpdIndex::class)->name('opd.index');
    Route::get('/create', App\Livewire\Opd\OpdCreate::class)->name('opd.create');
    Route::get('/{opd}/edit', App\Livewire\Opd\OpdEdit::class)->name('opd.edit');
});

// Agenda Management Routes
Route::prefix('agenda')->middleware(['auth'])->group(function () {
    Route::get('/', App\Livewire\Agenda\AgendaIndex::class)->name('agenda.index');
    Route::get('/create', App\Livewire\Agenda\AgendaCreate::class)->name('agenda.create');
    Route::get('/{agenda}/edit', App\Livewire\Agenda\AgendaEdit::class)->name('agenda.edit');
    Route::get('/{agenda}/detail', App\Livewire\Agenda\AgendaDetail::class)->name('agenda.detail');
    Route::get('/{agenda}/rekap', App\Livewire\Agenda\AgendaRekap::class)->name('agenda.rekap');
    Route::get('/{agenda}/pdf', [AgendaController::class, 'exportPdf'])->name('agenda.pdf');
});

// Dashboard Route
Route::get('/dashboard', App\Livewire\Dashboard\DashboardIndex::class)->middleware(['auth'])->name('dashboard');
```

### 4.2 Public Routes
```php
// Public Attendance Routes (No Auth Required)
Route::get('/attendance/{slug}', App\Livewire\Public\AttendanceForm::class)->name('attendance.form');
Route::get('/attendance-success', App\Livewire\Public\AttendanceSuccess::class)->name('attendance.success');
```

## 5. QR Code Implementation

### 5.1 Install Simple QR Code Package
```bash
composer require simplesoftwareio/simple-qrcode
```

### 5.2 QR Code Generation Service (app/Services/QrCodeService.php)
```php
<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class QrCodeService
{
    public function generateQrCode($agendaId, $slug)
    {
        $url = route('attendance.form', ['slug' => $slug]);
        $filename = 'qr_code_' . $agendaId . '_' . Str::random(10) . '.svg';
        $path = 'qr_codes/' . $filename;
        
        // Generate QR Code and save to storage
        $qrCode = QrCode::size(300)->generate($url);
        \Storage::disk('public')->put($path, $qrCode);
        
        return $path;
    }
}
```

### 5.3 QR Code Generation in AgendaCreate Component
```php
// In Livewire component after saving agenda
$qrCodeService = new QrCodeService();
$barcodePath = $qrCodeService->generateQrCode($agenda->id, $agenda->slug);
$agenda->update(['barcode' => $barcodePath]);
```

## 6. Digital Signature Implementation

### 6.1 Install Signature Pad
```bash
npm install signature_pad
```

### 6.2 JavaScript for Signature Pad (resources/js/signature-pad.js)
```javascript
import SignaturePad from 'signature_pad';

window.initializeSignaturePad = function(canvasId, hiddenInputId) {
    const canvas = document.getElementById(canvasId);
    const signaturePad = new SignaturePad(canvas);
    const hiddenInput = document.getElementById(hiddenInputId);
    
    // Resize canvas
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }
    
    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();
    
    // Clear button
    document.getElementById('clear-signature').addEventListener('click', function() {
        signaturePad.clear();
    });
    
    // Save signature
    document.getElementById('save-signature').addEventListener('click', function() {
        if (signaturePad.isEmpty()) {
            alert('Please provide signature first.');
            return;
        }
        
        const dataURL = signaturePad.toDataURL('image/png');
        hiddenInput.value = dataURL;
    });
};
```

### 6.3 Signature Storage Service (app/Services/SignatureService.php)
```php
<?php

namespace App\Services;

use Illuminate\Support\Str;

class SignatureService
{
    public function saveSignature($base64Data, $attendanceId)
    {
        // Remove base64 prefix
        $image = str_replace('data:image/png;base64,', '', $base64Data);
        $image = str_replace(' ', '+', $image);
        
        // Decode base64
        $imageData = base64_decode($image);
        
        // Generate filename
        $filename = 'signatures/signature_' . $attendanceId . '_' . Str::random(10) . '.png';
        
        // Save to storage
        \Storage::disk('public')->put($filename, $imageData);
        
        return $filename;
    }
}
```

## 7. PDF Export Implementation with COP OPD

### 7.1 Install DomPDF
```bash
composer require barryvdh/laravel-dompdf
```

### 7.2 PDF Export Service (app/Services/PdfExportService.php)
```php
<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Agenda;

class PdfExportService
{
    public function exportAttendanceReport($agendaId)
    {
        $agenda = Agenda::with(['opd', 'absensis' => function($query) {
            $query->orderBy('name');
        }])->findOrFail($agendaId);
        
        $data = [
            'agenda' => $agenda,
            'opd' => $agenda->opd,
            'attendances' => $agenda->absensis,
            'total_attendance' => $agenda->absensis->count()
        ];
        
        $pdf = Pdf::loadView('pdf.attendance-report', $data);
        
        return $pdf->download('rekap-absensi-' . $agenda->slug . '.pdf');
    }
}
```

### 7.3 PDF Blade Template (resources/views/pdf/attendance-report.blade.php)
```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi - {{ $agenda->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .kop-surat { text-align: center; margin-bottom: 30px; }
        .logo-container { display: flex; justify-content: center; align-items: center; }
        .logo { width: 80px; height: 80px; margin: 0 20px; }
        .kop-line { border-bottom: 3px solid #000; margin: 20px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .signature-cell { height: 60px; }
    </style>
</head>
<body>
    <!-- COP OPD Header -->
    <div class="kop-surat">
        <div class="logo-container">
            @if($opd->logo)
                <img src="{{ public_path('storage/' . $opd->logo) }}" alt="Logo OPD" class="logo">
            @endif
        </div>
        <h2>{{ strtoupper($opd->name) }}</h2>
        <p>{{ $opd->alamat }}</p>
        <p>Telp: {{ $opd->telp }}</p>
        <div class="kop-line"></div>
    </div>
    
    <!-- Agenda Details -->
    <h3 style="text-align: center;">REKAPITULASI ABSENSI</h3>
    <h4 style="text-align: center;">{{ strtoupper($agenda->name) }}</h4>
    <p style="text-align: center;">
        Tanggal: {{ $agenda->date->format('d F Y') }} | 
        Jam: {{ $agenda->jam_mulai }} - {{ $agenda->jam_selesai }}
    </p>
    
    <!-- Attendance Table -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP/NIK</th>
                <th>Asal</th>
                <th>No. Telp</th>
                <th>Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $index => $attendance)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $attendance->name }}</td>
                <td>{{ $attendance->nip_nik }}</td>
                <td>
                    @if($attendance->asal_daerah == 'dalam_kota')
                        {{ $attendance->opd->name ?? '-' }}
                    @else
                        {{ $attendance->instansi }}
                    @endif
                </td>
                <td>{{ $attendance->telp }}</td>
                <td class="signature-cell">
                    @if($attendance->ttd)
                        <img src="{{ public_path('storage/' . $attendance->ttd) }}" style="width: 100px; height: 40px;">
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <!-- Summary -->
    <p style="margin-top: 30px;">
        <strong>Total Kehadiran: {{ $total_attendance }} orang</strong>
    </p>
</body>
</html>
```

## 8. Dashboard Statistics Implementation

### 8.1 Dashboard Livewire Component (app/Livewire/Dashboard/DashboardIndex.php)
```php
<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Agenda;
use App\Models\Absensi;
use App\Models\Opd;
use Carbon\Carbon;

class DashboardIndex extends Component
{
    public $totalAgendas;
    public $activeAgendas;
    public $totalAttendances;
    public $attendanceByOpd;
    
    public function mount()
    {
        $this->loadStatistics();
    }
    
    public function loadStatistics()
    {
        $this->totalAgendas = Agenda::count();
        $this->activeAgendas = Agenda::where('date', '>=', Carbon::today())->count();
        $this->totalAttendances = Absensi::count();
        
        $this->attendanceByOpd = Opd::withCount(['absensis'])
            ->orderBy('absensis_count', 'desc')
            ->limit(5)
            ->get();
    }
    
    public function render()
    {
        return view('livewire.dashboard.dashboard-index');
    }
}
```

### 8.2 Dashboard Blade Template
```blade
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Agendas Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Total Agenda</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $totalAgendas }}</p>
            </div>
        </div>
    </div>
    
    <!-- Active Agendas Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Agenda Aktif</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $activeAgendas }}</p>
            </div>
        </div>
    </div>
    
    <!-- Total Attendances Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-700">Total Kehadiran</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $totalAttendances }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Attendance by OPD Chart -->
<div class="bg-white rounded-lg shadow p-6 mt-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">Statistik Kehadiran per OPD</h3>
    <div class="space-y-4">
        @foreach($attendanceByOpd as $opd)
        <div class="flex items-center justify-between">
            <span class="text-gray-600">{{ $opd->name }}</span>
            <div class="flex items-center">
                <div class="bg-blue-200 rounded-full h-2 w-32 mr-3">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $totalAttendances > 0 ? ($opd->absensis_count / $totalAttendances * 100) : 0 }}%"></div>
                </div>
                <span class="text-gray-900 font-semibold">{{ $opd->absensis_count }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
```

## 9. Sidebar Menu Updates

### 9.1 Update Sidebar (resources/views/components/sidebar.blade.php)
```blade
<!-- Add to existing sidebar -->
<li class="menu-item">
    <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="fas fa-tachometer-alt"></i>
        <span class="ml-3">Dashboard</span>
    </a>
</li>

<li class="menu-item">
    <a href="{{ route('agenda.index') }}" class="menu-link">
        <i class="fas fa-calendar-alt"></i>
        <span class="ml-3">Manajemen Agenda</span>
    </a>
</li>

<li class="menu-item">
    <a href="{{ route('opd.index') }}" class="menu-link">
        <i class="fas fa-building"></i>
        <span class="ml-3">Manajemen OPD</span>
    </a>
</li>
```

## 10. File Storage Configuration

### 10.1 Update filesystem config (config/filesystems.php)
```php
'disks' => [
    // ... existing disks
    
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
        'throw' => false,
    ],
],
```

### 10.2 Create Storage Links
```bash
php artisan storage:link
```

## 11. Validation Rules

### 11.1 OPD Validation
```php
$rules = [
    'name' => 'required|string|max:255',
    'singkatan' => 'required|string|max:50',
    'alamat' => 'required|string',
    'telp' => 'required|string|max:20',
    'logo' => 'nullable|image|max:2048'
];
```

### 11.2 Agenda Validation
```php
$rules = [
    'opd_id' => 'required|exists:tb_opd,id',
    'name' => 'required|string|max:255',
    'date' => 'required|date|after_or_equal:today',
    'jam_mulai' => 'required|date_format:H:i',
    'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
    'link_paparan' => 'nullable|url',
    'link_zoom' => 'nullable|url',
    'catatan' => 'nullable|string'
];
```

### 11.3 Attendance Validation
```php
$rules = [
    'agenda_id' => 'required|exists:tb_agenda,id',
    'nip_nik' => 'required|string|max:50',
    'name' => 'required|string|max:255',
    'asal_daerah' => 'required|in:dalam_kota,luar_kota',
    'telp' => 'required|string|max:20',
    'opd_id' => 'required_if:asal_daerah,dalam_kota|exists:tb_opd,id',
    'instansi' => 'required_if:asal_daerah,luar_kota|string|max:255',
    'ttd' => 'required|string'
];
```

## 12. Security Considerations

### 12.1 QR Code Security
- Validate QR code against active agenda only
- Check if agenda date is still valid
- Prevent duplicate attendance for same NIP/NIK per agenda

### 12.2 File Upload Security
- Validate file types and sizes
- Store files in private disk if sensitive
- Sanitize file names
- Implement rate limiting for file uploads

### 12.3 PDF Security
- Ensure proper authentication before PDF export
- Validate user permissions for agenda access
- Sanitize all data before PDF generation

## 13. Testing Implementation

### 13.1 Feature Tests
```bash
php artisan make:test OpdManagementTest
php artisan make:test AgendaManagementTest
php artisan make:test AttendanceTest
php artisan make:test PdfExportTest
```

### 13.2 Test Coverage
- CRUD operations for OPD
- CRUD operations for Agenda with QR generation
- Public attendance form submission
- PDF export functionality
- Dashboard statistics accuracy

## 14. Performance Optimization

### 14.1 Database Indexes
```php
// Add to migrations
$table->index('date');
$table->index('opd_id');
$table->index('agenda_id');
$table->index('slug');
```

### 14.2 Caching Strategy
- Cache dashboard statistics for 5 minutes
- Cache QR codes permanently (until agenda changes)
- Cache PDF exports for 1 hour

### 14.3 Image Optimization
- Resize uploaded logos to max 500x500px
- Compress signature images
- Use appropriate image formats (PNG for signatures, JPEG for photos)

This implementation guide provides a complete roadmap for building the Agenda & Absensi QR Code application according to the PRD specifications.
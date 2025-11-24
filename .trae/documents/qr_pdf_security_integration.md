# QR Code, PDF Export & Security Integration Guide

## 1. QR Code Integration

### 1.1 Install Simple QR Code Package

```bash
composer require simplesoftwareio/simple-qrcode
```

### 1.2 QR Code Service Implementation (app/Services/QrCodeService.php)

```php
<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class QrCodeService
{
    private $size = 300;
    private $margin = 2;
    private $errorCorrection = 'H'; // High error correction
    
    /**
     * Generate QR Code for agenda attendance
     */
    public function generateQrCode($agendaId, $slug, $customOptions = [])
    {
        $url = route('attendance.form', ['slug' => $slug]);
        $filename = 'qr_code_' . $agendaId . '_' . Str::random(10) . '.svg';
        $path = 'qr_codes/' . $filename;
        
        // Merge custom options with defaults
        $options = array_merge([
            'size' => $this->size,
            'margin' => $this->margin,
            'errorCorrection' => $this->errorCorrection,
            'backgroundColor' => [255, 255, 255], // White
            'color' => [0, 0, 0], // Black
            'style' => 'square', // square, dot, round
            'eye' => 'square' // square, circle
        ], $customOptions);
        
        try {
            // Generate QR Code with custom styling
            $qrCode = QrCode::size($options['size'])
                ->margin($options['margin'])
                ->errorCorrection($options['errorCorrection'])
                ->backgroundColor($options['backgroundColor'][0], $options['backgroundColor'][1], $options['backgroundColor'][2])
                ->color($options['color'][0], $options['color'][1], $options['color'][2])
                ->style($options['style'])
                ->eye($options['eye'])
                ->generate($url);
            
            // Save to storage
            Storage::disk('public')->put($path, $qrCode);
            
            // Log successful generation
            \Log::info('QR Code generated', [
                'agenda_id' => $agendaId,
                'path' => $path,
                'url' => $url
            ]);
            
            return $path;
            
        } catch (\Exception $e) {
            \Log::error('QR Code generation failed', [
                'agenda_id' => $agendaId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
    
    /**
     * Generate QR Code with custom logo (if needed)
     */
    public function generateQrCodeWithLogo($agendaId, $slug, $logoPath = null)
    {
        $url = route('attendance.form', ['slug' => $slug]);
        $filename = 'qr_code_logo_' . $agendaId . '_' . Str::random(10) . '.png';
        $path = 'qr_codes/' . $filename;
        
        $qrCode = QrCode::size(400)
            ->margin(3)
            ->errorCorrection('H')
            ->merge($logoPath, 0.3, true) // 30% logo size, absolute position
            ->generate($url);
        
        Storage::disk('public')->put($path, $qrCode);
        
        return $path;
    }
    
    /**
     * Regenerate QR Code for existing agenda
     */
    public function regenerateQrCode($agenda)
    {
        // Delete old QR code if exists
        if ($agenda->barcode) {
            Storage::disk('public')->delete($agenda->barcode);
        }
        
        // Generate new QR code
        $newPath = $this->generateQrCode($agenda->id, $agenda->slug);
        
        // Update agenda record
        $agenda->update(['barcode' => $newPath]);
        
        return $newPath;
    }
    
    /**
     * Validate QR Code integrity
     */
    public function validateQrCode($filePath)
    {
        $fullPath = Storage::disk('public')->path($filePath);
        
        if (!file_exists($fullPath)) {
            return false;
        }
        
        // Check file size (should be reasonable)
        $fileSize = filesize($fullPath);
        if ($fileSize < 100 || $fileSize > 50000) { // Between 100 bytes and 50KB
            return false;
        }
        
        // Check if it's a valid SVG file
        $content = file_get_contents($fullPath);
        if (!str_contains($content, '<svg') || !str_contains($content, '</svg>')) {
            return false;
        }
        
        return true;
    }
}
```

### 1.3 QR Code Generation in AgendaCreate Component

```php
// In Livewire component after saving agenda
use App\Services\QrCodeService;

public function store()
{
    $this->validate();
    
    // Create agenda
    $agenda = Agenda::create([
        // ... agenda data
        'slug' => Str::slug($this->name . '-' . $this->date),
    ]);
    
    // Generate QR Code
    $qrCodeService = new QrCodeService();
    $barcodePath = $qrCodeService->generateQrCode($agenda->id, $agenda->slug);
    
    // Update agenda with QR code path
    $agenda->update(['barcode' => $barcodePath]);
    
    // Redirect to detail page
    return redirect()->route('agenda.detail', $agenda)
        ->with('success', 'Agenda berhasil dibuat dan QR Code telah dihasilkan.');
}
```

### 1.4 QR Code Display in Blade Template

```blade
<!-- resources/views/livewire/agenda/agenda-detail.blade.php -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-700 mb-4">QR Code Absensi</h3>
    
    @if($agenda->barcode)
        <div class="text-center">
            <div class="inline-block p-4 bg-white border-2 border-gray-200 rounded-lg">
                <img src="{{ asset('storage/' . $agenda->barcode) }}" 
                     alt="QR Code" 
                     class="w-64 h-64 mx-auto">
            </div>
            
            <div class="mt-4 space-x-2">
                <button wire:click="downloadQrCode" 
                        class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                    Download QR Code
                </button>
                <button wire:click="printQrCode" 
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Cetak QR Code
                </button>
                <button wire:click="regenerateQrCode" 
                        class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">
                    Regenerate QR Code
                </button>
            </div>
            
            <p class="text-sm text-gray-600 mt-2">
                URL: {{ route('attendance.form', $agenda->slug) }}
            </p>
        </div>
    @else
        <div class="text-center text-gray-500">
            <p>QR Code belum tersedia</p>
            <button wire:click="generateQrCode" 
                    class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Generate QR Code
            </button>
        </div>
    @endif
</div>
```

## 2. PDF Export with COP OPD Integration

### 2.1 Install DomPDF Package

```bash
composer require barryvdh/laravel-dompdf
```

### 2.2 PDF Export Service (app/Services/PdfExportService.php)

```php
<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Agenda;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PdfExportService
{
    private $pageSize = 'A4';
    private $orientation = 'portrait';
    
    /**
     * Export attendance report with COP OPD
     */
    public function exportAttendanceReport($agendaId, $options = [])
    {
        $agenda = Agenda::with(['opd', 'absensis' => function($query) {
            $query->orderBy('name');
        }])->findOrFail($agendaId);
        
        $data = [
            'agenda' => $agenda,
            'opd' => $agenda->opd,
            'attendances' => $agenda->absensis,
            'total_attendance' => $agenda->absensis->count(),
            'generated_at' => Carbon::now()->format('d F Y H:i'),
            'generated_by' => auth()->user()->name ?? 'System',
            'options' => array_merge([
                'include_logo' => true,
                'include_qr' => false,
                'include_signature' => true,
                'page_numbers' => true
            ], $options)
        ];
        
        try {
            $pdf = Pdf::loadView('pdf.attendance-report', $data)
                ->setPaper($this->pageSize, $this->orientation)
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true)
                ->setOption('defaultFont', 'Arial');
            
            $filename = 'rekap-absensi-' . $agenda->slug . '-' . time() . '.pdf';
            
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            \Log::error('PDF generation failed', [
                'agenda_id' => $agendaId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
    
    /**
     * Generate PDF preview (for testing)
     */
    public function previewAttendanceReport($agendaId)
    {
        $agenda = Agenda::with(['opd', 'absensis'])->findOrFail($agendaId);
        
        $data = [
            'agenda' => $agenda,
            'opd' => $agenda->opd,
            'attendances' => $agenda->absensis,
            'total_attendance' => $agenda->absensis->count(),
            'generated_at' => Carbon::now()->format('d F Y H:i'),
            'generated_by' => auth()->user()->name ?? 'System'
        ];
        
        return Pdf::loadView('pdf.attendance-report', $data)
            ->setPaper($this->pageSize, $this->orientation)
            ->stream();
    }
}
```

### 2.3 PDF Blade Template with COP OPD (resources/views/pdf/attendance-report.blade.php)

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi - {{ $agenda->name }}</title>
    <style>
        @page {
            margin: 2cm 1.5cm;
            size: {{ $orientation }};
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        
        .kop-surat {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 20px;
        }
        
        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 10px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        
        .kop-text h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
            text-transform: uppercase;
        }
        
        .kop-text p {
            margin: 2px 0;
            font-size: 11px;
        }
        
        .kop-line {
            border-bottom: 2px solid #000;
            margin: 20px 0;
        }
        
        .report-title {
            text-align: center;
            margin: 30px 0;
        }
        
        .report-title h3 {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 5px 0;
        }
        
        .agenda-details {
            margin: 20px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        
        .agenda-details table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .agenda-details td {
            padding: 5px;
            vertical-align: top;
        }
        
        .agenda-details .label {
            font-weight: bold;
            width: 150px;
        }
        
        table.attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 11px;
        }
        
        table.attendance-table th,
        table.attendance-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }
        
        table.attendance-table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        
        table.attendance-table .number {
            text-align: center;
            width: 30px;
        }
        
        table.attendance-table .signature {
            width: 100px;
            height: 40px;
            text-align: center;
        }
        
        table.attendance-table .signature img {
            max-width: 80px;
            max-height: 30px;
            object-fit: contain;
        }
        
        .summary {
            margin-top: 30px;
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 5px;
            text-align: center;
        }
        
        .footer {
            margin-top: 50px;
            text-align: right;
            font-size: 11px;
        }
        
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        
        .signature-box {
            text-align: center;
            width: 200px;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        @media print {
            .page-break {
                page-break-after: always;
            }
        }
    </style>
</head>
<body>
    <!-- COP OPD Header -->
    <div class="kop-surat">
        <div class="logo-container">
            <!-- Government Logo (if available) -->
            <img src="{{ public_path('images/logo-pemkot.png') }}" alt="Logo Pemkot" class="logo">
            
            <!-- OPD Logo (if available) -->
            @if($opd->logo && file_exists(public_path('storage/' . $opd->logo)))
                <img src="{{ public_path('storage/' . $opd->logo) }}" alt="Logo {{ $opd->name }}" class="logo">
            @endif
        </div>
        
        <div class="kop-text">
            <h2>PEMERINTAH KOTA XYZ</h2>
            <h2>{{ strtoupper($opd->name) }}</h2>
            <p>{{ $opd->alamat }}</p>
            <p>Telp: {{ $opd->telp }} | Email: info@kota.go.id</p>
            <p>Website: www.kota.go.id</p>
        </div>
    </div>
    
    <!-- Report Title -->
    <div class="report-title">
        <h3>REKAPITULASI ABSENSI</h3>
        <h3>{{ strtoupper($agenda->name) }}</h3>
    </div>
    
    <!-- Agenda Details -->
    <div class="agenda-details">
        <table>
            <tr>
                <td class="label">Tanggal Kegiatan</td>
                <td>: {{ $agenda->date->format('d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">Waktu</td>
                <td>: {{ $agenda->jam_mulai }} - {{ $agenda->jam_selesai }} WIB</td>
            </tr>
            <tr>
                <td class="label">Penyelenggara</td>
                <td>: {{ $opd->name }}</td>
            </tr>
            @if($agenda->catatan)
            <tr>
                <td class="label">Catatan</td>
                <td>: {{ $agenda->catatan }}</td>
            </tr>
            @endif
        </table>
    </div>
    
    <!-- Attendance Table -->
    <table class="attendance-table">
        <thead>
            <tr>
                <th class="number">No</th>
                <th>Nama Lengkap</th>
                <th>NIP/NIK</th>
                <th>Asal/Instansi</th>
                <th>No. Telp</th>
                <th class="signature">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $index => $attendance)
            <tr>
                <td class="number">{{ $index + 1 }}</td>
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
                <td class="signature">
                    @if($attendance->ttd && file_exists(public_path('storage/' . $attendance->ttd)))
                        <img src="{{ public_path('storage/' . $attendance->ttd) }}" 
                             alt="Tanda Tangan">
                    @else
                        <span style="color: #999;">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #999;">
                    Belum ada data absensi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Summary -->
    <div class="summary">
        <strong>Total Kehadiran: {{ $total_attendance }} orang</strong>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <p>Dicetak pada: {{ $generated_at }}</p>
        <p>Oleh: {{ $generated_by }}</p>
    </div>
    
    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Kepala {{ $opd->name }}</p>
            <br><br><br>
            <p>_____________________</p>
            <p>NIP. _____________________</p>
        </div>
        
        <div class="signature-box">
            <p>{{ $agenda->opd->alamat ?? 'Kota XYZ' }}, {{ $agenda->date->format('d F Y') }}</p>
            <p>Petugas Absensi</p>
            <br><br><br>
            <p>_____________________</p>
            <p>NIP. _____________________</p>
        </div>
    </div>
</body>
</html>
```

### 2.4 PDF Export Controller Method

```php
// In AgendaController.php
public function exportPdf(Agenda $agenda)
{
    $this->authorize('view', $agenda);
    
    $pdfService = new PdfExportService();
    
    // Log PDF export activity
    \Log::info('PDF export initiated', [
        'agenda_id' => $agenda->id,
        'user_id' => auth()->id(),
        'timestamp' => now()
    ]);
    
    try {
        return $pdfService->exportAttendanceReport($agenda->id);
    } catch (\Exception $e) {
        \Log::error('PDF export failed', [
            'agenda_id' => $agenda->id,
            'error' => $e->getMessage()
        ]);
        
        return redirect()->back()
            ->with('error', 'Gagal mengekspor PDF. Silakan coba lagi.');
    }
}
```

## 3. Security Implementation

### 3.1 QR Code Security

```php
// app/Http/Middleware/ValidateQrCodeAccess.php
<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Agenda;
use Carbon\Carbon;

class ValidateQrCodeAccess
{
    public function handle($request, Closure $next)
    {
        $slug = $request->route('slug');
        $agenda = Agenda::where('slug', $slug)->first();
        
        if (!$agenda) {
            return redirect()->route('home')
                ->with('error', 'Agenda tidak ditemukan.');
        }
        
        // Check if agenda is still active (not past date)
        if ($agenda->date < Carbon::today()) {
            return redirect()->route('home')
                ->with('error', 'Agenda ini sudah berakhir.');
        }
        
        // Check if agenda is deleted
        if ($agenda->deleted_at) {
            return redirect()->route('home')
                ->with('error', 'Agenda ini tidak tersedia.');
        }
        
        // Add agenda to request for later use
        $request->merge(['agenda' => $agenda]);
        
        return $next($request);
    }
}
```

### 3.2 Attendance Validation

```php
// In AttendanceController.php
public function store(Request $request, $slug)
{
    $agenda = $request->get('agenda'); // Set by middleware
    
    // Validate request
    $validated = $request->validate([
        'nip_nik' => 'required|string|max:50',
        'name' => 'required|string|max:255',
        'asal_daerah' => 'required|in:dalam_kota,luar_kota',
        'telp' => 'required|string|max:20',
        'opd_id' => 'required_if:asal_daerah,dalam_kota|exists:tb_opd,id',
        'instansi' => 'required_if:asal_daerah,luar_kota|string|max:255',
        'ttd' => 'required|string'
    ]);
    
    // Check for duplicate attendance
    $existingAttendance = Absensi::where('agenda_id', $agenda->id)
        ->where('nip_nik', $validated['nip_nik'])
        ->whereNull('deleted_at')
        ->first();
    
    if ($existingAttendance) {
        return redirect()->back()
            ->with('error', 'Anda sudah melakukan absensi untuk agenda ini.');
    }
    
    // Rate limiting - max 5 attempts per IP per hour
    $key = 'attendance_attempts_' . $request->ip() . '_' . $agenda->id;
    if (Cache::has($key) && Cache::get($key) >= 5) {
        return redirect()->back()
            ->with('error', 'Terlalu banyak percobaan. Silakan coba lagi dalam 1 jam.');
    }
    
    // Increment attempt counter
    Cache::increment($key, 1, now()->addHour());
    
    // Process attendance...
}
```

### 3.3 File Upload Security

```php
// In Livewire components
protected function validateAndStoreFile($file, $directory, $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'])
{
    // Validate file type
    $extension = strtolower($file->getClientOriginalExtension());
    if (!in_array($extension, $allowedTypes)) {
        throw new \Exception('File type not allowed');
    }
    
    // Validate file size (max 2MB)
    if ($file->getSize() > 2048000) {
        throw new \Exception('File size exceeds maximum limit (2MB)');
    }
    
    // Validate MIME type
    $mimeType = $file->getMimeType();
    $allowedMimeTypes = [
        'image/jpeg', 'image/jpg', 'image/png', 'image/gif'
    ];
    
    if (!in_array($mimeType, $allowedMimeTypes)) {
        throw new \Exception('Invalid file type');
    }
    
    // Generate unique filename
    $filename = Str::random(40) . '.' . $extension;
    
    // Store file
    $path = $file->storeAs($directory, $filename, 'public');
    
    return $path;
}

// Usage in component
public function store()
{
    $this->validate();
    
    try {
        $logoPath = null;
        if ($this->logo) {
            $logoPath = $this->validateAndStoreFile($this->logo, 'logos', ['png', 'jpg', 'jpeg']);
        }
        
        // Create record...
        
    } catch (\Exception $e) {
        session()->flash('error', 'File upload failed: ' . $e->getMessage());
        return;
    }
}
```

### 3.4 Digital Signature Security

```php
// app/Services/SignatureService.php
<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SignatureService
{
    /**
     * Validate and save digital signature
     */
    public function saveSignature($base64Data, $attendanceId)
    {
        // Validate base64 format
        if (!preg_match('/^data:image\/png;base64,/', $base64Data)) {
            throw new \Exception('Invalid signature format');
        }
        
        // Remove base64 prefix
        $image = str_replace('data:image/png;base64,', '', $base64Data);
        $image = str_replace(' ', '+', $image);
        
        // Decode base64
        $imageData = base64_decode($image);
        if (!$imageData) {
            throw new \Exception('Failed to decode signature data');
        }
        
        // Validate image dimensions (should be reasonable)
        $imageInfo = getimagesizefromstring($imageData);
        if (!$imageInfo || $imageInfo[2] !== IMAGETYPE_PNG) {
            throw new \Exception('Invalid signature image format');
        }
        
        // Check dimensions (max 800x400 pixels)
        if ($imageInfo[0] > 800 || $imageInfo[1] > 400) {
            throw new \Exception('Signature dimensions too large');
        }
        
        // Check file size (max 100KB)
        if (strlen($imageData) > 102400) {
            throw new \Exception('Signature file size too large');
        }
        
        // Generate secure filename
        $filename = 'signatures/signature_' . $attendanceId . '_' . Str::random(20) . '.png';
        
        // Save to storage
        Storage::disk('public')->put($filename, $imageData);
        
        return $filename;
    }
    
    /**
     * Validate signature integrity
     */
    public function validateSignature($filePath)
    {
        $fullPath = Storage::disk('public')->path($filePath);
        
        if (!file_exists($fullPath)) {
            return false;
        }
        
        // Validate it's a PNG file
        $imageInfo = getimagesize($fullPath);
        if (!$imageInfo || $imageInfo[2] !== IMAGETYPE_PNG) {
            return false;
        }
        
        // Check file size is reasonable
        $fileSize = filesize($fullPath);
        if ($fileSize < 100 || $fileSize > 102400) { // 100 bytes to 100KB
            return false;
        }
        
        return true;
    }
}
```

### 3.5 Database Security

```php
// Use prepared statements (Laravel Eloquent handles this automatically)
// Example with raw queries
public function getAttendanceData($agendaId)
{
    return DB::select('
        SELECT a.*, o.name as opd_name 
        FROM tb_absensi a
        LEFT JOIN tb_opd o ON a.opd_id = o.id
        WHERE a.agenda_id = ? AND a.deleted_at IS NULL
        ORDER BY a.name ASC
    ', [$agendaId]);
}

// Prevent SQL injection in searches
public function searchAttendances($searchTerm)
{
    return Absensi::where('name', 'like', '%' . $searchTerm . '%')
        ->orWhere('nip_nik', 'like', '%' . $searchTerm . '%')
        ->get();
}

// Use mass assignment protection
// In models
protected $fillable = [
    'agenda_id', 'nip_nik', 'name', 'asal_daerah', 
    'telp', 'opd_id', 'instansi', 'ttd'
];

protected $guarded = ['id', 'created_at', 'updated_at'];
```

### 3.6 Rate Limiting

```php
// app/Providers/RouteServiceProvider.php
public function boot()
{
    parent::boot();
    
    // Rate limit for attendance submission
    RateLimiter::for('attendance', function (Request $request) {
        return Limit::perHour(5)->by($request->ip());
    });
    
    // Rate limit for PDF generation
    RateLimiter::for('pdf-export', function (Request $request) {
        return Limit::perMinute(3)->by($request->user()->id ?? $request->ip());
    });
}

// Apply rate limiting to routes
Route::middleware(['throttle:attendance'])->group(function () {
    Route::post('/attendance/{slug}', [AttendanceController::class, 'store']);
});

Route::middleware(['auth', 'throttle:pdf-export'])->group(function () {
    Route::get('/agenda/{agenda}/pdf', [AgendaController::class, 'exportPdf']);
});
```

### 3.7 Audit Logging

```php
// app/Services/AuditService.php
<?n
namespace App\Services;

use Illuminate\Support\Facades\Log;

class AuditService
{
    public function logAttendance($action, $data, $userId = null)
    {
        Log::channel('attendance')->info('Attendance activity', [
            'action' => $action,
            'data' => $data,
            'user_id' => $userId ?? auth()->id() ?? 'guest',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toDateTimeString()
        ]);
    }
    
    public function logPdfExport($agendaId, $userId)
    {
        Log::channel('pdf_export')->info('PDF export', [
            'agenda_id' => $agendaId,
            'user_id' => $userId,
            'ip_address' => request()->ip(),
            'timestamp' => now()->toDateTimeString()
        ]);
    }
    
    public function logQrCodeGeneration($agendaId, $userId)
    {
        Log::channel('qr_code')->info('QR Code generation', [
            'agenda_id' => $agendaId,
            'user_id' => $userId,
            'timestamp' => now()->toDateTimeString()
        ]);
    }
}

// Configure logging channels in config/logging.php
'channels' => [
    // ... existing channels
    
    'attendance' => [
        'driver' => 'single',
        'path' => storage_path('logs/attendance.log'),
        'level' => 'info',
    ],
    
    'pdf_export' => [
        'driver' => 'single',
        'path' => storage_path('logs/pdf_export.log'),
        'level' => 'info',
    ],
    
    'qr_code' => [
        'driver' => 'single',
        'path' => storage_path('logs/qr_code.log'),
        'level' => 'info',
    ],
],
```

This comprehensive integration guide provides all the necessary implementation details for QR Code generation, PDF export with COP OPD, and security measures for the Agenda & Absensi QR Code application.

# Livewire Components Implementation Guide

## 1. Dashboard Component

### 1.1 DashboardIndex Component (app/Livewire/Dashboard/DashboardIndex.php)

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
    public $recentAgendas;
    public $upcomingAgendas;
    
    public function mount()
    {
        $this->loadStatistics();
    }
    
    public function loadStatistics()
    {
        // Overall statistics
        $this->totalAgendas = Agenda::count();
        $this->activeAgendas = Agenda::where('date', '>=', Carbon::today())->count();
        $this->totalAttendances = Absensi::count();
        
        // Attendance statistics by OPD
        $this->attendanceByOpd = Opd::withCount(['absensis'])
            ->orderBy('absensis_count', 'desc')
            ->limit(5)
            ->get();
        
        // Recent agendas (last 5)
        $this->recentAgendas = Agenda::with(['opd'])
            ->where('date', '<=', Carbon::today())
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
        
        // Upcoming agendas (next 5)
        $this->upcomingAgendas = Agenda::with(['opd'])
            ->where('date', '>', Carbon::today())
            ->orderBy('date', 'asc')
            ->limit(5)
            ->get();
    }
    
    public function render()
    {
        return view('livewire.dashboard.dashboard-index', [
            'statistics' => [
                'total_agendas' => $this->totalAgendas,
                'active_agendas' => $this->activeAgendas,
                'total_attendances' => $this->totalAttendances,
                'attendance_by_opd' => $this->attendanceByOpd,
                'recent_agendas' => $this->recentAgendas,
                'upcoming_agendas' => $this->upcomingAgendas,
            ]
        ])->layout('components.layouts.app');
    }
}
```

### 1.2 Dashboard Blade Template (resources/views/livewire/dashboard/dashboard-index.blade.php)

```blade
<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Agenda & Absensi</h1>
        <p class="text-gray-600">Ringkasan aktivitas dan statistik sistem</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
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

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
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

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
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

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-700">OPD Terdaftar</h3>
                    <p class="text-3xl font-bold text-gray-900">{{ $attendanceByOpd->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance by OPD Chart -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Statistik Kehadiran per OPD</h3>
        <div class="space-y-4">
            @foreach($attendanceByOpd as $opd)
            <div class="flex items-center justify-between">
                <span class="text-gray-600 w-1/3">{{ $opd->name }}</span>
                <div class="flex items-center w-2/3">
                    <div class="bg-gray-200 rounded-full h-4 flex-1 mr-3">
                        <div class="bg-blue-600 h-4 rounded-full transition-all duration-300" 
                             style="width: {{ $totalAttendances > 0 ? ($opd->absensis_count / $totalAttendances * 100) : 0 }}%"></div>
                    </div>
                    <span class="text-gray-900 font-semibold text-sm w-12 text-right">{{ $opd->absensis_count }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Recent and Upcoming Agendas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Agendas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Agenda Terakhir</h3>
            <div class="space-y-3">
                @foreach($recentAgendas as $agenda)
                <div class="border-l-4 border-gray-300 pl-4">
                    <h4 class="font-medium text-gray-900">{{ $agenda->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $agenda->opd->name }}</p>
                    <p class="text-xs text-gray-500">{{ $agenda->date->format('d F Y') }} | {{ $agenda->jam_mulai }} - {{ $agenda->jam_selesai }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Upcoming Agendas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Agenda Mendatang</h3>
            <div class="space-y-3">
                @foreach($upcomingAgendas as $agenda)
                <div class="border-l-4 border-blue-500 pl-4">
                    <h4 class="font-medium text-gray-900">{{ $agenda->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $agenda->opd->name }}</p>
                    <p class="text-xs text-gray-500">{{ $agenda->date->format('d F Y') }} | {{ $agenda->jam_mulai }} - {{ $agenda->jam_selesai }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
```

## 2. OPD Management Components

### 2.1 OpdIndex Component (app/Livewire/Opd/OpdIndex.php)

```php
<?php

namespace App\Livewire\Opd;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Opd;

class OpdIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
            $this->sortField = $field;
        }
    }

    public function deleteOpd($opdId)
    {
        $opd = Opd::findOrFail($opdId);
        
        // Check if OPD has related agendas
        if ($opd->agendas()->exists()) {
            session()->flash('error', 'OPD ini tidak dapat dihapus karena masih memiliki agenda yang terkait.');
            return;
        }

        $opd->delete();
        session()->flash('success', 'OPD berhasil dihapus.');
    }

    public function render()
    {
        $opds = Opd::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('singkatan', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.opd.opd-index', [
            'opds' => $opds
        ])->layout('components.layouts.app');
    }
}
```

### 2.2 OpdCreate Component (app/Livewire/Opd/OpdCreate.php)

```php
<?php

namespace App\Livewire\Opd;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Opd;
use Illuminate\Support\Str;

class OpdCreate extends Component
{
    use WithFileUploads;

    public $name;
    public $singkatan;
    public $alamat;
    public $telp;
    public $logo;

    protected $rules = [
        'name' => 'required|string|max:255',
        'singkatan' => 'required|string|max:50',
        'alamat' => 'required|string',
        'telp' => 'required|string|max:20',
        'logo' => 'nullable|image|max:2048'
    ];

    public function store()
    {
        $this->validate();

        $logoPath = null;
        if ($this->logo) {
            $logoPath = $this->logo->store('logos', 'public');
        }

        Opd::create([
            'name' => $this->name,
            'singkatan' => $this->singkatan,
            'alamat' => $this->alamat,
            'telp' => $this->telp,
            'logo' => $logoPath
        ]);

        session()->flash('success', 'OPD berhasil ditambahkan.');
        return redirect()->route('opd.index');
    }

    public function render()
    {
        return view('livewire.opd.opd-create')->layout('components.layouts.app');
    }
}
```

### 2.3 OpdEdit Component (app/Livewire/Opd/OpdEdit.php)

```php
<?php

namespace App\Livewire\Opd;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Opd;

class OpdEdit extends Component
{
    use WithFileUploads;

    public Opd $opd;
    public $name;
    public $singkatan;
    public $alamat;
    public $telp;
    public $logo;
    public $existingLogo;

    protected $rules = [
        'name' => 'required|string|max:255',
        'singkatan' => 'required|string|max:50',
        'alamat' => 'required|string',
        'telp' => 'required|string|max:20',
        'logo' => 'nullable|image|max:2048'
    ];

    public function mount(Opd $opd)
    {
        $this->opd = $opd;
        $this->name = $opd->name;
        $this->singkatan = $opd->singkatan;
        $this->alamat = $opd->alamat;
        $this->telp = $opd->telp;
        $this->existingLogo = $opd->logo;
    }

    public function update()
    {
        $this->validate();

        $logoPath = $this->existingLogo;
        if ($this->logo) {
            // Delete old logo if exists
            if ($this->existingLogo) {
                \Storage::disk('public')->delete($this->existingLogo);
            }
            $logoPath = $this->logo->store('logos', 'public');
        }

        $this->opd->update([
            'name' => $this->name,
            'singkatan' => $this->singkatan,
            'alamat' => $this->alamat,
            'telp' => $this->telp,
            'logo' => $logoPath
        ]);

        session()->flash('success', 'OPD berhasil diperbarui.');
        return redirect()->route('opd.index');
    }

    public function render()
    {
        return view('livewire.opd.opd-edit')->layout('components.layouts.app');
    }
}
```

## 3. Agenda Management Components

### 3.1 AgendaIndex Component (app/Livewire/Agenda/AgendaIndex.php)

```php
<?php

namespace App\Livewire\Agenda;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Agenda;
use App\Models\Opd;

class AgendaIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'date';
    public $sortDirection = 'desc';
    public $filterOpd = '';
    public $filterStatus = ''; // active, completed, all

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'date'],
        'sortDirection' => ['except' => 'desc'],
        'filterOpd' => ['except' => ''],
        'filterStatus' => ['except' => '']
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
            $this->sortField = $field;
        }
    }

    public function deleteAgenda($agendaId)
    {
        $agenda = Agenda::findOrFail($agendaId);
        
        // Delete QR code file if exists
        if ($agenda->barcode) {
            \Storage::disk('public')->delete($agenda->barcode);
        }

        $agenda->delete();
        session()->flash('success', 'Agenda berhasil dihapus.');
    }

    public function duplicateAgenda($agendaId)
    {
        $agenda = Agenda::findOrFail($agendaId);
        
        $newAgenda = $agenda->replicate();
        $newAgenda->name = $agenda->name . ' (Copy)';
        $newAgenda->slug = \Str::slug($agenda->name . ' copy ' . time());
        $newAgenda->date = now()->addDay();
        $newAgenda->barcode = null; // Will be generated in edit
        $newAgenda->save();

        session()->flash('success', 'Agenda berhasil diduplikasi.');
    }

    public function render()
    {
        $agendas = Agenda::query()
            ->with(['opd'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('opd', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->filterOpd, function ($query) {
                $query->where('opd_id', $this->filterOpd);
            })
            ->when($this->filterStatus === 'active', function ($query) {
                $query->where('date', '>=', now()->toDateString());
            })
            ->when($this->filterStatus === 'completed', function ($query) {
                $query->where('date', '<', now()->toDateString());
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $opds = Opd::orderBy('name')->get();

        return view('livewire.agenda.agenda-index', [
            'agendas' => $agendas,
            'opds' => $opds
        ])->layout('components.layouts.app');
    }
}
```

### 3.2 AgendaCreate Component (app/Livewire/Agenda/AgendaCreate.php)

```php
<?php

namespace App\Livewire\Agenda;

use Livewire\Component;
use App\Models\Agenda;
use App\Models\Opd;
use App\Services\QrCodeService;
use Illuminate\Support\Str;

class AgendaCreate extends Component
{
    public $opd_id;
    public $name;
    public $date;
    public $jam_mulai;
    public $jam_selesai;
    public $link_paparan;
    public $link_zoom;
    public $catatan;

    protected $rules = [
        'opd_id' => 'required|exists:tb_opd,id',
        'name' => 'required|string|max:255',
        'date' => 'required|date|after_or_equal:today',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        'link_paparan' => 'nullable|url',
        'link_zoom' => 'nullable|url',
        'catatan' => 'nullable|string'
    ];

    public function store()
    {
        $this->validate();

        // Generate unique slug
        $slug = Str::slug($this->name . '-' . $this->date);
        
        // Ensure slug uniqueness
        $counter = 1;
        while (Agenda::where('slug', $slug)->exists()) {
            $slug = Str::slug($this->name . '-' . $this->date . '-' . $counter);
            $counter++;
        }

        $agenda = Agenda::create([
            'opd_id' => $this->opd_id,
            'user_id' => auth()->id(),
            'name' => $this->name,
            'slug' => $slug,
            'date' => $this->date,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'link_paparan' => $this->link_paparan,
            'link_zoom' => $this->link_zoom,
            'catatan' => $this->catatan
        ]);

        // Generate QR Code
        $qrCodeService = new QrCodeService();
        $barcodePath = $qrCodeService->generateQrCode($agenda->id, $agenda->slug);
        $agenda->update(['barcode' => $barcodePath]);

        session()->flash('success', 'Agenda berhasil dibuat dan QR Code telah dihasilkan.');
        return redirect()->route('agenda.detail', $agenda);
    }

    public function render()
    {
        $opds = Opd::orderBy('name')->get();
        
        return view('livewire.agenda.agenda-create', [
            'opds' => $opds
        ])->layout('components.layouts.app');
    }
}
```

### 3.3 AgendaDetail Component (app/Livewire/Agenda/AgendaDetail.php)

```php
<?php

namespace App\Livewire\Agenda;

use Livewire\Component;
use App\Models\Agenda;
use Barryvdh\DomPDF\Facade\Pdf;

class AgendaDetail extends Component
{
    public Agenda $agenda;
    public $attendanceCount;
    public $showQrModal = false;

    public function mount(Agenda $agenda)
    {
        $this->agenda = $agenda->load(['opd', 'absensis']);
        $this->attendanceCount = $this->agenda->absensis()->count();
    }

    public function downloadQrCode()
    {
        if (!$this->agenda->barcode) {
            session()->flash('error', 'QR Code tidak tersedia.');
            return;
        }

        $filePath = storage_path('app/public/' . $this->agenda->barcode);
        if (file_exists($filePath)) {
            return response()->download($filePath, 'qr-code-' . $this->agenda->slug . '.svg');
        } else {
            session()->flash('error', 'File QR Code tidak ditemukan.');
        }
    }

    public function printQrCode()
    {
        $this->showQrModal = true;
    }

    public function exportPdf()
    {
        return redirect()->route('agenda.pdf', $this->agenda);
    }

    public function render()
    {
        return view('livewire.agenda.agenda-detail')->layout('components.layouts.app');
    }
}
```

## 4. Public Attendance Component

### 4.1 AttendanceForm Component (app/Livewire/Public/AttendanceForm.php)

```php
<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Agenda;
use App\Models\Opd;
use App\Models\Absensi;
use App\Services\SignatureService;
use Carbon\Carbon;

class AttendanceForm extends Component
{
    public Agenda $agenda;
    public $opds;
    
    // Form fields
    public $nip_nik;
    public $name;
    public $asal_daerah = 'dalam_kota';
    public $telp;
    public $opd_id;
    public $instansi;
    public $ttd_data; // Base64 signature data
    
    protected $rules = [
        'nip_nik' => 'required|string|max:50',
        'name' => 'required|string|max:255',
        'asal_daerah' => 'required|in:dalam_kota,luar_kota',
        'telp' => 'required|string|max:20',
        'opd_id' => 'required_if:asal_daerah,dalam_kota|exists:tb_opd,id',
        'instansi' => 'required_if:asal_daerah,luar_kota|string|max:255',
        'ttd_data' => 'required|string'
    ];

    public function mount($slug)
    {
        $this->agenda = Agenda::where('slug', $slug)
            ->where('date', '>=', Carbon::today())
            ->firstOrFail();
            
        $this->opds = Opd::orderBy('name')->get();
    }

    public function updatedAsalDaerah($value)
    {
        if ($value === 'dalam_kota') {
            $this->instansi = null;
        } else {
            $this->opd_id = null;
        }
    }

    public function submitAttendance()
    {
        $this->validate();

        // Check for duplicate attendance
        $existing = Absensi::where('agenda_id', $this->agenda->id)
            ->where('nip_nik', $this->nip_nik)
            ->exists();

        if ($existing) {
            session()->flash('error', 'Anda sudah melakukan absensi untuk agenda ini.');
            return;
        }

        // Create attendance record
        $absensi = Absensi::create([
            'agenda_id' => $this->agenda->id,
            'opd_id' => $this->asal_daerah === 'dalam_kota' ? $this->opd_id : null,
            'nip_nik' => $this->nip_nik,
            'name' => $this->name,
            'asal_daerah' => $this->asal_daerah,
            'telp' => $this->telp,
            'instansi' => $this->asal_daerah === 'luar_kota' ? $this->instansi : null,
            'ttd' => null // Will be updated after creation
        ]);

        // Save signature
        $signatureService = new SignatureService();
        $signaturePath = $signatureService->saveSignature($this->ttd_data, $absensi->id);
        $absensi->update(['ttd' => $signaturePath]);

        // Redirect to success page
        return redirect()->route('attendance.success', ['agenda' => $this->agenda->slug]);
    }

    public function render()
    {
        return view('livewire.public.attendance-form')->layout('components.layouts.public');
    }
}
```

### 4.2 AttendanceForm Blade Template (resources/views/livewire/public/attendance-form.blade.php)

```blade
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Absensi Digital</h2>
            <p class="mt-2 text-sm text-gray-600">{{ $agenda->name }}</p>
            <p class="text-xs text-gray-500">{{ $agenda->date->format('d F Y') }} | {{ $agenda->jam_mulai }} - {{ $agenda->jam_selesai }}</p>
            <p class="text-xs text-gray-500">{{ $agenda->opd->name }}</p>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            @if (session()->has('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit.prevent="submitAttendance">
                <!-- NIP/NIK -->
                <div class="mb-4">
                    <label for="nip_nik" class="block text-sm font-medium text-gray-700">NIP/NIK</label>
                    <input type="text" wire:model="nip_nik" id="nip_nik" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('nip_nik') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" wire:model="name" id="name" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Asal Daerah -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Asal Daerah</label>
                    <div class="mt-2 space-y-2">
                        <label class="inline-flex items-center">
                            <input type="radio" wire:model="asal_daerah" value="dalam_kota" 
                                   class="form-radio text-blue-600">
                            <span class="ml-2">Dalam Kota</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" wire:model="asal_daerah" value="luar_kota" 
                                   class="form-radio text-blue-600">
                            <span class="ml-2">Luar Kota</span>
                        </label>
                    </div>
                    @error('asal_daerah') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- OPD (if dalam_kota) -->
                @if($asal_daerah === 'dalam_kota')
                <div class="mb-4">
                    <label for="opd_id" class="block text-sm font-medium text-gray-700">OPD</label>
                    <select wire:model="opd_id" id="opd_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih OPD</option>
                        @foreach($opds as $opd)
                        <option value="{{ $opd->id }}">{{ $opd->name }}</option>
                        @endforeach
                    </select>
                    @error('opd_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                @endif

                <!-- Instansi (if luar_kota) -->
                @if($asal_daerah === 'luar_kota')
                <div class="mb-4">
                    <label for="instansi" class="block text-sm font-medium text-gray-700">Instansi</label>
                    <input type="text" wire:model="instansi" id="instansi" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('instansi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                @endif

                <!-- Phone -->
                <div class="mb-4">
                    <label for="telp" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                    <input type="text" wire:model="telp" id="telp" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('telp') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Digital Signature -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanda Tangan Digital</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                        <canvas id="signature-canvas" width="400" height="200" 
                                class="w-full border border-gray-200 rounded bg-white"></canvas>
                        <div class="mt-2 flex justify-center space-x-2">
                            <button type="button" id="clear-signature" 
                                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                Hapus
                            </button>
                            <button type="button" id="save-signature" 
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                Simpan TTD
                            </button>
                        </div>
                    </div>
                    <input type="hidden" wire:model="ttd_data" id="ttd-data">
                    @error('ttd_data') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Submit Absensi
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('signature-canvas');
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)'
            });

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

            // Clear signature
            document.getElementById('clear-signature').addEventListener('click', function() {
                signaturePad.clear();
            });

            // Save signature
            document.getElementById('save-signature').addEventListener('click', function() {
                if (signaturePad.isEmpty()) {
                    alert('Silakan buat tanda tangan terlebih dahulu.');
                    return;
                }

                const dataURL = signaturePad.toDataURL('image/png');
                document.getElementById('ttd-data').value = dataURL;
                
                // Trigger Livewire update
                @this.set('ttd_data', dataURL);
                
                alert('Tanda tangan berhasil disimpan.');
            });
        });
    </script>
    @endpush
</div>
```

## 5. JavaScript Integration

### 5.1 Signature Pad Integration (resources/js/signature-pad.js)

```javascript
import SignaturePad from 'signature_pad';

window.initializeSignaturePad = function(canvasId, hiddenInputId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)',
        throttle: 16, // x-ms per dot
        minWidth: 0.5,
        maxWidth: 2.5,
        velocityFilterWeight: 0.7
    });

    // Resize canvas function
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    // Initial resize
    resizeCanvas();

    // Handle window resize
    window.addEventListener("resize", resizeCanvas);

    // Clear button functionality
    const clearButton = document.getElementById('clear-signature');
    if (clearButton) {
        clearButton.addEventListener('click', function() {
            signaturePad.clear();
        });
    }

    // Save button functionality
    const saveButton = document.getElementById('save-signature');
    const hiddenInput = document.getElementById(hiddenInputId);
    
    if (saveButton && hiddenInput) {
        saveButton.addEventListener('click', function() {
            if (signaturePad.isEmpty()) {
                alert('Silakan buat tanda tangan terlebih dahulu.');
                return;
            }

            const dataURL = signaturePad.toDataURL('image/png');
            hiddenInput.value = dataURL;
            
            // Trigger Livewire update if available
            if (window.Livewire) {
                window.Livewire.find(hiddenInput.closest('[wire\\:id]')?.getAttribute('wire:id'))
                    ?.set(hiddenInput.getAttribute('wire:model'), dataURL);
            }

            alert('Tanda tangan berhasil disimpan.');
        });
    }

    return signaturePad;
};
```

### 5.2 QR Code Print Functionality (resources/js/qr-print.js)

```javascript
window.printQrCode = function() {
    const qrContainer = document.getElementById('qr-print-container');
    if (!qrContainer) return;

    const printWindow = window.open('', '_blank', 'width=600,height=600');
    printWindow.document.write(`
        <html>
            <head>
                <title>Cetak QR Code</title>
                <style>
                    body { 
                        font-family: Arial, sans-serif; 
                        text-align: center; 
                        padding: 20px;
                    }
                    .qr-container { 
                        margin: 20px auto; 
                        text-align: center; 
                    }
                    .agenda-info { 
                        margin-bottom: 20px; 
                    }
                    .qr-code { 
                        max-width: 300px; 
                        margin: 0 auto; 
                    }
                    @media print {
                        body { margin: 0; }
                        .no-print { display: none; }
                    }
                </style>
            </head>
            <body>
                <div class="agenda-info">
                    <h2>{{ $agenda->name }}</h2>
                    <p>{{ $agenda->date->format('d F Y') }}</p>
                    <p>{{ $agenda->jam_mulai }} - {{ $agenda->jam_selesai }}</p>
                </div>
                <div class="qr-container">
                    <div class="qr-code">
                        ${qrContainer.innerHTML}
                    </div>
                    <p>Scan QR Code untuk absensi</p>
                    <p class="text-xs text-gray-600">{{ route('attendance.form', $agenda->slug) }}</p>
                </div>
                <button onclick="window.print()" class="no-print bg-blue-500 text-white px-4 py-2 rounded mt-4">
                    Cetak
                </button>
            </body>
        </html>
    `);
    printWindow.document.close();
};
```

This comprehensive Livewire components guide provides all the necessary implementation details for building the Agenda & Absensi QR Code application according to the PRD specifications.

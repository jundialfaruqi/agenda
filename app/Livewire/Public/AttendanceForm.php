<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Agenda;
use App\Models\Absensi;
use App\Models\Opd;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app-absensi')]
#[Title('Daftar Hadir')]
class AttendanceForm extends Component
{
    use WithFileUploads;

    public $agenda;
    public $agendaId;
    public $nama;
    public $nip_nik;
    public $jabatan;
    public $instansi;
    public $no_hp;
    public $email;
    public $status = 'hadir';
    public $keterangan;
    public $ttd; // legacy (tidak digunakan lagi untuk upload file)
    public $ttd_data; // base64 dari Signature Pad
    public $asal_daerah = 'dalam_kota';

    protected $rules = [
        'nama' => 'required|string|max:255',
        'nip_nik' => 'required|string|max:50',
        'jabatan' => 'nullable|string|max:255',
        'instansi' => 'required|string|max:255',
        'no_hp' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'status' => 'required|in:hadir,tidak_hadir',
        'keterangan' => 'nullable|string|max:500',
        // Mengganti upload file menjadi tanda tangan digital (base64)
        'ttd_data' => 'required_if:status,hadir|string',
        'asal_daerah' => 'required|in:dalam_kota,luar_kota',
    ];

    protected $messages = [
        'ttd_data.required_if' => 'Tanda tangan wajib diisi jika status hadir.',
    ];

    public function mount($agendaId)
    {
        $this->agendaId = $agendaId;
        $this->agenda = Agenda::with('opd')->findOrFail($agendaId);
        // Blokir jika agenda tidak aktif
        if (in_array($this->agenda->status, ['selesai', 'dibatalkan'])) {
            session()->flash('error', 'Agenda ini sudah tidak aktif, link absensi tidak berlaku.');
        }
    }

    public function save()
    {
        $this->validate();

        // Cegah submit jika agenda tidak aktif
        if (in_array($this->agenda->status, ['selesai', 'dibatalkan'])) {
            session()->flash('error', 'Agenda ini sudah tidak aktif, link absensi tidak berlaku.');
            return;
        }

        // Cek apakah sudah pernah absen
        $existingAttendance = Absensi::where('agenda_id', $this->agendaId)
            ->where('nip_nik', $this->nip_nik)
            ->first();

        if ($existingAttendance) {
            session()->flash('error', 'Anda sudah melakukan absensi untuk agenda ini.');
            return;
        }

        // Simpan TTD dari base64 ke storage publik
        $ttdPath = null;
        if ($this->status === 'hadir' && $this->ttd_data) {
            $data = $this->ttd_data;
            try {
                // Format: data:image/png;base64,XXXX
                if (str_starts_with($data, 'data:image')) {
                    [$meta, $base64] = explode(',', $data, 2);
                } else {
                    $base64 = $data;
                }
                $binary = base64_decode($base64);
                $fileName = 'ttd_' . $this->agendaId . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.png';
                $relativePath = 'signatures/' . $fileName;
                Storage::disk('public')->put($relativePath, $binary);
                $ttdPath = $relativePath;
            } catch (\Throwable $e) {
                // Jika gagal decode/simpan, tetap lanjut tanpa TTD
                $ttdPath = null;
            }
        }

        $attendance = Absensi::create([
            'agenda_id' => $this->agendaId,
            'opd_id' => $this->agenda->opd_id,
            'name' => $this->nama,
            'nip_nik' => $this->nip_nik,
            'jabatan' => $this->jabatan,
            'asal_daerah' => $this->asal_daerah,
            'instansi' => $this->instansi,
            'telp' => $this->no_hp,
            'email' => $this->email,
            'keterangan' => $this->keterangan,
            'ttd' => $ttdPath,
            'waktu_hadir' => $this->status === 'hadir' ? Carbon::now() : null,
            'status' => $this->status,
        ]);
        // Redirect ke halaman statis sukses
        return redirect('/absensi-berhasil');
    }

    public function render()
    {
        return view('livewire.public.attendance-form');
    }
}

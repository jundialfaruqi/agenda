<?php

namespace App\Livewire\Agenda;

use App\Models\Agenda;
use App\Models\Opd;
use App\Services\QrCodeService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Buat Agenda')]
class AgendaCreate extends Component
{
    public $name = '';
    public $opd_id = '';
    public $date = '';
    public $jam_mulai = '';
    public $jam_selesai = '';
    public $link_paparan = '';
    public $link_zoom = '';
    public $catatan = '';
    public $status = 'aktif';

    protected $rules = [
        'name' => 'required|string|max:255',
        'opd_id' => 'required|exists:tb_opd,id',
        'date' => 'required|date|after_or_equal:today',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        'link_paparan' => 'nullable|url|max:500',
        'link_zoom' => 'nullable|url|max:500',
        'catatan' => 'nullable|string|max:1000',
        'status' => 'required|in:aktif,selesai,dibatalkan',
    ];

    public function save()
    {
        $this->validate();

        $slug = Str::slug($this->name . '-' . $this->date);
        // Buat agenda terlebih dahulu
        $agenda = Agenda::create([
            'opd_id' => $this->opd_id,
            'user_id' => Auth::id(),
            'name' => $this->name,
            'slug' => $slug,
            'date' => $this->date,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'link_paparan' => $this->link_paparan,
            'link_zoom' => $this->link_zoom,
            'barcode' => null,
            'catatan' => $this->catatan,
            'status' => $this->status,
        ]);

        // Generate QR Code berdasarkan agenda yang sudah dibuat
        $qrCodeService = app(QrCodeService::class);
        $barcode = $qrCodeService->generateAgendaQrCode($agenda);

        // Update field barcode pada agenda
        $agenda->update(['barcode' => $barcode]);

        session()->flash('message', 'Agenda berhasil dibuat dengan QR Code.');
        return redirect()->route('agenda.index');
    }

    public function render()
    {
        $opds = Opd::orderBy('name')->get();

        return view('livewire.agenda.agenda-create', [
            'opds' => $opds,
        ]);
    }
}

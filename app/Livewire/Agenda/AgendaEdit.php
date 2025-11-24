<?php

namespace App\Livewire\Agenda;

use Livewire\Component;
use App\Models\Agenda;
use App\Models\Opd;
use App\Services\QrCodeService;
use Illuminate\Support\Str;

class AgendaEdit extends Component
{
    public $agendaId;
    public $name;
    public $opd_id;
    public $date;
    public $jam_mulai;
    public $jam_selesai;
    public $link_paparan;
    public $link_zoom;
    public $catatan;

    protected $rules = [
        'name' => 'required|string|max:255',
        'opd_id' => 'required|exists:tb_opd,id',
        'date' => 'required|date',
        'jam_mulai' => 'required|date_format:H:i',
        'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        'link_paparan' => 'nullable|url',
        'link_zoom' => 'nullable|url',
        'catatan' => 'nullable|string',
    ];

    public function mount(Agenda $agenda)
    {
        // Gunakan route model binding untuk menerima objek Agenda langsung
        $this->agendaId = $agenda->id;

        $this->name = $agenda->name;
        $this->opd_id = $agenda->opd_id;
        // Format tanggal ke 'Y-m-d' agar sesuai dengan input type=date
        if ($agenda->date instanceof \Carbon\Carbon) {
            $this->date = $agenda->date->format('Y-m-d');
        } else {
            $this->date = $agenda->date;
        }
        // Sesuaikan format TIME dari DB (H:i:s) ke H:i untuk form
        $this->jam_mulai = is_string($agenda->jam_mulai) ? substr($agenda->jam_mulai, 0, 5) : $agenda->jam_mulai;
        $this->jam_selesai = is_string($agenda->jam_selesai) ? substr($agenda->jam_selesai, 0, 5) : $agenda->jam_selesai;
        $this->link_paparan = $agenda->link_paparan;
        $this->link_zoom = $agenda->link_zoom;
        $this->catatan = $agenda->catatan;
    }

    public function update()
    {
        $this->validate();

        $agenda = Agenda::findOrFail($this->agendaId);
        
        $agenda->update([
            'name' => $this->name,
            'slug' => Str::slug($this->name),
            'opd_id' => $this->opd_id,
            'date' => $this->date,
            'jam_mulai' => $this->jam_mulai,
            'jam_selesai' => $this->jam_selesai,
            'link_paparan' => $this->link_paparan,
            'link_zoom' => $this->link_zoom,
            'catatan' => $this->catatan,
        ]);

        session()->flash('success', 'Agenda berhasil diperbarui.');
        
        return redirect()->route('agenda.index');
    }

    public function render()
    {
        $opds = Opd::all();
        
        return view('livewire.agenda.agenda-edit', [
            'opds' => $opds,
        ]);
    }
}

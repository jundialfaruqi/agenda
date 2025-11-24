<?php

namespace App\Livewire\Agenda;

use Livewire\Component;
use App\Models\Agenda;
use App\Models\Absensi;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Informasi Agenda')]
class AgendaDetail extends Component
{
    use WithPagination;

    public $agendaId;
    public $agenda;
    public $search = '';
    public $perPage = 10;

    protected $queryString = ['search', 'perPage'];

    public function mount(Agenda $agenda)
    {
        // Gunakan route model binding untuk mendapatkan objek Agenda langsung
        $this->agendaId = $agenda->id;
        $this->agenda = $agenda->load(['opd', 'user']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function deleteAttendance($attendanceId)
    {
        Absensi::findOrFail($attendanceId)->delete();
        session()->flash('success', 'Absensi berhasil dihapus.');
    }

    public function render()
    {
        $attendances = Absensi::with(['agenda', 'opd'])
            ->where('agenda_id', $this->agendaId)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('nip_nik', 'like', '%' . $this->search . '%')
                        ->orWhere('instansi', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $totalAttendance = Absensi::where('agenda_id', $this->agendaId)->count();
        $hadirCount = Absensi::where('agenda_id', $this->agendaId)->whereNotNull('waktu_hadir')->count();
        $tidakHadirCount = Absensi::where('agenda_id', $this->agendaId)->whereNull('waktu_hadir')->count();

        return view('livewire.agenda.agenda-detail', [
            'attendances' => $attendances,
            'totalAttendance' => $totalAttendance,
            'hadirCount' => $hadirCount,
            'tidakHadirCount' => $tidakHadirCount,
        ]);
    }
}

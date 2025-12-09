<?php

namespace App\Livewire\Agenda;

use Livewire\Component;
use App\Models\Agenda;
use App\Models\Absensi;
use App\Services\PdfService;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Title('Rekap Agenda')]
class AgendaRekap extends Component
{
    use WithPagination;

    public $agendaId;
    public $agenda;
    public $search = '';
    public $perPage = 25;

    protected $queryString = ['search', 'perPage'];

    public function mount(Agenda $agenda)
    {
        // Gunakan route model binding untuk parameter {agenda}
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

    public function exportPdf()
    {
        $pdfService = new PdfService();
        $pdf = $pdfService->generateAttendanceReport($this->agenda);

        $filename = 'rekap-absensi-' . ($this->agenda->slug ?? ('agenda-' . $this->agendaId)) . '.pdf';
        return $pdf->download($filename);
    }

    public function render()
    {
        $attendances = Absensi::with(['agenda', 'opd'])
            ->where('agenda_id', $this->agendaId)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('nip_nik', 'like', '%' . $this->search . '%')
                        ->orWhere('jabatan', 'like', '%' . $this->search . '%')
                        ->orWhere('instansi', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        $totalAttendance = Absensi::where('agenda_id', $this->agendaId)->count();
        $hadirCount = Absensi::where('agenda_id', $this->agendaId)->whereNotNull('waktu_hadir')->count();
        $tidakHadirCount = Absensi::where('agenda_id', $this->agendaId)->whereNull('waktu_hadir')->count();

        return view('livewire.agenda.agenda-rekap', [
            'attendances' => $attendances,
            'totalAttendance' => $totalAttendance,
            'hadirCount' => $hadirCount,
            'tidakHadirCount' => $tidakHadirCount,
        ]);
    }
}

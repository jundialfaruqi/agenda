<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Agenda;
use App\Models\Absensi;

class AttendanceSuccess extends Component
{
    public $agendaId;
    public $agenda;
    public $attendance;

    public function mount($agendaId)
    {
        $this->agendaId = $agendaId;
        $this->agenda = Agenda::with('opd')->findOrFail($agendaId);
        // Ambil absensi yang baru dibuat dari session jika tersedia
        $attendanceId = session('attendance_id');
        if ($attendanceId) {
            $this->attendance = Absensi::where('id', $attendanceId)
                ->where('agenda_id', $agendaId)
                ->first();
        }

        // Fallback ke absensi terbaru untuk agenda ini
        if (!$this->attendance) {
            $this->attendance = Absensi::where('agenda_id', $agendaId)
                ->orderByDesc('waktu_hadir')
                ->orderByDesc('id')
                ->first();
        }
    }

    public function render()
    {
        return view('livewire.public.attendance-success');
    }
}

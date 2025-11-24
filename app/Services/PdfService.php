<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Agenda;
use App\Models\Absensi;
use App\Models\Opd;
use Carbon\Carbon;

class PdfService
{
    public function generateAttendanceReport(Agenda $agenda): \Barryvdh\DomPDF\PDF
    {
        $attendances = Absensi::with(['agenda.opd'])
            ->where('agenda_id', $agenda->id)
            ->get();

        $total = $attendances->count();
        $hadir = $attendances->whereNotNull('waktu_hadir')->count();
        $tidak_hadir = $attendances->whereNull('waktu_hadir')->count();
        $belum_absen = 0; // Not applicable for this report

        $data = [
            'agenda' => $agenda,
            'attendances' => $attendances,
            'total' => $total,
            'hadir' => $hadir,
            'tidak_hadir' => $tidak_hadir,
            'belum_absen' => $belum_absen,
            'date_generated' => Carbon::now()->format('d F Y H:i'),
        ];

        return Pdf::loadView('pdf.attendance-report', $data)
            ->setPaper('a4', 'portrait');
    }

    public function generateOpdAttendanceReport(Opd $opd, Carbon $startDate = null, Carbon $endDate = null): \Barryvdh\DomPDF\PDF
    {
        $startDate = $startDate ?? Carbon::now()->startOfMonth();
        $endDate = $endDate ?? Carbon::now()->endOfMonth();

        $agendas = Agenda::with(['absensi'])
            ->where('opd_id', $opd->id)
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $totalAgendas = $agendas->count();
        $totalAttendances = 0;
        $totalPresent = 0;

        foreach ($agendas as $agenda) {
            $attendances = $agenda->absensi;
            $totalAttendances += $attendances->count();
            $totalPresent += $attendances->whereNotNull('waktu_hadir')->count();
        }

        $data = [
            'opd' => $opd,
            'agendas' => $agendas,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalAgendas' => $totalAgendas,
            'totalAttendances' => $totalAttendances,
            'totalPresent' => $totalPresent,
            'date_generated' => Carbon::now()->format('d F Y H:i'),
        ];

        return Pdf::loadView('pdf.opd-attendance-report', $data)
            ->setPaper('a4', 'landscape');
    }

    public function generateMonthlyReport(Carbon $month = null): \Barryvdh\DomPDF\PDF
    {
        $month = $month ?? Carbon::now();
        $startDate = $month->copy()->startOfMonth();
        $endDate = $month->copy()->endOfMonth();

        $agendas = Agenda::with(['opd', 'absensi'])
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $opds = Opd::all();
        $opdStats = [];

        foreach ($opds as $opd) {
            $opdAgendas = $agendas->where('opd_id', $opd->id);
            $totalAgendas = $opdAgendas->count();
            $totalAttendances = 0;
            $totalPresent = 0;

            foreach ($opdAgendas as $agenda) {
                $attendances = $agenda->absensi;
                $totalAttendances += $attendances->count();
                $totalPresent += $attendances->whereNotNull('waktu_hadir')->count();
            }

            $opdStats[] = [
                'opd' => $opd,
                'totalAgendas' => $totalAgendas,
                'totalAttendances' => $totalAttendances,
                'totalPresent' => $totalPresent,
            ];
        }

        $data = [
            'month' => $month,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'agendas' => $agendas,
            'opdStats' => $opdStats,
            'totalAgendas' => $agendas->count(),
            'date_generated' => Carbon::now()->format('d F Y H:i'),
        ];

        return Pdf::loadView('pdf.monthly-report', $data)
            ->setPaper('a4', 'portscape');
    }
}
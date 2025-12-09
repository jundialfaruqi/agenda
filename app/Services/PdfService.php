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

        // Sanitasi string ke UTF-8 untuk mencegah error "Malformed UTF-8 characters"
        $agenda->name = $this->sanitizeUtf8($agenda->name);
        $agenda->catatan = $this->sanitizeUtf8($agenda->catatan);
        $agenda->link_paparan = $this->sanitizeUtf8($agenda->link_paparan);
        $agenda->link_zoom = $this->sanitizeUtf8($agenda->link_zoom);
        if ($agenda->opd) {
            $agenda->opd->name = $this->sanitizeUtf8($agenda->opd->name);
            $agenda->opd->singkatan = $this->sanitizeUtf8($agenda->opd->singkatan);
        }

        foreach ($attendances as $attendance) {
            $attendance->name = $this->sanitizeUtf8($attendance->name);
            $attendance->nip_nik = $this->sanitizeUtf8($attendance->nip_nik);
            $attendance->jabatan = $this->sanitizeUtf8($attendance->jabatan);
            $attendance->instansi = $this->sanitizeUtf8($attendance->instansi);
            $attendance->email = $this->sanitizeUtf8($attendance->email);
            $attendance->keterangan = $this->sanitizeUtf8($attendance->keterangan);
        }

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

    private function sanitizeUtf8($value)
    {
        if (is_string($value)) {
            // Pastikan string valid UTF-8 dan buang byte tidak valid
            if (!mb_check_encoding($value, 'UTF-8')) {
                // Coba konversi dari beberapa encoding umum ke UTF-8
                $value = @mb_convert_encoding($value, 'UTF-8', 'ISO-8859-1, Windows-1252, ASCII');
            }
            $sanitized = @iconv('UTF-8', 'UTF-8//IGNORE', $value);
            return $sanitized !== false ? $sanitized : utf8_encode($value);
        }
        return $value;
    }
}

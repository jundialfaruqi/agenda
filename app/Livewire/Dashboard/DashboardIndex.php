<?php

namespace App\Livewire\Dashboard;

use App\Models\Agenda;
use App\Models\Opd;
use App\Models\Absensi;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
class DashboardIndex extends Component
{
    public function render()
    {
        $today = Carbon::today();

        // Statistics
        $totalOpd = Opd::count();
        $totalAgenda = Agenda::count();
        $totalAbsensi = Absensi::count();

        // Today's agenda
        $todayAgendas = Agenda::with(['opd', 'user'])
            ->whereDate('date', $today)
            ->orderBy('jam_mulai')
            ->get();

        // Upcoming agendas (next 7 days)
        $upcomingAgendas = Agenda::with(['opd', 'user'])
            ->whereBetween('date', [$today, $today->copy()->addDays(7)])
            ->whereDate('date', '>', $today)
            ->orderBy('date')
            ->orderBy('jam_mulai')
            ->limit(5)
            ->get();

        // Recent absensi
        $recentAbsensis = Absensi::with(['agenda', 'agenda.opd'])
            ->latest()
            ->limit(10)
            ->get();

        // Monthly statistics
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $monthlyAgendas = Agenda::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->count();

        $monthlyAbsensis = Absensi::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();

        return view('livewire.dashboard.dashboard-index', [
            'totalOpd' => $totalOpd,
            'totalAgenda' => $totalAgenda,
            'totalAbsensi' => $totalAbsensi,
            'todayAgendas' => $todayAgendas,
            'upcomingAgendas' => $upcomingAgendas,
            'recentAbsensis' => $recentAbsensis,
            'monthlyAgendas' => $monthlyAgendas,
            'monthlyAbsensis' => $monthlyAbsensis,
        ]);
    }
}

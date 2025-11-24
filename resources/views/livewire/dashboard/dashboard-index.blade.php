<div class="grid gap-4 md:gap-6">

    {{-- Statistics Cards --}}
    <div class="stats bg-base-100 flex flex-col md:flex-row border border-base-300 rounded-xl">
        <div class="stat">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="inline-block w-6 h-6 md:w-8 md:h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 21V8l9-5 9 5v13M9 21V10h6v11" />
                </svg>
            </div>
            <div class="stat-title">Total OPD</div>
            <div class="stat-value text-primary text-2xl md:text-3xl">{{ $totalOpd }}</div>
            <div class="stat-desc">Instansi terdaftar</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="inline-block w-6 h-6 md:w-8 md:h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 0 0 2-2v-6H3v6a2 2 0 0 0 2 2Z" />
                </svg>
            </div>
            <div class="stat-title">Total Agenda</div>
            <div class="stat-value text-secondary text-2xl md:text-3xl">{{ $totalAgenda }}</div>
            <div class="stat-desc">Semua agenda</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-success">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="inline-block w-6 h-6 md:w-8 md:h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z M2 12a10 10 0 1 0 20 0 10 10 0 0 0-20 0Z" />
                </svg>
            </div>
            <div class="stat-title">Total Absensi</div>
            <div class="stat-value text-success text-2xl md:text-3xl">{{ $totalAbsensi }}</div>
            <div class="stat-desc">Partisipasi tercatat</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-warning">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="inline-block w-6 h-6 md:w-8 md:h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3v18h18M3 12l5-5 4 4 6-6" />
                </svg>
            </div>
            <div class="stat-title">Agenda Bulan Ini</div>
            <div class="stat-value text-warning text-2xl md:text-3xl">{{ $monthlyAgendas }}</div>
            <div class="stat-desc">Periode berjalan</div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        {{-- Today's Agenda --}}
        <div class="card bg-base-100 border border-base-300 rounded-xl">
            <div class="card-body">
                <div class="card-title">
                    <div class="flex items-center gap-2 text-sm font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                        <h4 class="text-lg font-semibold">Agenda Hari Ini</h4>
                    </div>
                </div>

                @if ($todayAgendas->count() > 0)
                    @foreach ($todayAgendas as $agenda)
                        <div class="mb-3 pb-3 border-b">
                            <h6 class="mb-1 font-medium">{{ $agenda->name }}</h6>
                            <p class="text-gray-500 mb-1">
                                <i class="fas fa-building"></i> {{ $agenda->opd->name }}
                            </p>
                            <p class="flex items-center text-gray-500 mb-0 gap-2">
                                <i class="fas fa-clock"></i>
                                <span>{{ substr($agenda->jam_mulai, 0, 5) }} -
                                    {{ substr($agenda->jam_selesai, 0, 5) }}</span>
                                <a href="{{ route('agenda.detail', $agenda->id) }}"
                                    class="btn btn-xs btn-primary ml-3">Lihat Detail</a>
                            </p>
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-gray-500">Tidak ada agenda hari ini</p>
                @endif
            </div>
        </div>

        {{-- Upcoming Agenda --}}
        <div class="card bg-base-100 border border-base-300 rounded-xl">
            <div class="card-body">
                <div class="card-title">
                    <div class="flex items-center gap-2 text-sm font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                        </svg>
                        <h4 class="text-lg font-semibold">Agenda Mendatang</h4>
                    </div>
                </div>

                @if ($upcomingAgendas->count() > 0)
                    @foreach ($upcomingAgendas as $agenda)
                        <div class="mb-3 pb-3 border-b">
                            <h6 class="mb-1 font-medium">{{ $agenda->name }}</h6>
                            <p class="text-gray-500 mb-1">{{ $agenda->opd->name }}</p>
                            <p class="flex items-center text-gray-500 mb-0 gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                                </svg>
                                <span>{{ \Carbon\Carbon::parse($agenda->date)->format('d/m/Y') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span>{{ substr($agenda->jam_mulai, 0, 5) }}</span>
                                <a href="{{ route('agenda.detail', $agenda->id) }}"
                                    class="btn btn-xs btn-primary ml-3">Lihat Detail</a>
                            </p>
                        </div>
                    @endforeach
                @else
                    <p class="text-center text-gray-500">Tidak ada agenda mendatang</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Recent Absensi --}}
    <div class="flex items-center gap-1 text-sm font-bold">
        <svg class="size-4" fill="currentColor" width="12" height="12" viewBox="0 0 256 256" id="Flat"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M216,148H172V108h44a12,12,0,0,0,0-24H172V40a12,12,0,0,0-24,0V84H108V40a12,12,0,0,0-24,0V84H40a12,12,0,0,0,0,24H84v40H40a12,12,0,0,0,0,24H84v44a12,12,0,0,0,24,0V172h40v44a12,12,0,0,0,24,0V172h44a12,12,0,0,0,0-24Zm-108,0V108h40v40Z">
            </path>
        </svg>
        <h4 class="text-lg font-semibold">Absensi Terbaru</h4>
    </div>
    @if ($recentAbsensis->count() > 0)
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
            <table class="table table-md table-zebra table-compact text-sm md:text-base">
                <thead class="bg-gray-200 text-gray-800">
                    <tr>
                        <th>Nama</th>
                        <th>NIP/NIK</th>
                        <th>Agenda</th>
                        <th>OPD</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentAbsensis as $absensi)
                        <tr>
                            <td>{{ $absensi->name }}</td>
                            <td>{{ $absensi->nip_nik }}</td>
                            <td>{{ $absensi->agenda->name }}</td>
                            <td>{{ $absensi->agenda->opd->singkatan }}</td>
                            <td>{{ $absensi->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-gray-500">Tidak ada data absensi</p>
    @endif
</div>

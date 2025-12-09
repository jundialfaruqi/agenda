<div class="grid gap-4 md:gap-6">
    <div class="card bg-base-100 border border-base-300 rounded-xl">
        <div class="card-body">
            <div class="card-title">
                <div class="flex items-start justify-between w-full gap-2">
                    <div class="flex items-center gap-2">
                        <h4 class="text-lg font-semibold">Rekap Agenda</h4>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('agenda.detail', $agenda->id) }}" class="btn btn-sm" wire:navigate>
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>
                        <button wire:click="exportPdf" class="btn btn-sm btn-info">
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Export PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 border border-base-300">
        <div class="card-body">
            <div class="card-title">Informasi Agenda</div>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nama Agenda</p>
                    <p class="font-medium">{{ $agenda->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">OPD Penyelenggara</p>
                    <p class="font-medium">{{ data_get($agenda, 'opd.name', '-') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <p class="font-medium">{{ \Carbon\Carbon::parse($agenda->date)->format('d F Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Waktu</p>
                    <p class="font-medium">Jam {{ \Carbon\Carbon::parse($agenda->jam_mulai)->format('H:i') }} s/d
                        {{ \Carbon\Carbon::parse($agenda->jam_selesai)->format('H:i') }} WIB</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status Waktu</p>
                    <p>
                        @if ($agenda->status_waktu == 'sedang_berlangsung')
                            <span class="badge badge-warning">Sedang Berlangsung</span>
                        @elseif ($agenda->status_waktu == 'akan_datang')
                            <span class="badge badge-info">Akan Datang</span>
                        @elseif ($agenda->status_waktu == 'menunggu')
                            <span class="badge badge-neutral">Menunggu</span>
                        @else
                            <span class="badge badge-success">Selesai</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status Agenda</p>
                    <p>
                        @if ($agenda->status === 'aktif')
                            <span class="badge badge-primary">Aktif</span>
                        @elseif ($agenda->status === 'selesai')
                            <span class="badge badge-success">Selesai</span>
                        @else
                            <span class="badge badge-error">Dibatalkan</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Dibuat oleh</p>
                    <p class="font-medium">{{ optional($agenda->user)->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Peserta</p>
                    <p class="font-medium">{{ $totalAttendance }} orang</p>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="text-lg font-bold mb-2">Statistik Peserta</div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div class="p-3 rounded-lg border border-primary/30">
                <div class="text-2xl font-semibold text-primary">{{ $totalAttendance }}</div>
                <div class="text-sm text-gray-500">Total Peserta</div>
            </div>
            <div class="p-3 rounded-lg border border-success/30">
                <div class="text-2xl font-semibold text-success">{{ $hadirCount }}</div>
                <div class="text-sm text-gray-500">Hadir</div>
            </div>
            <div class="p-3 rounded-lg border border-error/30">
                <div class="text-2xl font-semibold text-error">{{ $tidakHadirCount }}</div>
                <div class="text-sm text-gray-500">Tidak Hadir</div>
            </div>
            <div class="p-3 rounded-lg border border-info/30">
                <div class="text-2xl font-semibold text-info">{{ $totalAttendance - $hadirCount - $tidakHadirCount }}
                </div>
                <div class="text-sm text-gray-500">Belum Absen</div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <div class="text-lg font-bold">Daftar Peserta</div>
        <div class="flex gap-2">
            <label class="input w-56">
                <input type="text" wire:model.live="search" class="grow" placeholder="Cari peserta…" />
                <kbd class="kbd kbd-sm">⌘</kbd>
                <kbd class="kbd kbd-sm">K</kbd>
            </label>
            <select wire:model.live="perPage" class="select select-bordered w-24">
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
            </select>
        </div>
    </div>

    <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100 mt-2">
        <table class="table table-md table-zebra table-compact text-sm md:text-base">
            <thead class="bg-gray-200 text-gray-800">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP/NIK</th>
                    <th>Jabatan</th>
                    <th>Instansi</th>
                    <th>No. HP</th>
                    <th>Email</th>
                    <th>Waktu Hadir</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $index => $attendance)
                    <tr>
                        <td>{{ ($attendances->currentPage() - 1) * $attendances->perPage() + $index + 1 }}</td>
                        <td>{{ $attendance->nama }}</td>
                        <td>{{ $attendance->nip_nik ?: '-' }}</td>
                        <td>{{ $attendance->jabatan ?: '-' }}</td>
                        <td>{{ $attendance->instansi }}</td>
                        <td>{{ $attendance->no_hp ?: '-' }}</td>
                        <td>{{ $attendance->email ?: '-' }}</td>
                        <td>{{ $attendance->waktu_hadir ? \Carbon\Carbon::parse($attendance->waktu_hadir)->format('d F Y H:i') : '-' }}
                        </td>
                        <td>
                            @if ($attendance->status == 'hadir')
                                <span class="badge badge-success">Hadir</span>
                            @else
                                <span class="badge badge-error">Tidak Hadir</span>
                            @endif
                        </td>
                        <td>{{ $attendance->keterangan ?: '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center text-gray-400">Belum ada peserta yang mendaftar</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-500">
            Menampilkan {{ $attendances->firstItem() ?? 0 }} - {{ $attendances->lastItem() ?? 0 }} dari
            {{ $attendances->total() }} data
        </p>
        <div>
            {{ $attendances->links('custom-pagination') }}
        </div>
    </div>
</div>

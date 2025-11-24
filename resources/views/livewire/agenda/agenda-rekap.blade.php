<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Rekap Agenda</h2>
        <div>
            <a href="{{ route('agenda.detail', $agenda->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Detail
            </a>
            <button wire:click="exportPdf" class="btn btn-primary">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Informasi Agenda</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama Agenda:</strong> {{ $agenda->name }}</p>
                    <p><strong>OPD Penyelenggara:</strong> {{ $agenda->opd->name }}</p>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($agenda->date)->format('d F Y') }}</p>
                    <p><strong>Waktu:</strong> {{ $agenda->jam_mulai }} - {{ $agenda->jam_selesai }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status Waktu:</strong> 
                        @if($agenda->status_waktu == 'sedang_berlangsung')
                            <span class="badge bg-warning">Sedang Berlangsung</span>
                        @elseif($agenda->status_waktu == 'akan_datang')
                            <span class="badge bg-info">Akan Datang</span>
                        @elseif($agenda->status_waktu == 'menunggu')
                            <span class="badge bg-secondary">Menunggu</span>
                        @else
                            <span class="badge bg-success">Selesai</span>
                        @endif
                    </p>
                    <p><strong>Status Agenda:</strong>
                        @if($agenda->status === 'aktif')
                            <span class="badge bg-primary">Aktif</span>
                        @elseif($agenda->status === 'selesai')
                            <span class="badge bg-success">Selesai</span>
                        @else
                            <span class="badge bg-danger">Dibatalkan</span>
                        @endif
                    </p>
                    <p><strong>Dibuat oleh:</strong> {{ $agenda->user->name }}</p>
                    <p><strong>Total Peserta:</strong> {{ $totalAttendance }} orang</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-primary">{{ $totalAttendance }}</h3>
                    <p class="text-muted mb-0">Total Peserta</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-success">{{ $hadirCount }}</h3>
                    <p class="text-muted mb-0">Hadir</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-danger">{{ $tidakHadirCount }}</h3>
                    <p class="text-muted mb-0">Tidak Hadir</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="text-info">{{ $totalAttendance - $hadirCount - $tidakHadirCount }}</h3>
                    <p class="text-muted mb-0">Belum Absen</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Peserta</h5>
            <div class="d-flex gap-2">
                <input type="text" wire:model="search" class="form-control form-control-sm" placeholder="Cari peserta..." style="width: 200px;">
                <select wire:model="perPage" class="form-select form-select-sm" style="width: 80px;">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
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
                                <td>{{ $attendance->waktu_hadir ? \Carbon\Carbon::parse($attendance->waktu_hadir)->format('d F Y H:i') : '-' }}</td>
                                <td>
                                    @if($attendance->status == 'hadir')
                                        <span class="badge bg-success">Hadir</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Hadir</span>
                                    @endif
                                </td>
                                <td>{{ $attendance->keterangan ?: '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">Belum ada peserta yang mendaftar</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <p class="text-muted mb-0">
                        Menampilkan {{ $attendances->firstItem() ?? 0 }} - {{ $attendances->lastItem() ?? 0 }} dari {{ $attendances->total() }} data
                    </p>
                </div>
                <div>
                    {{ $attendances->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

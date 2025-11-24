<div>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                        </div>
                        
                        <h3 class="text-success mb-3">Absensi Berhasil!</h3>
                        
                        <div class="alert alert-light text-start">
                            <h5>Detail Absensi:</h5>
                            <p class="mb-1"><strong>Agenda:</strong> {{ $agenda->name }}</p>
                            <p class="mb-1"><strong>OPD:</strong> {{ $agenda->opd->name }}</p>
                            @if($attendance)
                                <p class="mb-1"><strong>Nama:</strong> {{ $attendance->name ?? 'Tidak tersedia' }}</p>
                                <p class="mb-1"><strong>Status:</strong>
                                    @if(($attendance->status ?? null) === 'hadir')
                                        <span class="badge bg-success">Hadir</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Hadir</span>
                                    @endif
                                </p>
                                @if($attendance->waktu_hadir)
                                    <p class="mb-0"><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($attendance->waktu_hadir)->format('d F Y H:i') }}</p>
                                @endif
                            @else
                                <p class="mb-0 text-muted">Data absensi terbaru tidak ditemukan.</p>
                            @endif
                        </div>

                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle"></i> Informasi</h6>
                            <p class="mb-0">Terima kasih telah melakukan absensi. Anda dapat menutup halaman ini.</p>
                        </div>

                        <div class="d-grid gap-2">
                            <button onclick="window.print()" class="btn btn-outline-primary">
                                <i class="fas fa-print"></i> Cetak Bukti Absensi
                            </button>
                            <button onclick="window.close()" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Tutup Halaman
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

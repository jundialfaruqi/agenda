<div class="card w-full max-w-xl bg-base-100 shadow-xl">
    <div class="card-body">
        <div class="text-center">
            <h2 class="card-title justify-center">Formulir Absensi</h2>
            <p class="text-sm text-base-content/70">{{ $agenda->name }}</p>
        </div>

        @if (session()->has('error'))
            <div class="alert alert-error">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="alert alert-info">
            <div>
                <div class="font-semibold">Informasi Agenda</div>
                <div class="text-sm"><span class="font-medium">OPD:</span> {{ $agenda->opd->name }}</div>
                <div class="text-sm"><span class="font-medium">Tanggal:</span>
                    {{ \Carbon\Carbon::parse($agenda->date)->format('d F Y') }}</div>
                <div class="text-sm"><span class="font-medium">Waktu:</span> {{ $agenda->jam_mulai }} -
                    {{ $agenda->jam_selesai }}</div>
            </div>
        </div>

        <form wire:submit.prevent="save" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label" for="nama">
                        <span class="label-text">Nama Lengkap <span class="text-error">*</span></span>
                    </label>
                    <input id="nama" type="text" wire:model="nama" placeholder="Masukkan nama lengkap"
                        class="input input-bordered w-full" />
                    @error('nama')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>
                <div class="form-control">
                    <label class="label" for="nip_nik">
                        <span class="label-text">NIP/NIK <span class="text-error">*</span></span>
                    </label>
                    <input id="nip_nik" type="text" wire:model="nip_nik" placeholder="Masukkan NIP/NIK"
                        class="input input-bordered w-full" required />
                    @error('nip_nik')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label" for="jabatan">
                        <span class="label-text">Jabatan</span>
                    </label>
                    <input id="jabatan" type="text" wire:model="jabatan" placeholder="Masukkan jabatan"
                        class="input input-bordered w-full" />
                    @error('jabatan')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>
                <div class="form-control">
                    <label class="label" for="instansi">
                        <span class="label-text">Instansi/OPD <span class="text-error">*</span></span>
                    </label>
                    <input id="instansi" type="text" wire:model="instansi" placeholder="Masukkan instansi/OPD"
                        class="input input-bordered w-full" />
                    @error('instansi')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label" for="no_hp">
                        <span class="label-text">No. HP <span class="text-error">*</span></span>
                    </label>
                    <input id="no_hp" type="text" wire:model="no_hp" placeholder="Masukkan nomor HP"
                        class="input input-bordered w-full" required />
                    @error('no_hp')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>
                <div class="form-control">
                    <label class="label" for="email">
                        <span class="label-text">Email</span>
                    </label>
                    <input id="email" type="email" wire:model="email" placeholder="Masukkan email"
                        class="input input-bordered w-full" />
                    @error('email')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Asal Daerah <span class="text-error">*</span></span>
                        </label>
                        <div class="flex items-center gap-4">
                            <label class="label cursor-pointer">
                                <span class="label-text mr-2">Dalam Kota</span>
                                <input class="radio radio-primary" type="radio" wire:model="asal_daerah"
                                    id="dalam_kota" value="dalam_kota">
                            </label>
                            <label class="label cursor-pointer">
                                <span class="label-text mr-2">Luar Kota</span>
                                <input class="radio radio-primary" type="radio" wire:model="asal_daerah"
                                    id="luar_kota" value="luar_kota">
                            </label>
                        </div>
                        @error('asal_daerah')
                            <label class="label"><span
                                    class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Status Kehadiran <span class="text-error">*</span></span>
                        </label>
                        <div class="flex items-center gap-4">
                            <label class="label cursor-pointer">
                                <span class="label-text mr-2">Hadir</span>
                                <input class="radio radio-primary" type="radio" wire:model="status" id="hadir"
                                    value="hadir">
                            </label>
                            <label class="label cursor-pointer">
                                <span class="label-text mr-2">Tidak Hadir</span>
                                <input class="radio radio-primary" type="radio" wire:model="status"
                                    id="tidak_hadir" value="tidak_hadir">
                            </label>
                        </div>
                        @error('status')
                            <label class="label"><span
                                    class="label-text-alt text-error">{{ $message }}</span></label>
                        @enderror
                    </div>
                </div>
                <div class="form-control">
                    <label class="label" for="keterangan">
                        <span class="label-text">Keterangan</span>
                    </label>
                    <textarea id="keterangan" wire:model="keterangan" rows="3" placeholder="Masukkan keterangan (opsional)"
                        class="textarea textarea-bordered w-full"></textarea>
                    @error('keterangan')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>
            </div>

            @if ($status === 'hadir')
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Tanda Tangan Digital <span class="text-error">*</span></span>
                    </label>
                    <div class="rounded-lg p-3 border border-dashed border-base-300" wire:ignore
                        id="signature-wrapper">
                        <div class="mb-3 flex items-center gap-3">
                            <label class="label m-0"><span class="label-text">Warna:</span></label>
                            <input id="pen-color" type="color" value="#0f172a"
                                class="w-10 h-8 rounded-md border border-base-300" />
                            <label class="label m-0"><span class="label-text">Ketebalan:</span></label>
                            <input id="pen-width" type="range" min="1" max="8" value="2"
                                class="range range-xs w-40" />
                            <button type="button" id="undo"
                                class="btn btn-xs btn-outline ml-auto">Undo</button>
                        </div>
                        <div class="relative rounded-lg border border-dashed border-base-300">
                            <canvas id="signature" class="w-full"
                                style="width: 100%; height: 220px; background: #f8fafc;"></canvas>
                            <div id="empty-hint"
                                class="absolute inset-0 flex items-center justify-center text-center pointer-events-none">
                                <div class="text-base-content/50 text-sm">Mulailah menggambar tanda tangan di
                                    sini</div>
                            </div>
                        </div>
                        <div class="mt-3 flex gap-2">
                            <button type="button" id="clear"
                                class="btn btn-sm btn-outline btn-error">Bersihkan</button>
                            <button type="button" id="save" class="btn btn-sm btn-primary">Simpan
                                TTD</button>
                            <button type="button" id="download" class="btn btn-sm btn-outline btn-primary">Unduh
                                PNG</button>
                        </div>
                        <div id="preview" class="mt-3 hidden">
                            <label class="label"><span class="label-text">Preview</span></label>
                            <img id="preview_img" alt="Preview TTD"
                                class="rounded-md border border-base-300 max-h-40" />
                        </div>
                    </div>
                    <!-- Hidden input di luar wire:ignore agar Livewire menangkap perubahan -->
                    <input type="hidden" id="signature_data" wire:model.defer="ttd_data" />
                    @error('ttd_data')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>
            @endif

            <div>
                <button type="submit" class="btn btn-primary btn-wide">
                    <i class="fas fa-save"></i>
                    <span class="ml-2">Simpan Absensi</span>
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        function initSignaturePad() {
            const canvas = document.getElementById('signature');
            const penColor = document.getElementById('pen-color');
            const penWidth = document.getElementById('pen-width');
            const undoBtn = document.getElementById('undo');
            const clearBtn = document.getElementById('clear');
            const saveBtn = document.getElementById('save');
            const downloadBtn = document.getElementById('download');
            const emptyHint = document.getElementById('empty-hint');
            const signatureInput = document.getElementById('signature_data');
            const preview = document.getElementById('preview');
            const previewImg = document.getElementById('preview_img');

            if (!canvas) return;

            // Hindari multiple inisialisasi
            if (window.__signaturePadInstance) {
                try {
                    window.__signaturePadInstance.off();
                } catch (e) {}
                window.__signaturePadInstance = null;
            }

            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(0,0,0,0)',
                penColor: penColor?.value || '#0f172a',
                minWidth: 0.5,
                maxWidth: parseFloat(penWidth?.value || '2'),
            });
            window.__signaturePadInstance = signaturePad;

            function updateEmptyHint() {
                if (!emptyHint) return;
                emptyHint.classList.toggle('hidden', !signaturePad.isEmpty());
            }

            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                const {
                    offsetWidth,
                    offsetHeight
                } = canvas;
                canvas.width = offsetWidth * ratio;
                canvas.height = offsetHeight * ratio;
                const ctx = canvas.getContext('2d');
                ctx.scale(ratio, ratio);
                signaturePad.clear();
                updateEmptyHint();
            }
            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            penColor && penColor.addEventListener('input', (e) => {
                signaturePad.penColor = e.target.value;
            });
            penWidth && penWidth.addEventListener('input', (e) => {
                signaturePad.maxWidth = parseFloat(e.target.value);
            });

            undoBtn && undoBtn.addEventListener('click', () => {
                const data = signaturePad.toData();
                if (data && data.length) {
                    data.pop();
                    signaturePad.fromData(data);
                    updateEmptyHint();
                }
            });

            clearBtn && clearBtn.addEventListener('click', () => {
                signaturePad.clear();
                updateEmptyHint();
                if (preview) preview.classList.add('hidden');
                if (previewImg) previewImg.removeAttribute('src');
                if (signatureInput) {
                    signatureInput.value = '';
                    signatureInput.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                }
            });

            saveBtn && saveBtn.addEventListener('click', () => {
                if (signaturePad.isEmpty()) {
                    alert('Tolong isi tanda tangan dulu.');
                    return;
                }
                const dataURL = signaturePad.toDataURL('image/png');
                if (signatureInput) {
                    signatureInput.value = dataURL;
                    signatureInput.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                }
                if (previewImg) previewImg.src = dataURL;
                if (preview) preview.classList.remove('hidden');
            });

            downloadBtn && downloadBtn.addEventListener('click', () => {
                if (signaturePad.isEmpty()) {
                    alert('Tidak ada tanda tangan untuk diunduh.');
                    return;
                }
                const link = document.createElement('a');
                link.href = signaturePad.toDataURL('image/png');
                link.download = 'ttd.png';
                link.click();
            });

            canvas.addEventListener('pointerdown', updateEmptyHint);
            canvas.addEventListener('pointerup', updateEmptyHint);
        }

        // Inisialisasi saat halaman siap
        document.addEventListener('DOMContentLoaded', initSignaturePad);
        // Re-init setiap Livewire update
        document.addEventListener('livewire:load', () => {
            initSignaturePad();
            if (window.Livewire && Livewire.hook) {
                Livewire.hook('message.processed', () => {
                    initSignaturePad();
                });
            }
        });
    </script>
</div>

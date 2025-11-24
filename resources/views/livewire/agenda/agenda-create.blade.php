<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 items-start">
    <div class="mockup-window border bg-base-100 border-base-300 lg:col-span-2">
        <div class="grid border-t border-base-300 p-4">
            <form wire:submit="save">
                @csrf
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-2 gap-4">
                    {{-- Nama Agenda --}}
                    <div class="form-control lg:col-span-2">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Nama Agenda <span class="text-error">*</span></span>
                        </label>
                        <input type="text" wire:model="name" class="input w-full @error('name') input-error @enderror" placeholder="Masukkan nama agenda">
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- OPD Penyelenggara --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-medium">OPD Penyelenggara <span class="text-error">*</span></span>
                        </label>
                        <select wire:model="opd_id" class="select select-bordered w-full @error('opd_id') select-error @enderror">
                            <option value="">Pilih OPD</option>
                            @foreach ($opds as $opd)
                                <option value="{{ $opd->id }}">{{ $opd->name }}</option>
                            @endforeach
                        </select>
                        @error('opd_id')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Tanggal <span class="text-error">*</span></span>
                        </label>
                        <input type="date" wire:model="date" class="input input-bordered w-full @error('date') input-error @enderror">
                        @error('date')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Jam Mulai --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Jam Mulai <span class="text-error">*</span></span>
                        </label>
                        <input type="time" wire:model="jam_mulai" class="input input-bordered w-full @error('jam_mulai') input-error @enderror">
                        @error('jam_mulai')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Jam Selesai --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Jam Selesai <span class="text-error">*</span></span>
                        </label>
                        <input type="time" wire:model="jam_selesai" class="input input-bordered w-full @error('jam_selesai') input-error @enderror">
                        @error('jam_selesai')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Link Zoom --}}
                    <div class="form-control lg:col-span-2">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Link Zoom (Opsional)</span>
                        </label>
                        <input type="url" wire:model="link_zoom" class="input w-full @error('link_zoom') input-error @enderror" placeholder="https://zoom.us/j/...">
                        @error('link_zoom')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Link Paparan --}}
                    <div class="form-control lg:col-span-2">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Link Paparan (Opsional)</span>
                        </label>
                        <input type="url" wire:model="link_paparan" class="input w-full @error('link_paparan') input-error @enderror" placeholder="https://docs.google.com/...">
                        @error('link_paparan')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Catatan --}}
                    <div class="form-control lg:col-span-2">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Catatan (Opsional)</span>
                        </label>
                        <textarea wire:model="catatan" class="textarea textarea-bordered w-full @error('catatan') textarea-error @enderror" rows="4" placeholder="Catatan tambahan untuk agenda..."></textarea>
                        @error('catatan')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('agenda.index') }}" class="btn btn-sm" wire:navigate>Batal</a>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Simpan Agenda
                        <span wire:loading class="loading loading-spinner loading-sm"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Information Card (Right - 1 column) --}}
    <div class="lg:col-span-1">
        <div class="card bg-base-100 border border-base-300">
            <div class="card-body">
                <div class="card-title mb-4">
                    <svg class="size-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <h2 class="text-lg font-semibold">Informasi & Tips</h2>
                </div>

                <div class="space-y-4">
                    <div class="alert backdrop-blur-md bg-primary-content/90 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Persyaratan Data Agenda:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Nama Agenda wajib diisi</li>
                                <li>OPD Penyelenggara wajib dipilih</li>
                                <li>Tanggal, jam mulai, jam selesai wajib diisi</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert backdrop-blur-md bg-primary-content/70 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Catatan Link:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Link Zoom opsional</li>
                                <li>Link Paparan opsional</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert backdrop-blur-md bg-primary-content/50 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Tips:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Periksa data sebelum menyimpan</li>
                                <li>Pastikan waktu tidak bertabrakan</li>
                                <li>QR Code dibuat otomatis setelah agenda disimpan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

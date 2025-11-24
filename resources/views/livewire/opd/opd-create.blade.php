<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 items-start">
    <div class="mockup-window border bg-base-100 border-base-300 lg:col-span-2">
        <div class="grid border-t border-base-300 p-4">
            <form wire:submit="save">
                @csrf
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-2 gap-4">
                    {{-- Nama OPD --}}
                    <div class="form-control lg:col-span-2">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Nama OPD <span class="text-error">*</span></span>
                        </label>
                        <input type="text" wire:model="name" class="input w-full @error('name') input-error @enderror"
                            placeholder="Masukkan nama OPD">
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Singkatan --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Singkatan <span class="text-error">*</span></span>
                        </label>
                        <input type="text" wire:model="singkatan"
                            class="input w-full @error('singkatan') input-error @enderror"
                            placeholder="Masukkan singkatan">
                        @error('singkatan')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Telepon --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Telepon <span class="text-error">*</span></span>
                        </label>
                        <input type="text" wire:model="telp"
                            class="input w-full @error('telp') input-error @enderror"
                            placeholder="Masukkan nomor telepon">
                        @error('telp')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="form-control lg:col-span-2">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Alamat <span class="text-error">*</span></span>
                        </label>
                        <textarea wire:model="alamat" class="textarea textarea-bordered w-full @error('alamat') textarea-error @enderror"
                            rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                        @error('alamat')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Logo OPD --}}
                    <div class="form-control lg:col-span-2">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Logo OPD</span>
                        </label>
                        <div class="flex items-center gap-4">
                            @if ($logo)
                                <div class="avatar">
                                    <div class="w-20 rounded">
                                        <img src="{{ $logo->temporaryUrl() }}" alt="Preview Logo">
                                    </div>
                                </div>
                            @else
                                <div class="avatar placeholder">
                                    <div class="bg-base-200 text-base-content/70 w-20 rounded-xl">
                                    </div>
                                </div>
                            @endif
                            <input type="file" wire:model="logo"
                                class="file-input file-input-bordered w-full max-w-xs @error('logo') file-input-error @enderror"
                                accept="image/*">
                        </div>
                        @error('logo')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                        <label class="label pt-2">
                            <span class="label-text-alt">Format: JPG/PNG. Maksimal 2MB</span>
                        </label>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('opd.index') }}" class="btn btn-sm">Batal</a>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Simpan OPD
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
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <h2 class="text-lg font-semibold">Informasi & Tips</h2>
                </div>

                <div class="space-y-4">
                    <div class="alert backdrop-blur-md bg-primary-content/90 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Persyaratan Data OPD:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Nama OPD wajib diisi</li>
                                <li>Singkatan unik dan ringkas</li>
                                <li>Alamat dan telepon valid</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert backdrop-blur-md bg-primary-content/70 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Catatan Logo:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Format JPG/PNG, maksimal 2MB</li>
                                <li>Opsional, bisa ditambahkan nanti</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert backdrop-blur-md bg-primary-content/50 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Tips:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Periksa data sebelum menyimpan</li>
                                <li>Gunakan singkatan yang dikenal publik</li>
                                <li>Pastikan kontak OPD aktif</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

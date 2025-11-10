<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 items-start">
    <div class="mockup-window border bg-base-100 border-base-300 lg:col-span-2">
        <div class="grid border-t border-base-300 p-4">
            <form wire:submit="save">
                @csrf
                <div class="grid lg:grid-cols-2 md:grid-cols-2 sm:grid-cols-2 gap-4">
                    {{-- Name Field --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Nama Lengkap <span class="text-error">*</span></span>
                        </label>
                        <input type="text" wire:model="name" class="input w-full @error('name') input-error @enderror"
                            placeholder="Masukkan nama lengkap">
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Email Field --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Email <span class="text-error">*</span></span>
                        </label>
                        <input type="email" wire:model="email"
                            class="input w-full @error('email') input-error @enderror" placeholder="Masukkan email">
                        @error('email')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-medium">Password Baru</span>
                        </label>
                        <label class="label mb-2">
                            <span class="label-text-alt text-base-content/60">(Kosongkan jika tidak ingin
                                mengubah)</span>
                        </label>
                        <div class="join w-full">
                            <input id="password" type="password" wire:model="password"
                                class="input w-full join-item input-bordered bg-gray-50 text-gray-600 border focus:border-transparent border-gray-300 sm:text-sm rounded-s-lg ring-3 ring-transparent focus:ring-1 focus:outline-hidden focus:ring-gray-400 @error('password') input-error @enderror"
                                placeholder="••••••••••">
                            <button type="button"
                                class="btn btn-primary shadow-none btn-square join-item swap swap-rotate"
                                data-toggle="password" data-target="password"
                                aria-label="Tampilkan/sembunyikan password">
                                <svg class="size-4 swap-on" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    <circle cx="12" cy="12" r="3" stroke-width="2" />
                                </svg>
                                <svg class="size-4 swap-off" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.18 6.18A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.976 9.976 0 01-4.6 5.383M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Confirm Password Field --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Konfirmasi Password Baru</span>
                        </label>
                        <div class="join w-full">
                            <input id="password_confirmation" type="password" wire:model="password_confirmation"
                                class="input w-full join-item input-bordered bg-gray-50 text-gray-600 border focus:border-transparent border-gray-300 sm:text-sm rounded-s-lg ring-3 ring-transparent focus:ring-1 focus:outline-hidden focus:ring-gray-400"
                                placeholder="••••••••••">
                            <button type="button"
                                class="btn btn-primary shadow-none btn-square join-item swap swap-rotate"
                                data-toggle="password" data-target="password_confirmation"
                                aria-label="Tampilkan/sembunyikan konfirmasi password">
                                <svg class="size-4 swap-on" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    <circle cx="12" cy="12" r="3" stroke-width="2" />
                                </svg>
                                <svg class="size-4 swap-off" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.18 6.18A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.976 9.976 0 01-4.6 5.383M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Roles Field (Full Width) --}}
                <div class="form-control mt-4">
                    <label class="label mb-2">
                        <span class="label-text font-medium">Role <span class="text-error">*</span></span>
                    </label>
                    <div
                        class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 border border-base-300 rounded-lg @error('selectedRoles') @enderror">
                        @foreach ($roles as $role)
                            <label class="label cursor-pointer justify-start gap-3">
                                <input type="checkbox" wire:model="selectedRoles" value="{{ $role->name }}"
                                    class="checkbox checkbox-sm">
                                <span class="label-text">{{ ucfirst($role->name) }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('selectedRoles')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                {{-- Form Actions --}}
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('users.index') }}" class="btn btn-sm">Batal</a>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Update User
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
                    <h2 class="text-lg font-semibold">Informasi</h2>
                </div>

                <div class="space-y-4">
                    <div class="alert backdrop-blur-md bg-primary-content/90 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Persyaratan Password:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li> Password Baru (Kosongkan jika tidak ingin mengubah) </li>
                                <li>Minimal 8 karakter</li>
                                <li>Kombinasi huruf dan angka</li>
                                <li>Hindari kata yang mudah ditebak</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert backdrop-blur-md bg-primary-content/70 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Catatan Role:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Pilih minimal satu role</li>
                                <li>User dapat memiliki multiple role</li>
                                <li>Role menentukan akses sistem</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert backdrop-blur-md bg-primary-content/50 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Tips:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Email harus unik</li>
                                <li>Gunakan email aktif</li>
                                <li>Periksa data sebelum menyimpan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 items-start">
    <div class="mockup-window border bg-base-100 border-base-300 lg:col-span-2">
        <div class="grid border-t border-base-300 p-4">
            <form wire:submit="save">
                @csrf
                <div class="grid gap-4">
                    {{-- Name Field --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Nama Permission <span class="text-error">*</span></span>
                        </label>
                        <input type="text" wire:model="name" class="input w-full @error('name') input-error @enderror"
                            placeholder="Masukkan nama permission (contoh: create-article, edit-user)">
                        @error('name')
                            <label class="label">
                                <span
                                    class="label-text-alt text-error break-words whitespace-normal leading-relaxed">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    {{-- Group Field --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Group</span>
                            <span class="label-text-alt">Opsional - pilih atau ketik nama grup</span>
                        </label>
                        <input type="text" wire:model="group" list="groupOptions" class="input w-full"
                            placeholder="Contoh: User Management">
                        <datalist id="groupOptions">
                            @if (isset($groups))
                                @foreach ($groups as $g)
                                    @if ($g)
                                        <option value="{{ $g }}"></option>
                                    @endif
                                @endforeach
                            @endif
                        </datalist>
                        @error('group')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                {{-- Roles Field (Full Width) --}}
                <div class="form-control mt-4">
                    <label class="label mb-2">
                        <span class="label-text font-medium">Roles</span>
                        <span class="label-text-alt">pilih role yang akan memiliki permission ini</span>
                    </label>
                    <div class="space-y-4">
                        @if ($roles->count() > 0)
                            <div class="border border-base-300 rounded-lg p-4 bg-base-50">
                                <!-- Group Header -->
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-semibold text-base-content">Available Roles</h4>
                                    <div class="flex gap-2">
                                        <button type="button" onclick="selectAllRoles()"
                                            class="btn btn-xs btn-outline">
                                            Select All
                                        </button>
                                        <button type="button" onclick="deselectAllRoles()"
                                            class="btn btn-xs btn-outline">
                                            Deselect All
                                        </button>
                                    </div>
                                </div>

                                <!-- Roles Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach ($roles as $role)
                                        <label
                                            class="label cursor-pointer justify-start gap-3 p-2 hover:bg-base-100 rounded role-checkbox-group">
                                            <input type="checkbox" wire:model="selectedRoles"
                                                value="{{ $role->name }}" class="checkbox checkbox-sm role-checkbox">
                                            <span
                                                class="label-text">{{ ucfirst(str_replace('-', ' ', $role->name)) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8V4a1 1 0 00-1-1H7a1 1 0 00-1 1v1m8 0V4a1 1 0 00-1-1H9a1 1 0 00-1 1v1m4 6h.01M12 17h.01" />
                                </svg>
                                <p class="mt-2">Belum ada role yang tersedia</p>
                                <p class="text-sm">Buat role terlebih dahulu untuk mengassign permission</p>
                            </div>
                        @endif
                    </div>
                    @error('selectedRoles')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <script>
                    function selectAllRoles() {
                        const checkboxes = document.querySelectorAll('.role-checkbox');
                        checkboxes.forEach(checkbox => {
                            if (!checkbox.checked) {
                                checkbox.click();
                            }
                        });
                    }

                    function deselectAllRoles() {
                        const checkboxes = document.querySelectorAll('.role-checkbox');
                        checkboxes.forEach(checkbox => {
                            if (checkbox.checked) {
                                checkbox.click();
                            }
                        });
                    }
                </script>

                {{-- Form Actions --}}
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('permissions.index') }}" class="btn btn-sm">Batal</a>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Simpan Permission
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
                            <p class="font-medium mb-2">Panduan Permission:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Gunakan nama yang deskriptif</li>
                                <li>Format: action-resource (create-article)</li>
                                <li>Permission mengatur akses spesifik</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert backdrop-blur-md bg-primary-content/70 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Catatan Penting:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Permission dapat diassign ke multiple roles</li>
                                <li>Nama permission harus unik</li>
                                <li>Gunakan kebab-case (create-article)</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert backdrop-blur-md bg-primary-content/50 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Contoh Permission:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>create-article:</strong> Membuat artikel</li>
                                <li><strong>edit-user:</strong> Edit data user</li>
                                <li><strong>delete-comment:</strong> Hapus komentar</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

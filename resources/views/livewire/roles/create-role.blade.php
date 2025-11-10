<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 items-start">
    <div class="mockup-window border bg-base-100 border-base-300 lg:col-span-2">
        <div class="grid border-t border-base-300 p-4">
            <form wire:submit="save">
                @csrf
                <div class="grid gap-4">
                    {{-- Name Field --}}
                    <div class="form-control">
                        <label class="label mb-2">
                            <span class="label-text font-medium">Nama Role <span class="text-error">*</span></span>
                        </label>
                        <input type="text" wire:model="name" class="input w-full @error('name') input-error @enderror"
                            placeholder="Masukkan nama role (contoh: editor, moderator)">
                        @error('name')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                {{-- Permissions Field (Full Width) --}}
                <div class="form-control mt-4">
                    <label class="label mb-2">
                        <span class="label-text font-medium">Permissions <span class="text-error">*</span></span>
                    </label>
                    <div class="space-y-4 @error('selectedPermissions') @enderror">
                        @foreach ($groupedPermissions as $groupName => $permissions)
                            <div class="border border-base-300 rounded-lg p-4 bg-base-50">
                                <!-- Group Header -->
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-semibold text-base-content">{{ $groupName }}</h4>
                                    <div class="flex gap-2">
                                        <button type="button" onclick="selectAllInGroup('{{ $groupName }}')"
                                            class="btn btn-xs btn-outline">
                                            Select All
                                        </button>
                                        <button type="button" onclick="deselectAllInGroup('{{ $groupName }}')"
                                            class="btn btn-xs btn-outline">
                                            Deselect All
                                        </button>
                                    </div>
                                </div>

                                <!-- Permissions Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                    @foreach ($permissions as $permission)
                                        <label
                                            class="label cursor-pointer justify-start gap-3 p-2 hover:bg-base-100 rounded group-{{ str_replace(' ', '-', strtolower($groupName)) }}">
                                            <input type="checkbox" wire:model="selectedPermissions"
                                                value="{{ $permission->name }}"
                                                class="checkbox checkbox-sm permission-checkbox"
                                                data-group="{{ str_replace(' ', '-', strtolower($groupName)) }}">
                                            <span
                                                class="label-text">{{ ucfirst(str_replace('-', ' ', $permission->name)) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('selectedPermissions')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <script>
                    function selectAllInGroup(groupName) {
                        const groupClass = 'group-' + groupName.toLowerCase().replace(/\s+/g, '-');
                        const checkboxes = document.querySelectorAll('.' + groupClass + ' input[type="checkbox"]');
                        checkboxes.forEach(checkbox => {
                            if (!checkbox.checked) {
                                checkbox.click();
                            }
                        });
                    }

                    function deselectAllInGroup(groupName) {
                        const groupClass = 'group-' + groupName.toLowerCase().replace(/\s+/g, '-');
                        const checkboxes = document.querySelectorAll('.' + groupClass + ' input[type="checkbox"]');
                        checkboxes.forEach(checkbox => {
                            if (checkbox.checked) {
                                checkbox.click();
                            }
                        });
                    }
                </script>

                {{-- Form Actions --}}
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('roles.index') }}" class="btn btn-sm">Batal</a>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Simpan Role
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
                            <p class="font-medium mb-2">Panduan Role:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Gunakan nama yang deskriptif</li>
                                <li>Pilih permissions yang sesuai</li>
                                <li>Role akan mengatur akses user</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert backdrop-blur-md bg-primary-content/70 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Catatan Penting:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Role tidak dapat dihapus jika masih digunakan</li>
                                <li>Permissions dapat diubah kapan saja</li>
                                <li>Pastikan role memiliki minimal 1 permission</li>
                            </ul>
                        </div>
                    </div>

                    <div class="alert backdrop-blur-md bg-primary-content/50 border border-white/20 shadow">
                        <div class="text-sm">
                            <p class="font-medium mb-2">Contoh Role:</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>Editor:</strong> Kelola konten</li>
                                <li><strong>Moderator:</strong> Moderasi komentar</li>
                                <li><strong>Viewer:</strong> Hanya melihat</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

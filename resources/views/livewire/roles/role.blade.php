<div>
    <div class="grid gap-4 md:gap-6">
        {{-- Card --}}
        <div class="stats bg-base-100 flex flex-col md:flex-row border border-base-300 rounded-xl">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-6 h-6 md:w-8 md:h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                </div>
                <div class="stat-title">Total Role</div>
                <div class="stat-value text-primary text-2xl md:text-3xl">{{ $totalRoles }}</div>
                <div class="stat-desc">Semua role terdaftar</div>
            </div>

            <div class="stat">
                <div class="stat-figure text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-6 h-6 md:w-8 md:h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                        </path>
                    </svg>
                </div>
                <div class="stat-title">Role Baru</div>
                <div class="stat-value text-secondary text-2xl md:text-3xl">{{ $newRoles }}</div>
                <div class="stat-desc">30 hari terakhir</div>
            </div>

            <div class="stat">
                <div class="stat-figure text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-6 h-6 md:w-8 md:h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="stat-title">Total Users</div>
                <div class="stat-value text-accent text-2xl md:text-3xl">{{ $rolesWithUsers }}</div>
                <div class="stat-desc">User dengan role</div>
            </div>
        </div>

        {{-- Table --}}
        <div class="card bg-base-100 border border-base-300 rounded-xl">
            <div class="card-body">
                <div class="card-title">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1 text-sm font-bold">
                                <svg class="size-4" fill="currentColor" width="12" height="12"
                                    viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M216,148H172V108h44a12,12,0,0,0,0-24H172V40a12,12,0,0,0-24,0V84H108V40a12,12,0,0,0-24,0V84H40a12,12,0,0,0,0,24H84v40H40a12,12,0,0,0,0,24H84v44a12,12,0,0,0,24,0V172h40v44a12,12,0,0,0,24,0V172h44a12,12,0,0,0,0-24Zm-108,0V108h40v40Z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold">Data Role</h4>
                            </div>
                            <span class="text-xs font-light text-gray-400 hidden md:block">
                                Halaman Role menampilkan semua Data Role, jumlah pengguna yang menggunakan Role tersebut
                                dan kapan Role tersebut dibuat. Saat ini Role "Admin" adalah Role dengan level paling
                                tinggi
                                karena memiliki semua akses.
                            </span>
                        </div>
                        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm" wire:navigate>
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Role
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto rounded-box border border-base-content/7 bg-base-100">
            <table class="table table-zebra table-compact text-sm md:text-base">
                <thead class="bg-gray-200 text-gray-800">
                    <tr>
                        <th>
                            Name <span class="hidden sm:inline">&amp; Permissions</span>
                        </th>
                        <th class="hidden sm:table-cell">Users Count</th>
                        <th class="hidden sm:table-cell">Created At</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if ($roles->count() > 0)
                        @foreach ($roles as $role)
                            <tr>
                                <td class="align-middle">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <div class="avatar avatar-placeholder hidden sm:flex shrink-0">
                                            <div class="bg-neutral text-neutral-content w-10 rounded-full">
                                                <span class="font-bold">
                                                    {{ strtoupper(substr($role->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-medium truncate" title="{{ $role->name }}">
                                                {{ ucfirst($role->name) }}
                                            </div>

                                            <div class="flex items-center gap-1 text-sm text-primary min-w-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-4 shrink-0 hidden sm:inline">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.623 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                                </svg>
                                                <span class="hidden sm:inline truncate">
                                                    {{ $role->permissions->count() }} permissions
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="hidden sm:table-cell">
                                    <div class="badge badge-sm badge-outline">
                                        {{ $role->users_count }} users
                                    </div>
                                </td>

                                <td class="hidden sm:table-cell">
                                    <div class="text-sm text-gray-500">
                                        {{ $role->created_at->format('d M Y') }}
                                    </div>
                                </td>

                                <td class="text-end">
                                    <div class="flex justify-end space-x-2">
                                        @can('edit-role')
                                            <a href="{{ route('roles.edit', $role->id) }}" wire:navigate
                                                class="btn btn-square btn-sm backdrop-blur-md bg-white/10 border border-white/20 shadow hover:bg-blue-500/20 hover:border-blue-500/40 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="size-[1.2em]">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('delete-role')
                                            <button onclick="delete_modal_{{ $role->id }}.showModal()"
                                                class="btn btn-square btn-sm backdrop-blur-md bg-white/10 border border-white/20 shadow hover:bg-red-500/20 hover:border-red-500/40 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="size-[1.2em]">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data role</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div>
            {{ $roles->links('custom-pagination') }}
        </div>
    </div>

    <!-- Delete Confirmation Modals -->
    @if ($roles->count() > 0)
        @foreach ($roles as $role)
            @can('delete-role')
                <dialog id="delete_modal_{{ $role->id }}" class="modal modal-bottom sm:modal-middle">
                    <div class="modal-box relative">
                        <!-- Close button -->
                        <form method="dialog">
                            <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                        </form>

                        <!-- Warning Icon -->
                        <div class="flex justify-center mb-4">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="text-center">
                            <h3 class="text-lg font-bold mb-2">Konfirmasi Hapus Role</h3>
                            <p class="text-gray-600 mb-2">
                                Apakah Anda yakin ingin menghapus role <strong>"{{ $role->name }}"</strong>?
                            </p>
                            <p class="text-sm text-red-600 mb-4">Tindakan ini tidak dapat dibatalkan!</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 justify-center">
                            <form method="dialog">
                                <button class="btn">Batal</button>
                            </form>
                            <button wire:click="deleteRole({{ $role->id }})" class="btn btn-error text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus Role
                            </button>
                        </div>
                    </div>
                </dialog>
            @endcan
        @endforeach
    @endif
</div>

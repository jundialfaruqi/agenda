<div>
    <div class="grid gap-4 md:gap-6">
        {{-- Card --}}
        <div class="stats bg-base-100 flex flex-col md:flex-row border border-base-300 rounded-xl">
            <div class="stat">
                <div class="stat-figure text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-6 h-6 md:w-8 md:h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                </div>
                <div class="stat-title">Total User</div>
                <div class="stat-value text-primary text-2xl md:text-3xl">{{ $totalUsers }}</div>
                <div class="stat-desc">Semua pengguna terdaftar</div>
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
                <div class="stat-title">User Baru</div>
                <div class="stat-value text-secondary text-2xl md:text-3xl">{{ $newUsers }}</div>
                <div class="stat-desc">30 hari terakhir</div>
            </div>

            <div class="stat">
                <div class="stat-figure text-accent">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-6 h-6 md:w-8 md:h-8 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                        </path>
                    </svg>
                </div>
                <div class="stat-title">Role User</div>
                <div class="stat-value text-accent text-2xl md:text-3xl">{{ $roleUserTotal }}</div>
                <div class="stat-desc">Total user dengan role User</div>
            </div>
        </div>

        {{-- Table --}}
        <div class="card bg-base-100 border border-base-300 rounded-xl">
            <div class="card-body">
                <div class="card-title">
                    <div class="flex items-start justify-between w-full">
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1 text-sm font-bold">
                                <svg class="size-4" fill="currentColor" width="12" height="12"
                                    viewBox="0 0 256 256" id="Flat" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M216,148H172V108h44a12,12,0,0,0,0-24H172V40a12,12,0,0,0-24,0V84H108V40a12,12,0,0,0-24,0V84H40a12,12,0,0,0,0,24H84v40H40a12,12,0,0,0,0,24H84v44a12,12,0,0,0,24,0V172h40v44a12,12,0,0,0,24,0V172h44a12,12,0,0,0,0-24Zm-108,0V108h40v40Z">
                                    </path>
                                </svg>
                                <h4 class="text-lg font-semibold">Data User</h4>
                            </div>
                            <span class="text-xs font-light text-gray-400 hidden md:block">
                                Halaman User menampilkan seluruh Data User berupa Nama, Email, Role
                                dan waktu kapan User tersebut dibuat.
                            </span>
                        </div>
                        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm" wire:navigate>
                            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah User
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-x-auto rounded-box border border-base-content/5 bg-base-100">
            <table class="table table-md table-zebra table-compact text-sm md:text-base">
                <thead class="bg-gray-200 text-gray-800">
                    <tr>
                        <th>
                            Name <span class="hidden sm:inline">&amp; Email</span>
                        </th>
                        <th class="hidden sm:table-cell">Role</th>
                        <th class="hidden sm:table-cell">Created At</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if ($users->count() > 0)
                        @foreach ($users as $user)
                            <tr>
                                <td class="align-middle">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <div class="avatar avatar-placeholder hidden sm:flex shrink-0">
                                            <div class="bg-neutral text-neutral-content w-10 rounded-full">
                                                <span class="font-bold">
                                                    {{ strtoupper(collect(explode(' ', $user->name))->map(fn($word) => substr($word, 0, 1))->take(2)->implode('')) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-medium truncate" title="{{ $user->name }}">
                                                {{ $user->name }}
                                            </div>

                                            <div class="flex items-center gap-1 text-sm text-primary min-w-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-4 shrink-0 hidden sm:inline truncate">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                                </svg>
                                                <span class="hidden sm:inline truncate"
                                                    title="{{ $user->email }}">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="hidden sm:table-cell">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($user->roles as $role)
                                            @php
                                                $badgeClass = match (strtolower($role->name)) {
                                                    'admin' => 'badge-error',
                                                    'super admin' => 'badge-error',
                                                    'superadmin' => 'badge-error',
                                                    'manager' => 'badge-warning',
                                                    'editor' => 'badge-info',
                                                    'moderator' => 'badge-secondary',
                                                    'user' => 'badge-neutral',
                                                    'guest' => 'badge-ghost',
                                                    default => 'badge-primary',
                                                };
                                            @endphp
                                            <span class="badge badge-sm font-bold {{ $badgeClass }}">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="hidden sm:table-cell">
                                    <div class="text-sm text-gray-500">
                                        {{ $user->created_at->format('d M Y') }}</div>
                                </td>
                                <td class="text-end">
                                    <div class="flex justify-end space-x-2">
                                        @can('edit-user')
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="btn btn-square btn-sm backdrop-blur-md bg-white/10 border border-white/20 shadow hover:bg-blue-500/20 hover:border-blue-500/40"
                                                wire:navigate>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="size-[1.2em]">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('delete-user')
                                            <button onclick="delete_modal_{{ $user->id }}.showModal()"
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
                            <td colspan="3" class="text-center">Tidak ada data user</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div>
            {{ $users->links('custom-pagination') }}
        </div>
    </div>

    <!-- Delete Confirmation Modals -->
    @if ($users->count() > 0)
        @foreach ($users as $user)
            @can('delete-user')
                <dialog id="delete_modal_{{ $user->id }}" class="modal modal-bottom sm:modal-middle">
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
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Title -->
                        <h3 class="font-bold text-lg text-center mb-2">Konfirmasi Hapus User</h3>

                        <!-- Message -->
                        <div class="text-center mb-6">
                            <p class="text-gray-600 mb-2">Apakah Anda yakin ingin menghapus user:</p>
                            <p class="font-semibold text-lg">{{ $user->name }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
                            <br>
                            <span class="text-sm text-red-600">Tindakan ini tidak dapat dibatalkan!</span>
                        </div>

                        <!-- Action buttons -->
                        <div class="modal-action justify-center gap-3">
                            <form method="dialog">
                                <button class="btn">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Batal
                                </button>
                            </form>
                            <button wire:click="deleteUser({{ $user->id }})"
                                onclick="delete_modal_{{ $user->id }}.close()" class="btn btn-error text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Ya, Hapus User
                            </button>
                        </div>
                    </div>

                    <!-- Modal backdrop - click outside to close -->
                    <form method="dialog" class="modal-backdrop">
                        <button>close</button>
                    </form>
                </dialog>
            @endcan
        @endforeach
    @endif
</div>

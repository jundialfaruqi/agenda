<div class="px-4 py-2 lg:px-4 lg:pt-4">
    <div class="navbar bg-base-100 border border-base-300 rounded-xl">
        <div class="flex-none lg:hidden">
            <label for="drawer-toggle" class="btn btn-square btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                </svg>
            </label>
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-1">
                <span class="lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-laravel">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 17l8 5l7 -4v-8l-4 -2.5l4 -2.5l4 2.5v4l-11 6.5l-4 -2.5v-7.5l-4 -2.5z" />
                        <path d="M11 18v4" />
                        <path d="M7 15.5l7 -4" />
                        <path d="M14 7.5v4" />
                        <path d="M14 11.5l4 2.5" />
                        <path d="M11 13v-7.5l-4 -2.5l-4 2.5" />
                        <path d="M7 8l4 -2.5" />
                        <path d="M18 10l4 -2.5" />
                    </svg>
                </span>
                <span class="text-xl font-bold block lg:hidden">
                    Laravel
                </span>
            </div>
            <!-- Kolom pencarian - hanya tampil di desktop -->
            <div class="hidden lg:block lg:ml-1 lg:w-64">
                <div class="form-control w-full">
                    <div class="input-group flex items-stretch">
                        <label class="input backdrop-blur-md bg-white/10 border border-white/20 shadow">
                            <svg class="h-[2em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                    stroke="currentColor">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.3-4.3"></path>
                                </g>
                            </svg>
                            <input type="search" class="grow" placeholder="Search" />
                            <kbd class="kbd kbd-sm">⌘</kbd>
                            <kbd class="kbd kbd-sm">K</kbd>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-none flex items-center gap-2">
            <!-- Dark Mode Toggle -->
            <label
                class="swap swap-rotate btn backdrop-blur-md bg-white/10 border border-white/20 shadow btn-circle h-10 w-10">
                <!-- this hidden checkbox controls the state -->
                <input type="checkbox" class="theme-controller" value="dark" />

                <!-- sun icon -->
                <svg class="swap-off fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
                </svg>

                <!-- moon icon -->
                <svg class="swap-on fill-current w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path
                        d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
                </svg>
            </label>

            <!-- Dropdown notifikasi - hanya tampil di desktop  -->
            <div class="dropdown dropdown-end hidden lg:block">
                <label tabindex="0"
                    class="btn backdrop-blur-md bg-white/10 border border-white/20 shadow btn-circle h-10 w-10 flex items-center justify-center">
                    <div class="indicator">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="badge badge-xs badge-primary indicator-item">3</span>
                    </div>
                </label>
                <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-64 bg-base-100 shadow">
                    <div class="card-body">
                        <div class="font-bold text-lg mb-2">Notifikasi (3)</div>
                        <div class="space-y-2">
                            <div class="flex items-start gap-2 pb-2 border-b">
                                <div class="bg-primary/10 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-primary" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Video baru ditambahkan</p>
                                    <p class="text-xs text-gray-500">5 menit yang lalu</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2 pb-2 border-b">
                                <div class="bg-success/10 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-success" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Pembaruan sistem berhasil</p>
                                    <p class="text-xs text-gray-500">1 jam yang lalu</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-2">
                                <div class="bg-warning/10 p-2 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-warning"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Penyimpanan hampir penuh</p>
                                    <p class="text-xs text-gray-500">1 hari yang lalu</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-actions mt-2">
                            <button class="btn btn-primary btn-sm btn-block">Lihat semua</button>
                        </div>
                    </div>
                </div>
            </div>
            @auth
            <div class="avatar avatar-placeholder">
                <div
                    class="w-10 h-10 rounded-full flex items-center justify-center
                            backdrop-blur-md bg-white/10 border border-white/20 shadow">
                    <span class="font-bold">
                        {{ strtoupper(collect(explode(' ', Auth::user()->name))->map(fn($word) => substr($word, 0, 1))->take(2)->implode('')) }}
                    </span>
                </div>
            </div>
            @endauth
        </div>
    </div>
</div>

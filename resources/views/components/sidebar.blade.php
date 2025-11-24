<div class="drawer-side z-20 lg:ps-4 lg:py-4">
    <label for="drawer-toggle" class="drawer-overlay"></label>
    <aside id="sidebar"
        class="bg-base-100 w-64 sm:w-72 md:w-80 h-full border border-base-300 sidebar-expanded transition-all duration-300 ease-in-out flex flex-col lg:rounded-xl">
        <!-- Sidebar header with logo -->
        <div class="p-3 md:p-4 h-14 md:h-16">
            <h1 class="text-lg flex items-center justify-start gap-1 md:text-xl font-bold sidebar-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-laravel">
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
                Laravel
            </h1>
            <h1 class="text-lg md:text-xl font-bold hidden sidebar-collapsed-title w-full text-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-laravel w-8 h-8 mx-auto">
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
            </h1>
        </div>

        <!-- User info section -->
        @auth
        <div class="px-4 py-4 mb-2 mx-3 border border-base-300 rounded-lg user-info-container">
            <div class="dropdown dropdown-end w-full">
                <div tabindex="0" class="flex items-center justify-between cursor-pointer">
                    <div class="flex items-center">
                        <div class="avatar avatar-placeholder">
                            <div class="bg-neutral text-neutral-content w-10 rounded-full">
                                <span
                                    class="font-bold">{{ strtoupper(collect(explode(' ', Auth::user()->name))->map(fn($word) => substr($word, 0, 1))->take(2)->implode('')) }}</span>
                            </div>
                        </div>
                        <div class="ml-3 menu-item-text">
                            <p class="font-medium text-sm">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-base-content/70">{{ Auth::user()->getRoleNames()->implode(', ') }}
                            </p>
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-sm px-2 rounded-full menu-item-text">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                        </svg>
                    </button>
                </div>
                <ul tabindex="0" class="dropdown-content z-[100] menu p-2 shadow bg-base-100 rounded-box w-52 mb-2">
                    <li>
                        <a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Settings
                        </a>
                    </li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <li>
                            <button type="submit" aria-label="Logout">
                                <!-- icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </li>
                    </form>
                    </li>
                </ul>
            </div>
        </div>
        @endauth

        <!-- Sidebar menu -->
        <ul class="menu p-3 w-full  text-base-content text-sm md:text-base flex-1">
            <li class="menu-title">
                <span>Main Menu</span>
            </li>
            <li>
                <a wire:navigate href="{{ route('dashboard.index') }}"
                    class="{{ request()->routeIs('dashboard.index') ? 'menu-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="menu-item-text">Dashboard</span>
                </a>
            </li>
            @role('user')
                <li>
                    <a href="{{ route('masjid.user') }}" class="{{ request()->routeIs('masjid.*') ? 'menu-active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-building-mosque h-5 w-5">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 21h7v-2a2 2 0 1 1 4 0v2h7" />
                            <path d="M4 21v-10" />
                            <path d="M20 21v-10" />
                            <path d="M4 16h3v-3h10v3h3" />
                            <path d="M17 13a5 5 0 0 0 -10 0" />
                            <path
                                d="M21 10.5c0 -.329 -.077 -.653 -.224 -.947l-.776 -1.553l-.776 1.553a2.118 2.118 0 0 0 -.224 .947a.5 .5 0 0 0 .5 .5h1a.5 .5 0 0 0 .5 -.5z" />
                            <path
                                d="M5 10.5c0 -.329 -.077 -.653 -.224 -.947l-.776 -1.553l-.776 1.553a2.118 2.118 0 0 0 -.224 .947a.5 .5 0 0 0 .5 .5h1a.5 .5 0 0 0 .5 -.5z" />
                            <path d="M12 2a2 2 0 1 0 2 2" />
                            <path d="M12 6v2" />
                        </svg>
                        <span class="menu-item-text">Masjid</span>
                    </a>
                </li>
            @endrole
            <li>
                <a wire:navigate href="{{ route('opd.index') }}"
                    class="{{ request()->routeIs('opd.*') ? 'menu-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="menu-item-text">OPD</span>
                </a>
            </li>
            <li>
                <a wire:navigate href="{{ route('agenda.index') }}"
                    class="{{ request()->routeIs('agenda.*') ? 'menu-active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="menu-item-text">Agenda</span>
                </a>
            </li>
            <li class="menu-title mt-4">
                <span>Content Management</span>
            </li>
            <li><a {{-- href="{{ route('pages.index') }}" class="{{ request()->routeIs('pages.*') ? 'menu-active' : '' }}" --}}>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="menu-item-text">Pages</span>
                </a></li>
            <li><a {{-- href="{{ route('comments.index') }}" class="{{ request()->routeIs('comments.*') ? 'menu-active' : '' }}" --}}>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                    </svg>
                    <span class="menu-item-text">Comments</span>
                </a></li>

            <li class="menu-title mt-4">
                <span>Settings</span>
            </li>
            <li>
                <a {{-- href="{{ route('settings.general') }}" class="{{ request()->routeIs('settings.general') ? 'menu-active' : '' }}" --}}>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="menu-item-text">General Settings</span>
                </a>
            </li>
            @can('user-management')
                <li>
                    <details open>
                        <summary
                            class="{{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'menu-active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <span class="menu-item-text">User Management</span>
                        </summary>
                        <ul class="text-gray-500 text-sm">
                            @can('view-role')
                                <li>
                                    <a href="{{ route('roles.index') }}"
                                        class="{{ request()->routeIs('roles.*') ? 'menu-active' : '' }}">
                                        # User Roles
                                    </a>
                                </li>
                            @endcan
                            @can('view-permission')
                                <li>
                                    <a href="{{ route('permissions.index') }}"
                                        class="{{ request()->routeIs('permissions.*') ? 'menu-active' : '' }}">
                                        # User Permissions
                                    </a>
                                </li>
                            @endcan
                            @can('view-user')
                                <li>
                                    <a href="{{ route('users.index') }}"
                                        class="{{ request()->routeIs('users.*') ? 'menu-active' : '' }}">
                                        # Users Data
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </details>
                </li>
            @endcan
        </ul>

        <!-- Collapse button at the very bottom (desktop only) -->
        <div class="mt-auto hidden lg:block">
            <button id="sidebar-toggle"
                class="w-full flex items-center px-6 py-4 text-sm transition-all duration-300 rounded-b-xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="h-5 w-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                </svg>
                <span class="menu-item-text">Collapse</span>
            </button>
        </div>
    </aside>
</div>

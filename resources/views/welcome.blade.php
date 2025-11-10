<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|poppins:400,500,600,700"
        rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen font-['Poppins'] bg-base-100">
    <div class="hero min-h-screen bg-gradient-to-br from-primary to-secondary">
        <div class="hero-overlay bg-base-300/20"></div>
        <div class="hero-content text-center">
            <div class="max-w-2xl">
                <!-- Head -->
                <div
                    class="bg-accent w-fit px-4 py-2 rounded-xl lg:rounded-full mb-6 font-semibold text-accent-content mx-auto text-center">
                    ✨ Welcome to My Laravel Admin Panel Template
                </div>

                <!-- Main Title -->
                <h1
                    class="mb-8 text-6xl md:text-7xl lg:text-8xl font-bold bg-gradient-to-r from-primary-content to-base-content bg-clip-text text-transparent">
                    Hello World
                </h1>

                <!-- Subtitle -->
                <p class="mb-8 text-xl md:text-1xl font-medium text-primary-content/90 leading-relaxed italic">
                    "Selamat datang di panggung semu, tempat bayangan menipu mata dan harapan berbalut fatamorgana. Mari
                    melangkah, meski setiap jejak mungkin harus dibayar dengan luka dan air mata."
                </p>

                <!-- Technology Stack Cards -->
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-10">
                    <!-- Laravel -->
                    <div
                        class="card bg-base-100/20 backdrop-blur-sm border border-primary-content/20 hover:border-cyan-500/50 hover:bg-base-100/20 transition-all duration-300">
                        <div class="card-body items-center text-center p-6">
                            <div class="mb-3">
                                <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128">
                                    <path
                                        style="stroke:none;fill-rule:nonzero;fill:rgb(94.117647%,32.54902%,25.098039%);fill-opacity:1;"
                                        d="M 26.027344 0.136719 C 25.824219 0.214844 20.085938 3.484375 13.28125 7.394531 C 5.035156 12.136719 0.800781 14.632812 0.574219 14.867188 C 0.394531 15.070312 0.191406 15.421875 0.128906 15.644531 C -0.0429688 16.21875 -0.0546875 100.347656 0.117188 100.953125 C 0.179688 101.1875 0.382812 101.53125 0.566406 101.722656 C 1.011719 102.191406 50.238281 130.496094 50.835938 130.632812 C 51.113281 130.699219 51.425781 130.6875 51.734375 130.601562 C 52.40625 130.433594 101.503906 102.191406 101.941406 101.730469 C 102.121094 101.53125 102.324219 101.1875 102.390625 100.953125 C 102.476562 100.675781 102.507812 96.277344 102.507812 87.015625 L 102.507812 73.480469 L 114.476562 66.605469 C 125.761719 60.117188 126.453125 59.710938 126.742188 59.265625 L 127.039062 58.785156 L 127.039062 44.207031 C 127.039062 28.335938 127.070312 29.230469 126.441406 28.65625 C 126.273438 28.507812 120.523438 25.152344 113.652344 21.195312 L 101.171875 14.015625 L 99.785156 14.015625 L 87.574219 21.027344 C 80.851562 24.894531 75.136719 28.199219 74.859375 28.378906 C 74.582031 28.5625 74.25 28.902344 74.113281 29.148438 L 73.867188 29.574219 L 73.8125 43.308594 L 73.761719 57.046875 L 63.679688 62.855469 C 58.132812 66.042969 53.515625 68.683594 53.417969 68.707031 C 53.238281 68.757812 53.226562 67.449219 53.226562 42.203125 L 53.226562 15.632812 L 52.960938 15.175781 C 52.628906 14.621094 54.121094 15.507812 39.136719 6.894531 C 26.570312 -0.332031 26.871094 -0.179688 26.027344 0.136719 Z M 37.578125 10.65625 C 42.835938 13.671875 47.136719 16.167969 47.136719 16.199219 C 47.136719 16.230469 42.527344 18.894531 36.894531 22.132812 L 26.644531 28.015625 L 16.414062 22.132812 C 10.792969 18.894531 6.1875 16.230469 6.1875 16.199219 C 6.1875 16.167969 10.785156 13.503906 16.40625 10.273438 L 26.613281 4.402344 L 27.316406 4.785156 C 27.710938 5 32.332031 7.640625 37.578125 10.65625 Z M 110.730469 24.191406 C 116.265625 27.378906 120.84375 30.011719 120.886719 30.054688 C 121.003906 30.160156 100.703125 41.828125 100.425781 41.816406 C 100.148438 41.808594 80.097656 30.246094 80.105469 30.105469 C 80.117188 29.945312 100.289062 18.339844 100.492188 18.371094 C 100.585938 18.394531 105.195312 21.015625 110.730469 24.191406 Z M 14.828125 25.875 L 24.585938 31.492188 L 24.640625 59.304688 L 24.691406 87.121094 L 24.929688 87.496094 C 25.054688 87.695312 25.289062 87.964844 25.460938 88.089844 C 25.621094 88.207031 31.050781 91.300781 37.523438 94.953125 L 49.28125 101.59375 L 49.28125 113.359375 C 49.28125 119.816406 49.238281 125.113281 49.183594 125.113281 C 49.140625 125.113281 38.976562 119.296875 26.601562 112.175781 L 4.105469 99.238281 L 4.074219 59.464844 L 4.054688 19.703125 L 4.554688 19.980469 C 4.84375 20.132812 9.460938 22.785156 14.828125 25.875 Z M 49.28125 45.453125 L 49.28125 71.082031 L 48.886719 71.339844 C 48.351562 71.679688 28.8125 82.910156 28.746094 82.910156 C 28.714844 82.910156 28.691406 71.339844 28.691406 57.195312 L 28.703125 31.492188 L 38.910156 25.621094 C 44.523438 22.390625 49.152344 19.769531 49.207031 19.789062 C 49.246094 19.8125 49.28125 31.363281 49.28125 45.453125 Z M 88.222656 39.558594 L 98.453125 45.441406 L 98.453125 57.101562 C 98.453125 68.164062 98.441406 68.757812 98.273438 68.695312 C 98.164062 68.652344 93.535156 66 87.980469 62.800781 L 77.867188 56.992188 L 77.867188 45.335938 C 77.867188 38.917969 77.898438 33.675781 77.929688 33.675781 C 77.972656 33.675781 82.601562 36.320312 88.222656 39.558594 Z M 123.09375 45.261719 C 123.09375 51.644531 123.050781 56.910156 123.007812 56.960938 C 122.933594 57.078125 102.699219 68.738281 102.570312 68.738281 C 102.539062 68.738281 102.507812 63.496094 102.507812 57.078125 L 102.507812 45.421875 L 112.714844 39.546875 C 118.335938 36.320312 122.964844 33.675781 123.007812 33.675781 C 123.0625 33.675781 123.09375 38.886719 123.09375 45.261719 Z M 86.230469 66.46875 C 94.835938 71.421875 96.320312 72.308594 96.171875 72.425781 C 96.074219 72.488281 92.8125 74.363281 88.929688 76.582031 C 85.046875 78.796875 74.988281 84.53125 66.570312 89.328125 L 51.273438 98.054688 L 50.785156 97.789062 C 47.863281 96.191406 30.910156 86.546875 30.910156 86.472656 C 30.902344 86.3125 75.765625 60.53125 75.945312 60.597656 C 76.03125 60.628906 80.660156 63.269531 86.230469 66.46875 Z M 98.433594 87.558594 L 98.398438 99.238281 L 75.914062 112.175781 C 63.542969 119.296875 53.375 125.113281 53.324219 125.113281 C 53.269531 125.113281 53.226562 120.359375 53.226562 113.359375 L 53.226562 101.59375 L 75.765625 88.742188 C 88.148438 81.675781 98.324219 75.890625 98.378906 75.878906 C 98.421875 75.878906 98.441406 81.132812 98.433594 87.558594 Z M 98.433594 87.558594 " />
                                </svg>
                            </div>
                            <h3 class="card-title text-primary-content text-sm font-semibold">Laravel</h3>
                            <p class="text-primary-content/70 text-xs">PHP Framework</p>
                        </div>
                    </div>

                    <!-- Tailwind CSS -->
                    <div
                        class="card bg-base-100/20 backdrop-blur-sm border border-primary-content/20 hover:border-cyan-500/50 hover:bg-base-100/20 transition-all duration-300">
                        <div class="card-body items-center text-center p-6">
                            <div class="mb-3">
                                <svg class="w-10 h-10 text-cyan-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12.001,4.8c-3.2,0-5.2,1.6-6,4.8c1.2-1.6,2.6-2.2,4.2-1.8c0.913,0.228,1.565,0.89,2.288,1.624 C13.666,10.618,15.027,12,18.001,12c3.2,0,5.2-1.6,6-4.8c-1.2,1.6-2.6,2.2-4.2,1.8c-0.913-0.228-1.565-0.89-2.288-1.624 C16.337,6.182,14.976,4.8,12.001,4.8z M6.001,12c-3.2,0-5.2,1.6-6,4.8c1.2-1.6,2.6-2.2,4.2-1.8c0.913,0.228,1.565,0.89,2.288,1.624 C7.666,17.818,9.027,19.2,12.001,19.2c3.2,0,5.2-1.6,6-4.8c-1.2,1.6-2.6,2.2-4.2,1.8c-0.913-0.228-1.565-0.89-2.288-1.624 C10.337,13.382,8.976,12,6.001,12z" />
                                </svg>
                            </div>
                            <h3 class="card-title text-primary-content text-sm font-semibold">Tailwind</h3>
                            <p class="text-primary-content/70 text-xs">CSS Framework</p>
                        </div>
                    </div>

                    <!-- DaisyUI -->
                    <div
                        class="card bg-base-100/20 backdrop-blur-sm border border-primary-content/20 hover:border-green-500/50 hover:bg-base-100/20 transition-all duration-300">
                        <div class="card-body items-center text-center p-6">
                            <div class="mb-3">
                                <img src="https://img.daisyui.com/images/daisyui/mark-static.svg" alt="DaisyUI Logo"
                                    class="w-16 h-10 object-contain">
                            </div>
                            <h3 class="card-title text-primary-content text-sm font-semibold">DaisyUI</h3>
                            <p class="text-primary-content/70 text-xs">UI Components</p>
                        </div>
                    </div>

                    <!-- Livewire -->
                    <div
                        class="card bg-base-100/20 backdrop-blur-sm border border-primary-content/20 hover:border-purple-500/50 hover:bg-base-100/20 transition-all duration-300">
                        <div class="card-body items-center text-center p-6">
                            <div class="mb-3">
                                <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128">
                                    <path style="fill-rule:evenodd;fill:#fb70a9;fill-opacity:1"
                                        d="M108.566 83.547c-1.937 2.926-3.406 6.527-7.34 6.527-6.624 0-6.98-10.203-13.609-10.203-6.625 0-6.265 10.203-12.887 10.203-6.625 0-6.98-10.203-13.609-10.203-6.625 0-6.266 10.203-12.887 10.203-6.625 0-6.98-10.203-13.605-10.203-6.629 0-6.27 10.203-12.89 10.203-2.083 0-3.544-1.008-4.778-2.39-4.738-8.239-7.465-17.895-7.465-28.22 0-30.222 23.367-54.722 52.191-54.722 28.825 0 52.192 24.5 52.192 54.723 0 8.64-1.91 16.816-5.313 24.082Zm0 0" />
                                    <path style="fill-rule:evenodd;fill:#4e56a6;fill-opacity:1"
                                        d="M40.844 78.145v22.668c0 4.066-3.301 7.363-7.371 7.363a7.365 7.365 0 0 1-7.371-7.364V73.45c1.375-2.523 2.945-4.707 5.78-4.707 4.61 0 6.223 5.79 8.962 9.403Zm27.843 1.183v35.844a8.185 8.185 0 0 1-8.187 8.183c-4.523 0-8.191-3.664-8.191-8.183v-40.57c1.543-2.973 3.132-5.86 6.39-5.86 5.16 0 6.563 7.242 9.989 10.586Zm26.211-.66v26.023c0 4.067-3.3 7.364-7.37 7.364-4.071 0-7.372-3.297-7.372-7.364V72.707c1.281-2.195 2.809-3.965 5.364-3.965 4.84 0 6.375 6.38 9.378 9.926Zm0 0" />
                                    <path style="fill-rule:evenodd;fill:#000;fill-opacity:.298039"
                                        d="M40.844 85.094c-1.309-1.602-2.856-2.79-5.094-2.79-5.316 0-6.293 6.696-9.648 9.712V63.145a7.365 7.365 0 0 1 7.37-7.364c4.071 0 7.372 3.297 7.372 7.364Zm27.843.515c-1.394-1.855-3.023-3.304-5.496-3.304-5.914 0-6.457 8.285-10.882 10.578v-12.77c0-4.52 3.668-8.183 8.191-8.183a8.185 8.185 0 0 1 8.188 8.183Zm26.211-1.433c-1.136-1.117-2.48-1.871-4.265-1.871-5.73 0-6.418 7.777-10.477 10.343V66.734a7.371 7.371 0 0 1 14.742 0Zm0 0" />
                                    <path style="fill-rule:evenodd;fill:#fb70a9;fill-opacity:1"
                                        d="M108.566 83.547c-1.937 2.926-3.406 6.527-7.34 6.527-6.624 0-6.98-10.203-13.609-10.203-6.625 0-6.265 10.203-12.887 10.203-6.625 0-6.98-10.203-13.609-10.203-6.625 0-6.266 10.203-12.887 10.203-6.625 0-6.98-10.203-13.605-10.203-6.629 0-6.27 10.203-12.89 10.203-2.083 0-3.544-1.008-4.778-2.39-4.738-8.239-7.465-17.895-7.465-28.22 0-30.222 23.367-54.722 52.191-54.722 28.825 0 52.192 24.5 52.192 54.723 0 8.64-1.91 16.816-5.313 24.082Zm0 0" />
                                    <path style="fill-rule:evenodd;fill:#e24ca6;fill-opacity:1"
                                        d="M97.273 88.984c13.676-20.332 14.028-42.879 1.059-67.652 9.613 9.844 15.547 23.348 15.547 38.25 0 8.61-1.98 16.75-5.508 23.992-2.004 2.91-3.531 6.5-7.61 6.5a5.947 5.947 0 0 1-3.488-1.09Zm0 0" />
                                    <path style="fill-rule:evenodd;fill:#fff;fill-opacity:1"
                                        d="M58.89 73.117c18.15 0 25.79-10.52 25.79-25.46 0-14.942-11.547-28.692-25.79-28.692-14.245 0-25.792 13.75-25.792 28.691 0 14.942 7.64 25.461 25.793 25.461Zm0 0" />
                                    <path style="fill-rule:evenodd;fill:#030776;fill-opacity:1"
                                        d="M61.625 37.836c0 5.89-4.332 10.668-9.672 10.668-5.344 0-9.672-4.777-9.672-10.668 0-5.89 4.328-10.668 9.672-10.668 5.34 0 9.672 4.777 9.672 10.668Zm0 0" />
                                    <path style="fill-rule:evenodd;fill:#fff;fill-opacity:1"
                                        d="M55.176 35.375c0 2.719-2.164 4.922-4.836 4.922s-4.836-2.203-4.836-4.922 2.164-4.922 4.836-4.922s4.836 2.203 4.836 4.922Zm0 0" />
                                </svg>
                            </div>
                            <h3 class="card-title text-primary-content text-sm font-semibold">Livewire</h3>
                            <p class="text-primary-content/70 text-xs">Dynamic UI</p>
                        </div>
                    </div>

                    <!-- HTML5 -->
                    <div
                        class="card bg-base-100/20 backdrop-blur-sm border border-primary-content/20 hover:border-orange-500/50 hover:bg-base-100/20 transition-all duration-300">
                        <div class="card-body items-center text-center p-6">
                            <div class="mb-3">
                                <svg class="w-10 h-10 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M1.5 0h21l-1.91 21.563L11.977 24l-8.564-2.438L1.5 0zm7.031 9.75l-.232-2.718 10.059.003.23-2.622L5.412 4.41l.698 8.01h9.126l-.326 3.426-2.91.804-2.955-.81-.188-2.11H6.248l.33 4.171L12 19.351l5.379-1.443.744-8.157H8.531z" />
                                </svg>
                            </div>
                            <h3 class="card-title text-primary-content text-sm font-semibold">HTML5</h3>
                            <p class="text-primary-content/70 text-xs">Markup</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <div class="mb-8">
                    <h2 class="text-2xl md:text-3xl font-bold text-primary-content mb-2 text-center">
                        Jelajahi Halaman
                    </h2>

                    <!-- Quick Access Info -->
                    <div class="text-center mb-8">
                        <p class="text-primary-content/60 text-sm">
                            Klik menu di bawah ini untuk melihat detail halaman
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-center w-full">
                        <ul
                            class="menu menu-horizontal bg-base-500 rounded-box gap-2 flex-wrap justify-center items-center max-w-fit">
                            <!-- Home Button -->
                            <li>
                                <a href="{{ route('home') }}" class="bg-primary text-white p-2">
                                    <div class="transition-all duration-300 flex items-center">
                                        <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                        <span class="font-semibold text-xs">Home</span>
                                        <div class="badge badge-secondary badge-xs ml-1">Main</div>
                                    </div>
                                </a>
                            </li>
                            <!-- Login Button -->
                            <li>
                                <a href="{{ route('login') }}" class="bg-secondary text-white p-2">
                                    <div class="transition-all duration-300 flex items-center">
                                        <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                        </svg>
                                        <span class="font-semibold text-xs">Login</span>
                                        <div class="badge badge-accent badge-xs ml-1">Auth</div>
                                    </div>
                                </a>
                            </li>
                            <!-- Dashboard Button -->
                            <li>
                                <a href="{{ route('dashboard.index') }}" class="bg-accent text-white p-2">
                                    <div class="transition-all duration-300 flex items-center">
                                        <svg class="w-4 h-4 mr-1 group-hover:scale-110 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        <span class="font-semibold text-xs">Dashboard</span>
                                        <div class="badge badge-warning badge-xs ml-1">Panel</div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

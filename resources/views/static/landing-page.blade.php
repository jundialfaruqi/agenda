<!DOCTYPE html>
<html data-theme="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Jadwal Sholat Pekanbaru - Aplikasi Resmi Pemerintah Kota Pekanbaru</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|poppins:400,500,600,700"
        rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="min-h-screen bg-base-100 font-['Poppins']">
    <!-- Navbar -->
    <div class="navbar bg-gradient-to-r from-primary to-primary-focus text-primary-content shadow-lg sticky top-0 z-50">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52 text-base-content">
                    <li><a class="font-medium">Beranda</a></li>
                    <li><a class="font-medium">Jadwal Sholat</a></li>
                    <li><a class="font-medium">Tentang Kami</a></li>
                </ul>
            </div>
            <a class="btn btn-ghost text-xl font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                JWSM TV
            </a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a class="font-medium">Beranda</a></li>
                <li><a class="font-medium">Jadwal Sholat</a></li>
                <li><a class="font-medium">Tentang Kami</a></li>
            </ul>
        </div>
        <div class="navbar-end">
            <a class="btn btn-accent text-white font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download App
            </a>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero min-h-[80vh] relative">
        <img src="https://www.pekanbaru.go.id/berkas_file/slider/slider-13-96843.jpg" alt="Masjid Pekanbaru"
            class="w-full h-full object-cover absolute" />
        <div class="hero-overlay bg-gradient-to-r from-primary/80 to-secondary/80 absolute inset-0"></div>
        <div class="hero-content text-center text-white relative z-10 px-4">
            <div class="max-w-2xl">
                <h1 class="mb-6 text-5xl md:text-6xl font-bold leading-tight">Jadwal Sholat Pekanbaru</h1>
                <p class="mb-8 text-lg md:text-xl">Aplikasi resmi jadwal sholat untuk wilayah Pekanbaru yang dikeluarkan
                    oleh Pemerintah Kota Pekanbaru. Dapatkan informasi waktu sholat yang akurat dan terpercaya.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button class="btn btn-accent btn-lg text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Lihat Jadwal Hari Ini
                    </button>
                    <button class="btn btn-outline btn-lg text-white border-white hover:bg-white hover:text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tentang Aplikasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Countdown to Next Prayer -->
    <div class="bg-base-100 pt-30">
        <div class="container mx-auto px-4">
            <div
                class="card bg-gradient-to-r from-primary/10 to-secondary/10 shadow-xl -mt-20 relative z-20 max-w-5xl mx-auto">
                <div class="card-body p-6 md:p-8">
                    <h2 class="card-title text-2xl md:text-3xl font-bold text-center w-full mb-4">Menuju Waktu Sholat
                        Berikutnya</h2>
                    <div class="grid grid-cols-4 gap-4 text-center">
                        <div class="bg-base-100 rounded-box p-4 shadow">
                            <span class="countdown font-mono text-3xl md:text-4xl">
                                <span style="--value:02;"></span>
                            </span>
                            <div class="text-xs md:text-sm mt-2">Jam</div>
                        </div>
                        <div class="bg-base-100 rounded-box p-4 shadow">
                            <span class="countdown font-mono text-3xl md:text-4xl">
                                <span style="--value:45;"></span>
                            </span>
                            <div class="text-xs md:text-sm mt-2">Menit</div>
                        </div>
                        <div class="bg-base-100 rounded-box p-4 shadow">
                            <span class="countdown font-mono text-3xl md:text-4xl">
                                <span style="--value:30;"></span>
                            </span>
                            <div class="text-xs md:text-sm mt-2">Detik</div>
                        </div>
                        <div class="bg-primary text-primary-content rounded-box p-4 shadow">
                            <div class="text-lg md:text-xl font-bold">Ashar</div>
                            <div class="text-2xl md:text-3xl font-mono">15:30</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Sholat Hari Ini -->
    <div class="py-12 bg-base-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Jadwal Sholat Hari Ini</h2>
                <p class="text-base-content/70 max-w-2xl mx-auto">Jadwal sholat untuk wilayah Pekanbaru dan sekitarnya.
                    Tanggal: {{ date('d F Y') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 max-w-5xl mx-auto">
                <div
                    class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="card-body items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 12H4M12 4v16" />
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Subuh</h2>
                        <p class="text-3xl font-bold text-primary">04:45</p>
                    </div>
                </div>

                <div
                    class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="card-body items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Dzuhur</h2>
                        <p class="text-3xl font-bold text-primary">12:15</p>
                    </div>
                </div>

                <div
                    class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="card-body items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-accent/20 flex items-center justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Ashar</h2>
                        <p class="text-3xl font-bold text-accent">15:30</p>
                        <div class="badge badge-accent text-white mt-2">Berikutnya</div>
                    </div>
                </div>

                <div
                    class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="card-body items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Maghrib</h2>
                        <p class="text-3xl font-bold text-primary">18:10</p>
                    </div>
                </div>

                <div
                    class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="card-body items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Isya</h2>
                        <p class="text-3xl font-bold text-primary">19:25</p>
                    </div>
                </div>
            </div>

            <div class="alert alert-info shadow-lg max-w-4xl mx-auto mt-8 bg-gradient-to-r from-info/80 to-info">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="stroke-current flex-shrink-0 w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <span class="font-bold">Informasi!</span>
                        <p>Jadwal sholat ini dihitung berdasarkan metode Islamic Society of North America (ISNA) dan
                            telah disesuaikan dengan koordinat geografis kota Pekanbaru.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fitur Aplikasi -->
    <div class="py-16 bg-base-200">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">Fitur Aplikasi</h2>
                <p class="text-base-content/70 max-w-2xl mx-auto">Nikmati berbagai fitur unggulan dalam aplikasi jadwal
                    sholat resmi Pemerintah Kota Pekanbaru</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="card-body">
                        <div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Jadwal Sholat Akurat</h2>
                        <p>Dapatkan jadwal sholat yang akurat berdasarkan lokasi geografis kota Pekanbaru dengan
                            penyesuaian musiman.</p>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="card-body">
                        <div class="w-16 h-16 rounded-full bg-secondary/20 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Pengingat Waktu Sholat</h2>
                        <p>Fitur notifikasi yang akan mengingatkan Anda ketika waktu sholat telah tiba dengan pilihan
                            adzan dari berbagai muadzin.</p>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="card-body">
                        <div class="w-16 h-16 rounded-full bg-accent/20 flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                        <h2 class="card-title text-xl">Arah Kiblat</h2>
                        <p>Penunjuk arah kiblat yang akurat menggunakan teknologi GPS dan kompas untuk membantu Anda
                            menemukan arah yang tepat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Download Section -->
    <div class="py-16 bg-gradient-to-r from-primary to-secondary text-primary-content">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between max-w-5xl mx-auto">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Download Aplikasi Sekarang</h2>
                    <p class="mb-6">Dapatkan kemudahan akses jadwal sholat Pekanbaru di genggaman Anda. Aplikasi
                        resmi dari Pemerintah Kota Pekanbaru yang dapat diunduh secara gratis.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button class="btn btn-accent text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 3v18m0 0l-5.5-5.5M9 21l5.5-5.5" />
                            </svg>
                            Google Play
                        </button>
                        <button class="btn btn-accent text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 3v18m0 0l-5.5-5.5M9 21l5.5-5.5" />
                            </svg>
                            App Store
                        </button>
                    </div>
                </div>
                <div class="md:w-1/2 flex justify-center">
                    <div class="mockup-phone">
                        <div class="camera"></div>
                        <div class="display">
                            <div class="artboard artboard-demo phone-1 bg-base-100">
                                <div class="flex flex-col h-full">
                                    <div class="bg-primary text-primary-content p-4">
                                        <h3 class="font-bold">Jadwal Sholat Pekanbaru</h3>
                                    </div>
                                    <div class="flex-1 p-4">
                                        <div class="text-center mb-4">
                                            <div class="text-lg font-bold">Ashar</div>
                                            <div class="text-3xl font-bold text-primary">15:30</div>
                                            <div class="text-sm text-base-content/70">2 jam 45 menit lagi</div>
                                        </div>
                                        <div class="divider">Jadwal Hari Ini</div>
                                        <div class="space-y-2">
                                            <div class="flex justify-between items-center">
                                                <span>Subuh</span>
                                                <span class="font-bold">04:45</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span>Dzuhur</span>
                                                <span class="font-bold">12:15</span>
                                            </div>
                                            <div class="flex justify-between items-center bg-accent/20 p-2 rounded">
                                                <span>Ashar</span>
                                                <span class="font-bold text-accent">15:30</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span>Maghrib</span>
                                                <span class="font-bold">18:10</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span>Isya</span>
                                                <span class="font-bold">19:25</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer footer-center p-4 bg-base-300 text-base-content">
        <div>
            <p>© 2023 Pemerintah Kota Pekanbaru - Hak Cipta Dilindungi</p>
        </div>
    </footer>
</body>

</html>

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? '' }} - Laravel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-base-200">

    <div class="drawer lg:drawer-open">
        <input id="drawer-toggle" type="checkbox" class="drawer-toggle" />

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Page content -->
        <div class="drawer-content flex flex-col">

            {{-- Toast Messages --}}
            @include('components.toast')

            <!-- Navbar -->
            @include('components.navbar')

            <!-- Main content -->
            <main class="flex-1 p-4 md:pt-0 md:ps-4 md:pe-4 md:pb-4 pb-20 lg:pb-4">
                <fieldset class="fieldset bg-base-100 border-base-300 rounded-box border pt-2 pb-4 ps-4 pe-4">
                    <legend class="fieldset-legend gap-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8.25V18a2.25 2.25 0 0 0 2.25 2.25h13.5A2.25 2.25 0 0 0 21 18V8.25m-18 0V6a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 6v2.25m-18 0h18M5.25 6h.008v.008H5.25V6ZM7.5 6h.008v.008H7.5V6Zm2.25 0h.008v.008H9.75V6Z" />
                        </svg>
                        <span class="text-lg font-semibold">{{ $title ?? '' }}</span>
                    </legend>

                    {{ $slot }}

                </fieldset>
            </main>
        </div>

        {{-- Dock --}}
        @include('components.dock')
    </div>

</body>

</html>

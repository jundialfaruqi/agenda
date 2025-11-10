<div class="grid gap-4 md:gap-6">

    {{-- Card --}}
    <div class="stats bg-base-100 flex flex-col md:flex-row border border-base-300 rounded-xl">
        <div class="stat">
            <div class="stat-figure text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="inline-block w-6 h-6 md:w-8 md:h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                    </path>
                </svg>
            </div>
            <div class="stat-title">Total Videos</div>
            <div class="stat-value text-primary text-2xl md:text-3xl">256</div>
            <div class="stat-desc">21% more than last month</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="inline-block w-6 h-6 md:w-8 md:h-8 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div class="stat-title">Page Views</div>
            <div class="stat-value text-secondary text-2xl md:text-3xl">2.6M</div>
            <div class="stat-desc">14% more than last month</div>
        </div>

        <div class="stat">
            <div class="stat-figure text-secondary">
                <div class="avatar">
                    <div class="w-10 h-10 md:w-16 md:h-16 rounded-full">
                        <div
                            class="w-10 h-10 md:w-16 md:h-16 rounded-full bg-accent text-accent-content grid place-items-center">
                            <span class="text-lg md:text-xl">U</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="stat-title">New Users</div>
            <div class="stat-value text-2xl md:text-3xl">4,200</div>
            <div class="stat-desc">↗︎ 8% increase</div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card bg-base-100 border border-base-300 rounded-xl">
        <div class="card-body">
            <div class="card-title">
                <div class="flex items-center gap-1 text-sm font-bold">
                    <svg class="size-4" fill="currentColor" width="12" height="12" viewBox="0 0 256 256"
                        id="Flat" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M216,148H172V108h44a12,12,0,0,0,0-24H172V40a12,12,0,0,0-24,0V84H108V40a12,12,0,0,0-24,0V84H40a12,12,0,0,0,0,24H84v40H40a12,12,0,0,0,0,24H84v44a12,12,0,0,0,24,0V172h40v44a12,12,0,0,0,24,0V172h44a12,12,0,0,0,0-24Zm-108,0V108h40v40Z">
                        </path>
                    </svg>
                    <h4 class="text-lg font-semibold">Recent Activity</h4>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="table table-zebra table-compact text-sm md:text-base">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="hidden sm:table-cell">Type</th>
                            <th class="hidden md:table-cell">Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Video Pengajian Minggu</td>
                            <td class="hidden sm:table-cell">Video</td>
                            <td class="hidden md:table-cell">2023-10-15</td>
                            <td>
                                <div class="badge badge-success badge-sm md:badge-md">Published
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Ceramah Ustadz Ahmad</td>
                            <td class="hidden sm:table-cell">Video</td>
                            <td class="hidden md:table-cell">2023-10-14</td>
                            <td>
                                <div class="badge badge-success badge-sm md:badge-md">Published
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Kajian Tafsir Al-Quran</td>
                            <td class="hidden sm:table-cell">Video</td>
                            <td class="hidden md:table-cell">2023-10-12</td>
                            <td>
                                <div class="badge badge-warning badge-sm md:badge-md">Draft</div>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanya Jawab Seputar Ibadah</td>
                            <td class="hidden sm:table-cell">Video</td>
                            <td class="hidden md:table-cell">2023-10-10</td>
                            <td>
                                <div class="badge badge-error badge-sm md:badge-md">Unpublished
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

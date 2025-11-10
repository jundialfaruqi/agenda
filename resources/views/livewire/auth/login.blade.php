<div class="card w-full max-w-sm bg-base-100 shadow-xl">
    <div class="card-body">
        <div class="flex flex-col justify-center mx-auto items-center gap-3 pb-4">
            <div>
                <img src="{{ asset('/logo.png') }}" alt="Logo" width="50">
            </div>
            <!---->
            <h1 class="text-3xl font-bold text-[#4B5563] my-auto">Laravel</h1>

        </div>
        <div class="text-sm font-light text-[#6B7280] pb-4 mx-auto">“Sabar itu indah, hasilnya berkah.”</div>

        <form wire:submit.prevent="login">
            @csrf
            <div class="form-control w-full px-4">
                <label class="label mb-2">
                    <span class="label-text flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Email
                    </span>
                </label>
                <input wire:model.defer="email" type="email" id="email" placeholder="email@example.com"
                    class="input input-bordered w-full bg-gray-50 text-gray-600 border focus:border-transparent border-gray-300 sm:text-sm rounded-lg ring-3 ring-transparent focus:ring-1 focus:outline-hidden focus:ring-gray-400" />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-control w-full mt-4 px-4">
                <label class="label mb-2">
                    <span class="label-text flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Password
                    </span>
                </label>
                <div class="join w-full">
                    <input wire:model.defer="password" type="password" id="password" placeholder="••••••••••"
                        class="input input-bordered w-full join-item bg-gray-50 text-gray-600 border focus:border-transparent border-gray-300 sm:text-sm rounded-s-lg ring-3 ring-transparent focus:ring-1 focus:outline-hidden focus:ring-gray-400" />
                    <button type="button" class="btn btn-primary shadow-none btn-square join-item swap swap-rotate"
                        data-toggle="password" data-target="password" aria-label="Tampilkan/sembunyikan password">
                        <svg class="size-4 swap-on" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            <circle cx="12" cy="12" r="3" stroke-width="2" />
                        </svg>
                        <svg class="size-4 swap-off" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.18 6.18A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.976 9.976 0 01-4.6 5.383M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-control w-full mt-4 px-4 flex items-center">
                <input wire:model="remember" type="checkbox" id="remember"
                    class="checkbox checkbox-sm checkbox-primary mr-2">
                <label for="remember" class="text-sm font-light text-[#6B7280]">Ingat saya</label>
            </div>

            <div class="form-control mt-5 px-4">
                <button type="submit" class="btn btn-primary w-full" wire:loading.attr="disabled">Login
                    <span wire:loading class="loading loading-spinner loading-sm"></span>
                </button>
            </div>

            <div class="text-center mt-6 font-light text-[#6B7280]">
                <p>Belum punya akun? <a href="#" class="link link-primary font-bold">Daftar</a></p>
            </div>
        </form>
    </div>
</div>

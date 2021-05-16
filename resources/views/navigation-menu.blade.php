<div class="bg-gray-800 shadow-xl h-16 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-52">

    <div class="md:mt-16 md:w-52 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
        <ul class="list-reset flex flex-row md:flex-col py-0 md:py-3 px-1 md:px-2 text-center md:text-left">

            <li class="flex-1">
                <a href="{{ route('admin.home') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{request()->routeIs('admin.home') ? 'border-blue-600' : 'border-gray-800'}}">
                    <i class="fas fa-users pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base {{request()->routeIs('admin.home') ? 'text-white' : 'text-gray-400'}} block md:inline-block">Dashboard</span>
                </a>
            </li>

            @if(auth()->user()->hasRole(['admin','Admin']))
            <li class="flex-1">
                <div @click.away="open_new_user = false" class="relative" x-data="{ open_new_user: false }">
                    <a href="#" @click="open_new_user = !open_new_user" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{request()->routeIs('peserta-baru.*') ? 'border-blue-600' : 'border-gray-800'}}">
                        <i class="fas fa-cogs pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base {{request()->routeIs('peserta-baru.*') ? 'text-white' : 'text-gray-400'}} block md:inline-block">Peserta Baru</span>
                        <div class="hidden md:inline-block">
                            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open_new_user, 'rotate-0': !open_new_user}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </a>
                    <div x-show="open_new_user" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 md:top-12 bottom-14 w-full mt-2 origin-top-right rounded-md shadow-lg z-10">
                        <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                            <a class="block px-2 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('peserta-baru.index') }}">Penerima Upah & Bukan Penerima Upah</a>
                            <a class="block px-2 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('peserta-baru.index') }}?user=jasa-konstruksi">Jasa Konstruksi</a>
                        </div>
                    </div>
                </div>
            </li>

            <li class="flex-1">
                <div @click.away="open_new_user = false" class="relative" x-data="{ open_new_user: false }">
                    <a href="#" @click="open_new_user = !open_new_user" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{request()->routeIs('iuran.*') ? 'border-blue-600' : 'border-gray-800'}}">
                        <i class="fas fa-cogs pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base {{request()->routeIs('iuran.*') ? 'text-white' : 'text-gray-400'}} block md:inline-block">Data Iuran</span>
                        <div class="hidden md:inline-block">
                            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open_new_user, 'rotate-0': !open_new_user}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </a>
                    <div x-show="open_new_user" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 md:top-12 bottom-14 w-full mt-2 origin-top-right rounded-md shadow-lg z-10">
                        <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                            <a class="block px-2 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('iuran.index') }}">Penerima Upah & Bukan Penerima Upah</a>
                            <a class="block px-2 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('iuran.index') }}?user=jasa-konstruksi">Jasa Konstruksi</a>
                        </div>
                    </div>
                </div>
            </li>

            <li class="flex-1">
                <div @click.away="open_new_user = false" class="relative" x-data="{ open_new_user: false }">
                    <a href="#" @click="open_new_user = !open_new_user" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{request()->routeIs('klaim.*') ? 'border-blue-600' : 'border-gray-800'}}">
                        <i class="fas fa-cogs pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base {{request()->routeIs('klaim.*') ? 'text-white' : 'text-gray-400'}} block md:inline-block">Verifikasi Klaim</span>
                        <div class="hidden md:inline-block">
                            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open_new_user, 'rotate-0': !open_new_user}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </a>
                    <div x-show="open_new_user" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 md:top-12 bottom-14 w-full mt-2 origin-top-right rounded-md shadow-lg z-10">
                        <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                            <a class="block px-2 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('klaim.index') }}">Penerima Upah & Bukan Penerima Upah</a>
                            <a class="block px-2 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('klaim.index') }}?user=jasa-konstruksi">Jasa Konstruksi</a>
                        </div>
                    </div>
                </div>
            </li>

            <li class="flex-1">
                <div @click.away="open_new_user = false" class="relative" x-data="{ open_new_user: false }">
                    <a href="#" @click="open_new_user = !open_new_user" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{request()->routeIs('pemadanan.*') ? 'border-blue-600' : 'border-gray-800'}}">
                        <i class="fas fa-cogs pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base {{request()->routeIs('pemadanan.*') ? 'text-white' : 'text-gray-400'}} block md:inline-block">Pemadanan</span>
                        <div class="hidden md:inline-block">
                            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open_new_user, 'rotate-0': !open_new_user}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </a>
                    <div x-show="open_new_user" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 md:top-12 bottom-14 w-full mt-2 origin-top-right rounded-md shadow-lg">
                        <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                            <a class="block px-2 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('pemadanan.index') }}">Penerima Upah & Bukan Penerima Upah</a>
                            <a class="block px-2 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('pemadanan.index') }}?user=jasa-konstruksi">Jasa Konstruksi</a>
                        </div>
                    </div>
                </div>
            </li>

            <li class="flex-1">
                <a href="{{ route('rekap.index') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{request()->routeIs('rekap.*') ? 'border-blue-600' : 'border-gray-800'}}">
                    <i class="fas fa-users pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base {{request()->routeIs('rekap.*') ? 'text-white' : 'text-gray-400'}} block md:inline-block">Rekap Surat</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasRole(['user','User']))
            <li class="flex-1">
                <a href="{{ route('user.claim.form') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{request()->routeIs('user.claim.form') ? 'border-blue-600' : 'border-gray-800'}}">
                    <i class="fas fa-users pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base {{request()->routeIs('user.claim.form') ? 'text-white' : 'text-gray-400'}} block md:inline-block">Pengajuan Klaim</span>
                </a>
            </li>
            <li class="flex-1">
                <a href="{{ route('user.due.card') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{request()->routeIs('user.due.card') ? 'border-blue-600' : 'border-gray-800'}}">
                    <i class="fas fa-users pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base {{request()->routeIs('user.due.card') ? 'text-white' : 'text-gray-400'}} block md:inline-block">Pembayaran Iuran</span>
                </a>
            </li>
            <li class="flex-1">
                <a href="{{ route('user.balance.check') }}" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{request()->routeIs('user.balance.check') ? 'border-blue-600' : 'border-gray-800'}}">
                    <i class="fas fa-users pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base {{request()->routeIs('user.balance.check') ? 'text-white' : 'text-gray-400'}} block md:inline-block">Cek Saldo</span>
                </a>
            </li>

            <li class="flex-1">
                <div @click.away="open_new_user = false" class="relative" x-data="{ open_new_user: false }">
                    <a href="#" @click="open_new_user = !open_new_user" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 {{request()->routeIs('user.profile.*') ? 'border-blue-600' : 'border-gray-800'}}">
                        <i class="fas fa-cogs pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base {{request()->routeIs('user.profile.*') ? 'text-white' : 'text-gray-400'}} block md:inline-block">Ubah Data</span>
                        <div class="hidden md:inline-block">
                            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open_new_user, 'rotate-0': !open_new_user}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </a>
                    <div x-show="open_new_user" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 md:top-12 bottom-14 w-full mt-2 origin-top-right rounded-md shadow-lg">
                        <div class="px-2 py-2 bg-white rounded-md shadow dark-mode:bg-gray-800">
                            <a class="block px-2 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('user.profile.index') }}">Profile</a>
                            <a class="block px-2 py-2 mt-2 text-sm font-semibold bg-transparent rounded-lg dark-mode:bg-transparent dark-mode:hover:bg-gray-600 dark-mode:focus:bg-gray-600 dark-mode:focus:text-white dark-mode:hover:text-white dark-mode:text-gray-200 md:mt-0 hover:text-gray-900 focus:text-gray-900 focus:bg-gray-200 focus:outline-none focus:shadow-outline" href="{{ route('user.profile.password') }}">Password</a>
                        </div>
                    </div>
                </div>
            </li>
            @endif

        </ul>
    </div>


</div>
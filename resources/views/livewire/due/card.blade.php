@prepend('styles')
<style>
    /* CHECKBOX TOGGLE SWITCH */
    /* @apply rules for documentation, these do not work as inline style */
    .toggle-checkbox:checked {
        @apply: right-0 border-green-400;
        right: 0;
        border-color: #68D391;
    }

    .toggle-checkbox:checked+.toggle-label {
        @apply: bg-green-400;
        background-color: #68D391;
    }
</style>
@endprepend
<div>
    <div>
        <label for="toggle" class="text-sm font-bold">Notifikasi</label>
        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
            <input wire:click="update_notification" wire:model="notification" type="checkbox" name="toggle" id="toggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
            <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
        </div>
    </div>

    @if($notification && $invoice_notification)
    <div class="text-center">
        <div class="p-2 bg-indigo-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" role="alert">
            <span class="font-semibold mr-2 text-left flex-auto">Anda memiliki tagihan yang perlu dibayar</span>
            <svg class="fill-current opacity-75 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M12.95 10.707l.707-.707L8 4.343 6.586 5.757 10.828 10l-4.242 4.243L8 15.657l4.95-4.95z" />
            </svg>
            <button wire:click="pay" class="flex rounded-full bg-indigo-500 uppercase px-2 py-1 text-xs font-bold mr-3">Bayar Sekarang</button>
        </div>
    </div>
    @endif

    <!-- component -->
    <div class="flex items-center justify-center">
        <!-- 1 card -->
        <div style="background-color:#6aa84f" class="relative pt-6 pb-3 px-6 rounded-3xl w-2/5 my-4 shadow-xl">

            <p class="text-3xl font-bold">{{ $nama }}</p>
            <p class="text-xl font-bold mb-2">{{ $nomor }}</p>
            <div class="mt-2">
                <div class="flex justify-between space-x-4 text-gray-800 text-md font-bold">
                    <div class="my-2">
                        <div class="flex my-2">
                            <!-- svg  -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                            </svg>
                            <p>Tagihan</p>
                        </div>
                        <div class="flex my-2">
                            <!-- svg  -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            <p>Denda</p>
                        </div>
                    </div>
                    <div class="my-2">
                        <div class="flex my-2">
                            <p>Rp.{{ number_format($tagihan,2,',','.') }}</p>
                        </div>
                        <div class="flex my-2">
                            <p>Rp.{{ number_format($denda,2,',','.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t-2"></div>

            <div class="flex justify-between">
                <div class="my-2">
                    <p class="font-semibold text-base mb-2">Total Tagihan</p>
                    <p class="font-semibold text-base mb-2">Total Denda</p>
                </div>
                <div class="my-2">
                    <p class="font-semibold text-base mb-2">Rp.{{ number_format($tagihan,2,',','.') }}</p>
                    <p class="font-semibold text-base mb-2">Rp.{{ number_format($denda,2,',','.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
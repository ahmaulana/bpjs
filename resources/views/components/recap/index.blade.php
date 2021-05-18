@prepend('pagetitle')
Rekap Data
@endprepend
<x-app-layout>
    <div style="background-color: #009e0f;" class="pt-3">
        <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
            <h3 class="font-bold pl-2">Rekap Surat Pernyataan</h3>
        </div>
    </div>

    <div class="flex">
        <div class="p-4 w-24 min-w-full">
            <div class="text-right my-4">
                <div class="inline-flex">
                    <a href="{{ route('rekap.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <!-- Heroicon name: solid/check -->
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Buat Surat
                    </a>
                </div>
            </div>
            <livewire:recap.index />
        </div>
    </div>

</x-app-layout>
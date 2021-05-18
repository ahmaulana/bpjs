@prepend('pagetitle')
Buat Rekap
@endprepend
<x-app-layout>
    <div style="background-color: #009e0f;" class="pt-3">
        <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
            <h3 class="font-bold pl-2">Buat Rekap</h3>
        </div>
    </div>

    <div class="flex">
        <div class="p-4 w-24 min-w-full">
            <livewire:recap.create />
        </div>
    </div>

</x-app-layout>
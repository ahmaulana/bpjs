<x-app-layout>
    <div class="bg-gray-800 pt-3">
        <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
            <h3 class="font-bold pl-2">Data Pembayaran Iuran</h3>
        </div>
    </div>

    <div class="flex">
        <div class="p-4 w-24 min-w-full">
            <livewire:due.index />
        </div>
    </div>

</x-app-layout>
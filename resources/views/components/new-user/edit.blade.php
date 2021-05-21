@prepend('pagetitle')
Verifikasi Peserta
@endprepend
<x-app-layout>
    <div style="background-color: #009e0f;" class="pt-3">
        <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white flex">
            <a href="{{ $data->jenis_kepesertaan != 'jk' ? route('peserta-baru.index') : route('peserta-baru.index') . '?user=jasa-konstruksi' }}" class="my-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h3 class="font-bold pl-2 inline-block">Verifikasi Data</h3>
        </div>
    </div>

    <div class="flex">
        <div class="p-4 w-24 min-w-full">
            <livewire:new-user.edit :data="$data">
        </div>
    </div>

</x-app-layout>
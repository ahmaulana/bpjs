@prepend('pagetitle')
Dashboard
@endprepend
<x-app-layout>
    <div style="background-color: #009e0f;" class="pt-3">
        <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
            <h3 class="font-bold pl-2">Dashboard</h3>
        </div>
    </div>
    <div class="flex">
        <div class="p-4 w-24 min-w-full">
            <div>
                @if($user->jenis_kepesertaan != 'jk')
                <!-- component -->
                <div class="flex items-center justify-center">
                    <!-- 1 card -->
                    <div style="background-color:#6aa84f" class="relative pt-6 pb-3 px-6 rounded-3xl w-2/5 my-4 shadow-xl">

                        <h1 class="text-3xl text-center font-bold mb-4">Kartu Peserta</h1>
                        <p class="text-2xl font-bold">{{ $user->name }}</p>
                        <p class="text-xl font-bold mb-2">{{ $data->no_kpj }}</p>
                        <div class="mt-2">
                            <div class="flex justify-between space-x-4 text-xl font-bold mt-6">
                                <div class="my-2">
                                    <div class="flex my-2">
                                        <p>{{ \Carbon\Carbon::parse($user->created_at)->format('m-Y') }}</p>
                                    </div>
                                </div>
                                <div class="my-2">
                                    <div class="flex my-2">
                                        <p>BPJS</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <!-- component -->
                <div class="flex items-center justify-center">
                    <!-- 1 card -->
                    <div style="background-color:#6aa84f" class="relative pt-6 pb-3 px-6 rounded-3xl w-3/6 my-4 shadow-xl">

                        <h1 class="text-3xl text-center font-bold mb-4">Sertifikat Kepesertaan</h1>
                        <div class="mt-2 text-lg">
                            <table class="table-fixed">
                                <tbody>
                                    <tr>
                                        <td>Nama Badan Usaha/Asosiasi</td>
                                        <td class="pl-2 font-bold">{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Pendaftaran Peserta</td>
                                        <td class="pl-2 font-bold">{{ $data->npp_pelaksana }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td class="pl-2 font-bold">J{{ $data->alamat_proyek }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <div class="flex justify-between space-x-4 font-bold text-xl mt-6">
                                <div class="my-2">
                                    <div class="flex my-2"></div>
                                </div>
                                <div class="my-2">
                                    <div class="flex my-2">
                                        <p>BPJS KETENAGAKERJAAN</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
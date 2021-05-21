<div class="px-10">
    @if($jenis_kepesertaan != 'jk')
    <form wire:submit.prevent="update" x-data="
            { 
              'errors': {{ json_encode(array_keys($errors->getMessages())) }},
              focusField(input){
                  fieldError = Array.from(document.getElementsByName(input));
                  if(fieldError.length > 0){
                    fieldError[0].focus({preventScroll:false});
                  }
              },
            }
            " x-init="() => { $watch('errors', value => focusField(value[0])) }">
        @csrf

        <div class="mt-4">

            <div class="mt-4">
                <x-jet-label for="nik" value="{{ __('NIK') }}" />
                <x-jet-input wire:model="nik" id="nik" class="block mt-1 w-full" type="number" name="nik" />
                @error('nik') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="name" value="{{ __('Nama') }}" />
                <x-jet-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" />
            </div>

            <div>
                <div class="mt-4 flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/3 px-3 mt-4 md:mb-0">
                        <x-jet-label for="tempat_lahir" value="{{ __('Tempat Lahir') }}" />
                        <x-jet-input wire:model="tempat_lahir" id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir')" />
                    </div>
                    <div class="w-full md:w-2/3 mt-4 px-3">
                        <x-jet-label for="tgl_lahir" value="{{ __('Tanggal Lahir') }}" />
                        <x-jet-input wire:model="tgl_lahir" id="tgl_lahir" class="block mt-1 w-full" type="date" name="tgl_lahir" :value="old('tgl_lahir')" />
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="jenis_kelamin" value="{{ __('Jenis Kelamin') }}" />
                <select wire:model="jenis_kelamin" name="jenis_kelamin" id="jenis_kelamin" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih jenis kelamin...</option>
                    <option value="l">Laki-Laki</option>
                    <option value="p">Perempuan</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="no_hp" value="{{ __('Nomor Hp') }}" />
                <x-jet-input wire:model="no_hp" id="no_hp" class="block mt-1 w-full" type="number" name="no_hp" />
                @error('no_hp') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="lokasi_bekerja" value="{{ __('Lokasi Bekerja') }}" />
                <textarea wire:model="lokasi_bekerja" name="lokasi_bekerja" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="" cols="30" rows="3">{{ old('lokasi_bekerja') }}</textarea>
            </div>

            <div class="mt-4">
                <x-jet-label for="pekerjaan" value="{{ __('Pekerjaan') }}" />
                <x-jet-input wire:model="pekerjaan" id="pekerjaan" class="block mt-1 w-full" type="text" name="pekerjaan" :value="old('pekerjaan')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="jam_kerja" value="{{ __('Jam Kerja') }}" />
                <select wire:model="jam_kerja" name="jam_kerja" id="jam_kerja" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih jam kerja...</option>
                    <option value="07.00 - 15.00">07.00 - 15.00</option>
                    <option value="08.00 - 16.00">08.00 - 16.00</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="penghasilan" value="{{ __('Penghasilan Per Bulan') }}" />
                <div class="flex rounded-md shadow-sm">
                    <span class="h-11 mt-1 inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        Rp
                    </span>
                    <x-jet-input wire:model="penghasilan" id="penghasilan" class="mt-1 flex-1 block w-full rounded-none sm:text-sm" type="number" name="penghasilan" :value="old('penghasilan')" />
                </div>
            </div>

            @if($jenis_kepesertaan == 'pu')
            <div class="mt-4">
                <x-jet-label for="program_pu" value="{{ __('Program') }}" />
                <select wire:model="program" name="program_pu" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih program...</option>
                    <option value="jkk jkm jht">Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM), Jaminan Hari Tua (JHT)</option>
                    <option value="jkk jkm jp">Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM), Jaminan Pensiun (JP)</option>
                    <option value="jkk jht">Jaminan Kecelakaan Kerja (JKK), Jaminan Hari Tua (JHT)</option>
                    <option value="jkk jkm">Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM)</option>
                </select>
            </div>
            @else
            <div class="mt-4" x-show="jenis_kepesertaan == 2">
                <x-jet-label for="program_bpu" value="{{ __('Program') }}" />
                <select wire:model="program" name="program_bpu" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih program...</option>
                    <option value="jkk jkm">Jaminan Kecelakaan Kerja (JKK) dan Jaminan Kematian (JKM)</option>
                    <option value="jkk jht">Jaminan Kecelakaan Kerja (JKK) dan Jaminan Hari Tua (JHT)</option>
                    <option value="jkk jkm jht">Jaminan Kecelakaan Kerja (JKK), Jaminan Kematian (JKM), Jaminan Hari Tua (JHT)</option>
                </select>
            </div>
            @endif

            <div class="mt-4">
                <x-jet-label for="periode_pembayaran" value="{{ __('Periode Pembayaran') }}" />
                <select wire:model="periode_pembayaran" name="periode_pembayaran" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih periode...</option>
                    <option value="1">1 Bulan</option>
                    <option value="2">2 Bulan</option>
                    <option value="3">3 Bulan</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Berkas-Berkas') }}" />
                <ul class="border bg-white rounded-md divide-y divide-gray-200">
                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <!-- Heroicon name: solid/paper-clip -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-2 flex-1 w-0 truncate">
                                Foto Diri
                            </span>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a wire:click="download('{{ $berkas_foto }}','Foto ' . $user_id)" class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer">
                                Download
                            </a>
                        </div>
                    </li>
                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <!-- Heroicon name: solid/paper-clip -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-2 flex-1 w-0 truncate">
                                KTP
                            </span>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a wire:click="download('{{ $berkas_ktp }}','KTP ' . $user_id)" class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer">
                                Download
                            </a>
                        </div>
                    </li>
                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <!-- Heroicon name: solid/paper-clip -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-2 flex-1 w-0 truncate">
                                Kartu Keluarga
                            </span>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a wire:click="download('{{ $berkas_kk }}','Kartu Keluarga ' . $user_id)" class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer">
                                Download
                            </a>
                        </div>
                    </li>
                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <!-- Heroicon name: solid/paper-clip -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-2 flex-1 w-0 truncate">
                                Buku Tabungan
                            </span>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a wire:click="download('{{ $berkas_buku_tabungan }}','Buku Tabungan ' . $user_id)" class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer">
                                Download
                            </a>
                        </div>
                    </li>
                </ul>

            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button class="ml-4">
                {{ __('ACC') }}
            </x-jet-button>
        </div>
    </form>
    @else
    <form wire:submit.prevent="update" x-data="
            { 
              'errors': {{ json_encode(array_keys($errors->getMessages())) }},
              focusField(input){
                  fieldError = Array.from(document.getElementsByName(input));
                  if(fieldError.length > 0){
                    fieldError[0].focus({preventScroll:false});
                  }
              },
            }
            " x-init="() => { $watch('errors', value => focusField(value[0])) }">
        @csrf

        <div class="mt-4">

            <div class="mt-4">
                <x-jet-label for="npp" value="{{ __('NPP') }}" />
                <x-jet-input wire:model="npp" id="npp" class="block mt-1 w-full" type="number" name="npp" :value="old('npp')" />
                @error('npp') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <div class="mt-4">
                    <x-jet-label for="name" value="{{ __('Nama Pengguna') }}" />
                    <x-jet-input wire:model="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" />
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="jenis_kelamin" value="{{ __('Jenis Kelamin') }}" />
                <select wire:model="jenis_kelamin" name="jenis_kelamin" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih jenis kelamin...</option>
                    <option value="l">Laki-Laki</option>
                    <option value="p">Perempuan</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="no_hp" value="{{ __('Nomor Hp') }}" />
                <x-jet-input wire:model="no_hp" id="no_hp" class="block mt-1 w-full" type="number" name="no_hp" :value="old('no_hp')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="program" value="{{ __('Program') }}" />
                <select wire:model="program" name="program" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih program...</option>
                    <option value="jkk jkm">Jaminan Kecelakaan Kerja (JKK) dan Jaminan Kematian (JKM)</option>
                    <option value="jkm">Jaminan Kematian (JKM)</option>
                    <option value="jkk">Jaminan Kecelakaan Kerja (JKK)</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="nama_proyek" value="{{ __('Nama Proyek') }}" />
                <x-jet-input wire:model="nama_proyek" id="nama_proyek" class="block mt-1 w-full" type="text" name="nama_proyek" :value="old('nama_proyek')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="alamat_proyek" value="{{ __('Alamat Proyek') }}" />
                <textarea wire:model="alamat_proyek" name="alamat_proyek" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="" cols="30" rows="3">{{ old('alamat_proyek') }}</textarea>
            </div>

            <div class="mt-4">
                <x-jet-label for="nilai_proyek" value="{{ __('Nilai Proyek') }}" />
                <div class="flex rounded-md shadow-sm">
                    <span class="h-11 mt-1 inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        Rp
                    </span>
                    <x-jet-input wire:model="nilai_proyek" id="nilai_proyek" class="mt-1 flex-1 block w-full rounded-none sm:text-sm" type="number" name="nilai_proyek" :value="old('nilai_proyek')" />
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="sumber_pembiayaan" value="{{ __('Sumber Pembiayaan') }}" />
                <select wire:model="sumber_pembiayaan" id="sumber_pembiayaan" name="sumber_pembiayaan" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih sumber pembiayaan...</option>
                    <option value="swasta">Swasta</option>
                    <option value="pemerintah pusat">Pemerintah Pusat</option>
                    <option value="pemerintah daerah">Pemerintah Daerah</option>
                    <option value="badan usaha">Badan Usaha</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="jenis_pemilik" value="{{ __('Jenis Pemilik') }}" />
                <select wire:model="jenis_pemilik" name="jenis_pemilik" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih pemilik...</option>
                    <option value="instansi">Instansi</option>
                    <option value="perusahaan">Perusahaan</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="nama_pemilik" value="{{ __('Nama Pemilik') }}" />
                <x-jet-input wire:model="nama_pemilik" id="nama_pemilik" class="block mt-1 w-full" type="text" name="nama_pemilik" :value="old('nama_pemilik')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="npp_pelaksana" value="{{ __('NPP Pelaksana') }}" />
                <x-jet-input wire:model="npp_pelaksana" id="npp_pelaksana" class="block mt-1 w-full" type="number" name="npp_pelaksana" :value="old('npp_pelaksana')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="no_spk" value="{{ __('No SPK') }}" />
                <x-jet-input wire:model="no_spk" id="no_spk" class="block mt-1 w-full" type="number" name="no_spk" :value="old('no_spk')" />
            </div>

            <div class="mt-4">
                <x-jet-label value="{{ __('Berkas-Berkas') }}" />
                <ul class="border bg-white rounded-md divide-y divide-gray-200">
                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <!-- Heroicon name: solid/paper-clip -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-2 flex-1 w-0 truncate">
                                Berkas SPK
                            </span>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a wire:click="download('{{ $berkas_spk }}','SPK ' . $user_id)" class="font-medium text-indigo-600 hover:text-indigo-500 cursor-pointer">
                                Download
                            </a>
                        </div>
                    </li>
                </ul>

            </div>

            <div class="mt-4">
                <x-jet-label for="masa_kontrak" value="{{ __('Masa Kontrak') }}" />
                <div class="flex rounded-md shadow-sm">
                    <x-jet-input wire:model="masa_kontrak" id="masa_kontrak" class="mt-1 flex-1 block w-full rounded-none sm:text-sm" type="number" name="masa_kontrak" :value="old('masa_kontrak')" />
                    <span class="h-11 mt-1 inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        Tahun
                    </span>
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="total_pekerja" value="{{ __('Total Pekerja') }}" />
                <x-jet-input wire:model="total_pekerja" id="total_pekerja" class="block mt-1 w-full" type="number" name="total_pekerja" :value="old('total_pekerja')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="cara_pembayaran" value="{{ __('Cara Pembayaran') }}" />
                <select wire:model="cara_pembayaran" name="cara_pembayaran" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih pembayaran...</option>
                    <option value="sekaligus">Sekaligus</option>
                    <option value="termin">Termin</option>
                </select>
            </div>

        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button class="ml-4">
                {{ __('ACC') }}
            </x-jet-button>
        </div>
    </form>
    @endif
</div>
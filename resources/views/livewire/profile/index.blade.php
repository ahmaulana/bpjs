<div class="px-10">
    @if(auth()->user()->jenis_kepesertaan != 'jk')
    <form wire:submit.prevent="update_wage" x-data="
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
                    <option value="07.00 - 15.00">07.00 - 15.00</option>
                    <option value="08.00 - 16.00">08.00 - 16.00</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" />
                @error('email') <span class="error text-red-500">{{ $message }}</span> @enderror
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

            <div class="mt-4">
                <x-jet-label for="periode_pembayaran" value="{{ __('Periode Pembayaran') }}" />
                <select wire:model="periode_pembayaran" name="periode_pembayaran" id="periode_pembayaran" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="1">1 bulan</option>
                    <option value="2">2 bulan</option>
                    <option value="3">3 bulan</option>
                </select>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button class="ml-4">
                {{ __('Update') }}
            </x-jet-button>
        </div>
    </form>
    @else
    <form wire:submit.prevent="update_construction" x-data="
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

            <div>
                <div class="mt-4">
                    <x-jet-label for="name" value="{{ __('Nama Pengguna') }}" />
                    <x-jet-input wire:model="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" />
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="no_hp" value="{{ __('Nomor Hp') }}" />
                <x-jet-input wire:model="no_hp" id="no_hp" class="block mt-1 w-full" type="number" name="no_hp" :value="old('no_hp')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" />
                @error('email') <span class="error text-red-500">{{ $message }}</span> @enderror
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
                <x-jet-label for="jenis_pemilik" value="{{ __('Jenis Pemilik') }}" />
                <select wire:model="jenis_pemilik" name="jenis_pemilik" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="instansi">Instansi</option>
                    <option value="perusahaan">Perusahaan</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="nama_pemilik" value="{{ __('Nama Pemilik') }}" />
                <x-jet-input wire:model="nama_pemilik" id="nama_pemilik" class="block mt-1 w-full" type="text" name="nama_pemilik" :value="old('nama_pemilik')" />
            </div>

            <div class="mt-4">
                <x-jet-label for="total_pekerja" value="{{ __('Total Pekerja') }}" />
                <x-jet-input wire:model="total_pekerja" id="total_pekerja" class="block mt-1 w-full" type="number" name="total_pekerja" :value="old('total_pekerja')" />
            </div>            

        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button class="ml-4">
                {{ __('Update') }}
            </x-jet-button>
        </div>
    </form>
    @endif
</div>
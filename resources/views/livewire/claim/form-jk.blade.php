<div class="px-10">
    <form wire:submit.prevent="save" x-data="
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
                <x-jet-input wire:model="npp" id="npp" class="block mt-1 w-full" type="number" name="npp" readonly />
                @error('npp') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="nama" value="{{ __('Nama Pengguna') }}" />
                <x-jet-input wire:model="nama" id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" />
                @error('nama') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="nama_proyek" value="{{ __('Nama Proyek') }}" />
                <x-jet-input wire:model="nama_proyek" id="nama_proyek" class="block mt-1 w-full" type="text" name="nama_proyek" :value="old('nama_proyek')" />
                @error('nama_proyek') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="alamat_proyek" value="{{ __('Alamat Proyek') }}" />
                <textarea wire:model="alamat_proyek" name="alamat_proyek" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="" cols="30" rows="3">{{ old('alamat_proyek') }}</textarea>
                @error('alamat_proyek') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="jenis_pemilik" value="{{ __('Jenis Pemilik') }}" />
                <select wire:model="jenis_pemilik" name="jenis_pemilik" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih jenis pemilik...</option>
                    <option value="perusahaan">Perusahaan</option>
                    <option value="instansi">Instansi</option>
                </select>
                @error('jenis_pemilik') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="nama_pemilik" value="{{ __('Nama Pemilik') }}" />
                <x-jet-input wire:model="nama_pemilik" id="nama_pemilik" class="block mt-1 w-full" type="text" name="nama_pemilik" />
                @error('nama_pemilik') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="program" value="{{ __('Program') }}" />
                <select wire:model="program" name="program" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih program...</option>
                    <option value="jkk jkm">Jaminan Kecelakaan Kerja (JKK) dan Jaminan Kematian (JKM)</option>
                    <option value="jkm">Jaminan Kematian (JKM)</option>
                    <option value="jkk">Jaminan Kecelakaan Kerja (JKK)</option>
                </select>
                @error('program') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="no_hp" value="{{ __('Nomor Hp') }}" />
                <x-jet-input wire:model="no_hp" id="no_hp" class="block mt-1 w-full" type="number" name="no_hp" />
                @error('no_hp') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" />
                @error('email') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="bank" value="{{ __('Nama Bank') }}" />
                <select wire:model="bank" name="bank" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih bank...</option>
                    <option value="bni">BNI</option>
                    <option value="bri">BRI</option>
                    <option value="bca">BCA</option>
                    <option value="mandiri">Mandiri</option>
                </select>
                @error('bank') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="no_rekening" value="{{ __('Nomor Rekening') }}" />
                <x-jet-input wire:model="no_rekening" id="no_rekening" class="block mt-1 w-full" type="number" name="no_rekening" />
                @error('no_rekening') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="sebab_klaim" value="{{ __('Sebab Klaim') }}" />
                <x-jet-input wire:model="sebab_klaim" id="sebab_klaim" class="block mt-1 w-full" type="text" name="sebab_klaim" />
                @error('sebab_klaim') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="dokumen_spk" value="{{ __('Dokumen SPK (.pdf, maksimal 2MB)') }}" />
                <x-jet-input wire:model="dokumen_spk" id="dokumen_spk" class="block mt-1 w-full" type="file" name="dokumen_spk" />
                @error('dokumen_spk') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="file_ktp" value="{{ __('Foto KTP (.jpg atau .png, maksimal 2MB)') }}" />
                <x-jet-input wire:model="file_ktp" id="file_ktp" class="block mt-1 w-full" type="file" name="file_ktp" />
                @error('file_ktp') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="file_buku_rekening" value="{{ __('File Buku Rekening (.jpg atau .png, maksimal 2MB)') }}" />
                <x-jet-input wire:model="file_buku_rekening" id="file_buku_rekening" class="block mt-1 w-full" type="file" name="file_buku_rekening" />
                @error('file_buku_rekening') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="file_foto" value="{{ __('Foto Terbaru (.jpg atau .png, maksimal 2MB)') }}" />
                <x-jet-input wire:model="file_foto" id="file_foto" class="block mt-1 w-full" type="file" name="file_foto" />
                @error('file_foto') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="file_formulir_pengajuan" value="{{ __('Formulir Pengajuan (.pdf, maksimal 2MB)') }}" />
                <x-jet-input wire:model="file_formulir_pengajuan" id="file_formulir_pengajuan" class="block mt-1 w-full" type="file" name="file_formulir_pengajuan" />
                @error('file_formulir_pengajuan') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button class="ml-4">
                {{ __('Kirim') }}
            </x-jet-button>
        </div>
    </form>
</div>
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
                <x-jet-label for="no_kpj" value="{{ __('No KPJ') }}" />
                <x-jet-input wire:model="no_kpj" id="no_kpj" class="block mt-1 w-full" type="number" name="no_kpj" readonly />
                @error('no_kpj') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="nama" value="{{ __('Nama') }}" />
                <x-jet-input wire:model="nama" id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama')" />
                @error('nama') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <div class="mt-4 flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/3 px-3 mt-4 md:mb-0">
                        <x-jet-label for="tempat_lahir" value="{{ __('Tempat Lahir') }}" />
                        <x-jet-input wire:model="tempat_lahir" id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir')" />
                        @error('tempat_lahir') <span class="error text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="w-full md:w-2/3 mt-4 px-3">
                        <x-jet-label for="tgl_lahir" value="{{ __('Tanggal Lahir') }}" />
                        <x-jet-input wire:model="tgl_lahir" id="tgl_lahir" class="block mt-1 w-full" type="date" name="tgl_lahir" :value="old('tgl_lahir')" />
                        @error('tgl_lahir') <span class="error text-red-500">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="nama_ibu" value="{{ __('Nama Ibu Kandung') }}" />
                <x-jet-input wire:model="nama_ibu" id="nama_ibu" class="block mt-1 w-full" type="text" name="nama_ibu" :value="old('nama_ibu')" />
                @error('nama_ibu') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="alamat" value="{{ __('Alamat') }}" />
                <textarea wire:model="alamat" name="alamat" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="" cols="30" rows="3">{{ old('alamat') }}</textarea>
                @error('alamat') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="kabupaten" value="{{ __('Kabupaten') }}" />
                <x-jet-input wire:model="kabupaten" id="kabupaten" class="block mt-1 w-full" type="text" name="kabupaten" />
                @error('kabupaten') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="kecamatan" value="{{ __('Kecamatan') }}" />
                <x-jet-input wire:model="kecamatan" id="kecamatan" class="block mt-1 w-full" type="text" name="kecamatan" />
                @error('kecamatan') <span class="error text-red-500">{{ $message }}</span> @enderror
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
                <x-jet-label for="program" value="{{ __('Program') }}" />
                <x-jet-input wire:model="program" id="program" class="block mt-1 w-full" type="text" name="program" readonly />
                @error('program') <span class="error text-red-500">{{ $message }}</span> @enderror
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
                <x-jet-label for="file_kartu_bpjs" value="{{ __('Kartu BPJS (.jpg atau .png, maksimal 2MB)') }}" />
                <x-jet-input wire:model="file_kartu_bpjs" id="file_kartu_bpjs" class="block mt-1 w-full" type="file" name="file_kartu_bpjs" />
                @error('file_kartu_bpjs') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="file_ktp" value="{{ __('Foto KTP (.jpg atau .png, maksimal 2MB)') }}" />
                <x-jet-input wire:model="file_ktp" id="file_ktp" class="block mt-1 w-full" type="file" name="file_ktp" />
                @error('file_ktp') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="file_kk" value="{{ __('Foto Kartu Keluarga (.jpg atau .png, maksimal 2MB)') }}" />
                <x-jet-input wire:model="file_kk" id="file_kk" class="block mt-1 w-full" type="file" name="file_kk" />
                @error('file_kk') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="file_suket" value="{{ __('Surat Keterangan Berhenti Kerja (.pdf, maksimal 2MB)') }}" />
                <x-jet-input wire:model="file_suket" id="file_suket" class="block mt-1 w-full" type="file" name="file_suket" />
                @error('file_suket') <span class="error text-red-500">{{ $message }}</span> @enderror
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
                <x-jet-label for="file_formulir_jht" value="{{ __('Formulir Pengajuan JHT (.pdf, maksimal 2MB)') }}" />
                <x-jet-input wire:model="file_formulir_jht" id="file_formulir_jht" class="block mt-1 w-full" type="file" name="file_formulir_jht" />
                @error('file_formulir_jht') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button class="ml-4">
                {{ __('Kirim') }}
            </x-jet-button>
        </div>
    </form>
</div>
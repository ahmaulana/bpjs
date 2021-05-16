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
                <x-jet-input wire:model="npp" id="npp" class="block mt-1 w-full" type="number" name="npp" />
                @error('npp') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="nama_perusahaan" value="{{ __('Nama Perusahaan') }}" />
                <x-jet-input wire:model="nama_perusahaan" id="nama_perusahaan" class="block mt-1 w-full" type="text" name="nama_perusahaan" :value="old('nama_perusahaan')" />
                @error('nama_perusahaan') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="program" value="{{ __('Program') }}" />
                <select wire:model="program" name="program" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    <option value="">Pilih program...</option>
                    <option value="jkk jkm jht">Jaminan Kecelakaan Kerja (JKK), Jaminan Kematian (JKM), Jaminan Hari Tua (JHT)</option>
                    <option value="jkk jkm jp">Jaminan Kecelakaan Kerja (JKK), Jaminan Kematian (JKM), Jaminan Pensiun (JP)</option>
                    <option value="jkk jht">Jaminan Kecelakaan Kerja (JKK), Jaminan Hari Tua (JHT)</option>
                    <option value="jkk jkm">Jaminan Kecelakaan Kerja (JKK), Jaminan Kematian (JKM)</option>
                    <option value="jkm">Jaminan Kematian (JKM)</option>
                    <option value="jkk">Jaminan Kecelakaan Kerja (JKK)</option>
                </select>
                @error('program') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="tgl" value="{{ __('Tanggal') }}" />
                <x-jet-input wire:model="tgl" id="tgl" class="block mt-1 w-full" type="date" name="tgl" :value="old('tgl')" />
                @error('tgl') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="kop_surat" class="text-sm ml-1">KOP Surat</label>
                    </div>
                    <div class="col-span-2">
                        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input wire:model="kop_surat" type="checkbox" name="toggle" id="toggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                            <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="materai" class="text-sm ml-1">Materai</label>
                    </div>
                    <div class="col-span-2">
                        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input wire:model="materai" type="checkbox" name="toggle" id="toggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                            <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="ttd" class="text-sm ml-1">Tanda Tangan</label>
                    </div>
                    <div class="col-span-2">
                        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input wire:model="ttd" type="checkbox" name="toggle" id="toggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                            <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="rekening" class="text-sm ml-1">Rekening</label>
                    </div>
                    <div class="col-span-2">
                        <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                            <input wire:model="rekening" type="checkbox" name="toggle" id="toggle" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer" />
                            <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <x-jet-label for="pernyataan" value="{{ __('Pernyataan (.pdf, maksimal 2MB)') }}" />
                <x-jet-input wire:model="pernyataan" id="pernyataan" class="block mt-1 w-full" type="file" name="pernyataan" />
                @error('pernyataan') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="mt-4">
                <x-jet-label for="lampiran" value="{{ __('Lampiran (.pdf, maksimal 2MB)') }}" />
                <x-jet-input wire:model="lampiran" id="lampiran" class="block mt-1 w-full" type="file" name="lampiran" />
                @error('lampiran') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="flex items-center justify-end mt-4">
            <x-jet-button class="ml-4">
                {{ __('Simpan') }}
            </x-jet-button>
        </div>
    </form>
</div>
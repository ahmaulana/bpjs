<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <div class="mt-10">
                <x-jet-authentication-card-logo />
            </div>
        </x-slot>
        <div class="text-center">
            <h1 class="inline-block text-3xl font-extrabold text-gray-600 tracking-tight mb-4">Form Pendaftaran</h1>
        </div>

        <x-jet-validation-errors class="mb-4" />
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <div>
                <x-jet-label for="name" value="{{ __('Nama') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>


            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="no_hp" value="{{ __('Nomor Hp') }}" />
                <x-jet-input id="no_hp" class="block mt-1 w-full" type="number" name="no_hp" :value="old('no_hp')" required />
            </div>

            <div class="mt-4">
                <x-jet-label for="jenis_kelamin" value="{{ __('Jenis Kelamin') }}" />
                <select name="jenis_kelamin" id="jenis_kelamin" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" :value="old('jenis_kelamin')" required>
                    <option value="">Pilih jenis kelamin...</option>
                    <option value="l" @if (old('jenis_kelamin')=='l' ) selected="selected" @endif>Laki-Laki</option>
                    <option value="p" @if (old('jenis_kelamin')=='p' ) selected="selected" @endif>Perempuan</option>
                </select>
            </div>

            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Password') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-jet-label for="password_confirmation" value="{{ __('Konfirmasi Password') }}" />
                <x-jet-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="mt-4" x-data="{ jenis_kepesertaan: 0 }">
                <div class="mt-4">
                    <x-jet-label for="jenis_kepesertaan" value="{{ __('Jenis Kepesertaan') }}" />
                    <select name="jenis_kepesertaan" id="jenis_kepesertaan" @change="jenis_kepesertaan = $event.target.value" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" required>
                        <option value="">Pilih kepesertaan...</option>
                        <option x-bind:value="1">Penerima Upah</option>
                        <option x-bind:value="2">Bukan Penerima Upah</option>
                        <option x-bind:value="3">Jasa Konstruksi</option>
                    </select>
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 1 || jenis_kepesertaan == 2">
                    <x-jet-label for="nik" value="{{ __('NIK') }}" />
                    <x-jet-input id="nik" class="block mt-1 w-full" type="number" name="nik" :value="old('nik')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 1 || jenis_kepesertaan == 2">
                    <x-jet-label for="tgl_lahir" value="{{ __('Tanggal Lahir') }}" />
                    <x-jet-input id="tgl_lahir" class="block mt-1 w-full" type="date" name="tgl_lahir" :value="old('tgl_lahir')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 1 || jenis_kepesertaan == 2">
                    <x-jet-label for="lokasi_bekerja" value="{{ __('Lokasi Bekerja') }}" />
                    <textarea name="lokasi_bekerja" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="" cols="30" rows="3">{{ old('lokasi_bekerja') }}</textarea>
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 1 || jenis_kepesertaan == 2">
                    <x-jet-label for="penghasilan" value="{{ __('Penghasilan Rp.') }}" />
                    <x-jet-input id="penghasilan" class="block mt-1 w-full" type="number" name="penghasilan" :value="old('penghasilan')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 1 || jenis_kepesertaan == 2">
                    <x-jet-label for="jam_kerja" value="{{ __('Jam Kerja') }}" />
                    <select name="jam_kerja" id="jam_kerja" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                        <option value="">Pilih jam kerja...</option>
                        <option value="08.00 - 16.00" @if (old('jam_kerja')=="08.00 - 16.00" ) selected="selected" @endif>08.00 - 16.00</option>
                        <option value="07.00 - 15.00" @if (old('jam_kerja')=="07.00 - 15.00" ) selected="selected" @endif>07.00 - 15.00</option>
                    </select>
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 1 || jenis_kepesertaan == 2">
                    <x-jet-label for="pekerjaan" value="{{ __('Pekerjaan') }}" />
                    <x-jet-input id="pekerjaan" class="block mt-1 w-full" type="text" name="pekerjaan" :value="old('pekerjaan')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 1 || jenis_kepesertaan == 2">
                    <x-jet-label for="program" value="{{ __('Program') }}" />
                    <select name="program" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                        <option value="">Pilih program...</option>
                        <option value="jht" @if (old('program')=='jht' ) selected="selected" @endif>Jaminan Hari Tua</option>
                        <option value="jkm" @if (old('program')=='jkm' ) selected="selected" @endif>Jaminan Kematian</option>
                        <option value="jkk" @if (old('program')=='jkk' ) selected="selected" @endif>Jaminan Kecelakaan Kerja</option>
                        <option value="jp" @if (old('program')=='jp' ) selected="selected" @endif>Jaminan Pensiun</option>
                    </select>
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 2">
                    <x-jet-label for="periode_pembayaran" value="{{ __('Periode Pembayaran') }}" />
                    <select name="periode_pembayaran" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                        <option value="">Pilih periode...</option>
                        <option value="1" @if (old('periode_pembayaran')=='1' ) selected="selected" @endif>1 Bulan</option>
                        <option value="2" @if (old('periode_pembayaran')=='2' ) selected="selected" @endif>2 Bulan</option>
                        <option value="3" @if (old('periode_pembayaran')=='3' ) selected="selected" @endif>3 Bulan</option>
                    </select>
                </div>

                <!-- Jasa Konstruksi -->

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="npp" value="{{ __('NPP') }}" />
                    <x-jet-input id="npp" class="block mt-1 w-full" type="number" name="npp" :value="old('npp')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="nama_proyek" value="{{ __('Nama Proyek') }}" />
                    <x-jet-input id="nama_proyek" class="block mt-1 w-full" type="text" name="nama_proyek" :value="old('nama_proyek')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="alamat_proyek" value="{{ __('Alamat Proyek') }}" />
                    <textarea name="alamat_proyek" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" id="" cols="30" rows="3">{{ old('alamat_proyek') }}</textarea>
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="nilai_proyek" value="{{ __('Nilai Proyek') }}" />
                    <x-jet-input id="nilai_proyek" class="block mt-1 w-full" type="number" name="nilai_proyek" :value="old('nilai_proyek')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="sumber_pembiayaan" value="{{ __('Sumber Pembiayaan') }}" />
                    <x-jet-input id="sumber_pembiayaan" class="block mt-1 w-full" type="text" name="sumber_pembiayaan" :value="old('sumber_pembiayaan')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="jenis_pemilik" value="{{ __('Jenis Pemilik') }}" />
                    <select name="jenis_pemilik" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                        <option value="">Pilih pemilik...</option>
                        <option value="instansi" @if (old('jenis_pemilik')=='instansi' ) selected="selected" @endif>Instansi</option>
                        <option value="perusahaan" @if (old('jenis_pemilik')=='perusahaan' ) selected="selected" @endif>Perusahaan</option>
                    </select>
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="nama_pemilik" value="{{ __('Nama Pemilik') }}" />
                    <x-jet-input id="nama_pemilik" class="block mt-1 w-full" type="text" name="nama_pemilik" :value="old('nama_pemilik')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="npp_pelaksana" value="{{ __('NPP Pelaksana') }}" />
                    <x-jet-input id="npp_pelaksana" class="block mt-1 w-full" type="number" name="npp_pelaksana" :value="old('npp_pelaksana')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="no_spk" value="{{ __('No SPK') }}" />
                    <x-jet-input id="no_spk" class="block mt-1 w-full" type="number" name="no_spk" :value="old('no_spk')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="dokumen_spk" value="{{ __('Dokumen SPK (.jpg atau .png, maksimal 2MB)') }}" />
                    <x-jet-input id="dokumen_spk" class="block mt-1 w-full" type="file" name="dokumen_spk" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="masa_kontrak" value="{{ __('Masa Kontrak') }}" />
                    <x-jet-input id="masa_kontrak" class="block mt-1 w-full" type="number" name="masa_kontrak" :value="old('masa_kontrak')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="masa_pemeliharaan" value="{{ __('Masa Pemeliharaan') }}" />
                    <x-jet-input id="masa_pemeliharaan" class="block mt-1 w-full" type="number" name="masa_pemeliharaan" :value="old('masa_pemeliharaan')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="total_pekerja" value="{{ __('Total Pekerja') }}" />
                    <x-jet-input id="total_pekerja" class="block mt-1 w-full" type="number" name="total_pekerja" :value="old('total_pekerja')" />
                </div>

                <div class="mt-4" x-show="jenis_kepesertaan == 3">
                    <x-jet-label for="cara_pembayaran" value="{{ __('Cara Pembayaran') }}" />
                    <select name="cara_pembayaran" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                        <option value="">Pilih pembayaran...</option>
                        <option value="sekaligus" @if (old('cara_pembayaran')=='sekaligus' ) selected="selected" @endif>Sekaligus</option>
                        <option value="termin" @if (old('cara_pembayaran')=='termin' ) selected="selected" @endif>Termin</option>
                    </select>
                </div>

                <div class="mt-4">
                    <x-jet-label for="berkas_foto" value="{{ __('Foto Diri (.jpg atau .png, maksimal 2MB)') }}" />
                    <x-jet-input id="berkas_foto" class="block mt-1 w-full" type="file" name="berkas_foto" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="berkas_ktp" value="{{ __('Foto KTP (.jpg atau .png, maksimal 2MB)') }}" />
                    <x-jet-input id="berkas_ktp" class="block mt-1 w-full" type="file" name="berkas_ktp" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="berkas_kk" value="{{ __('Foto Kartu Keluarga (.jpg atau .png, maksimal 2MB)') }}" />
                    <x-jet-input id="berkas_kk" class="block mt-1 w-full" type="file" name="berkas_kk" />
                </div>

                <div class="mt-4">
                    <x-jet-label for="berkas_buku_tabungan" value="{{ __('Foto Buku Tabungan (.jpg atau .png, maksimal 2MB)') }}" />
                    <x-jet-input id="berkas_buku_tabungan" class="block mt-1 w-full" type="file" name="berkas_buku_tabungan" />
                </div>

            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
            <div class="mt-4">
                <x-jet-label for="terms">
                    <div class="flex items-center">
                        <x-jet-checkbox name="terms" id="terms" />

                        <div class="ml-2">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </div>
                    </div>
                </x-jet-label>
            </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Sudah punya akun?') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Daftar') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
<?php

namespace App\Actions\Fortify;

use App\Models\Construction;
use App\Models\User;
use App\Models\Wage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {        
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            'nik' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'tgl_lahir' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2', 'date', 'before:today'],
            'lokasi_bekerja' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'penghasilan' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'jam_kerja' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'pekerjaan' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'program' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'periode_pembayaran' => ['required_if:jenis_kepesertaan,==,2'],
            'npp' => ['required_if:jenis_kepesertaan,==,3'],
            'nama_proyek' => ['required_if:jenis_kepesertaan,==,3'],
            'alamat_proyek' => ['required_if:jenis_kepesertaan,==,3'],
            'nilai_proyek' => ['required_if:jenis_kepesertaan,==,3'],
            'sumber_pembiayaan' => ['required_if:jenis_kepesertaan,==,3'],
            'jenis_pemilik' => ['required_if:jenis_kepesertaan,==,3'],
            'nama_pemilik' => ['required_if:jenis_kepesertaan,==,3'],
            'npp_pelaksana' => ['required_if:jenis_kepesertaan,==,3'],
            'no_spk' => ['required_if:jenis_kepesertaan,==,3'],
            'dokumen_spk' => ['required_if:jenis_kepesertaan,==,3', 'mimes:png,jpg', 'max:2048'],
            'masa_kontrak' => ['required_if:jenis_kepesertaan,==,3'],
            'masa_pemeliharaan' => ['required_if:jenis_kepesertaan,==,3'],
            'total_pekerja' => ['required_if:jenis_kepesertaan,==,3'],
            'cara_pembayaran' => ['required_if:jenis_kepesertaan,==,3'],
            'berkas_foto' => ['required', 'mimes:png,jpg', 'max:2048'],
            'berkas_ktp' => ['required', 'mimes:png,jpg', 'max:2048'],
            'berkas_kk' => ['required', 'mimes:png,jpg', 'max:2048'],
            'berkas_buku_tabungan' => ['required', 'mimes:png,jpg', 'max:2048'],
        ], [
            'nik.required_if' => ':attribute tidak boleh kosong!',
            'tgl_lahir.required_if' => 'Tanggal lahir tidak boleh kosong!',
            'tgl_lahir.before' => 'Tanggal lahir harus tanggal sebelum hari ini!',
            'lokasi_bekerja.required_if' => 'Lokasi bekerja tidak boleh kosong!',
            'penghasilan.required_if' => 'Penghasilan tidak boleh kosong!',
            'jam_kerja.required_if' => 'Jam kerja tidak boleh kosong!',
            'program.required_if' => 'Program tidak boleh kosong!',
            'periode_pembayaran.required_if' => 'Periode pembayaran tidak boleh kosong!',
            'npp.required_if' => 'Nomor NPP tidak boleh kosong!',
            'nama_proyek.required_if' => 'Nama proyek tidak boleh kosong!',
            'alamat_proyek.required_if' => 'Alamat proyek tidak boleh kosong!',
            'nilai_proyek.required_if' => 'Nilai proyek tidak boleh kosong!',
            'sumber_pembiayaan.required_if' => 'Sumber pembiayaan tidak boleh kosong!',
            'jenis_pemilik.required_if' => 'Jenis pemilik tidak boleh kosong!',
            'nama_pemilik.required_if' => 'Nama pemilik tidak boleh kosong!',
            'npp_pelaksana.required_if' => 'NPP pelaksana tidak boleh kosong!',
            'no_spk.required_if' => 'No SPK tidak boleh kosong!',
            'dokumen_spk.required_if' => 'Dokumen SPK tidak boleh kosong!',
            'dokumen_spk.mimes' => 'File dokumen SPK tidak valid!',
            'dokumen_spk.max' => 'Ukuran file dokumen SPK maksimal 2MB!',
            'masa_kontrak.required_if' => 'Masa kontrak tidak boleh kosong!',
            'masa_pemeliharaan.required_if' => 'Masa pemeliharaan tidak boleh kosong!',
            'total_pekerja.required_if' => 'Total pekerja tidak boleh kosong!',
            'cara_pembayaran.required_if' => 'Cara pembayaran tidak boleh kosong!',
            'berkas_foto.required' => 'Foto diri tidak boleh kosong!',
            'berkas_foto.mimes' => 'Foto diri tidak valid!',
            'berkas_foto.max' => 'Ukuran file foto diri maksimal 2MB!',
            'berkas_ktp.required' => 'Foto KTP tidak boleh kosong!',
            'berkas_ktp.mimes' => 'Foto KTP tidak valid!',
            'berkas_ktp.max' => 'Foto KTP maksimal 2MB!',
            'berkas_kk.required' => 'Foto Kartu Keluarga tidak boleh kosong!',
            'berkas_kk.mimes' => 'Foto Kartu Keluarga tidak valid!',
            'berkas_kk.max' => 'Foto Kartu Keluarga maksimal 2MB!',
            'berkas_buku_tabungan.required' => 'Foto buku tabungan tidak boleh kosong!',
            'berkas_buku_tabungan.mimes' => 'Foto buku tabungan tidak valid!',
            'berkas_buku_tabungan.max' => 'Foto buku tabungan maksimal 2MB!',
        ])->validate();

        //Store file
        if (isset($input['dokumen_spk'])) {
            $dokumen_spk = uniqid() . time() . '.' . $input['dokumen_spk']->getClientOriginalExtension();
            $input['dokumen_spk']->storeAs('public/images', $dokumen_spk);
        }

        if (isset($input['berkas_foto'])) {
            $berkas_foto = uniqid() . time() . '.' . $input['berkas_foto']->getClientOriginalExtension();
            $input['berkas_foto']->storeAs('public/images', $berkas_foto);
        }            

        if (isset($input['berkas_ktp'])) {
            $berkas_ktp = uniqid() . time() . '.' . $input['berkas_ktp']->getClientOriginalExtension();
            $input['berkas_ktp']->storeAs('public/images', $berkas_ktp);
        }

        if (isset($input['berkas_kk'])) {
            $berkas_kk = uniqid() . time() . '.' . $input['berkas_kk']->getClientOriginalExtension();
            $input['berkas_kk']->storeAs('public/images', $berkas_kk);
        }

        if (isset($input['berkas_buku_tabungan'])) {
            $berkas_buku_tabungan = uniqid() . time() . '.' . $input['berkas_buku_tabungan']->getClientOriginalExtension();
            $input['berkas_buku_tabungan']->storeAs('public/images', $berkas_buku_tabungan);
        }

        $user = null;

        DB::transaction(function () use ($input, &$user) {            

            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'no_hp' => $input['no_hp'],
                'password' => Hash::make($input['password']),
                'jenis_kelamin' => $input['jenis_kelamin'],
                'berkas_foto' => uniqid() . time() . '.' . $input['berkas_foto']->getClientOriginalExtension(),
                'berkas_ktp' => uniqid() . time() . '.' . $input['berkas_ktp']->getClientOriginalExtension(),
                'berkas_kk' => uniqid() . time() . '.' . $input['berkas_kk']->getClientOriginalExtension(),
                'berkas_buku_tabungan' => uniqid() . time() . '.' . $input['berkas_buku_tabungan']->getClientOriginalExtension(),
                'status' => 0,
            ]);

            $user->assignRole('user');

            if ($input['jenis_kepesertaan'] != 3) {
                $wage = new Wage([
                    'nik' => $input['nik'],
                    'tgl_lahir' => $input['tgl_lahir'],
                    'lokasi_bekerja' => $input['lokasi_bekerja'],
                    'pekerjaan' => $input['pekerjaan'],
                    'jam_kerja' => $input['jam_kerja'],
                    'penghasilan' => $input['penghasilan'],
                    'program' => $input['program'],
                    'periode_pembayaran' => $input['periode_pembayaran'],
                ]);

                $user->wage()->save($wage);
            } else {
                $construction = new Construction([
                    'npp' => $input['npp'],
                    'nama_proyek' => $input['nama_proyek'],
                    'alamat_proyek' => $input['alamat_proyek'],
                    'nilai_proyek' => $input['nilai_proyek'],
                    'sumber_pembiayaan' => $input['sumber_pembiayaan'],
                    'jenis_pemilik' => $input['jenis_pemilik'],
                    'nama_pemilik' => $input['nama_pemilik'],
                    'npp_pelaksana' => $input['npp_pelaksana'],
                    'no_spk' => $input['no_spk'],
                    'dokumen_spk' => uniqid() . time() . '.' . $input['dokumen_spk']->getClientOriginalExtension(),
                    'masa_kontrak' => $input['masa_kontrak'],
                    'masa_pemeliharaan' => $input['masa_pemeliharaan'],
                    'total_pekerja' => $input['total_pekerja'],
                    'cara_pembayaran' => $input['cara_pembayaran'],
                ]);
                $user->construction()->save($construction);
            }
        });        
        return $user;
    }
}

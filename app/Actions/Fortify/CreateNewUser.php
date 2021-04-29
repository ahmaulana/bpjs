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
            'name' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'nama_pengguna' => ['required_if:jenis_kepesertaan,==,3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            'nik' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2', 'nullable', 'numeric', 'digits:16', 'unique:wages'],
            'tempat_lahir' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'tgl_lahir' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2','nullable', 'date', 'before:today'],
            'lokasi_bekerja' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'penghasilan' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'jam_kerja' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'pekerjaan' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'program_pu' => ['required_if:jenis_kepesertaan,==,1'],
            'program_bpu' => ['required_if:jenis_kepesertaan,==,2'],
            'program_jk' => ['required_if:jenis_kepesertaan,==,3'],
            'kantor_cabang' => ['required'],
            'jenis_kepesertaan' => ['required'],
            'periode_pembayaran' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'npp' => ['required_if:jenis_kepesertaan,==,3', 'nullable', 'digits:6'],
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
            'total_pekerja' => ['required_if:jenis_kepesertaan,==,3'],
            'cara_pembayaran' => ['required_if:jenis_kepesertaan,==,3'],
            'berkas_foto' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2', 'mimes:png,jpg', 'max:2048'],
            'berkas_ktp' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2', 'mimes:png,jpg', 'max:2048'],
            'berkas_kk' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2', 'mimes:png,jpg', 'max:2048'],
            'berkas_buku_tabungan' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2', 'mimes:png,jpg', 'max:2048'],
        ], [
            'name.required_if' => 'Nama tidak boleh kosong!',
            'nama_pengguna.required_if' => 'Nama tidak boleh kosong!',
            'email.unique' => 'Alamat email sudah terdaftar!',
            'nik.required_if' => ':attribute tidak boleh kosong!',
            'nik.digits' => ':attribute tidak valid, silahkan cek kembali!',
            'nik.unique' => 'NIK sudah terdaftar!',
            'tempat_lahir.required_if' => 'Tempat lahir tidak boleh kosong!',
            'tgl_lahir.required_if' => 'Tanggal lahir tidak boleh kosong!',
            'tgl_lahir.before' => 'Tanggal lahir harus tanggal sebelum hari ini!',
            'lokasi_bekerja.required_if' => 'Lokasi bekerja tidak boleh kosong!',
            'penghasilan.required_if' => 'Penghasilan tidak boleh kosong!',
            'jam_kerja.required_if' => 'Jam kerja tidak boleh kosong!',
            'pekerjaan.required_if' => 'Pekerjaan tidak boleh kosong!',
            'program_pu.required_if' => 'Program tidak boleh kosong!',
            'program_bpu.required_if' => 'Program tidak boleh kosong!',
            'program_jk.required_if' => 'Program tidak boleh kosong!',
            'kantor_cabang.required' => 'Kantor cabang tidak boleh kosong!',
            'jenis_kepesertaan.required' => 'Kepesertaan tidak boleh kosong!',
            'periode_pembayaran.required_if' => 'Periode pembayaran tidak boleh kosong!',
            'npp.required_if' => 'Nomor NPP tidak boleh kosong!',
            'npp.digits' => 'Nomor NPP tidak valid!',
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
            'total_pekerja.required_if' => 'Total pekerja tidak boleh kosong!',
            'cara_pembayaran.required_if' => 'Cara pembayaran tidak boleh kosong!',
            'berkas_foto.required_if' => 'Foto diri tidak boleh kosong!',
            'berkas_foto.mimes' => 'Foto diri tidak valid!',
            'berkas_foto.max' => 'Ukuran file foto diri maksimal 2MB!',
            'berkas_ktp.required_if' => 'Foto KTP tidak boleh kosong!',
            'berkas_ktp.mimes' => 'Foto KTP tidak valid!',
            'berkas_ktp.max' => 'Foto KTP maksimal 2MB!',
            'berkas_kk.required_if' => 'Foto Kartu Keluarga tidak boleh kosong!',
            'berkas_kk.mimes' => 'Foto Kartu Keluarga tidak valid!',
            'berkas_kk.max' => 'Foto Kartu Keluarga maksimal 2MB!',
            'berkas_buku_tabungan.required_if' => 'Foto buku tabungan tidak boleh kosong!',
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

            switch ($input['jenis_kepesertaan']) {
                case '1':
                    $jenis_kepesertaan = 'pu';
                    $nama = $input['name'];
                    $program = $input['program_pu'];
                    break;
                case '2':
                    $jenis_kepesertaan = 'bpu';
                    $nama = $input['name'];
                    $program = $input['program_bpu'];
                    break;
                case '3':
                    $jenis_kepesertaan = 'jk';
                    $nama = $input['nama_pengguna'];
                    $program = $input['program_jk'];
                    break;
            }

            $user = User::create([
                'name' => $nama,
                'email' => $input['email'],
                'no_hp' => $input['no_hp'],
                'password' => Hash::make($input['password']),
                'jenis_kelamin' => $input['jenis_kelamin'],
                'program' => $program,
                'kantor_cabang' => $input['kantor_cabang'],
                'jenis_kepesertaan' => $jenis_kepesertaan,                
            ]);

            //Assign Role
            $user->assignRole('user');

            if ($input['jenis_kepesertaan'] != 3) {
                $wage = new Wage([
                    'nik' => $input['nik'],
                    'tempat_lahir' => $input['tempat_lahir'],
                    'tgl_lahir' => $input['tgl_lahir'],
                    'lokasi_bekerja' => $input['lokasi_bekerja'],
                    'pekerjaan' => $input['pekerjaan'],
                    'jam_kerja' => $input['jam_kerja'],
                    'penghasilan' => $input['penghasilan'],
                    'periode_pembayaran' => $input['periode_pembayaran'],
                    'berkas_foto' => uniqid() . time() . '.' . $input['berkas_foto']->getClientOriginalExtension(),
                    'berkas_ktp' => uniqid() . time() . '.' . $input['berkas_ktp']->getClientOriginalExtension(),
                    'berkas_kk' => uniqid() . time() . '.' . $input['berkas_kk']->getClientOriginalExtension(),
                    'berkas_buku_tabungan' => uniqid() . time() . '.' . $input['berkas_buku_tabungan']->getClientOriginalExtension(),
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
                    'total_pekerja' => $input['total_pekerja'],
                    'cara_pembayaran' => $input['cara_pembayaran'],
                ]);
                $user->construction()->save($construction);
            }
        });
        return $user;
    }
}

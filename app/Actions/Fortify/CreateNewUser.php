<?php

namespace App\Actions\Fortify;

use App\Http\Requests\StoreUserRequest;
use App\Models\Construction;
use App\Models\User;
use App\Models\Wage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{        
    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {                
        $validation = new StoreUserRequest();           
        Validator::make($input, $validation->rules(), $validation->messages())->validate();        

        //Store file
        if (isset($input['dokumen_spk'])) {
            $dokumen_spk = uniqid() . time() . '.' . $input['dokumen_spk']->getClientOriginalExtension();
            $input['dokumen_spk']->storeAs('berkas-peserta', $dokumen_spk);
        } else {
            $dokumen_spk = '';
        }        

        if (isset($input['berkas_foto'])) {
            $berkas_foto = uniqid() . time() . '.' . $input['berkas_foto']->getClientOriginalExtension();
            $input['berkas_foto']->storeAs('berkas-peserta', $berkas_foto);
        } else {
            $berkas_foto = '';
        }

        if (isset($input['berkas_ktp'])) {
            $berkas_ktp = uniqid() . time() . '.' . $input['berkas_ktp']->getClientOriginalExtension();
            $input['berkas_ktp']->storeAs('berkas-peserta', $berkas_ktp);
        } else {
            $berkas_ktp = '';
        }

        if (isset($input['berkas_kk'])) {
            $berkas_kk = uniqid() . time() . '.' . $input['berkas_kk']->getClientOriginalExtension();
            $input['berkas_kk']->storeAs('berkas-peserta', $berkas_kk);
        } else {
            $berkas_kk = '';
        }

        if (isset($input['berkas_buku_tabungan'])) {
            $berkas_buku_tabungan = uniqid() . time() . '.' . $input['berkas_buku_tabungan']->getClientOriginalExtension();
            $input['berkas_buku_tabungan']->storeAs('berkas-peserta', $berkas_buku_tabungan);
        } else {
            $berkas_buku_tabungan = '';
        }

        $user = null;

        DB::transaction(function () use ($input, &$user, $berkas_foto, $berkas_ktp, $berkas_kk, $berkas_buku_tabungan, $dokumen_spk) {            

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
                    'berkas_foto' => $berkas_foto,
                    'berkas_ktp' => $berkas_ktp,
                    'berkas_kk' => $berkas_kk,
                    'berkas_buku_tabungan' => $berkas_buku_tabungan,
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
                    'dokumen_spk' => $dokumen_spk,
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

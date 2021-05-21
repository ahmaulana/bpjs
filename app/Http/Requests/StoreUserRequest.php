<?php

namespace App\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Laravel\Jetstream\Jetstream;

class StoreUserRequest extends FormRequest
{
    use PasswordValidationRules;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],            
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'no_hp' => ['required', 'numeric', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
            'nik' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2', 'nullable', 'numeric', 'digits:16', 'unique:wages'],
            'tempat_lahir' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2'],
            'tgl_lahir' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2', 'nullable', 'date', 'before:today'],
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
            'npp' => ['required_if:jenis_kepesertaan,==,3', 'nullable', 'digits:6', 'unique:constructions'],
            'nama_proyek' => ['required_if:jenis_kepesertaan,==,3'],
            'alamat_proyek' => ['required_if:jenis_kepesertaan,==,3'],
            'nilai_proyek' => ['required_if:jenis_kepesertaan,==,3'],
            'sumber_pembiayaan' => ['required_if:jenis_kepesertaan,==,3'],
            'jenis_pemilik' => ['required_if:jenis_kepesertaan,==,3'],
            'nama_pemilik' => ['required_if:jenis_kepesertaan,==,3'],
            'npp_pelaksana' => ['required_if:jenis_kepesertaan,==,3'],
            'no_spk' => ['required_if:jenis_kepesertaan,==,3'],
            'dokumen_spk' => ['required_if:jenis_kepesertaan,==,3', 'mimes:png', 'max:2048'],
            'masa_kontrak' => ['required_if:jenis_kepesertaan,==,3'],
            'total_pekerja' => ['required_if:jenis_kepesertaan,==,3'],
            'cara_pembayaran' => ['required_if:jenis_kepesertaan,==,3'],
            'berkas_foto' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2', 'mimes:png,jpg', 'max:2048'],
            'berkas_ktp' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2', 'mimes:png,jpg', 'max:2048'],
            'berkas_kk' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2', 'mimes:png,jpg', 'max:2048'],
            'berkas_buku_tabungan' => ['required_if:jenis_kepesertaan,==,1', 'required_if:jenis_kepesertaan,==,2', 'mimes:png,jpg', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'name.required_if' => 'Nama tidak boleh kosong!',            
            'email.unique' => 'Alamat email sudah terdaftar!',            
            'no_hp.unique' => 'Nomor sudah terdaftar!',
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
            'npp.unique' => 'NPP sudah terdaftar!',
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
        ];
    }
}

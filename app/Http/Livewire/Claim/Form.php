<?php

namespace App\Http\Livewire\Claim;

use App\Models\Claim;
use App\Models\Wage;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use WithFileUploads;

    public $user;
    public $no_kpj, $program, $nama, $tempat_lahir, $tgl_lahir, $nama_ibu, $alamat, $kabupaten, $kecamatan, $no_hp, $email, $bank, $no_rekening, $sebab_klaim, $file_kartu_bpjs, $file_ktp, $file_kk, $file_suket, $file_buku_rekening, $file_foto, $file_formulir_jht;

    public $rules = [
        'no_kpj' => ['required', 'numeric', 'digits:11'],
        'nama' => ['required'],
        'nama_ibu' => ['required'],
        'tempat_lahir' => ['required'],
        'tgl_lahir' => ['required', 'date', 'before:today'],
        'alamat' => ['required'],
        'kabupaten' => ['required'],
        'kecamatan' => ['required'],
        'no_hp' => ['required', 'numeric'],
        'email' => ['required', 'email'],
        'bank' => ['required'],
        'no_rekening' => ['required', 'numeric'],
        'program' => ['required'],
        'sebab_klaim' => ['required'],
        'file_kartu_bpjs' => ['required', 'mimes:jpg,png', 'max:2048'],
        'file_ktp' => ['required', 'mimes:jpg,png', 'max:2048'],
        'file_kk' => ['required', 'mimes:jpg,png', 'max:2048'],
        'file_foto' => ['required', 'mimes:jpg,png', 'max:2048'],
        'file_formulir_jht' => ['required', 'mimes:pdf', 'max:2048'],
        'file_suket' => ['required', 'mimes:pdf', 'max:2048'],
        'file_buku_rekening' => ['required', 'mimes:jpg,png', 'max:2048'],
    ];

    public $messages = [
        'no_kpj.required' => 'Nomor KPJ tidak boleh kosong!',
        'no_kpj.digits' => 'Nomor KPJ tidak valid!',
        'nama.required' => 'Nama tidak boleh kosong!',
        'nama_ibu.required' => 'Nama Ibu tidak boleh kosong!',
        'tempat_lahir.required' => 'Tempat lahir tidak boleh kosong!',
        'tgl_lahir.required' => 'Tanggal lahir tidak boleh kosong!',
        'tgl_lahir.date' => 'Format tanggal lahir tidak valid!',
        'tgl_lahir.before' => 'Tanggal lahir harus tanggal sebelum hari ini!',
        'alamat.required' => 'Alamat tidak boleh kosong!',
        'kabupaten.required' => 'Kabupaten tidak boleh kosong!',
        'kecamatan.required' => 'Kecamatan tidak boleh kosong!',
        'no_hp.required' => 'Nomor hp tidak boleh kosong!',
        'email.required' => 'Email tidak boleh kosong',
        'email.email' => 'Email tidak valid',
        'bank.required' => 'Nama bank tidak boleh kosong!',
        'no_rekening.required' => 'Nomor rekening tidak boleh kosong!',
        'sebab_klaim.required' => 'Sebab klaim tidak boleh kosong!',
        'file_kartu_bpjs.required' => 'File tidak boleh kosong!',
        'file_kartu_bpjs.mimes' => 'Format file tidak valid!',
        'file_kartu_bpjs.max' => 'Ukuran file tidak boleh lebih dari 2MB!',
        'file_ktp.required' => 'File tidak boleh kosong!',
        'file_ktp.mimes' => 'Format file tidak valid!',
        'file_ktp.max' => 'Ukuran file tidak boleh lebih dari 2MB!',
        'file_kk.required' => 'File tidak boleh kosong!',
        'file_kk.mimes' => 'Format file tidak valid!',
        'file_kk.max' => 'Ukuran file tidak boleh lebih dari 2MB!',
        'file_foto.required' => 'File tidak boleh kosong!',
        'file_foto.mimes' => 'Format file tidak valid!',
        'file_foto.max' => 'Ukuran file tidak boleh lebih dari 2MB!',
        'file_formulir_jht.required' => 'File tidak boleh kosong!',
        'file_formulir_jht.mimes' => 'Format file tidak valid!',
        'file_formulir_jht.max' => 'Ukuran file tidak boleh lebih dari 2MB!',
        'file_suket.required' => 'File tidak boleh kosong!',
        'file_suket.mimes' => 'Format file tidak valid!',
        'file_suket.max' => 'Ukuran file tidak boleh lebih dari 2MB!',
        'file_buku_rekening.required' => 'File tidak boleh kosong!',
        'file_buku_rekening.mimes' => 'Format file tidak valid!',
        'file_buku_rekening.max' => 'Ukuran file tidak boleh lebih dari 2MB!',
    ];

    public function mount()
    {
        //Nomor KPJ                                
        $user = Wage::where('user_id', $this->user->id)->first();
        $this->no_kpj = $user->no_kpj;

        //Jenis Program
        switch ($this->user->program) {
            case 'jkk jkm jht':
                $this->program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM), Jaminan Hari Tua (JHT)';
                break;
            case 'jkk jkm jp':
                $this->program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM), Jaminan Pensiun (JP)';
                break;
            case 'jkk jht':
                $this->program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Hari Tua (JHT)';
                break;
            case 'jkk jkm':
                $this->program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM)';
                break;
            case 'jkm':
                $this->program = 'Jaminan Kematian';
                break;
            case 'jkk':
                $this->program = 'Jaminan Kecelakaan Kerja';
                break;
        }
    }

    public function render()
    {
        return view('livewire.claim.form');
    }

    public function save()
    {
        $claim = $this->validate();
        
        DB::transaction(function () use ($claim) {
            //Simpan Berkas-Berkas
            $claim['file_kartu_bpjs']->store('berkas-klaim');
            $claim['file_kartu_bpjs'] = $claim['file_kartu_bpjs']->hashName();
            $claim['file_ktp']->store('berkas-klaim');
            $claim['file_ktp'] = $claim['file_ktp']->hashName();
            $claim['file_kk']->store('berkas-klaim');
            $claim['file_kk'] = $claim['file_kk']->hashName();
            $claim['file_foto']->store('berkas-klaim');
            $claim['file_foto'] = $claim['file_foto']->hashName();
            $claim['file_formulir_jht']->store('berkas-klaim');
            $claim['file_formulir_jht'] = $claim['file_formulir_jht']->hashName();
            $claim['file_suket']->store('berkas-klaim');
            $claim['file_suket'] = $claim['file_suket']->hashName();
            $claim['file_buku_rekening']->store('berkas-klaim');
            $claim['file_buku_rekening'] = $claim['file_buku_rekening']->hashName();

            //Save to Claims Table
            $store_claim = Claim::create([
                'nama' => $claim['nama'],
                'no_hp' => $claim['no_hp'],
                'email' => $claim['email'],
                'jenis_kepesertaan' => $this->user->jenis_kepesertaan,
                'program' => $this->user->program,
                'bank' => $claim['bank'],
                'no_rekening' => $claim['no_rekening'],
                'sebab_klaim' => $claim['sebab_klaim'],
                'file_ktp' => $claim['file_ktp'],
                'file_buku_rekening' => $claim['file_buku_rekening'],
                'file_foto' => $claim['file_foto'],
            ]);
            $store_claim->wage_claim()->create([
                'no_kpj' => $claim['no_kpj'],
                'tempat_lahir' => $claim['tempat_lahir'],
                'tgl_lahir' => $claim['tgl_lahir'],
                'nama_ibu' => $claim['nama_ibu'],
                'alamat' => $claim['alamat'],
                'kabupaten' => $claim['kabupaten'],
                'kecamatan' => $claim['kecamatan'],                
                'file_kartu_bpjs' => $claim['file_kartu_bpjs'],
                'file_kk' => $claim['file_kk'],
                'file_suket' => $claim['file_suket'],
                'file_formulir_jht' => $claim['file_formulir_jht'],
            ]);
        });
        session()->flash('flash.banner', 'Pengajuan klaim berhasil disimpan!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect(route('user.claim.form'));
    }
}

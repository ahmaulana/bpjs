<?php

namespace App\Http\Livewire\Claim;

use App\Models\Claim;
use App\Models\Construction;
use App\Models\Wage;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormJk extends Component
{
    use WithFileUploads;

    public $user;
    public $npp, $program, $nama, $nama_proyek, $alamat_proyek, $jenis_pemilik, $nama_pemilik, $no_hp, $email, $bank, $no_rekening, $sebab_klaim, $dokumen_spk, $file_ktp, $file_buku_rekening, $file_foto, $file_formulir_pengajuan;

    public $rules = [
        'npp' => ['required', 'numeric', 'digits:6'],
        'nama' => ['required'],
        'nama_proyek' => ['required'],
        'alamat_proyek' => ['required'],
        'jenis_pemilik' => ['required'],
        'nama_pemilik' => ['required'],
        'no_hp' => ['required', 'numeric'],
        'email' => ['required', 'email'],
        'bank' => ['required'],
        'no_rekening' => ['required', 'numeric'],
        'program' => ['required'],
        'sebab_klaim' => ['required'],
        'file_ktp' => ['required', 'mimes:jpg,png', 'max:2048'],
        'file_foto' => ['required', 'mimes:jpg,png', 'max:2048'],
        'file_formulir_pengajuan' => ['required', 'mimes:pdf', 'max:2048'],
        'dokumen_spk' => ['required', 'mimes:pdf', 'max:2048'],
        'file_buku_rekening' => ['required', 'mimes:jpg,png', 'max:2048'],
    ];

    public $messages = [
        'npp.required' => 'Nomor NPP tidak boleh kosong!',
        'npp.digits' => 'Nomor NPP tidak valid!',
        'nama.required' => 'Nama tidak boleh kosong!',
        'nama_proyek.required' => 'Nama proyek tidak boleh kosong!',
        'alamat_proyek.required' => 'Alamat proyek tidak boleh kosong!',
        'nama_pemilik.required' => 'Nama tidak boleh kosong!',
        'no_hp.required' => 'Nomor hp tidak boleh kosong!',
        'email.required' => 'Email tidak boleh kosong',
        'email.email' => 'Email tidak valid',
        'bank.required' => 'Nama bank tidak boleh kosong!',
        'no_rekening.required' => 'Nomor rekening tidak boleh kosong!',
        'sebab_klaim.required' => 'Sebab klaim tidak boleh kosong!',
        'file_ktp.required' => 'File tidak boleh kosong!',
        'file_ktp.mimes' => 'Format file tidak valid!',
        'file_ktp.max' => 'Ukuran file tidak boleh lebih dari 2MB!',
        'file_foto.required' => 'File tidak boleh kosong!',
        'file_foto.mimes' => 'Format file tidak valid!',
        'file_foto.max' => 'Ukuran file tidak boleh lebih dari 2MB!',
        'file_formulir_pengajuan.required' => 'File tidak boleh kosong!',
        'file_formulir_pengajuan.mimes' => 'Format file tidak valid!',
        'file_formulir_pengajuan.max' => 'Ukuran file tidak boleh lebih dari 2MB!',
        'file_buku_rekening.required' => 'File tidak boleh kosong!',
        'file_buku_rekening.mimes' => 'Format file tidak valid!',
        'file_buku_rekening.max' => 'Ukuran file tidak boleh lebih dari 2MB!',
        'dokumen_spk.required' => 'File tidak boleh kosong!',
        'dokumen_spk.mimes' => 'Format file tidak valid!',
        'dokumen_spk.max' => 'Ukuran file tidak boleh lebih dari 2MB!',
    ];

    public function mount()
    {
        //Nomor NPP                                
        $user = Construction::where('user_id', $this->user->id)->first();
        $this->npp = $user->npp;

        //Jenis Program
        switch ($this->user->program) {
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
        return view('livewire.claim.form-jk');
    }

    public function save()
    {
        $claim = $this->validate();

        DB::transaction(function () use ($claim) {
            //Simpan Berkas-Berkas        
            $claim['file_ktp']->store('berkas-klaim');
            $claim['file_ktp'] = $claim['file_ktp']->hashName();
            $claim['file_foto']->store('berkas-klaim');
            $claim['file_foto'] = $claim['file_foto']->hashName();
            $claim['file_formulir_pengajuan']->store('berkas-klaim');
            $claim['file_formulir_pengajuan'] = $claim['file_formulir_pengajuan']->hashName();
            $claim['dokumen_spk']->store('berkas-klaim');
            $claim['dokumen_spk'] = $claim['dokumen_spk']->hashName();
            $claim['file_buku_rekening']->store('berkas-klaim');
            $claim['file_buku_rekening'] = $claim['file_buku_rekening']->hashName();
            
            //Save to Claims Table
            $store_claim = Claim::create([
                'nama' => $claim['nama'],
                'no_hp' => $claim['no_hp'],
                'email' => $claim['email'],
                'jenis_kepesertaan' => $this->user->jenis_kepesertaan,
                'program' => $claim['program'],
                'bank' => $claim['bank'],
                'no_rekening' => $claim['no_rekening'],
                'sebab_klaim' => $claim['sebab_klaim'],
                'file_ktp' => $claim['file_ktp'],
                'file_buku_rekening' => $claim['file_buku_rekening'],
                'file_foto' => $claim['file_foto'],
            ]);
            $store_claim->construction_claim()->create([
                'npp' => $claim['npp'],
                'nama_proyek' => $claim['nama_proyek'],
                'alamat_proyek' => $claim['alamat_proyek'],
                'jenis_pemilik' => $claim['jenis_pemilik'],
                'nama_pemilik' => $claim['nama_pemilik'],
                'dokumen_spk' => $claim['dokumen_spk'],
                'file_formulir_pengajuan' => $claim['file_formulir_pengajuan'],
            ]);
        });

        session()->flash('flash.banner', 'Pengajuan klaim berhasil disimpan!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect(route('user.claim.form'));
    }
}

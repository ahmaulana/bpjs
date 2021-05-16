<?php

namespace App\Http\Livewire\Recap;

use App\Models\RecapLetter;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public $npp, $nama_perusahaan, $program, $tgl, $kop_surat, $materai, $ttd, $rekening, $pernyataan, $lampiran;

    protected $rules = [
        'npp' => ['required', 'exists:constructions'],
        'nama_perusahaan' => ['required'],
        'program' => ['required'],
        'tgl' => ['required', 'date'],
        'kop_surat' => ['required'],
        'materai' => ['required'],
        'ttd' => ['required'],
        'rekening' => ['required'],
        'pernyataan' => ['required', 'mimes:pdf', 'max:2048'],
        'lampiran' => ['required', 'mimes:pdf', 'max:2048'],
    ];

    protected $messages = [
        'npp.required' => 'Nomor NPP tidak boleh kosong',
        'npp.exists' => 'Nomor NPP belum terdaftar',
        'nama_perusahaan.required' => 'Nama perusahaan tidak boleh kosong',
        'program.required' => 'Program tidak boleh kosong',
        'tgl.required' => 'Tanggal tidak boleh kosong',
        'pernyataan.required' => 'Pernyataan tidak boleh kosong',
        'pernyataan.mimes' => 'Format file tidak valid!',
        'pernyataan.max' => 'Ukuran file maksimal 2MB!',
        'lampiran.required' => 'Lampiran tidak boleh kosong',
        'lampiran.mimes' => 'Format file tidak valid!',
        'lampiran.max' => 'Ukuran file maksimal 2MB!',
    ];

    public function render()
    {
        return view('livewire.recap.create');
    }

    public function save()
    {
        $recap = $this->validate();

        //Save File
        $recap['pernyataan']->store('berkas-rekap');
        $recap['pernyataan'] = $recap['pernyataan']->hashName();
        $recap['lampiran']->store('berkas-rekap');
        $recap['lampiran'] = $recap['lampiran']->hashName();
        RecapLetter::create($recap);
        return redirect()->route('rekap.index');
    }
}

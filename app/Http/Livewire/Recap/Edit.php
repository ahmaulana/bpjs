<?php

namespace App\Http\Livewire\Recap;

use App\Models\RecapLetter;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    public $data;
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
        'pernyataan' => ['nullable', 'mimes:pdf', 'max:2048'],
        'lampiran' => ['nullable', 'mimes:pdf', 'max:2048'],
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

    public function mount()
    {
        $this->npp = $this->data->npp;
        $this->nama_perusahaan = $this->data->nama_perusahaan;
        $this->program = $this->data->program;
        $this->tgl = date('Y-m-d', strtotime($this->data->tgl));
        $this->kop_surat = $this->data->kop_surat;
        $this->materai = $this->data->materai;
        $this->ttd = $this->data->ttd;
        $this->rekening = $this->data->rekening;
    }

    public function render()
    {
        return view('livewire.recap.edit');
    }

    public function update()
    {
        $recap = $this->validate();

        //Save File
        if (isset($recap['pernyataan'])) {
            $recap['pernyataan']->store('berkas-rekap');
            $recap['pernyataan'] = $recap['pernyataan']->hashName();
        } else {
            unset($recap['pernyataan']);
        }

        if (isset($recap['lampiran'])) {
            $recap['lampiran']->store('berkas-rekap');
            $recap['lampiran'] = $recap['lampiran']->hashName();
        } else {
            unset($recap['lampiran']);
        }

        RecapLetter::findOrFail($this->data->id)->update($recap);
        return redirect()->route('rekap.index');
    }
}

<?php

namespace App\Http\Livewire\NewUser;

use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    public $data;
    public $jenis_kelamin, $program, $tgl_lahir, $status;

    public function mount()
    {                
        $this->jenis_kelamin = ($this->data->jenis_kelamin) == 'l' ? 'Laki-Laki' : 'Perempuan';        

        switch ($this->data->program) {
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
        if ($this->data->jenis_kepesertaan) {
            $this->tgl_lahir = Carbon::parse($this->data->tgl_lahir)->isoFormat('D MMMM Y');
        }

        $this->status = ($this->data->status) == true ? 'Aktif' : 'Tidak Aktif';
    }

    public function render()
    {
        return view('livewire.new-user.show');
    }

    public function download($file, $name)
    {
        $path = storage_path('app/berkas-peserta/' . $file);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return response()->download($path, $name . '.' . $extension);
    }
}

<?php

namespace App\Http\Livewire\Recap;

use Livewire\Component;

class Show extends Component
{
    public $data;
    public $program;

    public function mount()
    {
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
    }

    public function render()
    {
        return view('livewire.recap.show');
    }

    public function download($file, $name)
    {
        $path = storage_path('app/berkas-rekap/' . $file);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return response()->download($path, $name . '.' . $extension);
    }
}

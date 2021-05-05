<?php

namespace App\Http\Livewire\Claim;

use App\Models\Claim;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Show extends Component
{
    public $data;
    public $program, $tgl_lahir, $status;

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

        $this->tgl_lahir = Carbon::parse($this->data->tgl_lahir)->isoFormat('D MMMM Y');

        $this->status = ($this->data->status) == true ? 'Aktif' : 'Tidak Aktif';
    }

    public function render()
    {
        return view('livewire.claim.show');
    }

    public function download($file, $name)
    {
        $path = storage_path('app/berkas-klaim/' . $file);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return response()->download($path, $name . '.' . $extension);
    }

    public function update($id)
    {                     
        $claim = Claim::findOrFail($id);    
        $claim->update([
            'status' => true
        ]);
        if ($claim->jenis_kepesertaan != 'jk') {
            return redirect(route('klaim.index'));
        }
        return redirect(route('klaim.index') . '?user=jasa-konstruksi');
    }
}

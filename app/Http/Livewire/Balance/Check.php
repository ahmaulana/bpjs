<?php

namespace App\Http\Livewire\Balance;

use App\Models\Invoice;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;

class Check extends Component
{
    public $user, $data, $program, $balance, $last_invoice, $last_payment;

    public function mount()
    {
        $this->user = User::findOrFail(auth()->user()->id);

        $this->balance = Invoice::where('user_id',$this->user->id)->where('status',true)->sum('tagihan');
        
        $this->last_invoice = $this->user->last_invoice() != null ? $this->user->last_invoice()->tagihan : 0;
        
        $this->last_payment = $this->user->last_payment() != null ? Carbon::parse($this->user->last_payment()->updated_at)->isoFormat('D MMMM Y') : '-';

        // Program
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

        if ($this->user->jenis_kepesertaan != 'jk') {
            $this->data = $this->user->wage;
        } else {
            $this->data = $this->user->construction;
        }
    }

    public function render()
    {
        return view('livewire.balance.check');
    }
}

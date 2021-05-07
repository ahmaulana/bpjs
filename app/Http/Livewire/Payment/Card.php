<?php

namespace App\Http\Livewire\Payment;

use App\Models\Construction;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Wage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Card extends Component
{
    public $tagihan, $denda;
    public $nama, $nomor, $notification, $invoice_notification = false;

    public function mount()
    {
        $invoice = Invoice::where('user_id', auth()->user()->id)->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month);

        // Jenis Kepesertaan
        if (auth()->user()->jenis_kepesertaan != 'jk') {
            $wage = Wage::where('user_id', auth()->user()->id)->first();
            $this->nama = auth()->user()->name;
            $this->nomor = $wage->no_kpj;
        } else {
            $construction = Construction::where('user_id', auth()->user()->id)->first();
            $this->nama = auth()->user()->name;
            $this->nomor = $construction->npp;
        }

        if ($invoice->doesntExist()) {

            // Program
            switch (auth()->user()->program) {
                case 'jkk jkm jht':
                    $persentase = 0.54 + 0.3 + 5.7;
                    break;
                case 'jkk jkm jp':
                    $persentase = 0.54 + 0.3 + 3;
                    break;
                case 'jkk jht':
                    $persentase = 0.54 + 5.7;
                    break;
                case 'jkk jkm':
                    $persentase = $persentase = 0.54 + 0.3;
                    break;
                case 'jkm':
                    $persentase = 0.3;
                    break;
                case 'jkk':
                    $persentase = 0.54;
                    break;
            }

            if (auth()->user()->jenis_kepesertaan != 'jk') {
                $tagihan = $wage->penghasilan * $persentase / 100;
            } else {
                $tagihan = $construction->nilai_proyek * $persentase / 100;
            }

            //Save
            Invoice::create([
                'user_id' => auth()->user()->id,
                'tagihan' => $tagihan,
            ]);
        }

        //Count Invoice & Fine
        $invoice = Invoice::where('user_id', auth()->user()->id)->where('status', false);

        if ($invoice->exists()) {
            $last_invoice = $invoice->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month);            

            if (!$last_invoice->first()->status && Carbon::now()->day > 10) {

                $last_invoice->update([
                    'denda' => $last_invoice->first()->tagihan * 2 / 100,
                ]);
                
            }
        }
        $this->tagihan = $invoice->sum('tagihan');
        $this->denda = $invoice->sum('denda');

        //Show Notification
        $this->notification = auth()->user()->notification;
        if ($this->tagihan != 0) {
            $this->invoice_notification = true;
        }
    }

    public function render()
    {
        return view('livewire.payment.card');
    }

    public function update_notification()
    {
        $notification = User::findOrFail(auth()->user()->id);

        $notification->notification = $this->notification;
        $notification->save();
    }

    public function pay()
    {
        Invoice::where('user_id', auth()->user()->id)->where('status', false)->update(array('status' => true));
        $this->invoice_notification = false;
        $this->tagihan = 0;
    }
}

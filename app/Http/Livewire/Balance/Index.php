<?php

namespace App\Http\Livewire\Balance;

use App\Models\Construction;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Wage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use PhpOffice\PhpWord\TemplateProcessor;

class Index extends LivewireDatatable
{
    public function builder()
    {
        $user_table = (Request::has('user')) ? 'constructions' : 'wages';

        return User::query()
            ->join($user_table, 'users.id', $user_table . '.user_id')
            ->where('users.id', '!=', '1')
            ->where('status', true)
            ->orderBy('users.status', 'ASC')
            ->orderBy('users.id', 'ASC');
    }

    public function columns()
    {
        if (Request::has('user')) {

            $columns = [

                Column::name('id')
                    ->label('ID'),

                Column::name('constructions.npp')
                    ->label('NPP')
                    ->searchable(),

                Column::name('constructions.nama_proyek')
                    ->label('Nama Proyek'),

                Column::name('constructions.nama_pemilik')
                    ->label('Nama Pemilik'),

                Column::callback(['program'], function ($prog) {
                    switch ($prog) {
                        case 'jkk jkm jht':
                            $program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM), Jaminan Hari Tua (JHT)';
                            break;
                        case 'jkk jkm jp':
                            $program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM), Jaminan Pensiun (JP)';
                            break;
                        case 'jkk jht':
                            $program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Hari Tua (JHT)';
                            break;
                        case 'jkk jkm':
                            $program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM)';
                            break;
                        case 'jkm':
                            $program = 'Jaminan Kematian';
                            break;
                        case 'jkk':
                            $program = 'Jaminan Kecelakaan Kerja';
                            break;
                    }
                    return $program;
                })
                    ->label('Program'),

                Column::callback(['status', 'id'], function ($status, $id) {
                    $invoice = Invoice::where('user_id', $id)->where('status', true)->sum('tagihan');
                    return $invoice;
                })
                    ->label('Saldo Terakhir')
                    ->alignCenter(),

                Column::callback(['id', 'name'], function ($id) {
                    $invoice = Invoice::where('user_id', $id)->where('status', true)->latest('created_at')->first();
                    return $invoice->tagihan;
                })
                    ->label('Iuran Terakhir')
                    ->alignCenter(),

                Column::callback(['name', 'id'], function ($name, $id) {
                    $invoice = Invoice::where('user_id', $id)->latest('created_at')->first();
                    return Carbon::parse($invoice->created_at)->isoFormat('D MMMM Y');
                })
                    ->label('Pembayaran Iuran Terakhir')
                    ->alignCenter(),

                Column::callback(['id', 'status'], function ($id, $status) {
                    return view('due-table-actions', ['id' => $id, 'status' => $status]);
                })
                    ->label('Aksi')
                    ->alignCenter(),
            ];
        } else {

            $columns = [

                Column::name('id')
                    ->label('ID'),

                Column::name('wages.no_kpj')
                    ->label('No KPJ')
                    ->searchable(),

                Column::name('users.name')
                    ->label('Nama')
                    ->searchable(),

                Column::name('wages.lokasi_bekerja')
                    ->label('Lokasi Bekerja'),

                Column::callback(['program'], function ($prog) {
                    switch ($prog) {
                        case 'jkk jkm jht':
                            $program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM), Jaminan Hari Tua (JHT)';
                            break;
                        case 'jkk jkm jp':
                            $program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM), Jaminan Pensiun (JP)';
                            break;
                        case 'jkk jht':
                            $program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Hari Tua (JHT)';
                            break;
                        case 'jkk jkm':
                            $program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM)';
                            break;
                        case 'jkm':
                            $program = 'Jaminan Kematian';
                            break;
                        case 'jkk':
                            $program = 'Jaminan Kecelakaan Kerja';
                            break;
                    }
                    return $program;
                })
                    ->label('Program'),

                Column::callback(['status', 'id'], function ($status, $id) {
                    $invoice = Invoice::where('user_id', $id)->where('status', true)->sum('tagihan');
                    return $invoice;
                })
                    ->label('Saldo Terakhir')
                    ->alignCenter(),

                Column::name('wages.penghasilan')
                    ->label('Upah Terakhir'),

                Column::callback(['id', 'name'], function ($id) {
                    $invoice = Invoice::where('user_id', $id)->where('status', true)->latest('created_at')->first();
                    return $invoice->tagihan;
                })
                    ->label('Iuran Terakhir')
                    ->alignCenter(),

                Column::callback(['name', 'id'], function ($name, $id) {
                    $invoice = Invoice::where('user_id', $id)->latest('created_at')->first();
                    return Carbon::parse($invoice->created_at)->isoFormat('D MMMM Y');
                })
                    ->label('Pembayaran Iuran Terakhir')
                    ->alignCenter(),

                Column::callback(['id', 'status'], function ($id, $status) {
                    return view('due-table-actions', ['id' => $id, 'status' => $status]);
                })
                    ->label('Aksi')
                    ->alignCenter(),
            ];
        }

        return $columns;
    }

    public function print($id)
    {
        $user = User::findOrFail($id);

        // Program
        switch ($user->program) {
            case 'jkk jkm jht':
                $program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM), Jaminan Hari Tua (JHT)';
                break;
            case 'jkk jkm jp':
                $program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM), Jaminan Pensiun (JP)';
                break;
            case 'jkk jht':
                $program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Hari Tua (JHT)';
                break;
            case 'jkk jkm':
                $program = 'Jaminan Kecelakaan Kerja (JKK), Jaminan Kemation (JKM)';
                break;
            case 'jkm':
                $program = 'Jaminan Kematian';
                break;
            case 'jkk':
                $program = 'Jaminan Kecelakaan Kerja';
                break;
        }

        //Balance
        $balance = Invoice::where('user_id', $user->id)->where('status', true)->sum('tagihan');
        //Total Iuran
        $due = Invoice::where('user_id', $user->id)->latest('created_at')->first();

        if ($user->jenis_kepesertaan != 'jk') {
            // Nomor KPJ            
            $data = Wage::where('user_id', $user->id)->first();

            $card = new TemplateProcessor(storage_path('app/templates/saldo-upah.docx'));
            $card->setValues([
                'no_kpj' => $data->no_kpj,
                'nama' => $user->name,
                'lokasi_bekerja' => $data->lokasi_bekerja,
                'program' => $program,
                'saldo' => "Rp." . number_format($balance, 2, ',', '.'),
                'penghasilan' => "Rp." . number_format($data->penghasilan, 2, ',', '.'),
                'iuran' => "Rp." . number_format($due->tagihan, 2, ',', '.'),
                'tgl' => Carbon::parse($due->created_at)->isoFormat('D MMMM Y'),
            ]);

            $file_name = 'Data Saldo ' . $data->no_kpj . '.docx';
            $card->saveAs($file_name);

            return response()->download(public_path($file_name))->deleteFileAfterSend();
        } else {
            // Nomor NPP
            $data = Construction::where('user_id', $user->id)->first();

            $card = new TemplateProcessor(storage_path('app/templates/saldo-jk.docx'));
            $card->setValues([
                'npp' => $data->npp,
                'nama_pemilik' => $data->nama_pemilik,
                'nama_proyek' => $data->nama_proyek,
                'program' => $program,
                'saldo' => "Rp." . number_format($balance, 2, ',', '.'),
                'iuran' => "Rp." . number_format($due->tagihan, 2, ',', '.'),
                'tgl' => Carbon::parse($due->created_at)->isoFormat('D MMMM Y'),
            ]);

            $file_name = 'Data Saldo ' . $data->npp . '.docx';
            $card->saveAs($file_name);

            return response()->download(public_path($file_name))->deleteFileAfterSend();
        }
    }
}

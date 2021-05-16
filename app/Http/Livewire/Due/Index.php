<?php

namespace App\Http\Livewire\Due;

use App\Models\Construction;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Wage;
use Illuminate\Support\Facades\Request;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use PhpOffice\PhpWord\TemplateProcessor;

class Index extends LivewireDatatable
{
    public function builder()
    {
        $user_table = (Request::has('user')) ? 'constructions' : 'wages';

        return User::query()
            ->join($user_table, 'users.id', $user_table . '.user_id')
            ->where('users.id', '!=', '1')->orderBy('users.status', 'ASC')->orderBy('users.id', 'ASC');
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

                Column::name('name')
                    ->label('Nama Pengguna'),

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

                Column::name('latest_invoice.tagihan')
                    ->label('Total Iuran'),

                BooleanColumn::name('latest_invoice.status')
                    ->label('Status Iuran'),

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

                Column::name('wages.lokasi_bekerja')
                    ->label('Lokasi Bekerja'),

                Column::name('wages.no_kpj')
                    ->label('No KPJ')
                    ->searchable(),

                Column::name('name')
                    ->label('Nama Tenaga Kerja'),

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

                Column::name('latest_invoice.tagihan')
                    ->label('Total Iuran'),

                BooleanColumn::name('latest_invoice.status')
                    ->label('Status Iuran'),

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

        //Total Iuran
        $due = Invoice::where('user_id', $user->id)->latest('created_at')->first();

        if ($user->jenis_kepesertaan != 'jk') {
            // Nomor KPJ            
            $data = Wage::where('user_id', $user->id)->first();

            $card = new TemplateProcessor(storage_path('app/templates/iuran-upah.docx'));
            $card->setValues([
                'lokasi_bekerja' => $data->lokasi_bekerja,
                'no_kpj' => $data->no_kpj,
                'nama' => $user->name,
                'program' => $program,
                'total_iuran' => "Rp." . number_format($due->tagihan, 2, ',', '.'),
                'status' => ($due->status) ? 'Terbayar' : 'Belum Terbayar',
            ]);

            $file_name = 'Data Iuran ' . $data->no_kpj . '.docx';
            $card->saveAs($file_name);

            return response()->download(public_path($file_name))->deleteFileAfterSend();
        } else {
            // Nomor NPP
            $data = Construction::where('user_id', $user->id)->first();

            $card = new TemplateProcessor(storage_path('app/templates/iuran-jk.docx'));
            $card->setValues([
                'npp' => $data->npp,
                'nama_proyek' => $data->nama_proyek,
                'nama' => $user->name,
                'program' => $program,
                'total_iuran' => "Rp." . number_format($due->tagihan, 2, ',', '.'),
                'status' => ($due->status) ? 'Terbayar' : 'Belum Terbayar',
            ]);

            $file_name = 'Data Iuran ' . $data->npp . '.docx';
            $card->saveAs($file_name);

            return response()->download(public_path($file_name))->deleteFileAfterSend();
        }
    }
}

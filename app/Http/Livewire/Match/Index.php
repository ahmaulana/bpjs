<?php

namespace App\Http\Livewire\Match;

use App\Models\Construction;
use App\Models\User;
use App\Models\Wage;
use Carbon\Carbon;
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
            ->join($user_table, 'users.id', 'user_id')
            ->where('users.id', '!=', '1')->where('status', true)->orderBy('status', 'ASC')->orderBy('users.id', 'ASC');
    }

    public function columns()
    {
        if (Request::has('user')) {

            $columns = [

                Column::name('users.id')
                    ->label('ID'),

                Column::name('constructions.npp')
                    ->label('NPP')
                    ->searchable(),

                Column::name('constructions.nama_proyek')
                    ->label('Nama Proyek')
                    ->searchable(),

                Column::name('users.name')
                    ->label('Nama Pengguna')
                    ->searchable(),

                NumberColumn::name('constructions.nilai_proyek')
                    ->label('Nilai Proyek'),

                Column::callback(['users.program'], function ($prog) {
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

                Column::callback(['id', 'status'], function ($id, $status) {
                    return view('match-table-actions', ['id' => $id, 'status' => $status]);
                })
                    ->label('Aksi')
                    ->alignCenter(),
            ];
        } else {

            $columns = [

                Column::name('users.id')
                    ->label('ID'),

                Column::name('wages.no_kpj')
                    ->label('KPJ'),

                Column::name('wages.nik')
                    ->label('NIK')
                    ->searchable(),

                Column::name('name')
                    ->label('Nama')
                    ->searchable(),

                Column::name('wages.tempat_lahir')
                    ->label('Tempat Lahir'),

                DateColumn::name('wages.tgl_lahir')
                    ->label('Tanggal Lahir'),

                Column::callback(['jenis_kelamin'], function ($jk) {
                    if ($jk == 'l')
                        $gender = 'Laki-Laki';
                    else
                        $gender = 'Perempuan';
                    return $gender;
                })
                    ->label('Jenis Kelamin'),

                Column::callback(['users.program'], function ($prog) {
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

                Column::callback(['id', 'status'], function ($id, $status) {
                    return view('match-table-actions', ['id' => $id, 'status' => $status]);
                })
                    ->label('Aksi')
                    ->alignCenter(),
            ];
        }

        return $columns;
    }

    public function print($id)
    {
        $data = User::findOrFail($id);
        if ($data->status) {
            if ($data->jenis_kepesertaan != 'jk') {

                // Nomor KPJ
                $user = Wage::where('user_id', $data->id)->first();

                $card = new TemplateProcessor(storage_path('app/templates/upah.docx'));
                $card->setValues([
                    'nama' => $data->name,
                    'no' => $user->no_kpj,
                    'tgl' => Carbon::now()->format('m-Y'),
                ]);

                $file_name = 'Kartu ' . $user->no_kpj . '.docx';
                $card->saveAs($file_name);

                return response()->download(public_path($file_name))->deleteFileAfterSend();
            } else {
                // Nomor NPP
                $user = Construction::where('user_id', $data->id)->first();

                $card = new TemplateProcessor(storage_path('app/templates/jasa-konstruksi.docx'));
                $card->setValues([
                    'nama' => $data->name,
                    'no' => $user->npp_pelaksana,
                    'alamat' => $user->alamat_proyek,
                ]);

                $file_name = 'Kartu ' . $user->npp_pelaksana . '.docx';
                $card->saveAs($file_name);

                return response()->download(public_path($file_name))->deleteFileAfterSend();
            }
        }
    }
}

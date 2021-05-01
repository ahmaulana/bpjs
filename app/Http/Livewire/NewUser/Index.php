<?php

namespace App\Http\Livewire\NewUser;

use App\Models\User;
use Illuminate\Support\Facades\Request;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;

class Index extends LivewireDatatable
{

    public function builder()
    {
        if (Request::has('user')) {

            $user_table = 'constructions';
        } else {

            $user_table = 'wages';
        }        

        return User::query()
            ->join($user_table, 'users.id', 'user_id')
            ->where('users.id', '!=', '1')->where('status', false);
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

                BooleanColumn::name('status')
                    ->label('Verifikasi'),

                Column::callback(['id', 'status'], function ($id, $status) {
                    return view('user-table-actions', ['id' => $id, 'status' => $status]);
                })
                    ->label('Aksi')
                    ->alignCenter(),
            ];
        } else {

            $columns = [

                Column::name('users.id')
                    ->label('ID'),

                Column::name('wage.nik')
                    ->label('NIK')
                    ->searchable(),

                Column::name('name')
                    ->label('Nama')
                    ->searchable(),

                Column::name('wage.tempat_lahir')
                    ->label('Tempat Lahir'),

                DateColumn::name('wage.tgl_lahir')
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

                BooleanColumn::name('status')
                    ->label('Verifikasi'),

                Column::callback(['id', 'status'], function ($id, $status) {
                    return view('user-table-actions', ['id' => $id, 'status' => $status]);
                })
                    ->label('Aksi')
                    ->alignCenter(),
            ];
        }

        return $columns;
    }
}

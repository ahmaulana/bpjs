<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class Index extends LivewireDatatable
{

    public function builder()
    {
        return User::query()
            ->where('id', '!=', '1');
    }

    public function columns()
    {
        $columns = [

            Column::name('id')
                ->label('ID'),

            Column::name('nik')
                ->label('NIK')
                ->searchable(),

            Column::name('name')
                ->label('Nama')
                ->searchable(),

            Column::name('tempat_lahir')
                ->label('Tempat Lahir'),

            DateColumn::name('tgl_lahir')
                ->label('Tanggal Lahir'),

            Column::callback(['jenis_kelamin'], function ($jk) {
                if ($jk == 'l')
                    $gender = 'Laki-Laki';
                else
                    $gender = 'Perempuan';
                return $gender;
            })
                ->label('Jenis Kelamin'),

            Column::callback(['program'], function ($prog) {
                switch ($prog) {
                    case 'jht':
                        $program = 'Jaminan Hari Tua';
                        break;
                    case 'jkm':
                        $program = 'Jaminan Kematian';
                        break;
                    case 'jkk':
                        $program = 'Jaminan Kecelakaan Kerja';
                        break;
                    case 'jp':
                        $program = 'Jaminan Pensiun';
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

        return $columns;
    }
}

<?php

namespace App\Http\Livewire\Match;

use App\Models\Construction;
use App\Models\User;
use App\Models\Wage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
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

        if ($user->status) {
            if ($user->jenis_kepesertaan != 'jk') {

                // Nomor KPJ
                $data = Wage::where('user_id', $user->id)->first();

                $card = new TemplateProcessor(storage_path('app/templates/pemadanan-upah.docx'));
                $card->setValues([
                    'no_kpj' => $data->no_kpj,
                    'nik' => $data->nik,
                    'nama' => $user->name,
                    'tempat_lahir' => $data->tempat_lahir,
                    'tgl_lahir' => Carbon::parse($data->tgl_lahir)->isoFormat('D MMMM Y'),
                    'jenis_kelamin' => ($user->jenis_kelamin == 'l') ? 'Laki-Laki' : 'Perempuan',
                    'no_hp' => $user->no_hp,
                    'email' => $user->email,
                    'lokasi_bekerja' => $data->lokasi_bekerja,
                    'pekerjaan' => $data->pekerjaan,
                    'penghasilan' => $data->penghasilan,
                    'program' => $program,
                    'periode_pembayaran' => $data->periode_pembayaran,
                    'cabang' => $user->kantor_cabang,
                ]);

                $file_name = 'Pemadanan ' . $data->no_kpj . '.docx';
                $card->saveAs($file_name);

                return response()->download(public_path($file_name))->deleteFileAfterSend();
            } else {
                // Nomor NPP
                $data = Construction::where('user_id', $user->id)->first();

                $card = new TemplateProcessor(storage_path('app/templates/pemadanan-jk.docx'));
                $card->setValues([
                    'npp' => $data->npp_pelaksana,
                    'nama' => $user->name,
                    'jenis_kelamin' => ($user->jenis_kelamin == 'l') ? 'Laki-Laki' : 'Perempuan',
                    'no_hp' => $user->no_hp,
                    'email' => $user->email,
                    'program' => $program,
                    'nama_proyek' => $data->nama_proyek,
                    'alamat_proyek' => $data->alamat_proyek,
                    'cabang' => $user->kantor_cabang,
                    'nilai_proyek' => $data->nilai_proyek,
                    'sumber_pembiayaan' => $data->sumber_pembiayaan,
                    'jenis_pemilik' => $data->jenis_pemilik,
                    'nama_pemilik' => $data->nama_pemilik,
                    'npp_pelaksana' => $data->npp_pelaksana,
                    'no_spk' => $data->no_spk,
                    'masa_kontrak' => $data->masa_kontrak,
                    'masa_pemeliharaan' => Carbon::parse($data->masa_pemeliharaan)->isoFormat('D MMMM Y'),
                    'total_pekerja' => $data->total_pekerja,
                ]);

                $file_name = 'Pemadanan ' . $data->npp_pelaksana . '.docx';
                $card->saveAs($file_name);

                return response()->download(public_path($file_name))->deleteFileAfterSend();
            }
        }
    }

    public function delete($id)
    {
        $data = User::findOrFail($id);

        if ($data->jenis_kepesertaan != 'jk') {
            $data->delete();
        } else {
            $data->delete();
            return redirect(route('pemadanan.index') . '?user=jasa-konstruksi');
        }
    }
}

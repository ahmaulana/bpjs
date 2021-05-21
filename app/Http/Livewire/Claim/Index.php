<?php

namespace App\Http\Livewire\Claim;

use App\Models\Claim;
use App\Models\ConstructionClaim;
use App\Models\WageClaim;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use PhpOffice\PhpWord\TemplateProcessor;

class Index extends LivewireDatatable
{
    public function builder()
    {
        if (Request::has('user')) {
            $user_table = 'construction_claims';
        } else {
            $user_table = 'wage_claims';
        }

        return Claim::query()
            ->join($user_table, 'claims.id', 'claim_id')
            ->orderBy('status', 'ASC')->orderBy('claims.id', 'ASC');
    }

    public function columns()
    {
        if (Request::has('user')) {

            $columns = [

                Column::name('claims.id')
                    ->label('ID'),

                Column::name('construction_claims.npp')
                    ->label('NPP')
                    ->searchable(),

                Column::name('claims.nama')
                    ->label('Nama Pengguna'),

                Column::name('construction_claims.alamat_proyek')
                    ->label('Alamat_Proyek'),

                Column::callback(['claims.program'], function ($prog) {
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

                Column::name('claims.no_rekening')
                    ->label('No Rekening'),

                Column::name('claims.sebab_klaim')
                    ->label('Sebab Klaim'),

                BooleanColumn::name('status')
                    ->label('Verifikasi'),

                Column::callback(['id', 'status'], function ($id, $status) {
                    return view('claim-table-actions', ['id' => $id, 'status' => $status]);
                })
                    ->label('Aksi')
                    ->alignCenter(),
            ];
        } else {

            $columns = [

                Column::name('claims.id')
                    ->label('ID'),

                Column::name('wage_claims.no_kpj')
                    ->label('No KPJ')
                    ->searchable(),

                Column::name('claims.nama')
                    ->label('Nama Peserta')
                    ->searchable(),

                Column::name('wage_claims.tempat_lahir')
                    ->label('Tempat Lahir'),

                DateColumn::name('wage_claims.tgl_lahir')
                    ->label('Tanggal Lahir'),

                Column::name('wage_claims.alamat')
                    ->label('Alamat'),

                Column::callback(['claims.program'], function ($prog) {
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

                Column::name('claims.no_rekening')
                    ->label('No Rekening'),

                Column::name('claims.sebab_klaim')
                    ->label('Sebab Klaim'),

                BooleanColumn::name('status')
                    ->label('Verifikasi'),

                Column::callback(['id', 'status'], function ($id, $status) {
                    return view('claim-table-actions', ['id' => $id, 'status' => $status]);
                })
                    ->label('Aksi')
                    ->alignCenter(),
            ];
        }

        return $columns;
    }

    public function delete($id)
    {
        $data = Claim::findOrFail($id);

        if ($data->jenis_kepesertaan != 'jk') {
            $data->delete();
        } else {
            $data->delete();
            return redirect(route('klaim.index') . '?user=jasa-konstruksi');
        }
    }

    public function print($id)
    {
        $data = Claim::findOrFail($id);
        if ($data->status) {
            if ($data->jenis_kepesertaan != 'jk') {

                // Nomor KPJ
                $claim = WageClaim::where('claim_id', $data->id)->first();

                // Program
                switch ($data->program) {
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

                $card = new TemplateProcessor(storage_path('app/templates/klaim-upah.docx'));
                $card->setValues([
                    'no_kpj' => $claim->no_kpj,
                    'nama' => $data->nama,
                    'tempat_lahir' => $claim->tempat_lahir,
                    'tgl_lahir' => Carbon::parse($claim->tgl_lahir)->isoFormat('D MMMM Y'),
                    'nama_ibu' => $claim->nama_ibu,
                    'alamat' => $claim->alamat,
                    'kabupaten' => $claim->kabupaten,
                    'kecamatan' => $claim->kecamatan,
                    'no_hp' => $data->no_hp,
                    'email' => $data->email,
                    'program' => $program,
                    'bank' => $data->bank,
                    'no_rekening' => $data->no_rekening,
                    'sebab_klaim' => $data->sebab_klaim,
                ]);

                $file_name = 'Klaim ' . $claim->no_kpj . '.docx';
                $card->saveAs($file_name);

                return response()->download(public_path($file_name))->deleteFileAfterSend();
            } else {
                // Nomor NPP
                $claim = ConstructionClaim::where('claim_id', $data->id)->first();

                // Program
                switch ($data->program) {
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

                $card = new TemplateProcessor(storage_path('app/templates/klaim-jk.docx'));
                $card->setValues([
                    'npp' => $claim->npp,
                    'nama' => $data->nama,
                    'nama_proyek' => $claim->nama_proyek,
                    'alamat_proyek' => $claim->alamat_proyek,
                    'jenis_pemilik' => $claim->jenis_pemilik,
                    'nama_pemilik' => $claim->nama_pemilik,
                    'program' => $program,
                    'no_hp' => $data->no_hp,
                    'email' => $data->email,
                    'bank' => $data->bank,
                    'no_rekening' => $data->no_rekening,
                    'sebab_klaim' => $data->sebab_klaim,
                ]);

                $file_name = 'Klaim ' . $claim->npp . '.docx';
                $card->saveAs($file_name);

                return response()->download(public_path($file_name))->deleteFileAfterSend();
            }
        }
    }
}

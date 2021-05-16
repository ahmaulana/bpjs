<?php

namespace App\Http\Livewire\Recap;

use App\Models\RecapLetter;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Mediconesystems\LivewireDatatables\NumberColumn;
use PhpOffice\PhpWord\TemplateProcessor;

class Index extends LivewireDatatable
{
    public function builder()
    {
        return RecapLetter::query();
    }

    public function columns()
    {
        return [
            NumberColumn::name('npp')
                ->label('NPP')
                ->searchable(),

            NumberColumn::name('nama_perusahaan')
                ->label('Nama Perusahaan'),

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

            BooleanColumn::name('kop_surat')
                ->label('Kop Surat'),

            Column::callback(['id'], function ($id) {
                return view('recap-table-actions', ['id' => $id]);
            })
                ->label('Aksi')
                ->alignCenter(),

        ];
    }

    public function print($id)
    {
        $recap = RecapLetter::findOrFail($id);

        // Program
        switch ($recap->program) {
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

        $card = new TemplateProcessor(storage_path('app/templates/rekap.docx'));
        $card->setValues([
            'npp' => $recap->npp,
            'nama_perusahaan' => $recap->nama_perusahaan,
            'program' => $program,
            'kop_surat' => ($recap->kop_surat) ? 'Ada' : 'Tidak Ada',
            'materai' => ($recap->materai) ? 'Ada' : 'Tidak Ada',
            'ttd' => ($recap->ttd) ? 'Ada' : 'Tidak Ada',
            'rekening' => ($recap->rekening) ? 'Ada' : 'Tidak Ada',
            'pernyataan' => (isset($recap->pernyataan)) ? 'Ada' : 'Tidak Ada',
            'lampiran' => (isset($recap->lampiran)) ? 'Ada' : 'Tidak Ada',
        ]);

        $file_name = 'Rekap ' . $recap->npp . '.docx';
        $card->saveAs($file_name);

        return response()->download(public_path($file_name))->deleteFileAfterSend();
    }
}

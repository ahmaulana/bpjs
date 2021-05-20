<?php

namespace App\Http\Livewire\NewUser;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Wage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    public $data;
    public $user_id, $jenis_kepesertaan, $nik, $name, $tempat_lahir, $tgl_lahir, $jenis_kelamin, $no_hp, $lokasi_bekerja, $pekerjaan, $jam_kerja, $penghasilan, $program, $periode_pembayaran, $npp;

    public $nama_proyek, $alamat_proyek, $nilai_proyek, $sumber_pembiayaan, $jenis_pemilik, $nama_pemilik, $npp_pelaksana, $no_spk, $masa_kontrak, $total_pekerja, $cara_pembayaran;

    public $berkas_foto, $berkas_ktp, $berkas_kk, $berkas_buku_tabungan, $berkas_spk;

    protected $rules;
    protected $messages;

    public function mount()
    {
        $this->user_id = $this->data->user_id;
        $this->jenis_kepesertaan = $this->data->jenis_kepesertaan;
        $this->nik = $this->data->nik;
        $this->name = $this->data->name;
        $this->tempat_lahir = $this->data->tempat_lahir;
        $this->tgl_lahir = date('Y-m-d', strtotime($this->data->tgl_lahir));
        $this->jenis_kelamin = $this->data->jenis_kelamin;
        $this->no_hp = $this->data->no_hp;
        $this->lokasi_bekerja = $this->data->lokasi_bekerja;
        $this->pekerjaan = $this->data->pekerjaan;
        $this->jam_kerja = $this->data->jam_kerja;
        $this->penghasilan = $this->data->penghasilan;
        $this->program = $this->data->program;
        $this->periode_pembayaran = $this->data->periode_pembayaran;
        $this->berkas_foto = $this->data->berkas_foto;
        $this->berkas_ktp = $this->data->berkas_ktp;
        $this->berkas_kk = $this->data->berkas_kk;
        $this->berkas_buku_tabungan = $this->data->berkas_buku_tabungan;

        $this->npp = $this->data->npp;
        $this->nama_proyek = $this->data->nama_proyek;
        $this->alamat_proyek = $this->data->alamat_proyek;
        $this->nilai_proyek = $this->data->nilai_proyek;
        $this->sumber_pembiayaan = $this->data->sumber_pembiayaan;
        $this->jenis_pemilik = $this->data->jenis_pemilik;
        $this->nama_pemilik = $this->data->nama_pemilik;
        $this->npp_pelaksana = $this->data->npp_pelaksana;
        $this->no_spk = $this->data->no_spk;
        $this->masa_kontrak = $this->data->masa_kontrak;
        $this->total_pekerja = $this->data->total_pekerja;
        $this->cara_pembayaran = $this->data->cara_pembayaran;
        $this->berkas_spk = $this->data->dokumen_spk;
    }

    public function render()
    {
        return view('livewire.new-user.edit');
    }

    public function download($file, $name)
    {
        $path = storage_path('app/berkas-peserta/' . $file);
        return response()->download($path, $name);
    }

    public function update()
    {
        $user = User::findOrFail($this->user_id);

        // Program
        switch ($user->program) {
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

        if ($this->jenis_kepesertaan != 'jk') {
            $this->rules = [
                'nik' => ['required', 'numeric', 'digits:16', 'unique:wages,nik,' . $this->data->id],
                'name' => ['required'],
                'jenis_kelamin' => ['required'],
                'tempat_lahir' => ['required'],
                'tgl_lahir' => ['required', 'date', 'before:today'],
                'no_hp' => ['required', 'unique:users,no_hp,' . $this->user_id],
                'lokasi_bekerja' => ['required'],
                'pekerjaan' => ['required'],
                'jam_kerja' => ['required'],
                'penghasilan' => ['required'],
                'program' => ['required'],
                'periode_pembayaran' => ['required'],
            ];
            $this->messages = [
                'nik.required' => ':attribute tidak boleh kosong!',
                'nik.digits' => ':attribute tidak valid, silahkan cek kembali!',
                'nik.unique' => 'NIK sudah terdaftar!',
                'no_hp.unique' => 'Nomor sudah terdaftar!',
                'name.required' => 'Nama tidak boleh kosong!',
                'tempat_lahir.required' => 'Tempat lahir tidak boleh kosong!',
                'tgl_lahir.required' => 'Tanggal lahir tidak boleh kosong!',
                'tgl_lahir.before' => 'Tanggal lahir harus tanggal sebelum hari ini!',
                'lokasi_bekerja.required' => 'Lokasi bekerja tidak boleh kosong!',
                'penghasilan.required' => 'Penghasilan tidak boleh kosong!',
                'jam_kerja.required' => 'Jam kerja tidak boleh kosong!',
                'pekerjaan.required' => 'Pekerjaan tidak boleh kosong!',
                'program.required' => 'Program tidak boleh kosong!',
                'periode_pembayaran.required' => 'Periode pembayaran tidak boleh kosong!',
            ];
            $update = $this->validate();

            DB::transaction(function () use ($user, $persentase, $update) {
                //Update Users Table                
                $user->name = $update['name'];
                $user->no_hp = $update['no_hp'];
                $user->jenis_kelamin = $update['jenis_kelamin'];
                $user->program = $update['program'];
                $user->status = true;
                $user->save();

                //Get Random Number
                do {
                    $no_kpj = mt_rand(10000000000, 99999999999);
                } while (Wage::where('no_kpj', $no_kpj)->exists());

                //Update Wages Table            
                $user->wage()->update([
                    'nik' => $update['nik'],
                    'no_kpj' => $no_kpj,
                    'tempat_lahir' => $update['tempat_lahir'],
                    'tgl_lahir' => $update['tgl_lahir'],
                    'lokasi_bekerja' => $update['lokasi_bekerja'],
                    'pekerjaan' => $update['pekerjaan'],
                    'jam_kerja' => $update['jam_kerja'],
                    'penghasilan' => $update['penghasilan'],
                    'periode_pembayaran' => $update['periode_pembayaran'],
                ]);

                //Invoice
                $tagihan = $update['penghasilan'] * $persentase / 100;

                Invoice::create([
                    'user_id' => $user->id,
                    'tagihan' => $tagihan,
                    'status' => true,
                ]);
            });
            return redirect(route('peserta-baru.index'));
        } else {
            $this->rules = [
                'npp' => ['required', 'numeric', 'digits:6', 'unique:constructions,npp,' . $this->data->id],
                'name' => ['required'],
                'jenis_kelamin' => ['required'],
                'no_hp' => ['required', 'unique:users,no_hp,' . $this->user_id],
                'program' => ['required'],
                'nama_proyek' => ['required'],
                'alamat_proyek' => ['required'],
                'nilai_proyek' => ['required'],
                'sumber_pembiayaan' => ['required'],
                'jenis_pemilik' => ['required'],
                'nama_pemilik' => ['required'],
                'npp_pelaksana' => ['required'],
                'no_spk' => ['required'],
                'masa_kontrak' => ['required'],
                'total_pekerja' => ['required'],
                'cara_pembayaran' => ['required'],
            ];
            $this->messages = [
                'npp.required_if' => 'Nomor NPP tidak boleh kosong!',
                'npp.digits' => 'Nomor NPP tidak valid!',
                'npp.unique' => 'NPP sudah terdaftar!',
                'no_hp.unique' => 'Nomor sudah terdaftar!',
                'name.required' => 'Nama tidak boleh kosong!',
                'program.required' => 'Program tidak boleh kosong!',
                'nama_proyek.required' => 'Nama proyek tidak boleh kosong!',
                'alamat_proyek.required' => 'Alamat proyek tidak boleh kosong!',
                'nilai_proyek.required' => 'Nilai proyek tidak boleh kosong!',
                'sumber_pembiayaan.required' => 'Sumber pembiayaan tidak boleh kosong!',
                'jenis_pemilik.required' => 'Jenis pemilik tidak boleh kosong!',
                'nama_pemilik.required' => 'Nama pemilik tidak boleh kosong!',
                'npp_pelaksana.required' => 'NPP pelaksana tidak boleh kosong!',
                'no_spk.required' => 'No SPK tidak boleh kosong!',
                'masa_kontrak.required' => 'Masa kontrak tidak boleh kosong!',
                'total_pekerja.required' => 'Total pekerja tidak boleh kosong!',
                'cara_pembayaran.required' => 'Cara pembayaran tidak boleh kosong!',
            ];
            $update = $this->validate();

            DB::transaction(function () use ($persentase, $update) {
                //Update Users Table
                $user = User::findOrFail($this->user_id);
                $user->name = $update['name'];
                $user->no_hp = $update['no_hp'];
                $user->jenis_kelamin = $update['jenis_kelamin'];
                $user->program = $update['program'];
                $user->status = true;
                $user->save();

                //Update Wages Table                
                $user->construction()->update([
                    'npp' => $update['npp'],
                    'nama_proyek' => $update['nama_proyek'],
                    'alamat_proyek' => $update['alamat_proyek'],
                    'nilai_proyek' => $update['nilai_proyek'],
                    'sumber_pembiayaan' => $update['sumber_pembiayaan'],
                    'jenis_pemilik' => $update['jenis_pemilik'],
                    'nama_pemilik' => $update['nama_pemilik'],
                    'npp_pelaksana' => $update['npp_pelaksana'],
                    'no_spk' => $update['no_spk'],
                    'masa_kontrak' => $update['masa_kontrak'],
                    'masa_pemeliharaan' => Carbon::now()->addYears($update['masa_kontrak']),
                    'total_pekerja' => $update['total_pekerja'],
                    'cara_pembayaran' => $update['cara_pembayaran'],
                ]);

                //Invoice
                $tagihan = $update['nilai_proyek'] * $persentase / 100;

                Invoice::create([
                    'user_id' => $user->id,
                    'tagihan' => $tagihan,
                ]);
            });
            return redirect(route('peserta-baru.index') . '?user=jasa-konstruksi');
        }
    }
}

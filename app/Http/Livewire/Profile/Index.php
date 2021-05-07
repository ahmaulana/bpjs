<?php

namespace App\Http\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Index extends Component
{
    public $user, $data, $name, $tempat_lahir, $tgl_lahir, $no_hp, $lokasi_bekerja, $pekerjaan, $jam_kerja, $email, $penghasilan, $periode_pembayaran;

    // Variabel Jasa Konstruksi
    public $nama_proyek, $alamat_proyek, $jenis_pemilik, $nama_pemilik, $total_pekerja;
    //Validation
    protected $rules;

    public function mount()
    {
        $this->user = auth()->user();
        $this->data = $this->user->jenis_kepesertaan != 'jk' ? $this->user->wage : $this->user->construction;

        $this->name = $this->user->name;
        $this->no_hp = $this->user->no_hp;
        $this->email = $this->user->email;

        if ($this->user->jenis_kepesertaan != 'jk') {
            $this->tempat_lahir = $this->data->tempat_lahir;
            $this->tgl_lahir = date('Y-m-d', strtotime($this->data->tgl_lahir));
            $this->lokasi_bekerja = $this->data->lokasi_bekerja;
            $this->pekerjaan = $this->data->pekerjaan;
            $this->jam_kerja = $this->data->jam_kerja;
            $this->penghasilan = $this->data->penghasilan;
            $this->periode_pembayaran = $this->data->periode_pembayaran;
        } else {
            $this->nama_proyek = $this->data->nama_proyek;
            $this->alamat_proyek = $this->data->alamat_proyek;
            $this->jenis_pemilik = $this->data->jenis_pemilik;
            $this->nama_pemilik = $this->data->nama_pemilik;
            $this->total_pekerja = $this->data->total_pekerja;
        }
    }

    public function render()
    {
        return view('livewire.profile.index');
    }

    public function update_wage()
    {
        $this->rules = [
            'name' => ['required'],
            'no_hp' => ['required', 'unique:users,no_hp,' . $this->user->id],
            'email' => ['required', 'unique:users,email,' . $this->user->id],
            'tempat_lahir' => ['required'],
            'tgl_lahir' => ['required'],
            'lokasi_bekerja' => ['required'],
            'pekerjaan' => ['required'],
            'jam_kerja' => ['required'],
            'penghasilan' => ['required'],
            'periode_pembayaran' => ['required'],
        ];
        $data = $this->validate();
        DB::transaction(function () use ($data) {

            //Update user table
            $user = $this->user;            
            $user->name = $data['name'];
            $user->no_hp = $data['no_hp'];
            $user->email = $data['email'];
            $user->save();        

            //Update Wages Table            
            $user->wage()->update([                                
                'tempat_lahir' => $data['tempat_lahir'],
                'tgl_lahir' => $data['tgl_lahir'],
                'lokasi_bekerja' => $data['lokasi_bekerja'],
                'pekerjaan' => $data['pekerjaan'],
                'jam_kerja' => $data['jam_kerja'],
                'penghasilan' => $data['penghasilan'],
                'periode_pembayaran' => $data['periode_pembayaran'],
            ]);
        });
    }

    public function update_construction()
    {
        $this->rules = [
            'name' => ['required'],
            'no_hp' => ['required', 'unique:users,no_hp,' . $this->user->id],
            'email' => ['required', 'unique:users,email,' . $this->user->id],
            'nama_proyek' => ['required'],
            'alamat_proyek' => ['required'],
            'jenis_pemilik' => ['required'],
            'nama_pemilik' => ['required'],
            'total_pekerja' => ['required'],
        ];
        $data = $this->validate();
        DB::transaction(function () use ($data) {

            //Update user table
            $user = $this->user;            
            $user->name = $data['name'];
            $user->no_hp = $data['no_hp'];
            $user->email = $data['email'];
            $user->save();        

            //Update Wages Table            
            $user->construction()->update([                                
                'nama_proyek' => $data['nama_proyek'],
                'alamat_proyek' => $data['alamat_proyek'],
                'jenis_pemilik' => $data['jenis_pemilik'],
                'nama_pemilik' => $data['nama_pemilik'],
                'total_pekerja' => $data['total_pekerja'],                
            ]);
        });
    }
}

<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {        
        $user = auth()->user();
        $data = $user->jenis_kepesertaan != 'jk' ? $user->wage : $user->construction;
        
        return view('components.profile.index', compact(['user','data']));
    }

    public function store()
    {
        $update = request()->validate([
            'name' => ['required'],
            'tempat_lahir' => ['required'],
            'tgl_lahir' => ['required','date','before:today'],
            'no_hp' => ['required', 'unique:users,no_hp,' . auth()->user()->id],
            'lokasi_bekerja' => ['required'],
            'pekerjaan' => ['required'],
            'jam_kerja' => ['required'],
            'email' => ['required','email', 'unique:users,email,' . auth()->user()->id],
            'penghasilan' => ['required','numeric'],
            'periode_pembayaran' => ['required'],
        ]);
        $user = User::findOrFail(auth()->user()->id)->update($update);
        
        return redirect()->route('update-profile.index');
    }
}

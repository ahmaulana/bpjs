<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $pu = User::where('jenis_kepesertaan','pu')->count();
        $bpu = User::where('jenis_kepesertaan','bpu')->count();
        $jk = User::where('jenis_kepesertaan','jk')->count();
        return view('admin.dashboard', compact(['pu','bpu','jk']));
    }
}

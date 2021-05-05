<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\User;
use Illuminate\Http\Request;

class ClaimController extends Controller
{

    public function index()
    {        
        return view('components.claim.index');
    }

    public function show($id)
    {
        $user = Claim::findOrFail($id);
        if ($user->jenis_kepesertaan != 'jk') {
            $user_table = 'wage_claims';
        } else {
            $user_table = 'construction_claims';
        }

        $data = Claim::join($user_table, 'claims.id', 'claim_id')->where('claims.id', $id)->first();                

        return view('components.claim.show', compact(['data']));
    }

    public function form()
    {        
        $user = auth()->user();
        if($user->jenis_kepesertaan != 'jk'){
            return view('components.claim.form', compact(['user']));
        }
        return view('components.claim.form-jk', compact(['user']));
    }
}

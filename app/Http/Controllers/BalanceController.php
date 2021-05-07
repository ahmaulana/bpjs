<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BalanceController extends Controller
{
    public function check()
    {        
        return view('components.balance.check');
    }
}

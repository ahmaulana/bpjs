<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DueController extends Controller
{
    public function index()
    {
        return view('components.due.index');
    }
    
    public function card()
    {     
        return view('components.due.card');
    }
}

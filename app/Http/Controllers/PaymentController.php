<?php

namespace App\Http\Controllers;

use App\Models\Construction;
use App\Models\Invoice;
use App\Models\Wage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function card()
    {        
        return view('components.payment.card');
    }
}

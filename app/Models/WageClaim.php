<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WageClaim extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }
}

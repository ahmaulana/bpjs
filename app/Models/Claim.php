<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function wage_claim()
    {
        return $this->hasOne(WageClaim::class);
    }

    public function construction_claim()
    {
        return $this->hasOne(ConstructionClaim::class);
    }
}

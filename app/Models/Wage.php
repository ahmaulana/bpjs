<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wage extends Model
{
    use HasFactory;    
    protected $guarded = [];
    protected $hidden = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

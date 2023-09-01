<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JalurDaftar extends Model
{
    use HasFactory;  
    protected $guarded = [];

    //belongs to many shift
    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'jalur_daftars_shifts', 'jalur_daftars_id', 'shifts_id');
    }
   
}

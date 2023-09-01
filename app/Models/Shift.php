<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    protected $guarded = [];

    //has many jalur daftar
    public function jalurDaftars()
    {
        return $this->belongsToMany(JalurDaftar::class, 'jalur_daftars_shifts', 'shifts_id', 'jalur_daftars_id');
    }
}

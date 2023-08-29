<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;
    //guarded
    protected $guarded = [];

    //has one to DataDaftar
    public function dataDaftar()
    {
        return $this->hasOne(DataDaftar::class);
    }
}

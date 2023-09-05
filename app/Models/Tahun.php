<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahun extends Model
{
    use HasFactory;
    //guarded
    protected $guarded = [];

    //has many DataDaftar
    public function dataDaftars()
    {
        return $this->hasMany(DataDaftar::class);
    }
}

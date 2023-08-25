<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pindahan extends Model
{
    use HasFactory;
    //guarded
    protected $guarded = [];

    //belong to user
    public function user()
    {
        
        return $this->belongsTo(User::class);
    }

}

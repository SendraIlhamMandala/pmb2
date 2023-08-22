<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPribadi extends Model
{
    use HasFactory;
    
    //guarded = " "
    protected $guarded = [];

    // belongsTo one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

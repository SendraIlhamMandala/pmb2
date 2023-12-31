<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faktur extends Model
{
    use HasFactory;
    protected $guarded = [];

    //belongs to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
    use HasFactory;

    protected $guarded = [];

    //belongs to user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

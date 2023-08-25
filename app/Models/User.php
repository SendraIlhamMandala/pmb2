<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //has one DataPribadi
    public function dataPribadi()   {
        return $this->hasOne(DataPribadi::class);
    }

    //has one alamat
    public function alamat()   {
        return $this->hasOne(Alamat::class);
    }

    //has one asal_sekolah
    public function asalSekolah()   {
        
        return $this->hasOne(AsalSekolah::class);
    }

    //has one pindahan
    public function pindahan()   {
        
        return $this->hasOne(Pindahan::class);
    }

}

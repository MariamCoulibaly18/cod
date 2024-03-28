<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    //use is for traits in php ,traits are used to declare methods that can be used in multiple classes
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'descreption',
        'profile'
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
    ];

    /**
     * Get the boutiques for the user.
     */
    public function boutiques(){
        return $this->hasMany(Boutique::class);
    }
    public function livreurs(){
        return $this->hasMany(Livreur::class);
    }
     public function depenses()
    {
        return $this->hasMany(Depense::class);
    }
    public function notifications()
    {
        return $this->belongsToMany(Notification::class);
    }
}

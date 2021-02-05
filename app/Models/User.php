<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
<<<<<<< HEAD
        'role_id',
=======
>>>>>>> 8f9de2fcbc92b00e54b8f91ce7318c52e5b542f0
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

<<<<<<< HEAD
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task');
=======
    public function tasks()
    {
        $this->hasMany('App\Models\Task');
>>>>>>> 8f9de2fcbc92b00e54b8f91ce7318c52e5b542f0
    }
}

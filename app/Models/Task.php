<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'status'
    ];

    public function user()
    {
<<<<<<< HEAD
        return $this->belongsToMany('App\Model\User');
=======
        $this->belongsTo('App\Model\User');
>>>>>>> 8f9de2fcbc92b00e54b8f91ce7318c52e5b542f0
    }
}

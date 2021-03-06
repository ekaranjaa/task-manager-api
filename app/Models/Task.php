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
        'assigned_on',
        'closed_on',
        'status'
    ];

    public function user()
    {
        $this->hasMany('App\Model\User');
    }
}

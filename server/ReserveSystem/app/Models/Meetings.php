<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meetings extends Model
{
    protected $fillable = [
        'title',
        'description',
        'meeting_url',
        'join_url',
        'create_user_id',
    ];

    public function create_user()
    {
        return $this->belongTo('App\User', 'create_user_id');
    }
}

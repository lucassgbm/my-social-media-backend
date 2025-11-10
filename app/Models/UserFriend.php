<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFriend extends Model
{
    protected $table = 'user_friends';

    protected $fillable = [
        'user_id',
        'user_id',
    ];

}

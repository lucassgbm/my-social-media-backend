<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasUuids;

    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'description',
        'photo_path'
    ];

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function likes(){
        return $this->hasMany(PostLike::class, 'post_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id', 'id');
    }

}

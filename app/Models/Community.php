<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $table = 'communities';

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'owner_id',
        'photo'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function events()
    {
        return $this->hasMany(CommunityEvent::class, 'community_id', 'id');
    }
}

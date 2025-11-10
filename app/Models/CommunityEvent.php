<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityEvent extends Model
{
    protected $table = 'community_events';

    protected $fillable = [
        'title',
        'description',
        'date_start',
        'date_end',
        'time_start',
        'time_end',
        'local',
        'photo',
        'link',
        'community_id',
    ];

    public function community()
    {
        return $this->belongsTo(Community::class, 'community_id', 'id');
    }
}

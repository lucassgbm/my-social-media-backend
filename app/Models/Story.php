<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasUuids;

    protected $fillable = ["user_id", "uuid", "description", "photo_path", "status"];

    protected $table = "stories";

    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

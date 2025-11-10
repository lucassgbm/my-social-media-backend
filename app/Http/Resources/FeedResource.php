<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"                => $this->id,
            "created_at"        => Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->diffForHumans(),
            "description"       => $this->description,
            "photo_path"        => $this->photo_path
            ? Storage::disk('r2')->temporaryUrl(
                $this->photo_path,
                now()->addMinutes(10) // URL válida por 10 minutos
            )
            : null,
            "user"              => [
                "name"          => $this->user->name,
                "photo"         => $this->user->photo
                ? Storage::disk('r2')->temporaryUrl(
                    $this->user->photo,
                    now()->addMinutes(10) // URL válida por 10 minutos
                )
                : null,
            ],
            "likes"             => [
                "count"         => $this->likes()->count()
            ],
            "comments"          => [
                "count"         => $this->comments()->count(),
                "comment"       => $this->comments
            ],
        ];
    }
}

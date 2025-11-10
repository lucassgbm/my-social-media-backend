<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserPhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "photo_path" => $this->photo_path ?
                Storage::disk('r2')->temporaryUrl(
                    $this->photo_path,
                    now()->addMinutes(10)
                )
                : null,
            "created_at" => $this->created_at->format('d/m/Y - H:i')
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'autodescription'   => $this->autodescription,
            'email'             => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'age'               => $this->age,
            'uf'                => $this->uf,
            'city'              => $this->city,
            'birthdate'         => $this->birthdate,
            'phone'             => $this->phone,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'photo_url'             => $this->photo,
            'photo' => $this->photo
                ? Storage::disk('r2')->temporaryUrl(
                    $this->photo,
                    now()->addMinutes(10) // URL válida por 10 minutos
                )
                : null,
        ];
    }
}

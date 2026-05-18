<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $hasLocation = $this->relationLoaded('location') && $this->location;

        $locationData = [
            'level1' => $hasLocation ? $this->location->level1 : '',
            'level2' => $hasLocation ? $this->location->level2 : '',
            'level3' => $hasLocation ? $this->location->level3 : '',
            'detail' => $hasLocation ? $this->location->detail : '',
        ];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'gender' => $this->gender,
            'field' => $this->field,
            'slogan' => $this->slogan,
            'about_me' => $this->about_me,
            'avatar' => $this->avatar,
            'facebook_link' => $this->facebook_link,
            'linkedin_link' => $this->linkedin_link,
            'github_link' => $this->github_link,
            'location' => $locationData,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

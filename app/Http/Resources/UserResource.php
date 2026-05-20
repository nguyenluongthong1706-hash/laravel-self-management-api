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
            'province' => $hasLocation ? $this->location->province : '',
            'district' => $hasLocation ? $this->location->district : '',
            'ward' => $hasLocation ? $this->location->ward : '',
            'detail' => $hasLocation ? $this->location->detail : '',
        ];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'dateOfBirth' => $this->date_of_birth,
            'gender' => $this->gender,
            'field' => $this->field,
            'slogan' => $this->slogan,
            'aboutMe' => $this->about_me,
            'avatar' => $this->avatar,
            'facebookLink' => $this->facebook_link,
            'linkedinLink' => $this->linkedin_link,
            'githubLink' => $this->github_link,
            'location' => $locationData,
        ];
    }
}

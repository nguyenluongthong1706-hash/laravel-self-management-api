<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $productLinks = collect($this->links)->map(function ($link) {
            return [
                'id' => $link->id,
                'title' => $link->title,
                'url' => $link->url,
            ];
        });

        $productTechs = collect($this->techs)->map(function ($tech) {
            return [
                'id' => $tech->id,
                'name' => $tech->name,
                'icon' => $tech->icon,
            ];
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'task' => $this->task,
            'image' => $this->image,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'userId' => $this->user_id,
            'productLinks' => $productLinks,
            'productTechs' => $productTechs,
        ];
    }
}

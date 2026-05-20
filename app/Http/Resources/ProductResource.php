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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'task' => $this->task,
            'image' => $this->image,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'userId' => $this->user_id,
            'productLinks' => $this->links,
            'productTechs' => $this->techs,
        ];
    }
}

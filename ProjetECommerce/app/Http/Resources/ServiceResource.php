<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->resource->id,
            'user_id' => new UserResource($this->resource->user),
            'name' => $this->resource->name,
            'cost' => $this->resource->cost,
            'area' => $this->resource->area,
        ];
    }
}

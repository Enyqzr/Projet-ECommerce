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
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'price' => $this->resource->price,
            'description' => $this->resource->description,
            'category' => new CategoryResource($this->resource->category),
            'quantity' => $this->whenPivotLoaded('orders_products', function () {
                return $this->pivot->quantity;
            }),
            'sum_products' => $this->whenPivotLoaded('orders_products', function () {
                return $this->pivot->quantity * $this->resource->price;
            })
        ];
    }
}

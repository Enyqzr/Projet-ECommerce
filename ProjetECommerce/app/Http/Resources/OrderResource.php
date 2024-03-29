<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $order_sum = null;
        foreach ($this->resource->products as $product) {
            $order_sum += $product->price * $product->pivot->quantity;
        }
        return [
            'id'=> $this->resource->id,
            'date'=> $this->resource->date,
            'user_id' => new UserResource($this->resource->user),
            'products' => ProductResource::collection($this->resource->products),
            'order_sum'=> $order_sum,
            'service_id'=> new ServiceResource($this->resource->service),
        ];
    }
}

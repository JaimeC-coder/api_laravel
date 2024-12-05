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
            'productId' => $this->productId,
            'productName' => $this->productName,
            'productStockMin' => $this->productStockMin,
            'productDescription' => $this->productDescription,
            'productPricePurchase' => $this->productPricePurchase,
            'category' => new CategoryResource($this->category)
        ];
    }
}

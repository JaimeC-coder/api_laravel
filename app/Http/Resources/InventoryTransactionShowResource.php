<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryTransactionShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'inventoryId' => $this->inventoryId,
            'inventoryTransactionId' => $this->inventoryTransactionId,
            'transactionCount' =>number_format($this->transactionCount,2,'.',''),
            'transactionClase' => $this->transactionClase,
            'transactionType' => $this->transactionType,
            'transactionDate' => $this->transactionDate,
            'productUnitPriceId' => $this->productUnitPrice->product->productName,
        ];
    }
}

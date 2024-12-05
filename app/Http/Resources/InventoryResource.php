<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
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
            'currentStock' => $this->currentStock,
            'isBox' => $this->isBox,
            // 'input' => number_format($this->inventoryTransactions->where('transactionType', 'input')->sum('transactionCount'),2,'.',''),
            // 'output' => number_format($this->inventoryTransactions->where('transactionType', 'output')->sum('transactionCount'),2,'.',''),
        ];
    }
}

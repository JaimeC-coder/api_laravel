<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoryTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'inventoryTransactionId' => $this->inventoryTransactionId,
            'transactionType' => $this->transactionType == "output" ? "Salida" : "Entrada",
            'transactionClase' => $this->transactionClase == "purchase" ? "Compra" : ($this->transactionClase == "sale" ? "Venta" : "Producción"),

            'transactionDate' => Carbon::parse($this->transactionDate)->format('d-m-Y'),
            'transactionCount' => $this->transactionCount,
            'productName' => $this->productUnitPrice->product->productName,
        ];
    }
}

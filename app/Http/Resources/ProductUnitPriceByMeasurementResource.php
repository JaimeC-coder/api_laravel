<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductUnitPriceByMeasurementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Agrupamos los inventarios por `isBox`
        $groupedInventories = $this->inventories
            ->groupBy('isBox') // Agrupa según el valor de isBox
            ->map(function ($group, $key) {
                // Suma el stock de cada grupo
                return [
                    'isBox' => (bool)$key, // True o False
                    'currentStock' => $group->sum('currentStock'), // Suma los stocks
                ];
            });

        // Aseguramos que ambos valores (true y false) existan en el resultado
        $groupedInventories = collect([
            ['isBox' => true, 'currentStock' => 0],  // Por defecto para true
            ['isBox' => false, 'currentStock' => 0] // Por defecto para false
        ])->map(function ($default) use ($groupedInventories) {
            // Sobrescribe con los valores existentes si están presentes
            return $groupedInventories->firstWhere('isBox', $default['isBox']) ?? $default;
        });
        return [
            'productUnitPriceId' => $this->productUnitPriceId,
            'price' => $this->price,
            'effectiveDate' => $this->effectiveDate,
            'unitMeasurement' => new  UnitMeasurementResource($this->unitMeasurement),
            'product' => new  ProductResource($this->product),
            'inventories' => $groupedInventories,
        ];
    }
}

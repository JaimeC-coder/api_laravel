<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitMeasurement extends Model
{
    use HasFactory, SoftDeletes;


    protected $primaryKey = 'unitMeasurementId';
    protected $fillable = [
        'unitName',
        'abbreviation',
        'description'
    ];

    //inventory_transactions
    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'unitMeasurementId', 'unitMeasurementId');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_unit_price_by_measurements')
                    ->using(ProductUnitPriceByMeasurement::class) // Indicando que use el modelo pivote
                    ->withPivot('price', 'effectiveDate') // Los campos adicionales
                    ->withTimestamps();
    }
}

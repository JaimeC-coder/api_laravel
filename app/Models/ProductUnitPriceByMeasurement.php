<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use function Illuminate\Log\log;

class ProductUnitPriceByMeasurement extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_unit_price_by_measurements';
    protected $primaryKey = 'productUnitPriceId';
    protected $fillable = [
        'productId',
        'unitMeasurementId',
        'price',
        'effectiveDate'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId', 'productId');
    }

    public function unitMeasurement()
    {
        return $this->belongsTo(UnitMeasurement::class, 'unitMeasurementId', 'unitMeasurementId');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'productUnitPriceId', 'productUnitPriceId');
    }
}

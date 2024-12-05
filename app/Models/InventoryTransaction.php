<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryTransaction extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'inventory_transactions';
    protected $primaryKey = 'inventoryTransactionId';

    protected $fillable = [
        'productUnitPriceId',
        'userId',
        'transactionType',
        'transactionCount',
        'transactionClase',
        'transactionDate'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId', 'productId');

    }
    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventoryId', 'inventoryId');
    }

    public function productUnitPrice()
    {
        return $this->belongsTo(ProductUnitPriceByMeasurement::class, 'productUnitPriceId', 'productUnitPriceId');
    }

    public function unitMeasurement()
    {
        return $this->belongsTo(UnitMeasurement::class, 'unitMeasurementId', 'unitMeasurementId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}

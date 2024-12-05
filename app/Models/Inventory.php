<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'stockProductbyMedie';
    protected $primaryKey = 'inventoryId';
    protected $fillable = [
        'productUnitPriceId',
        'currentStock',
        'isBox'
    ];

    public function productUnitPrice()
    {
        return $this->belongsTo(ProductUnitPriceByMeasurement::class, 'productUnitPriceId', 'productUnitPriceId');
    }

    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'inventoryId', 'inventoryId');
    }

}

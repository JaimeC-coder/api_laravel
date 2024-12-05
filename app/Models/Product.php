<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'productId';
    protected $fillable = [
        'productName',
        'productStockMin',
        'productDescription',
        'categoryId'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'categoryId');
    }

    //inventory
    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'productId', 'productId');
    }

    //unitPrices
    public function unitPrices()
    {
        return $this->belongsToMany(UnitMeasurement::class,'product_unit_price_by_measurements')
        ->using(ProductUnitPriceByMeasurement::class)
        ->withPivot('price', 'effectiveDate')
        ->withTimestamps();

    }
    public function productUnitPrices()
    {
        return $this->hasMany(ProductUnitPriceByMeasurement::class, 'productId', 'productId');
    }


    //inventory_transactions
    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'productId', 'productId');
    }






    // unit_measurements
    // product_unit_price_by_measurements

    // public function sales()
    // {
    //     return $this->belongsToMany(Sale::class, 'sale_details', 'productId', 'saleId')->withPivot('productQuantity', 'productPrice');
    // }
}

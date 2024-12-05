<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shoppingDetail extends Model
{
    use HasFactory;

    protected $table = 'shoppingDetails';
    protected $primaryKey = 'shoppingDetailId';


    protected $fillable = [
        'shoppingId',
        'productUnitPriceId',
        'quantity',
        'priceByUnit',
        'total'
    ];

    public function shopping()
    {
        return $this->belongsTo(shopping::class, 'shoppingId', 'shoppingId');
    }

    public function productUnitPrice()
    {
        return $this->belongsTo(ProductUnitPriceByMeasurement::class, 'productUnitPriceId', 'productUnitPriceId');
    }

    
}

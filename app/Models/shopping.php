<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shopping extends Model
{
    use HasFactory;

    protected $table = 'shoppings';
    protected $primaryKey = 'shoppingId';
    protected $fillable = [
        'userId',
        'shoppingDate',
        'name',
        'email',
        'address',
        'phone',
        'bankInfoNo',
        'bankInfoName',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function shoppingDetails()
    {
        return $this->hasMany(ShoppingDetail::class, 'shoppingId', 'shoppingId');
    }

    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory , SoftDeletes;

    protected $primaryKey = 'categoryId';
    protected $fillable = [
        'categoryName',
        'categoryDescription',
        'parentCategoryId'
    ];

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parentCategoryId', 'categoryId');
    }

    //relacion recursiva con la misma tabla

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parentCategoryId', 'categoryId');
    }

    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

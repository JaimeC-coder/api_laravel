<?php

namespace App\Http\Resources;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'categoryId' => $this->categoryId,
            'categoryName' => $this->categoryName,
            'categorydescription' => $this->categoryDescription,
            'parentCategories' =>[
                'parentCategoryId' => $this->parentCategoryId,
                'parentCategoryName' => $this->parentCategory->categoryName ?? null
            ]

        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Response\JsonResponse;
use App\Models\Category;

use function Illuminate\Log\log;

class CategoryController extends Controller
{
    public function index()
    {
       try {
            $category = Category::all();
            $category = CategoryResource::collection($category);
            return JsonResponse::success($category, 'Success', true, count($category), 200);
        } catch (\Exception $e) {
            log("----------Error Categoria List----------");
            log($e->getMessage());
            log("--------------------");
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }

    public function store(CategoryRequest $request)
    {
      try {
            $category = Category::create($request->all());
        return JsonResponse::success($category, 'Categoria creada con exito', true, 1, 200);
        } catch (\Exception $e) {
            log("----------Error Categoria Crear----------");
            log($e->getMessage());
            log("--------------------");
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }


    public function show(Category $category)
    {
        try {
            $category = new  CategoryResource($category);
            return JsonResponse::success([$category], 'Success', true, 1, 200);
        } catch (\Exception $e) {
            log("----------Error Categoria Mostrar----------");
            log($e->getMessage());
            log("--------------------");
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }


    public function update(CategoryRequest $request, Category $category)
    {
        try {
            log("-----------------");
            log($request);
            log("-----------------");
            log($request->all());
            $category->update($request->all());
            return JsonResponse::success($category, 'Categoria actualizada con exito', true, 1, 200);
        } catch (\Exception $e) {
            log("----------Error Categoria Actualizar----------");
            log($e->getMessage());
            log("--------------------");
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }

    public function destroy(Category $category)
    {

        try {
            $category->delete();
            return JsonResponse::success($category, 'Categoria eliminada con exito', true, 1, 200);
        } catch (\Exception $e) {
            log("----------Error Categoria Eliminar----------");
            log($e->getMessage());
            log("--------------------");
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }
}

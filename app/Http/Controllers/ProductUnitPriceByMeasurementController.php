<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductUnitPriceByMeasurementRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductUnitPriceByMeasurementResource;
use App\Http\Response\JsonResponse;
use App\Models\Product;
use App\Models\ProductUnitPriceByMeasurement;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use function Illuminate\Log\log;

class ProductUnitPriceByMeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(ProductUnitPriceByMeasurement $productUnitPriceByMeasurement)
    {
        //
    }

    public function edit(ProductUnitPriceByMeasurement $productUnitPriceByMeasurement)
    {
        //
    }

    public function update(Request $request, ProductUnitPriceByMeasurement $productUnitPriceByMeasurement)
    {
        //
    }

    public function destroy($product, $productUnitPriceByMeasurement)
    {
        try {
            $productUnitPriceByMeasurement = ProductUnitPriceByMeasurement::find($productUnitPriceByMeasurement);
            log($productUnitPriceByMeasurement);
            $productUnitPriceByMeasurement = $productUnitPriceByMeasurement->delete();
            log($productUnitPriceByMeasurement);
            return JsonResponse::success($productUnitPriceByMeasurement, 'Producto eliminada con exito', true, 1, 200);
        } catch (\Exception $e) {
            log("----------Error Precio Actualizar----------");
            log($e->getMessage());
            log("--------------------");
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }

    public function updatePrice(ProductUnitPriceByMeasurementRequest $request, $product)
    {
        try {
            log("----------Precio Actualizar----------");
             log($request->all());
            $product = Product::find($product);
            $productUnitPriceByMeasurement = ProductUnitPriceByMeasurement::find($request->productUnitPriceId);
            log($productUnitPriceByMeasurement);
            $productUnitPriceByMeasurement->update([
                'price' => $request->price
            ]);
            $productUnitPriceByMeasurement->save();
            $productUnitPriceByMeasurement = new ProductResource($product);

            return JsonResponse::success($productUnitPriceByMeasurement, 'Precio actualizado con exito', true, 1, 200);
        } catch (\Exception $e) {
            log("----------Error Precio Actualizar----------");
            log($e->getMessage());
            log("--------------------");
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }
}

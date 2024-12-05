<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductUnitPriceByMeasurementResource;
use App\Http\Response\JsonResponse;
use App\Models\Product;
use App\Models\ProductUnitPriceByMeasurement;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Illuminate\Log\log;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::all();
            $products = ProductResource::collection($products);
            $productUnitPrices = ProductUnitPriceByMeasurement::all();
            

            $productUnitPrices = ProductUnitPriceByMeasurementResource::collection($productUnitPrices);
            $productAll = [
                'products' =>  $products,
                'productUnitPrices'=>$productUnitPrices
            ];
            return JsonResponse::success($productAll, 'Success', true,count($products), 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }

    public function store(ProductRequest $request)
    {
        try {
            $product = Product::create([
                "productName"=> $request->productName,
                "productDescription"=> $request->productDescription,
                "categoryId"=> $request->categoryId,
                "productStock"=> $request->productStock,
            ]);
            if($request->unitMeasurementId != null){
                $prodUnitprice = ProductUnitPriceByMeasurement::create([
                    "productId"=> $product->productId,
                    "price"=> $request->price,
                    "unitMeasurementId"=> $request->unitMeasurementId,
                    "effectiveDate"=> date('Y-m-d H:i:s')
                ]);

                $product['unitPrices'] = new ProductUnitPriceByMeasurementResource($prodUnitprice);
            }

            return JsonResponse::success($product, 'Success', true, 1, 201);
        } catch (\Exception $e) {
            //si hay un error en la creacion del producto se elimina el producto creado
            $product->forceDelete();
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {

            $product = new ProductResource($product);

            return JsonResponse::success($product, 'Success', true, 1, 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }
    public function update(ProductRequest $request, Product $product)
    {
        try {
            DB::transaction(function () use ($request, $product) {
                // Actualizamos el producto utilizando Eloquent
                $product->update([
                    "productName" => $request->productName,
                    "productDescription" => $request->productDescription,
                    "categoryId" => $request->categoryId,
                    "productStock" => $request->productStock,
                ]);
                $prodUnitPrice = ProductUnitPriceByMeasurement::updateOrCreate(
                    ['productUnitPriceId' => $request->productUnitPriceId],
                    [
                        "productId" => $product->productId,
                        "price" => $request->price,
                        "unitMeasurementId" => $request->unitMeasurementId,
                        "effectiveDate" => now(),
                    ]
                );

                // Asignamos el precio actualizado o creado al producto
                $product->unitPrices = $prodUnitPrice;
            });

            // Retornamos el producto actualizado como respuesta
            return JsonResponse::success($product, 'Success', true, 1, 200);
        } catch (\Exception $e) {
            log()->error($e->getMessage());

            return JsonResponse::error([], 'Error: ' . $e->getMessage(), false, 0, 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return JsonResponse::success($product, 'Success', true, 1, 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        } catch (\Throwable $th) {
            return JsonResponse::error([], 'Error' . $th->getMessage(), false, 0, 500);
        }
    }

    public function updateStock(ProductRequest $request, Product $product)
    {
        try {
            $product->update($request->all());
            return JsonResponse::success($product, 'Success', true, 1, 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }
    public function productInformationAll($productId, $productUnitPriceId)
    {
        try {
            $product =  ProductUnitPriceByMeasurement::productByproductUnitPriceId($productUnitPriceId);
            log($product);
            return JsonResponse::success($product, 'Success', true, 1, 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\InventoryResource;
use App\Http\Resources\InventoryTransactionResource;
use App\Http\Resources\InventoryTransactionShowResource;
use App\Http\Resources\ProductUnitPriceByMeasurementResource;
use App\Http\Response\JsonResponse;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use Illuminate\Http\Request;

use function Illuminate\Log\log;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try { //inventories
            $inventory = Inventory::all();
            $inventory = InventoryResource::collection($inventory);
            return $inventory;
            return JsonResponse::success($inventory, 'Lista de inventario', true, 1, 200);
        } catch (\Throwable $th) {
            //throw $th;
            log("----------Error Categoria Crear----------");
            log($th->getMessage());
            log("--------------------");
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        log($request);
        return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //

        try {
            $inventory = Inventory::find($inventory->inventoryId);
            $inventory = InventoryTransaction::where('inventoryId', $inventory->inventoryId)
                ->orderBy('created_at', 'desc')
                ->get();
            $inventory = InventoryTransactionShowResource::collection($inventory);
            return JsonResponse::success($inventory, 'Inventario', true, 1, 200);
        } catch (\Throwable $th) {
            log("----------Error Categoria Crear----------");
            log($th->getMessage());
            log("--------------------");
            return JsonResponse::error([], 'Error' . $th->getMessage(), false, 0, 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }

    public function input()
    {

        try {
            $input = InventoryTransaction::where('transactionType', 'input')->ORWhere('transactionType', 'purchase')
                ->orderBy('created_at', 'desc')
                ->get();

            $input = InventoryTransactionResource::collection($input);
            return JsonResponse::success($input, 'Lista de transacciones de entrada', true, 1, 200);
        } catch (\Throwable $th) {
            log("----------Error Categoria Crear----------");
            log($th->getMessage());
            log("--------------------");
            return JsonResponse::error([], 'Error' . $th->getMessage(), false, 0, 500);
        }
    }
    public function ouput()
    {
        try {
            $output = InventoryTransaction::where('transactionType', 'output')
                ->orderBy('created_at', 'desc')
                ->get();
            $output = InventoryTransactionResource::collection($output);
            return JsonResponse::success($output, 'Lista de transacciones de salida', true, 1, 200);
        } catch (\Throwable $th) {
            log("----------Error Categoria Crear----------");
            log($th->getMessage());
            log("--------------------");
            return JsonResponse::error([], 'Error' . $th->getMessage(), false, 0, 500);
        }
    }
}

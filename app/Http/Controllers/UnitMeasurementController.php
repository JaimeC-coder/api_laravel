<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitMeasurementRequest;
use App\Http\Resources\UnitMeasurementResource;
use App\Http\Response\JsonResponse;
use App\Models\UnitMeasurement;
use Illuminate\Http\Request;

class UnitMeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $unitMeasurements = UnitMeasurement::all();
            $unitMeasurements = UnitMeasurementResource::collection($unitMeasurements);
            return JsonResponse::success($unitMeasurements, 'Success', true,count($unitMeasurements), 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitMeasurementRequest $request)
    {
        try {
           $unitMeasurement = UnitMeasurement::create($request->all());
            return JsonResponse::success($unitMeasurement, 'Success', true, 1, 201);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitMeasurement $unitMeasurement)
    {
        try {
            $unitMeasurement = new UnitMeasurementResource($unitMeasurement);
            return JsonResponse::success($unitMeasurement, 'Success', true, 1, 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnitMeasurement $unitMeasurement)
    {
        try {
            $unitMeasurement->update($request->all());
            $unitMeasurement->save();
            return JsonResponse::success($unitMeasurement, 'Success', true, 1, 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitMeasurement $unitMeasurement)
    {
        try {
            $unitMeasurement->delete();
            return JsonResponse::success([], 'Success', true, 1, 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }
}

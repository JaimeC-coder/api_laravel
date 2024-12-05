<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Response\JsonResponse;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        try {
            $permissions = Permission::all();
            $permissions = PermissionResource::collection($permissions);
            return  JsonResponse::success($permissions, 'Success', true, count($permissions), 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }


    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        try {
            $permission = new PermissionResource($permission);
            return JsonResponse::success($permission, 'Success', true, 1, 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }
    public function update(PermissionRequest $request, Permission $permission)
    {
        try {
            $permission->update([
                'permissionDescription'=> $request->permissionDescription,
            ]);
            return JsonResponse::success($permission, 'Success', true, 1, 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }

    public function destroy(Permission $permission)
    {
        try {
            $data = "Permission " . $permission->permissionDescription . " deleted successfully";
            $permission->delete();
            return JsonResponse::success($data, 'Success', true, 1, 200);
        } catch (\Exception $e) {
            return JsonResponse::error([], 'Error' . $e->getMessage(), false, 0, 500);
        }
    }
}

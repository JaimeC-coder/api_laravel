<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Http\Resources\StaffResource;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $staff = Staff::all();
        $staff = StaffResource::collection($staff);
        return response()->json(
            [
                'data' =>  $staff,
                'message' => 'Success',
                'status' => true,
                'total' => count($staff)
            ]
        );
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
    public function store(StaffRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Staff $staff)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff)
    {
        //
    }
    public function staffbyUser($id)
    {

        $user = User::where('id', $id)->first();
        $staff = Staff::where('staffId', $user->staffId)->get();
        $staff = StaffResource::collection($staff);
        return response()->json(
            [
                'data' =>  $staff,
                'message' => 'Success',
                'status' => true,
                'total' => count($staff)
            ]
        );
    }
}

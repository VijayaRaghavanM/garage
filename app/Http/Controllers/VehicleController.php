<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // There is no index method provided for the VehicleController 
    // as there seems to be no reason to list all the vehicles from the database.

    /**
     * Returns the vehicle whose id is provided 
     *
     * @param Integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $vehicle = App\Vehicle::find($id);
 
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'vehicle with id ' . $id . ' not found'
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $vehicle->toArray()
        ], 400);
    }
 

    /**
     * Creates a new vehicle
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'brand' => 'required|string',
            'make' => 'required|string',
            'model' => 'required|string',
            'variant' => 'required|string',
            'color' => 'required|string',
            'fuel_type' => 'required|string',
            'registration_number' => 'required|string',
            'chassis_number' => 'required|string',
            'engine_number' => 'required|string'
        ]);
 
        $vehicle = new Vehicle();
        $vehicle->brand = $request->brand;
        $vehicle->make = $request->make;
        $vehicle->model = $request->model;
        $vehicle->variant = $request->variant;
        $vehicle->color = $request->color;
        $vehicle->fuel_type = $request->fuel_type;
        $vehicle->registration_number = $request->registration_number;
        $vehicle->chassis_number = $request->chassis_number;
        $vehicle->engine_number = $request->engine_number;
        
        if ($vehicle->save())
            return response()->json([
                'success' => true,
                'data' => $vehicle->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'Vehicle could not be added'
            ], 500);
    }

    /**
     * Updates exisiting vehicle
     *
     * @param Request $request
     * @param Integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $vehicle = App\Vehicle::find($id);
 
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'vehicle with id ' . $id . ' not found'
            ], 400);
        }
 
        $updated = $vehicle->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'vehicle could not be updated'
            ], 500);
    }

    /**
     * Deletes exisiting vehicle
     *
     * @param Request $request
     * @param Integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $vehicle = App\Vehicle::find($id);
 
        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'vehicle with id ' . $id . ' not found'
            ], 400);
        }
 
        if ($vehicle->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'vehicle could not be deleted'
            ], 500);
        }
    }

}

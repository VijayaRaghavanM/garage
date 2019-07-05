<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Lists all the orders of current user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $orders = auth()->user()->orders;
 
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
 
    /**
     * Returns the order whose id is provided 
     *
     * @param Integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $order = auth()->user()->orders()->find($id);
 
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'order with id ' . $id . ' not found'
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $order->toArray()
        ], 400);
    }

    
    /**
     * Creates a new order
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'scheduled_on' => 'required|date',
            'issue' => 'required|string',
            'garage_in' => 'required|datetime',
            'garage_out' => 'required|datetime|after:garage_in',
            'status' => 'required|in:pending,confirmed,estimation_shared,work_in_progress,delivered',
            'user' => 'required|exists:users',
            'client' => 'required|exists:clients',
            'vehicle' => 'required|exists:vehicles',
        ]);
 
        $order = new Order();
        $order->scheduled_on = $request->scheduled_on;
        $order->issue = $request->issue;
        $order->garage_in = $request->garage_in;
        $order->garage_out = $request->garage_out;
        $order->status = $request->status;
        $order->client = $request->client;
        $order->vehicle = $request->vehicle;        

        
        if (auth()->user()->orders()->save($order))
            return response()->json([
                'success' => true,
                'data' => $order->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'order could not be added'
            ], 500);
    }

    /**
     * Updates exisiting order
     *
     * @param Request $request
     * @param Integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $order = auth()->user()->orders()->find($id);
 
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'order with id ' . $id . ' not found'
            ], 400);
        }
 
        $updated = $order->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'order could not be updated'
            ], 500);
    }



    /**
     * Deletes exisiting order
     *
     * @param Request $request
     * @param Integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $order = auth()->user()->orders()->find($id);
 
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'order with id ' . $id . ' not found'
            ], 400);
        }
 
        if ($order->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'order could not be deleted'
            ], 500);
        }
    }
}

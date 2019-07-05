<?php

namespace App\Http\Controllers;
use App\Client;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Lists all the clients of current user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $clients = auth()->user()->clients;
 
        return response()->json([
            'success' => true,
            'data' => $clients
        ]);
    }

    /**
     * Returns the client whose id is provided 
     *
     * @param Integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $client = auth()->user()->clients()->find($id);
 
        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Client with id ' . $id . ' not found'
            ], 400);
        }
 
        return response()->json([
            'success' => true,
            'data' => $client->toArray()
        ], 400);
    }


    /**
     * Creates a new client
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email',
            'mobile' => 'required|digits:value',
            'address' => 'required'
        ]);
 
        $client = new Client();
        $client->name = $request->name;
        $client->gender = $request->gender;
        $client->email = $request->email;
        $client->mobile = $request->mobile;
        $client->address = $request->address;
 
        if (auth()->user()->clients()->save($client))
            return response()->json([
                'success' => true,
                'data' => $client->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'client could not be added'
            ], 500);
    }

    /**
     * Updates exisiting client
     *
     * @param Request $request
     * @param Integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $client = auth()->user()->clients()->find($id);
 
        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'client with id ' . $id . ' not found'
            ], 400);
        }
 
        $updated = $client->fill($request->all())->save();
 
        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'client could not be updated'
            ], 500);
    }


    /**
     * Deletes exisiting client
     *
     * @param Request $request
     * @param Integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $client = auth()->user()->clients()->find($id);
 
        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'client with id ' . $id . ' not found'
            ], 400);
        }
 
        if ($client->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'client could not be deleted'
            ], 500);
        }
    }
}

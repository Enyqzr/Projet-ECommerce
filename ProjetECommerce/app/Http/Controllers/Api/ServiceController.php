<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Models\User;


class ServiceController extends Controller
{
    //Show all the service (GET)
    public function index(){

        $service = ServiceResource::collection(Service::all());

        return response()->json([
            'service' => $service
        ]);
    }

    //Search a service and show him by his ID (GET)
    public function show($id){

        $service = Service::find($id);
        $service = ServiceResource::make($service);

        return response()->json([
            'service' => $service
        ]);
    }

    //Add a service method  (POST)
    public function store(ServiceRequest $request){

        //Extract user ID from the request input
        $userId = $request->input('user_id');
        //Retrieve the user based on the extracted user ID
        $user = User::where('id' , $userId)->first();
        $service = new Service;
        $service->name = $request->input('name');
        $service->cost = $request->input('cost');
        $service->area = $request->input('area');
        $service->user()->associate($user);

        $service->save();


        return response()->json([
            'service' => $service
        ]);
    }

    public function update($id, ServiceRequest $request){

        $service = Service::find($id);
        $userId = $request->input('user_id');
        $user = User::where('id' , $userId)->first();
        $service = new Service;
        $service->name = $request->input('name');
        $service->cost = $request->input('cost');
        $service->area = $request->input('area');
        $service->user()->associate($user);

        return response()->json([
            'service'=>$service
        ]);
    }

    public function destroy($id) {
        $service = Service::find($id);
        $service->delete();
        $services = ServiceResource::collection(Service::all());

        return response()->json([
            'services'=>$services
        ]);
    }
}

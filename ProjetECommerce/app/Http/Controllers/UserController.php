<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{
    public function store(StoreUserRequest $request)
    {
        $arrayRequest = $request->all();

        $user = new User();
        $user->firstname = $arrayRequest['firstname'];
        $user->lastname = $arrayRequest['lastname'];
        $user->mail = $arrayRequest['mail'];
        $user->address = $arrayRequest['address'];
        $user->password = $arrayRequest['password'];
        $user->role = $arrayRequest['role'];

        $user->save();

        return response()->json(
             new UserResource($user)
        );
    }

    public function index()
    {
        $users = UserResource::collection(User::all());

        return response()->json(
            $users
        );
    }

    public function show($id)
    {
        $user = new UserResource(User::find($id));

        return response()->json([
            'user' => $user
        ]);
    }

    public function update($id, StoreUserRequest $request){
        $user = User::find($id);
        $user->update($request->safe()->except('mail'));
        $user->save();



        return response()->json([
            'user' => $user
        ]);
    }

    public function destroy($id){

        $user = User::find($id);
        $user->delete();

        return response()->json([
            'users' => $this->index()
        ]);
    }


}


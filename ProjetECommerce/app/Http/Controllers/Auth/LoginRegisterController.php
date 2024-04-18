<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Validator;


class LoginRegisterController extends Controller
{
    public function register(Request $request)
    {
      $user = User::create([
          'firstname' => $request->firstname,
          'lastname' => $request->lastname,
          'mail' => $request->mail,
          'password' => Hash::make($request->password),
          'role'=> 'user',
          'address' => 'test address'
      ]);

      $data['token'] = $user->createToken($request->mail)->plainTextToken;
      $data['user'] = $user;

      $response = [
          'data' => $data,
      ];
      return response()->json($response, 201);
    }

    public function login(Request $request){

        $validate = Validator::make ($request->all(),[
            'mail' => 'required|string|email|',
            'password' => 'required|string'
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 403);
        }
        $user = User::where('mail', $request->mail)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'status' => 'failed',
                'message' => 'Unauthorized!',
            ], 401);
        }
        $data['token'] = $user->createToken($request->mail)->plainTextToken;
        $data['user'] = $user;

        $response = [
            'status' => 'success',
            'message' => 'Login Successful!',
            'data' => $data,
        ];
        return response()->json($response, 200);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Logout Successful!',
        ], 200);
    }
}

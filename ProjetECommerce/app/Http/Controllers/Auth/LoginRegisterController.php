<?php

namespace App\Http\Controllers\Auth;






use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


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

    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    //
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            ...$request->only('name', 'lastname', 'email'),
            'password' => bcrypt($request->password),
            'role' => 'seller' //defecto
        ]);

        return response()->json($user, 201);
    }
}

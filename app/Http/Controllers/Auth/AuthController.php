<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique',
            'password' => 'required|min:6',
            'password_confirmation' => 'required',
        ]);


     $user =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        
        return response()->json([
            'msg' => 'register success',
            'user' => $user
        ]);

    }

    public function login(Request $request){
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        
            $user = User::where('email', $request->email)->first();
        
            if (!$user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }
        
            return $user->createToken('test')->plainTextToken;

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
    }
}

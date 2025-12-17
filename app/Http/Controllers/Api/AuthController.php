<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fuvarozo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $fuvarozo = Fuvarozo::where('email', $request->email)->first();
    
        if (!$fuvarozo || !Hash::check($request->password, $fuvarozo->password)) {
            throw ValidationException::withMessages([
                'email' => ['A megadott hitelesítési adatok helytelenek.'],
            ]);
        }
    
        $token = $fuvarozo->createToken('api-token')->plainTextToken;
    
        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $fuvarozo->id,
                'name' => $fuvarozo->name,
                'email' => $fuvarozo->email,
                'role' => $fuvarozo->role,
            ]
        ]);
    }
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json(['message' => 'Sikeres kijelentkezés']);
    }
}

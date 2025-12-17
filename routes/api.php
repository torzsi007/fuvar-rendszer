<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Fuvarozo;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Fő API endpoint
Route::get('/', function () {
    return response()->json([
        'message' => 'Fuvarozó Rendszer API v1.0',
        'status' => 'active',
        'endpoints' => [
            'GET /api' => 'API információ',
            'POST /api/login' => 'Bejelentkezés',
            'GET /api/munkak' => 'Munkák listája (GET)',
        ]
    ]);
});

// Bejelentkezés (egyszerű verzió)
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $fuvarozo = Fuvarozo::where('email', $request->email)->first();

    if (!$fuvarozo || !password_verify($request->password, $fuvarozo->password)) {
        return response()->json([
            'error' => 'Hibás hitelesítési adatok'
        ], 401);
    }

    return response()->json([
        'message' => 'Sikeres bejelentkezés',
        'user' => [
            'id' => $fuvarozo->id,
            'name' => $fuvarozo->name,
            'email' => $fuvarozo->email,
            'role' => $fuvarozo->role,
        ]
    ]);
});

// Munkák listája (publikus, csak demo)
Route::get('/munkak', function () {
    $munkak = \App\Models\Munka::with('fuvarozo')
        ->latest()
        ->take(10)
        ->get()
        ->map(function ($munka) {
            return [
                'id' => $munka->id,
                'kiindulo_cim' => $munka->kiindulo_cim,
                'erkezesi_cim' => $munka->erkezesi_cim,
                'cimzett_nev' => $munka->cimzett_nev,
                'statusz' => $munka->statusz,
                'fuvarozo' => $munka->fuvarozo ? $munka->fuvarozo->name : null,
            ];
        });

    return response()->json([
        'count' => $munkak->count(),
        'munkak' => $munkak
    ]);
});

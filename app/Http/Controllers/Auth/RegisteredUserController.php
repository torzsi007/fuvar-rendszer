<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Fuvarozo;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:fuvarozos,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Fuvarozo::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'fuvarozo', // Minden új felhasználó fuvarozó
        ]);

        event(new Registered($user));

        // ⚠️ FONTOS: NEM jelentkeztetjük be automatikusan!
        // Auth::login($user); // EZT NE HASZNÁLDUK!

        return redirect('/login')->with('status', 'Sikeres regisztráció! Most már bejelentkezhetsz.');
    }
}

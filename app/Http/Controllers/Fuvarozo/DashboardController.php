<?php

namespace App\Http\Controllers\Fuvarozo;

use App\Http\Controllers\Controller;
use App\Models\Munka;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $munkak = Munka::where('fuvarozo_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('fuvarozo.dashboard', compact('munkak'));
    }

    public function updateStatus(Request $request, Munka $munka)
    {
        // Ellenőrizés, hogy a fuvarozó saját munkáját módosítja-e
        if ($munka->fuvarozo_id !== auth()->id()) {
            abort(403, 'Nincs jogosultságod módosítani ezt a munkát!');
        }

        $validated = $request->validate([
            'statusz' => 'required|in:kiosztva,folyamatban,elvegezve,sikertelen'
        ]);

        $munka->update($validated);

        return back()->with('success', 'Státusz frissítve!');
    }
}

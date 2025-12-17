<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Munka;
use App\Http\Resources\MunkaResource;
use Illuminate\Http\Request;

class MunkaApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Munka::with('fuvarozo');

        // Szűrés státusz szerint
        if ($request->has('statusz')) {
            $query->where('statusz', $request->statusz);
        }

        // Szűrés fuvarozó szerint
        if ($request->has('fuvarozo_id')) {
            $query->where('fuvarozo_id', $request->fuvarozo_id);
        }

        return MunkaResource::collection($query->latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kiindulo_cim' => 'required|string|max:255',
            'erkezesi_cim' => 'required|string|max:255',
            'cimzett_nev' => 'required|string|max:100',
            'cimzett_telefon' => 'required|string|max:20',
            'statusz' => 'sometimes|in:kiosztva,folyamatban,elvegezve,sikertelen',
            'fuvarozo_id' => 'sometimes|exists:fuvarozos,id'
        ]);

        $munka = Munka::create($validated);

        return new MunkaResource($munka);
    }

    public function show(Munka $munka)
    {
        return new MunkaResource($munka->load('fuvarozo'));
    }

    public function update(Request $request, Munka $munka)
    {
        $validated = $request->validate([
            'kiindulo_cim' => 'sometimes|string|max:255',
            'erkezesi_cim' => 'sometimes|string|max:255',
            'cimzett_nev' => 'sometimes|string|max:100',
            'cimzett_telefon' => 'sometimes|string|max:20',
            'statusz' => 'sometimes|in:kiosztva,folyamatban,elvegezve,sikertelen',
            'fuvarozo_id' => 'sometimes|exists:fuvarozos,id'
        ]);

        $munka->update($validated);

        return new MunkaResource($munka);
    }

    public function destroy(Munka $munka)
    {
        $munka->delete();

        return response()->json(['message' => 'Munka sikeresen törölve'], 200);
    }
}

    // Státusz frissítés (fuvarozók számára)
    public function updateStatus(Request $request, Munka $munka)
    {
        // Ellenőrizzük, hogy a fuvarozó saját munkáját módosítja-e
        if ($munka->fuvarozo_id !== $request->user()->id) {
            return response()->json(['error' => 'Nincs jogosultságod módosítani ezt a munkát!'], 403);
        }
        
        $validated = $request->validate([
            'statusz' => 'required|in:kiosztva,folyamatban,elvegezve,sikertelen'
        ]);
        
        $munka->update($validated);
        
        return new \App\Http\Resources\MunkaResource($munka);
    }

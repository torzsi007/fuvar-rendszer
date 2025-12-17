<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fuvarozo;
use App\Models\Munka;
use Illuminate\Http\Request;

class MunkaController extends Controller
{
    public function index()
    {
        $munkak = Munka::with('fuvarozo')->latest()->paginate(20);
        return view('admin.munkak.index', compact('munkak'));
    }

    public function create()
    {
        return view('admin.munkak.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kiindulo_cim' => 'required|string|max:255',
            'erkezesi_cim' => 'required|string|max:255',
            'cimzett_nev' => 'required|string|max:100',
            'cimzett_telefon' => 'required|string|max:20',
        ]);

        Munka::create($validated);

        return redirect()->route('admin.munkak.index')
            ->with('success', 'Munka sikeresen létrehozva!');
    }

    public function show(Munka $munka)
    {
        return view('admin.munkak.show', compact('munka'));
    }

    public function edit(Munka $munka)
    {
        return view('admin.munkak.edit', compact('munka'));
    }

    public function update(Request $request, Munka $munka)
    {
        $validated = $request->validate([
            'kiindulo_cim' => 'required|string|max:255',
            'erkezesi_cim' => 'required|string|max:255',
            'cimzett_nev' => 'required|string|max:100',
            'cimzett_telefon' => 'required|string|max:20',
        ]);

        $munka->update($validated);

        return redirect()->route('admin.munkak.index')
            ->with('success', 'Munka sikeresen frissítve!');
    }

    public function destroy(Munka $munka)
    {
        $munka->delete();

        return redirect()->route('admin.munkak.index')
            ->with('success', 'Munka sikeresen törölve!');
    }

    public function assignForm(Munka $munka)
    {
        $fuvarozok = Fuvarozo::where('role', 'fuvarozo')->get();
        return view('admin.munkak.assign', compact('munka', 'fuvarozok'));
    }

    public function assign(Request $request, Munka $munka)
    {
        $validated = $request->validate([
            'fuvarozo_id' => 'required|exists:fuvarozos,id'
        ]);

        $munka->update($validated);

        return redirect()->route('admin.munkak.index')
            ->with('success', 'Munka sikeresen hozzárendelve!');
    }
}

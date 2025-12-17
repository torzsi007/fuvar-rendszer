<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fuvarozo;
use Illuminate\Http\Request;

class FuvarozoController extends Controller
{
    public function index()
    {
        $fuvarozok = Fuvarozo::where('role', 'fuvarozo')
            ->with('jarmu')
            ->latest()
            ->paginate(20);

        return view('admin.fuvarozok.index', compact('fuvarozok'));
    }
}

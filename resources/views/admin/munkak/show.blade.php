@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-6">Munka részletei</h2>
                
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-2">Alapadatok</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-100 rounded">
                            <p class="font-bold">Kiindulási cím:</p>
                            <p>{{ $munka->kiindulo_cim }}</p>
                        </div>
                        <div class="p-4 bg-gray-100 rounded">
                            <p class="font-bold">Érkezési cím:</p>
                            <p>{{ $munka->erkezesi_cim }}</p>
                        </div>
                        <div class="p-4 bg-gray-100 rounded">
                            <p class="font-bold">Címzett neve:</p>
                            <p>{{ $munka->cimzett_nev }}</p>
                        </div>
                        <div class="p-4 bg-gray-100 rounded">
                            <p class="font-bold">Címzett telefonszáma:</p>
                            <p>{{ $munka->cimzett_telefon }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-2">Státusz és hozzárendelés</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-100 rounded">
                            <p class="font-bold">Státusz:</p>
                            <span class="px-2 py-1 rounded text-white 
                                @if($munka->statusz == 'elvegezve') bg-green-500
                                @elseif($munka->statusz == 'sikertelen') bg-red-500
                                @elseif($munka->statusz == 'folyamatban') bg-yellow-500
                                @else bg-blue-500 @endif">
                                {{ ucfirst($munka->statusz) }}
                            </span>
                        </div>
                        <div class="p-4 bg-gray-100 rounded">
                            <p class="font-bold">Hozzárendelt fuvarozó:</p>
                            @if($munka->fuvarozo)
                                <p>{{ $munka->fuvarozo->name }} ({{ $munka->fuvarozo->email }})</p>
                            @else
                                <p class="text-gray-500">Nincs hozzárendelve</p>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-2">Időbélyegek</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-100 rounded">
                            <p class="font-bold">Létrehozva:</p>
                            <p>{{ $munka->created_at->format('Y. m. d. H:i') }}</p>
                        </div>
                        <div class="p-4 bg-gray-100 rounded">
                            <p class="font-bold">Utoljára módosítva:</p>
                            <p>{{ $munka->updated_at->format('Y. m. d. H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.munkak.edit', $munka) }}" 
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Szerkesztés
                    </a>
                    
                    <a href="{{ route('admin.munkak.assign.form', $munka) }}" 
                       class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Fuvarozóhoz rendelés
                    </a>
                    
                    <form action="{{ route('admin.munkak.destroy', $munka) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Biztosan törölni szeretnéd ezt a munkát?')"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Törlés
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.munkak.index') }}" 
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Vissza a listához
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

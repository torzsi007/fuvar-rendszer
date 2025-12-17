@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-6">Munka hozzárendelése</h2>
                
                <div class="mb-6 p-4 bg-gray-100 rounded">
                    <h3 class="font-bold text-lg mb-2">Munka adatai:</h3>
                    <p><strong>Kiindulási cím:</strong> {{ $munka->kiindulo_cim }}</p>
                    <p><strong>Érkezési cím:</strong> {{ $munka->erkezesi_cim }}</p>
                    <p><strong>Címzett:</strong> {{ $munka->cimzett_nev }} ({{ $munka->cimzett_telefon }})</p>
                    <p><strong>Státusz:</strong> {{ $munka->statusz }}</p>
                </div>
                
                <form action="{{ route('admin.munkak.assign', $munka) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="fuvarozo_id" class="block text-gray-700 text-sm font-bold mb-2">Fuvarozó kiválasztása:</label>
                        <select name="fuvarozo_id" id="fuvarozo_id" 
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                            <option value="">-- Válassz fuvarozót --</option>
                            @foreach($fuvarozok as $fuvarozo)
                                <option value="{{ $fuvarozo->id }}" 
                                    {{ old('fuvarozo_id', $munka->fuvarozo_id) == $fuvarozo->id ? 'selected' : '' }}>
                                    {{ $fuvarozo->name }} ({{ $fuvarozo->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('fuvarozo_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <button type="submit" 
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Hozzárendelés
                        </button>
                        
                        <a href="{{ route('admin.munkak.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Mégse
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

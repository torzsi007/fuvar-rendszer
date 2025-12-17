@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-6">Munka szerkesztése</h2>
                
                <form action="{{ route('admin.munkak.update', $munka) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="kiindulo_cim" class="block text-gray-700 text-sm font-bold mb-2">Kiindulási cím:</label>
                        <input type="text" name="kiindulo_cim" id="kiindulo_cim" 
                               value="{{ old('kiindulo_cim', $munka->kiindulo_cim) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                        @error('kiindulo_cim')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="erkezesi_cim" class="block text-gray-700 text-sm font-bold mb-2">Érkezési cím:</label>
                        <input type="text" name="erkezesi_cim" id="erkezesi_cim" 
                               value="{{ old('erkezesi_cim', $munka->erkezesi_cim) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                        @error('erkezesi_cim')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="cimzett_nev" class="block text-gray-700 text-sm font-bold mb-2">Címzett neve:</label>
                        <input type="text" name="cimzett_nev" id="cimzett_nev" 
                               value="{{ old('cimzett_nev', $munka->cimzett_nev) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                        @error('cimzett_nev')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="cimzett_telefon" class="block text-gray-700 text-sm font-bold mb-2">Címzett telefonszáma:</label>
                        <input type="text" name="cimzett_telefon" id="cimzett_telefon" 
                               value="{{ old('cimzett_telefon', $munka->cimzett_telefon) }}"
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               required>
                        @error('cimzett_telefon')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div style="display: flex; gap: 15px; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                        <button type="submit" 
                                style="background-color: #3b82f6; color: white; padding: 12px 24px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
                            Frissítés
                        </button>
                        
                        <a href="{{ route('admin.munkak.index') }}" 
                           style="background-color: #6b7280; color: white; padding: 12px 24px; border: none; border-radius: 6px; font-weight: bold; text-decoration: none;">
                            Mégse
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Fuvarozó Dashboard')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-6">Az én munkáim</h2>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse($munkak as $munka)
                        <div class="bg-gray-50 rounded-lg p-4 mb-4 border border-gray-200">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-bold text-lg">Munka #{{ $munka->id }}</h3>
                                    <div class="flex items-center space-x-2 mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($munka->statusz == 'kiosztva') bg-blue-100 text-blue-800
                                    @elseif($munka->statusz == 'folyamatban') bg-yellow-100 text-yellow-800
                                    @elseif($munka->statusz == 'elvegezve') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($munka->statusz) }}
                                </span>
                                        <span class="text-sm text-gray-500">{{ $munka->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-1">Útvonal</h4>
                                    <div class="text-sm">
                                        <p class="text-gray-600">🏁 <strong>Honnan:</strong> {{ $munka->kiindulo_cim }}</p>
                                        <p class="text-gray-600">📍 <strong>Hova:</strong> {{ $munka->erkezesi_cim }}</p>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-medium text-gray-700 mb-1">Címzett</h4>
                                    <div class="text-sm">
                                        <p class="text-gray-600">👤 <strong>Név:</strong> {{ $munka->cimzett_nev }}</p>
                                        <p class="text-gray-600">📱 <strong>Telefon:</strong> {{ $munka->cimzett_telefon }}</p>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('fuvarozo.update-status', $munka) }}" method="POST" class="mt-3">
                                @csrf
                                @method('PATCH')
                                <div class="flex items-center space-x-3">
                                    <label for="statusz_{{ $munka->id }}" class="text-sm font-medium text-gray-700">
                                        Státusz módosítása:
                                    </label>
                                    <select name="statusz"
                                            id="statusz_{{ $munka->id }}"
                                            class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                            onchange="this.form.submit()">
                                        <option value="kiosztva" {{ $munka->statusz == 'kiosztva' ? 'selected' : '' }}>
                                            Kiosztva
                                        </option>
                                        <option value="folyamatban" {{ $munka->statusz == 'folyamatban' ? 'selected' : '' }}>
                                            Folyamatban
                                        </option>
                                        <option value="elvegezve" {{ $munka->statusz == 'elvegezve' ? 'selected' : '' }}>
                                            Elvégezve
                                        </option>
                                        <option value="sikertelen" {{ $munka->statusz == 'sikertelen' ? 'selected' : '' }}>
                                            Sikertelen
                                        </option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="text-gray-400 mb-2">
                                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500">Nincsenek kiosztott munkáid.</p>
                        </div>
                    @endforelse

                    <div class="mt-4">
                        {{ $munkak->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

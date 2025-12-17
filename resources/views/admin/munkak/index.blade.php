@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold">Munkák kezelése</h2>
                    <a href="{{ route('admin.munkak.create') }}" 
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Új munka
                    </a>
                </div>
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">ID</th>
                                <th class="py-3 px-6 text-left">Címzett</th>
                                <th class="py-3 px-6 text-left">Címek</th>
                                <th class="py-3 px-6 text-left">Státusz</th>
                                <th class="py-3 px-6 text-left">Fuvarozó</th>
                                <th class="py-3 px-6 text-left">Létrehozva</th>
                                <th class="py-3 px-6 text-left">Műveletek</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @forelse($munkak as $munka)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    {{ $munka->id }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="font-bold">{{ $munka->cimzett_nev }}</div>
                                    <div class="text-gray-500">{{ $munka->cimzett_telefon }}</div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div><strong>Indulás:</strong> {{ Str::limit($munka->kiindulo_cim, 30) }}</div>
                                    <div><strong>Cél:</strong> {{ Str::limit($munka->erkezesi_cim, 30) }}</div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <span class="px-2 py-1 rounded text-white 
                                        @if($munka->statusz == 'elvegezve') bg-green-500
                                        @elseif($munka->statusz == 'sikertelen') bg-red-500
                                        @elseif($munka->statusz == 'folyamatban') bg-yellow-500
                                        @else bg-blue-500 @endif">
                                        {{ ucfirst($munka->statusz) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    @if($munka->fuvarozo)
                                        {{ $munka->fuvarozo->name }}
                                    @else
                                        <span class="text-gray-500">Nincs</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ $munka->created_at->format('m-d H:i') }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.munkak.show', $munka) }}" 
                                           class="bg-blue-100 hover:bg-blue-200 text-blue-800 text-xs font-semibold px-3 py-1 rounded">
                                            Nézet
                                        </a>
                                        <a href="{{ route('admin.munkak.edit', $munka) }}" 
                                           class="bg-yellow-100 hover:bg-yellow-200 text-yellow-800 text-xs font-semibold px-3 py-1 rounded">
                                            Szerkeszt
                                        </a>
                                        <a href="{{ route('admin.munkak.assign.form', $munka) }}" 
                                           class="bg-green-100 hover:bg-green-200 text-green-800 text-xs font-semibold px-3 py-1 rounded">
                                            Hozzárendel
                                        </a>
                                        <form action="{{ route('admin.munkak.destroy', $munka) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Biztosan törölni szeretnéd?')"
                                                    class="bg-red-100 hover:bg-red-200 text-red-800 text-xs font-semibold px-3 py-1 rounded">
                                                Törlés
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="py-4 px-6 text-center text-gray-500">
                                    Nincsenek munkák.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $munkak->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

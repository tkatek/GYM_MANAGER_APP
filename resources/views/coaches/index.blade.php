<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gym Coaches') }}
            </h2>
            <a href="{{ route('coaches.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow transition">
                + Add New Coach
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if($coaches->isEmpty())
                <div class="bg-white p-12 text-center rounded-lg shadow">
                    <p class="text-gray-500 text-lg">No coaches registered yet. Click "Add New Coach" to get started.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($coaches as $coach)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 hover:shadow-md transition">
                            <div class="h-48 w-full bg-gray-200">
                                @if($coach->photo)
                                    <img src="{{ asset('storage/' . $coach->photo) }}" alt="{{ $coach->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $coach->name }}</h3>
                                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded mt-1 uppercase font-semibold">
                                            {{ $coach->specialty }}
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500 uppercase">Per Session</p>
                                        <p class="text-lg font-bold text-green-600">${{ number_format($coach->session_price, 2) }}</p>
                                    </div>
                                </div>

                                <div class="mt-4 border-t pt-4">
                                    <p class="text-sm text-gray-600"><strong>Phone:</strong> {{ $coach->phone }}</p>
                                    <p class="text-sm text-gray-600 mt-2 line-clamp-2"><strong>Planning:</strong> {{ $coach->planning ?? 'No schedule set' }}</p>
                                </div>

                                <div class="mt-6 flex gap-2">
                                    <a href="{{ route('coaches.edit', $coach->id) }}" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded transition">
                                        Edit Profile
                                    </a>
                                    <form action="{{ route('coaches.destroy', $coach->id) }}" method="POST" onsubmit="return confirm('Delete coach?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-semibold py-2 px-4 rounded transition">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
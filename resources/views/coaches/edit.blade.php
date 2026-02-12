<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Coach Profile') }}: {{ $coach->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('coaches.update', $coach->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-6 flex items-center space-x-6 p-4 bg-gray-50 rounded-lg border border-gray-100">
                            <div class="flex-shrink-0">
                                <span class="block text-xs font-semibold text-gray-500 uppercase mb-2">Current Photo</span>
                                <div class="h-20 w-20 rounded-full overflow-hidden border-2 border-white shadow-sm bg-white">
                                    @if($coach->photo)
                                        <img src="{{ asset('storage/' . $coach->photo) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400 text-xs italic">None</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1">
                                <label for="photo" class="block text-sm font-medium text-gray-700">Replace Profile Photo</label>
                                <input type="file" name="photo" id="photo" 
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ $coach->name }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="specialty" class="block text-sm font-medium text-gray-700">Specialty</label>
                                <input type="text" name="specialty" id="specialty" value="{{ $coach->specialty }}" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="text" name="phone" id="phone" value="{{ $coach->phone }}" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="session_price" class="block text-sm font-medium text-gray-700">Price per Session ($)</label>
                            <input type="number" step="0.01" name="session_price" id="session_price" value="{{ $coach->session_price }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-6">
                            <label for="planning" class="block text-sm font-medium text-gray-700">Weekly Schedule</label>
                            <textarea name="planning" id="planning" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $coach->planning }}</textarea>
                        </div>

                        <div class="flex items-center justify-end border-t pt-4">
                            <a href="{{ route('coaches.index') }}" class="text-gray-600 underline mr-4">Cancel</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition">
                                Update Coach
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
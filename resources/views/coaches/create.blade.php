<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Gym Coach') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form action="{{ route('coaches.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="specialty" class="block text-sm font-medium text-gray-700">Specialty (e.g. Boxing, Yoga)</label>
                                <input type="text" name="specialty" id="specialty" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="text" name="phone" id="phone" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="session_price" class="block text-sm font-medium text-gray-700">Price per Session ($)</label>
                            <input type="number" step="0.01" name="session_price" id="session_price" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="photo" class="block text-sm font-medium text-gray-700">Coach Photo</label>
                            <input type="file" name="photo" id="photo" 
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>

                        <div class="mb-6">
                            <label for="planning" class="block text-sm font-medium text-gray-700">Weekly Schedule / Planning</label>
                            <textarea name="planning" id="planning" rows="3" placeholder="Example: Mon-Fri 8am to 12pm" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <div class="flex items-center justify-end border-t pt-4">
                            <a href="{{ route('coaches.index') }}" class="text-gray-600 underline mr-4">Cancel</a>
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition">
                                Save Coach
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
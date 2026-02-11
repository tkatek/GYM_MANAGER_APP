<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Plan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form action="{{ route('plans.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Plan Name</label>
                        <input type="text" name="name" placeholder="e.g. Gold Membership" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Duration (Days)</label>
                        <input type="number" name="duration_days" placeholder="30" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="text-xs text-gray-500 mt-1">30 for Monthly, 365 for Yearly</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Price ($)</label>
                        <input type="number" step="0.01" name="price" placeholder="50.00" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex justify-end mt-6">
                        <a href="{{ route('plans.index') }}" class="text-gray-500 mr-4 mt-2">Cancel</a>
                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-bold">Save Plan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
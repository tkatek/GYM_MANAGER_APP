<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Record New Expense') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form action="{{ route('expenses.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Expense Title</label>
                            <input type="text" name="title" id="title" placeholder="e.g. Monthly Rent, Electricity" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category" id="category" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="fixed">Fixed</option>
                                    <option value="variable">Variable</option>
                                    <option value="salaries">Salaries</option>
                                    <option value="utilities">Utilities</option>
                                    <option value="marketing">Marketing</option>
                                    <option value="maintenance">Maintenance</option>
                                </select>
                            </div>
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" name="date" id="date" value="{{ date('Y-m-d') }}" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount ($)</label>
                            <input type="number" step="0.01" name="amount" id="amount" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>

                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes (Optional)</label>
                            <textarea name="notes" id="notes" rows="3" placeholder="Add any extra details here..." 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"></textarea>
                        </div>

                        <div class="flex items-center justify-end border-t pt-4">
                            <a href="{{ route('expenses.index') }}" class="text-gray-600 underline mr-4">Cancel</a>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow transition">
                                Save Expense
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
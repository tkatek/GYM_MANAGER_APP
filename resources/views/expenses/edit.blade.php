<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Expense') }}: {{ $expense->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6">
                    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Expense Title</label>
                            <input type="text" name="title" id="title" value="{{ $expense->title }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category" id="category" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                                    @foreach(['fixed', 'variable', 'salaries', 'utilities', 'marketing', 'maintenance'] as $cat)
                                        <option value="{{ $cat }}" {{ $expense->category == $cat ? 'selected' : '' }}>
                                            {{ ucfirst($cat) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" name="date" id="date" value="{{ $expense->date }}" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount ($)</label>
                            <input type="number" step="0.01" name="amount" id="amount" value="{{ $expense->amount }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                        </div>

                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" id="notes" rows="3" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">{{ $expense->notes }}</textarea>
                        </div>

                        <div class="flex items-center justify-end border-t pt-4">
                            <a href="{{ route('expenses.index') }}" class="text-gray-600 underline mr-4">Cancel</a>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded shadow transition">
                                Update Expense
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
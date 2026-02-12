<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Expense Tracking') }}
            </h2>
            <a href="{{ route('expenses.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition">
                + Record Expense
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

            <div class="bg-white p-6 mb-6 rounded-lg shadow-sm border border-gray-200">
                <form action="{{ route('expenses.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Filter by Month</label>
                        <input type="month" name="month" value="{{ request('month') }}" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                            <option value="">All Categories</option>
                            @foreach(['fixed', 'variable', 'salaries', 'utilities', 'marketing', 'maintenance'] as $cat)
                                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                    {{ ucfirst($cat) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-md hover:bg-black transition font-semibold">
                            Filter
                        </button>
                        <a href="{{ route('expenses.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-200 transition font-semibold text-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border-l-8 border-red-500">
                <div class="p-6">
                    <p class="text-sm text-gray-500 uppercase font-bold tracking-wider">Total Expenses for Selection</p>
                    <p class="text-4xl font-black text-red-600 mt-1">${{ number_format($totalAmount, 2) }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($expenses as $expense)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $expense->title }}</div>
                                        @if($expense->notes)
                                            <div class="text-xs text-gray-400 truncate max-w-xs">{{ $expense->notes }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 uppercase">
                                            {{ $expense->category }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-black text-red-600">
                                        ${{ number_format($expense->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end items-center space-x-3">
                                            <a href="{{ route('expenses.edit', $expense->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Edit</a>
                                            
                                            <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this expense?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        No expenses found for this criteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
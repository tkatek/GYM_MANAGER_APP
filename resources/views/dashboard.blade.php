<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Gym Management Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase tracking-wider">Revenue (This Month)</div>
                    <div class="mt-2 text-3xl font-black text-blue-600 dark:text-blue-400">${{ number_format($currentMonthlyRevenue, 2) }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase tracking-wider">Expenses (This Month)</div>
                    <div class="mt-2 text-3xl font-black text-red-600 dark:text-red-400">${{ number_format($currentMonthlyExpenses, 2) }}</div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 {{ $netProfit >= 0 ? 'border-green-500' : 'border-red-700' }}">
                    <div class="text-gray-500 dark:text-gray-400 text-sm font-medium uppercase tracking-wider">Net Profit</div>
                    <div class="mt-2 text-3xl font-black {{ $netProfit >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-700 dark:text-red-500' }}">
                        ${{ number_format($netProfit, 2) }}
                        <span class="text-lg ml-1">{{ $netProfit >= 0 ? '↗️' : '↘️' }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-indigo-400">
                    <div class="text-gray-400 dark:text-gray-500 text-xs font-bold uppercase">Total Members</div>
                    <div class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $totalMembers }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-green-400">
                    <div class="text-gray-400 dark:text-gray-500 text-xs font-bold uppercase">Active</div>
                    <div class="mt-1 text-2xl font-bold text-green-500 dark:text-green-400">{{ $activeMembers }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-pink-400">
                    <div class="text-gray-400 dark:text-gray-500 text-xs font-bold uppercase">Coaches</div>
                    <div class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $totalCoaches }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 border-l-4 border-purple-400">
                    <div class="text-gray-400 dark:text-gray-500 text-xs font-bold uppercase">Plans</div>
                    <div class="mt-1 text-2xl font-bold text-gray-800 dark:text-white">{{ $totalPlans }}</div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8">
                <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Financial Performance (Last 3 Months)</h3>
                <div class="h-64">
                    <canvas id="gymFinanceChart"></canvas>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white flex items-center">
                        <span class="mr-2">⚠️</span> Expiring Soon (Next 7 Days)
                    </h3>
                    
                    @if($expiringSoon->isEmpty())
                        <p class="text-gray-500 dark:text-gray-400 italic">Everything is up to date.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-700 font-bold uppercase text-gray-600 dark:text-gray-300">
                                    <tr>
                                        <th class="px-6 py-3">Member Name</th>
                                        <th class="px-6 py-3">Plan</th>
                                        <th class="px-6 py-3 text-center">End Date</th>
                                        <th class="px-6 py-3 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y dark:divide-gray-700">
                                    @foreach($expiringSoon as $member)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">{{ $member->name }}</td>
                                        <td class="px-6 py-4">
                                            <span class="bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs font-bold px-2.5 py-1 rounded">
                                                {{ $member->plan ? $member->plan->name : 'No Plan' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center text-red-600 dark:text-red-400 font-bold">
                                            {{ \Carbon\Carbon::parse($member->end_date)->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('members.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold">Manage</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('gymFinanceChart').getContext('2d');
        
        // Check if dark mode is active to adjust chart text color
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#9ca3af' : '#4b5563';

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['labels']) !!},
                datasets: [
                    {
                        label: 'Revenue',
                        data: {!! json_encode($chartData['revenue']) !!},
                        backgroundColor: '#3b82f6',
                        borderRadius: 4,
                    },
                    {
                        label: 'Expenses',
                        data: {!! json_encode($chartData['expenses']) !!},
                        backgroundColor: '#ef4444',
                        borderRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        position: 'bottom',
                        labels: { color: textColor }
                    }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { 
                            color: textColor,
                            callback: (value) => '$' + value 
                        },
                        grid: { color: isDark ? '#374151' : '#e5e7eb' }
                    },
                    x: {
                        ticks: { color: textColor },
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
</x-app-layout>
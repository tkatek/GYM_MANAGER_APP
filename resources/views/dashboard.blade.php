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
                                        <td class="px-6 py-4 text-right flex items-center justify-end gap-3">
                                            @php
                                                $expiryMessage = urlencode("Hello " . $member->name . "! 👋 Your membership at PowerGym expires on " . \Carbon\Carbon::parse($member->end_date)->format('d M Y') . ". Would you like to renew it today?");
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $member->phone); 
                                            @endphp
                                            
                                            <a href="https://wa.me/{{ $cleanPhone }}?text={{ $expiryMessage }}" 
                                               target="_blank" 
                                               title="Send Reminder"
                                               class="text-green-500 hover:text-green-600 transition-transform hover:scale-110">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.889 1.034 3.862 1.574 5.71 1.576h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            </a>

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
        
        // Dynamic chart colors based on Dark Mode
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#9ca3af' : '#4b5563';
        const gridColor = isDark ? '#374151' : '#e5e7eb';

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
                        ticks: { color: textColor, callback: (value) => '$' + value },
                        grid: { color: gridColor }
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
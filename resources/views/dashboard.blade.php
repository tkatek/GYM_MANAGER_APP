<x-app-layout>
    <script src="https://unpkg.com/lucide@latest"></script>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Gym Analytics Dashboard') }}
            </h2>
            <div class="text-sm font-medium text-gray-500 bg-white dark:bg-gray-800 px-4 py-2 rounded-lg shadow-sm">
                {{ now()->format('l, d M Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f8fafc] dark:bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 relative overflow-hidden">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Monthly Revenue</p>
                            <h3 class="text-3xl font-black text-gray-900 dark:text-white mt-1">${{ number_format($currentMonthlyRevenue, 0) }}</h3>
                        </div>
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-600">
                            <i data-lucide="trending-up" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm font-medium text-green-500">
                        <span>Current Month</span>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Monthly Expenses</p>
                            <h3 class="text-3xl font-black text-gray-900 dark:text-white mt-1">${{ number_format($currentMonthlyExpenses, 0) }}</h3>
                        </div>
                        <div class="p-3 bg-red-50 dark:bg-red-900/30 rounded-xl text-red-600">
                            <i data-lucide="credit-card" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm font-medium text-gray-400">Total outgoings</div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 ring-2 {{ $netProfit >= 0 ? 'ring-green-500/20' : 'ring-red-500/20' }}">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Net Profit</p>
                            <h3 class="text-3xl font-black {{ $netProfit >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">${{ number_format($netProfit, 0) }}</h3>
                        </div>
                        <div class="p-3 {{ $netProfit >= 0 ? 'bg-green-50 dark:bg-green-900/30 text-green-600' : 'bg-red-50 text-red-600' }} rounded-xl">
                            <i data-lucide="dollar-sign" class="w-6 h-6"></i>
                        </div>
                    </div>
                    <div class="mt-4 text-sm font-bold {{ $netProfit >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{ $netProfit >= 0 ? '+ Sustainable' : '- Budget Warning' }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/40 text-indigo-600 rounded-lg"><i data-lucide="users" class="w-5 h-5"></i></div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Members</p>
                        <p class="text-xl font-black dark:text-white">{{ $totalMembers }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-2 bg-green-100 dark:bg-green-900/40 text-green-600 rounded-lg"><i data-lucide="user-check" class="w-5 h-5"></i></div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Active</p>
                        <p class="text-xl font-black text-green-500">{{ $activeMembers }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-2 bg-orange-100 dark:bg-orange-900/40 text-orange-600 rounded-lg"><i data-lucide="award" class="w-5 h-5"></i></div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Coaches</p>
                        <p class="text-xl font-black dark:text-white">{{ $totalCoaches }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 flex items-center gap-4">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900/40 text-purple-600 rounded-lg"><i data-lucide="layers" class="w-5 h-5"></i></div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase">Plans</p>
                        <p class="text-xl font-black dark:text-white">{{ $totalPlans }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold mb-6 text-gray-800 dark:text-white">Cash Flow Analysis</h3>
                    <div class="h-72">
                        <canvas id="gymFinanceChart"></canvas>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 flex flex-col">
                    <h3 class="text-lg font-bold mb-6 text-gray-800 dark:text-white">Membership Focus</h3>
                    <div class="h-64 flex-grow">
                        <canvas id="planPopularityChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-6 border-b border-gray-50 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white flex items-center">
                        <i data-lucide="bell" class="w-5 h-5 mr-2 text-orange-500"></i> Renewal Alerts
                    </h3>
                    <span class="bg-orange-100 text-orange-700 text-xs font-black px-3 py-1 rounded-full uppercase">Next 7 Days</span>
                </div>
                
                <div class="p-0">
                    @if($expiringSoon->isEmpty())
                        <div class="p-8 text-center text-gray-400">No memberships expiring this week.</div>
                    @else
                        <table class="min-w-full">
                            <thead class="bg-gray-50 dark:bg-gray-900/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">Member</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-400 uppercase">Plan</th>
                                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-400 uppercase">Expiry</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-gray-400 uppercase">Contact</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach($expiringSoon as $member)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                    <td class="px-6 py-4 font-bold text-gray-700 dark:text-gray-200">{{ $member->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-bold px-2 py-1 bg-blue-50 text-blue-600 rounded-md">{{ $member->plan->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center font-black text-red-500">
                                        {{ \Carbon\Carbon::parse($member->end_date)->format('d M') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @php
                                            $expiryMessage = "Hi " . $member->name . "! Your PowerGym plan expires soon.";
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $member->phone); 
                                        @endphp
                                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode($expiryMessage) }}" target="_blank" class="inline-flex items-center text-green-500 hover:bg-green-50 p-2 rounded-lg transition">
                                            <i data-lucide="message-circle" class="w-6 h-6"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Initialize Icons
        lucide.createIcons();

        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#9ca3af' : '#4b5563';

        // Finance Chart (Cleaned up)
        new Chart(document.getElementById('gymFinanceChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['labels']) !!},
                datasets: [
                    { label: 'Revenue', data: {!! json_encode($chartData['revenue']) !!}, backgroundColor: '#3b82f6', borderRadius: 6 },
                    { label: 'Expenses', data: {!! json_encode($chartData['expenses']) !!}, backgroundColor: '#cbd5e1', borderRadius: 6 }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { borderDash: [5, 5] }, ticks: { color: textColor } },
                    x: { grid: { display: false }, ticks: { color: textColor } }
                }
            }
        });

        // Popularity Chart (Modern Doughnut)
        new Chart(document.getElementById('planPopularityChart'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($planData['labels']) !!},
                datasets: [{
                    data: {!! json_encode($planData['counts']) !!},
                    backgroundColor: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444'],
                    hoverOffset: 10,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                cutout: '75%',
                plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, color: textColor } } }
            }
        });
    </script>
</x-app-layout>
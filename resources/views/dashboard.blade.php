<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Members</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalMembers }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Active Members</div>
                    <div class="mt-2 text-3xl font-bold text-green-600">{{ $activeMembers }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Expired Members</div>
                    <div class="mt-2 text-3xl font-bold text-red-600">{{ $expiredMembers }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Plans</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalPlans }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Revenue</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">${{ number_format($monthlyRevenue, 2) }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4 text-gray-800">⚠️ Expiring Soon (Next 7 Days)</h3>
                    
                    @if($expiringSoon->isEmpty())
                        <p class="text-gray-500">No memberships expiring in the next 7 days.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm font-light">
                                <thead class="border-b font-medium bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-4">Name</th>
                                        <th scope="col" class="px-6 py-4">Plan</th>
                                        <th scope="col" class="px-6 py-4">End Date</th>
                                        <th scope="col" class="px-6 py-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expiringSoon as $member)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-6 py-4 font-medium">{{ $member->name }}</td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded">
                                                {{ $member->plan ? $member->plan->name : 'No Plan' }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-red-600 font-bold">
                                            {{ \Carbon\Carbon::parse($member->end_date)->format('d M Y') }}
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <a href="{{ route('members.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">View</a>
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
</x-app-layout>
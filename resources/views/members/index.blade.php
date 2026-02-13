<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Members Management') }}
            </h2>
            <a href="{{ route('members.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition duration-150 ease-in-out">
                + Add Member
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                    <p class="font-bold">Success</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="GET" action="{{ route('members.index') }}" class="mb-6 flex gap-4">
                        <div class="flex-grow">
                            <input type="text" name="search" placeholder="Search by name..." value="{{ request('search') }}" 
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                        </div>
                        <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition">
                            Search
                        </button>
                        @if(request('search'))
                            <a href="{{ route('members.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 flex items-center transition">
                                Clear
                            </a>
                        @endif
                    </form>

                    @if($members->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No members found</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(request('search'))
                                    Try adjusting your search terms.
                                @else
                                    Get started by creating a new member.
                                @endif
                            </p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm font-light">
                                <thead class="border-b font-medium bg-gray-50 text-gray-600 uppercase tracking-wider">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Name</th>
                                        <th scope="col" class="px-6 py-3">Phone</th>
                                        <th scope="col" class="px-6 py-3">Plan</th>
                                        <th scope="col" class="px-6 py-3 text-center">Status</th>
                                        <th scope="col" class="px-6 py-3">End Date</th>
                                        <th scope="col" class="px-6 py-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($members as $member)
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="whitespace-nowrap px-6 py-4 font-bold text-gray-900">{{ $member->name }}</td>
                                        
                                        <td class="whitespace-nowrap px-6 py-4 text-gray-500 font-medium">{{ $member->phone ?? '-' }}</td>

                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded">
                                                {{ $member->plan ? $member->plan->name : 'No Plan' }}
                                            </span>
                                        </td>
                                        
                                        <td class="whitespace-nowrap px-6 py-4 text-center">
                                            @if($member->status === 'active')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                                    Expired
                                                </span>
                                            @endif
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 {{ $member->end_date < now() ? 'text-red-600 font-bold' : 'text-gray-700' }}">
                                            {{ \Carbon\Carbon::parse($member->end_date)->format('d M Y') }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-right flex items-center justify-end gap-2">
                                            @php
                                                // 1. Clean number for WhatsApp
                                                $cleanPhone = preg_replace('/[^0-9]/', '', $member->phone);
                                                
                                                // 2. Motivational Message
                                                $welcomeMsg = urlencode(
                                                    "Welcome to PowerGym, " . $member->name . "! 💪\n\n" .
                                                    "Your " . ($member->plan ? $member->plan->name : 'membership') . " is now ACTIVE! 🚀\n\n" .
                                                    "The only bad workout is the one that didn't happen. Let's crush those goals! 🔥🏋️‍♂️"
                                                );
                                                
                                                $whatsappUrl = "https://web.whatsapp.com/send?phone=" . $cleanPhone . "&text=" . $welcomeMsg;
                                            @endphp

                                            <a href="{{ $whatsappUrl }}" 
                                               target="_blank"
                                               class="bg-green-500 hover:bg-green-600 text-white p-1.5 rounded-md transition transform hover:scale-110 shadow-sm flex items-center gap-1 px-2"
                                               title="Send Welcome Message">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.889 1.034 3.862 1.574 5.71 1.576h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                                <span class="text-[10px] font-black uppercase">Welcome</span>
                                            </a>

                                            <a href="{{ route('members.edit', $member->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-sm bg-indigo-50 p-1.5 rounded-md px-3 border border-indigo-100">Edit / Renew</a>
                                            
                                            <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete {{ $member->name }}? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 p-1.5 rounded-md border border-red-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $members->withQueryString()->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
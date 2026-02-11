<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Plans Management') }}
            </h2>
            <a href="{{ route('plans.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition duration-150 ease-in-out">
                + Add Plan
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
                    
                    @if($plans->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No plans found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new subscription plan.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-left text-sm font-light">
                                <thead class="border-b font-medium bg-gray-50 text-gray-600 uppercase tracking-wider">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">Plan Name</th>
                                        <th scope="col" class="px-6 py-3">Duration</th>
                                        <th scope="col" class="px-6 py-3">Price</th>
                                        <th scope="col" class="px-6 py-3">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($plans as $plan)
                                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                        <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900">
                                            {{ $plan->name }}
                                        </td>
                                        
                                        <td class="whitespace-nowrap px-6 py-4 text-gray-700">
                                            {{ $plan->duration_days }} Days
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 font-bold text-gray-900">
                                            ${{ number_format($plan->price, 2) }}
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                            <a href="{{ route('plans.edit', $plan->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4 font-semibold">
                                                Edit
                                            </a>
                                            
                                            <form action="{{ route('plans.destroy', $plan->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this plan? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
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
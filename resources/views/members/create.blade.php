<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('members.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone" id="phone" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>






<div class="mb-4">
    <label for="plan_id" class="block text-sm font-medium text-gray-700">Subscription Plan</label>
    <select name="plan_id" id="plan_id" required 
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">-- Select a Plan --</option>
        @foreach($plans as $plan)
            <option value="{{ $plan->id }}">
                {{ $plan->name }} ({{ $plan->duration_days }} days - ${{ $plan->price }})
            </option>
        @endforeach
    </select>
    @if($plans->isEmpty())
        <p class="text-red-500 text-sm mt-1">No plans found. <a href="{{ route('plans.create') }}" class="underline font-bold">Create a plan first.</a></p>
    @endif
</div>





                        <div class="mb-4">
                            <label for="plan_type" class="block text-sm font-medium text-gray-700">Subscription Plan</label>
                            <select name="plan_type" id="plan_type" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="monthly">Monthly (1 Month)</option>
                                <option value="3_months">Quarterly (3 Months)</option>
                                <option value="yearly">Yearly (1 Year)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price Paid</label>
                            <input type="number" name="price" id="price" step="0.01" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ date('Y-m-d') }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('members.index') }}" class="text-gray-600 underline mr-4">Cancel</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Save Member
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
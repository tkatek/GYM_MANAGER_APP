<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('members.update', $member->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ $member->name }}" required 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="text" name="phone" id="phone" value="{{ $member->phone }}" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="p-4 mb-4 bg-yellow-50 border border-yellow-200 rounded-md">
                            <h3 class="font-bold text-yellow-800 mb-2">Renew / Extend Subscription</h3>
                            <p class="text-sm text-yellow-700 mb-4">Changing the Start Date or Plan will automatically recalculate the End Date.</p>

                            <div class="mb-4">
                                <label for="plan_type" class="block text-sm font-medium text-gray-700">Plan</label>
                                <select name="plan_type" id="plan_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="monthly" {{ $member->plan_type == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="3_months" {{ $member->plan_type == '3_months' ? 'selected' : '' }}>Quarterly (3 Months)</option>
                                    <option value="yearly" {{ $member->plan_type == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="start_date" class="block text-sm font-medium text-gray-700">New Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ $member->start_date }}" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('members.index') }}" class="text-gray-600 underline mr-4">Cancel</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Update Member
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
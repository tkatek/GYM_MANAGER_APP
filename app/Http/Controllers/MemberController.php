<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Plan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MemberController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {
        $query = Member::with('plan'); // Load plan details efficiently

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $members = $query->latest()->paginate(10);
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        // Get all plans to show in the dropdown
        $plans = Plan::all(); 
        return view('members.create', compact('plans'));
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'plan_id' => 'required|exists:plans,id', // Must exist in database
            'start_date' => 'required|date',
        ]);

        // 1. Find the Plan details
        $plan = Plan::findOrFail($request->plan_id);

        // 2. Calculate End Date automatically
        $startDate = Carbon::parse($request->start_date);
        $endDate = $startDate->copy()->addDays($plan->duration_days);

        // 3. Set Status
        $status = $endDate->isPast() ? 'expired' : 'active';

        // 4. Create Member
        Member::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'plan_id' => $plan->id,
            'price' => $plan->price, // <--- THIS IS THE FIX. It saves the price from the plan.
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $status,
        ]);

        return redirect()->route('members.index')->with('success', 'Member added successfully!');
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(Member $member)
    {
        $plans = Plan::all();
        return view('members.edit', compact('member', 'plans'));
    }

    /**
     * Update the specified member in storage.
     */
  public function update(Request $request, Member $member)
{
    // 1. Validate the input
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'plan_id' => 'required|exists:plans,id',
        'start_date' => 'required|date',
    ]);

    // 2. Get the Plan details to calculate the new duration
    $plan = \App\Models\Plan::findOrFail($request->plan_id);

    // 3. Calculate new End Date
    $startDate = \Carbon\Carbon::parse($request->start_date);
    $endDate = $startDate->copy()->addDays($plan->duration_days);

    // 4. Auto-determine status (If end date is today or future, it's active)
    $status = $endDate->isPast() ? 'expired' : 'active';

    // 5. Save everything to the database
    $member->update([
        'name' => $request->name,
        'phone' => $request->phone,
        'plan_id' => $request->plan_id,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'status' => $status,
        'price' => $plan->price, // In case the plan price changed
    ]);

    // 6. REDIRECT back to the members list (This solves your issue)
    return redirect()->route('members.index')->with('success', 'Member updated and subscription renewed!');
}

    /**
     * Remove the specified member from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted!');
    }
}
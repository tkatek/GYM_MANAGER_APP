<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoachController extends Controller
{
    /**
     * Display a listing of coaches.
     */
    public function index()
    {
        $coaches = Coach::all();
        return view('coaches.index', compact('coaches'));
    }

    /**
     * Show the form for creating a new coach.
     */
    public function create()
    {
        return view('coaches.create');
    }

    /**
     * Store a newly created coach.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'session_price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // 2MB Max
            'planning' => 'nullable|string',
        ]);

        $data = $request->all();

        // Handle Photo Upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('coaches', 'public');
        }

        Coach::create($data);

        return redirect()->route('coaches.index')->with('success', 'Coach added successfully!');
    }

    /**
     * Show the form for editing a coach.
     */
    public function edit(Coach $coach)
    {
        return view('coaches.edit', compact('coach'));
    }

    /**
     * Update the coach details.
     */
    public function update(Request $request, Coach $coach)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'session_price' => 'required|numeric|min:0',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'planning' => 'nullable|string',
        ]);

        $data = $request->all();

        // Handle Photo Update
        if ($request->hasFile('photo')) {
            // Delete old photo if it exists
            if ($coach->photo) {
                Storage::disk('public')->delete($coach->photo);
            }
            $data['photo'] = $request->file('photo')->store('coaches', 'public');
        }

        $coach->update($data);

        return redirect()->route('coaches.index')->with('success', 'Coach updated successfully!');
    }

    /**
     * Remove the coach.
     */
    public function destroy(Coach $coach)
    {
        if ($coach->photo) {
            Storage::disk('public')->delete($coach->photo);
        }
        $coach->delete();

        return redirect()->route('coaches.index')->with('success', 'Coach deleted.');
    }
}
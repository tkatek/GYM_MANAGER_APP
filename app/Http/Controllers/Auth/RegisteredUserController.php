<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Gym;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'gym_name' => ['required', 'string', 'max:255'], // Validate Gym Name
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // We use a Transaction to make sure both Gym and User are created, or neither.
        DB::transaction(function () use ($request) {
            
            // 1. Create the Gym
            $gym = Gym::create([
                'name' => $request->gym_name,
                'owner_name' => $request->name,
                'email' => $request->email,
            ]);

            // 2. Create the User linked to that Gym
            $user = User::create([
                'gym_id' => $gym->id, // <--- Link to the new Gym
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'owner',    // <--- Assign Owner role
            ]);

            event(new Registered($user));

            Auth::login($user);
        });

        return redirect('/dashboard');
    }
}

    
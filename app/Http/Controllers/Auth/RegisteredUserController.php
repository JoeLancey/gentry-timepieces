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
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Prevent public access to staff registration
        $requestedRole = request('role');
        if ($requestedRole === 'staff' && !(auth()->check() && auth()->user()->role === 'admin')) {
            return redirect()->route('login')->withErrors(['role' => 'Staff registration is restricted to administrators. Please contact an admin.']);
        }

        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Determine allowed role: only admins may set role, other users default to staff
        $isAdminCreating = auth()->check() && auth()->user()->role === 'admin';

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        if ($isAdminCreating) {
            $rules['role'] = ['required', 'in:admin,staff'];
        }

        $validated = $request->validate($rules);

        $role = $isAdminCreating ? $validated['role'] : 'staff';

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
        ]);

        event(new Registered($user));

        if ($isAdminCreating) {
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        }

        return redirect()->route('login')->with('success', 'Account created successfully.');
    }
}

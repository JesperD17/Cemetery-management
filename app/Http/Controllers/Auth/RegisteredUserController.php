<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/CreateUser');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'infix' => 'nullable|string|max:50',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'nullable|integer',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            Log::info('Registration validation failed', [
                'errors' => $validator->errors()->toArray(),
                'input' => $request->except(['password', 'password_confirmation']),
            ]);

            // Return with validation errors (Inertia / normal redirect compatible)
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'infix' => $request->infix,
                'last_name' => $request->last_name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'zip_code' => $request->zip_code,
                'email' => $request->email,
                'password_hash' => Hash::make($request->password),
                'role_id' => $request->role_id ?? 1,
            ]);

            event(new Registered($user));

            return back()->with('success', 'Account succesvol aangemaakt.');
        } catch (\Throwable $e) {
            Log::error('Failed to create user', [
                'exception' => $e,
                'input' => $request->except(['password', 'password_confirmation']),
            ]);

            return back()->withErrors(['error' => 'Server error while creating account. Check logs.']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
        return view('login.login');
    }

    // Handle login form submission
    public function login(Request $request)
    {
        $credentials = $request->only('badge_number', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->back()->withInput()->withErrors(['message' => 'Invalid credentials']);
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'badge_number' => 'required|min:5',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with('loginError', 'Login fail');

        dd($request);
    }

    // Logout user
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function updateProfile(Request $request)
    {
        try{
            $user = Auth::user();

            $validatedData = $request->validate([
                'password' => 'required|string|min:5|confirmed',
            ]);

            $user->password = bcrypt($validatedData['password']);
            $user->save();

            return response()->json(['message' => 'Profile updated successfully.']);
        }catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update Profile'], 500);
        }
    
        

    }

}

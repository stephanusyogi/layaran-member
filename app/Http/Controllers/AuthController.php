<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signin(Request $request){
        return view('auth-signin');
    }

    public function signin_action(Request $request){
        $credentials = $request->validate([
            'customField-1' => 'required|email|max:255|exists:users,email_address',
            'customField-2' => 'required|string|min:8|max:32',
        ], [
            'customField-1.required' => 'Email is required.',
            'customField-1.email' => 'Enter a valid email address.',
            'customField-1.exists' => 'Email is not registered.',
    
            'customField-2.required' => 'Password is required.',
            'customField-2.string' => 'Password must be a valid string.',
            'customField-2.min' => 'Password must be at least 8 characters long.',
            'customField-2.max' => 'Password cannot exceed 32 characters.',
        ]);
        
        if (Auth::attempt([
            'email_address' => $credentials['customField-1'],
            'password' => $credentials['customField-2'],
        ], $request->has('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 'Login successful! Welcome back.');
        }
        
        // dd("sip");
    
        // Authentication failed
        return back()->with('error', 'Invalid email or password.')->withInput();
    
    }

    public function signup(Request $request){
        return view('auth-signup');
    }

    public function signup_action(Request $request){
        $formData = $request->validate([
            'customField-1'  => 'required|string|max:255',
            'customField-2'  => 'nullable|string|max:255',
            'customField-3'  => 'required|email|max:255|unique:users,email_address',
            'customField-4'  => [
                'required',
                'string',
                'regex:/^8[1-9][0-9]{6,11}$/',
            ],
            'customField-5'   => 'nullable|in:Pelajar/Mahasiswa,Event Organizer,Wedding Organizer,IT Staff,Admin,Lainnya',
            'customField-6'   => 'nullable|in:Laki-Laki,Perempuan',
            'customField-7'   => 'nullable|in:Search Google,Instagram,Rekomendasi Teman,Website Layaran',
            'customField-8'   =>  [
                'required',
                'string',
                'min:8',
                'max:32',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            ],
            'customField-9'  => 'required|string|same:customField-8',
        ],  [
            'customField-1.required'  => 'First name is required.',
            'customField-1.string'    => 'First name must be a string.',
            'customField-1.max'       => 'First name cannot exceed 255 characters.',
        
            'customField-2.string'    => 'Last name must be a string.',
            'customField-2.max'       => 'Last name cannot exceed 255 characters.',
        
            'customField-3.required'  => 'Email is required.',
            'customField-3.email'     => 'Please enter a valid email address.',
            'customField-3.max'       => 'Email cannot exceed 255 characters.',
            'customField-3.unique'    => 'This email is already in use.',
        
            'customField-4.required'  => 'Phone number is required.',
            'customField-4.string'    => 'Phone number must be a valid string.',
            'customField-4.regex'     => 'Phone number must be an Indonesian number (e.g., 81234567890 without +62).',

            'customField-5.in'        => 'Please select a valid profession.',

            'customField-6.in'        => 'Please select a valid gender.',

            'customField-7.in'        => 'Please select a valid source of information.',
        
            'customField-8.required'  => 'Password is required.',
            'customField-8.string'    => 'Password must be a valid string.',
            'customField-8.min'       => 'Password must be at least 8 characters long.',
            'customField-8.max'       => 'Password cannot exceed 32 characters.',
            'customField-8.regex'     => 'Password must contain at least one letter, one number, and one special character.',
            
            'customField-9.required'  => 'Confirm Password is required.',
            'customField-9.string'    => 'Confirm Password must be a valid string.',
            'customField-9.same'      => 'Passwords do not match. Please re-enter.',
        ]);
        
        try {
            DB::beginTransaction();
    
            User::create([
                'first_name'    => $formData['customField-1'],
                'last_name'     => $formData['customField-2'] ?? null,
                'email_address' => $formData['customField-3'],
                'phone_number'  => $formData['customField-4'],
                'profession'    => $formData['customField-5'] ?? null,
                'gender'        => $formData['customField-6'] ?? null,
                'knowing_from'  => $formData['customField-7'] ?? null,
                'password'      => Hash::make($formData['customField-8']),
            ]);
    
            DB::commit();
    
            return redirect('/login')->with('success', 'Registration successful! Please log in.');
        } catch (Exception $e) {
            DB::rollBack();
    
            \Illuminate\Support\Facades\Log::error('User registration failed: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'Registration failed! Please try again.');
        }
    
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out.');
    }

}

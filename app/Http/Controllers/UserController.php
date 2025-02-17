<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function account_details($user_id){
        $title_page = "My Acccount";
        return view('account-details', compact('title_page'));
    }

    public function update(Request $request, $user_id){
        $formData = $request->validate([
            'customField-1'  => 'required|string|max:255',
            'customField-2'  => 'nullable|string|max:255',
            'customField-3'  => 'required|email|max:255|unique:users,email_address,' . $user_id . ',user_id',
            'customField-4'  => [
                'required',
                'string',
                'regex:/^8[1-9][0-9]{6,11}$/',
            ],
            'customField-5'   => 'nullable|in:Pelajar/Mahasiswa,Event Organizer,Wedding Organizer,IT Staff,Admin,Lainnya',
            'customField-6'   => 'nullable|in:Laki-Laki,Perempuan',
            'customField-7'   => 'nullable|in:Search Google,Instagram,Rekomendasi Teman,Website Layaran',
        ],  [
            'customField-1.required'  => 'First name is required.',
            'customField-1.string'    => 'First name must be a string.',
            'customField-1.max'       => 'First name cannot exceed 255 characters.',
        
            'customField-2.string'    => 'Last name must be a string.',
            'customField-2.max'       => 'Last name cannot exceed 255 characters.',
        
            'customField-3.required'  => 'Email is required.',
            'customField-3.email'     => 'Please enter a valid email address.',
            'customField-3.max'       => 'Email cannot exceed 255 characters.',
        
            'customField-4.required'  => 'Phone number is required.',
            'customField-4.string'    => 'Phone number must be a valid string.',
            'customField-4.regex'     => 'Phone number must be an Indonesian number (e.g., 81234567890 without +62).',

            'customField-5.in'        => 'Please select a valid profession.',

            'customField-6.in'        => 'Please select a valid gender.',

            'customField-7.in'        => 'Please select a valid source of information.',
        ]);

        try{
            DB::beginTransaction();

            $user = User::findOrFail($user_id);

            $user->update([
                'first_name'    => $formData['customField-1'],
                'last_name'     => $formData['customField-2'] ?? null,
                'email_address' => $formData['customField-3'],
                'phone_number'  => $formData['customField-4'],
                'profession'    => $formData['customField-5'] ?? null,
                'gender'        => $formData['customField-6'] ?? null,
                'knowing_from'  => $formData['customField-7'] ?? null,
            ]);
    
    
            DB::commit();
    
            return redirect('/account-details/'.$user_id)->with('success', 'Update account successful!');

        } catch (Exception $e) {
            DB::rollBack();
    
            \Illuminate\Support\Facades\Log::error('User update account failed: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'Update Account failed! Please try again.');
        }
    }

    public function deactivate(Request $request){
        $request->validate([
            'accountDeactivation' => ['required', 'accepted'],
        ], [
            'accountDeactivation.required' => 'You must confirm account deactivation before proceeding.',
            'accountDeactivation.accepted' => 'Please check the confirmation box to deactivate your account.',
        ]);
        
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        try {
            $user->delete();
    
            Auth::logout();

            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect()->route('login')->with('success', 'Your account has been deactivated.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Account deactivation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to deactivate account. Please try again.');
        }
    
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables as DataTables;

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

        if (Auth::user()->role === 'admin') {
            $formData = array_merge($formData, $request->validate([
                'customField-8'   => 'required|in:admin,member',
            ]));
        }

        try{
            DB::beginTransaction();

            $user = User::findOrFail($user_id);
            
            $updateData = [
                'first_name'    => $formData['customField-1'],
                'last_name'     => $formData['customField-2'] ?? null,
                'email_address' => $formData['customField-3'],
                'phone_number'  => $formData['customField-4'],
                'profession'    => $formData['customField-5'] ?? null,
                'gender'        => $formData['customField-6'] ?? null,
                'knowing_from'  => $formData['customField-7'] ?? null,
            ];

            if ($request->filled('customField-8')) {
                $updateData['role'] = $formData['customField-8'];
            }

            $user->update($updateData);

            if ($request->filled('customField-8')) {
                $user->syncRoles($formData['customField-8']);
            }
    
            DB::commit();

            if (Auth::user()->role === 'member') {
                return redirect('/account-details/'.$user_id)->with('success', 'Update account successful!');
            }else{
                if ($user->role === 'admin') {
                    return redirect()->route('administrators')->with('success', 'Update account successful.');
                } else {
                    return redirect()->route('members')->with('success', 'Update account successful.');
                }   
            }

        } catch (Exception $e) {
            DB::rollBack();
    
            \Illuminate\Support\Facades\Log::error('User update account failed: ' . $e->getMessage());
    
            return redirect()->back()->with('error', 'Update Account failed! Please try again.');
        }
    }

    public function deactivate(Request $request, $user_id){
        $request->validate([
            'accountDeactivation' => ['required', 'accepted'],
        ], [
            'accountDeactivation.required' => 'You must confirm account deactivation before proceeding.',
            'accountDeactivation.accepted' => 'Please check the confirmation box to deactivate your account.',
        ]);

         /** @var User $user */
        $user = User::withTrashed()->find($user_id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        try {
            $user->delete();
            if (Auth::user()->user_id === $user->user_id) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login')->with('success', 'Your account has been deactivated.');
            }

            if ($user->role === 'admin') {
                return redirect()->route('administrators')->with('success', 'Administrator account has been deactivated.');
            } else {
                return redirect()->route('members')->with('success', 'User account has been deactivated.');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Account deactivation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to deactivate account. <br> Please try again.');
        }
    
    }
    
    public function change_password($user_id){
        $title_page = "My Acccount";
        return view('change-password', compact('title_page'));
    }

    public function change_password_action(Request $request, $user_id){
        $formData = $request->validate([
            'customField-1'   =>  [
                'required',
                'string',
            ],
            'customField-2' => [
                'required',
                'string',
                'min:8',
                'max:32',
                'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
            ],
            'customField-3' => 'required|string|same:customField-2',
        ],  [
            'customField-1.required' => 'Current Password is required.',
            'customField-1.string' => 'Current Password must be a valid string.',
    
            'customField-2.required' => 'New Password is required.',
            'customField-2.string' => 'New Password must be a valid string.',
            'customField-2.min' => 'New Password must be at least 8 characters long.',
            'customField-2.max' => 'New Password cannot exceed 32 characters.',
            'customField-2.regex' => 'New Password must contain at least one letter, one number, and one special character.',
    
            'customField-3.required' => 'Confirm Password is required.',
            'customField-3.string' => 'Confirm Password must be a valid string.',
            'customField-3.same' => 'Passwords do not match. Please re-enter.',
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($user_id);

            if (!Hash::check($formData['customField-1'], $user->password)) {
                return redirect()->back()->with('error', 'Current Password is incorrect.');
            }

            $user->update([
                'password' => Hash::make($formData['customField-2']),
            ]);

            DB::commit();

            return redirect('/account-details/change-password/' . $user_id)->with('success', 'Password updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();

            \Illuminate\Support\Facades\Log::error('Password update failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Password update failed! Please try again.');

        }
    }

    public function members(){
        if (request()->ajax()) {
            $users = User::withTrashed()->where('role', 'member')->latest();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('full_name', function ($row) {
                    return $row->first_name . ($row->last_name ? ' ' . $row->last_name : '');
                })
                ->addColumn('timestamp', function ($row) {
                    return $row->created_at->format('d-m-Y H:i:s');
                })
                ->addColumn('status_user', function ($row) {
                    if ($row->deleted_at) {
                        $div = '<button type="button" class="badge badge-sm border border-warning text-warning bg-warning text-white">
                        <svg width="9" height="9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="me-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Inactive
                    </button>';
                    }else{
                        $div = '<button type="button" class="badge badge-sm border border-success text-success bg-success text-white">
                        <svg width="9" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" class="me-1">
                            <path d="M1 4.42857L3.28571 6.71429L9 1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Active
                    </button>';
                    }
                    return $div;
                })->addColumn('action', function ($row) {
                    $span = '  
                    <a href="'.route('user.details', $row->user_id).'" class="badge badge-sm border border-info text-info bg-info text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 4px;">
                            <path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5" />
                        </svg>
                        Detail
                    </a>';
    
                    return $span;
                })
                ->rawColumns(['action', 'status_user'])
                ->make(true);
        }

        $title_page = "Members";
        return view('members', compact('title_page'));
    }
    
    public function administrators(){
        if (request()->ajax()) {
            $users = User::withTrashed()->where('role', 'admin')->latest();

            return Datatables::of($users)
                ->addIndexColumn()
                ->addColumn('full_name', function ($row) {
                    return $row->first_name . ($row->last_name ? ' ' . $row->last_name : '');
                })
                ->addColumn('timestamp', function ($row) {
                    return $row->created_at->format('d-m-Y H:i:s');
                })
                ->addColumn('status_user', function ($row) {
                    if ($row->deleted_at) {
                        $div = '<span class="badge badge-sm border border-warning text-warning bg-warning text-white">
                        <svg width="9" height="9" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="me-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Deactivate
                    </span>';
                    }else{
                        $div = '<span class="badge badge-sm border border-success text-success bg-success text-white">
                        <svg width="9" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" class="me-1">
                            <path d="M1 4.42857L3.28571 6.71429L9 1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Active
                    </span>';
                    }
                    return $div;
                })->addColumn('action', function ($row) {
                    $span = '  
                    <a href="'.route('user.details', $row->user_id).'" class="badge badge-sm border border-info text-info bg-info text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 4px;">
                            <path fill="currentColor" d="M12 9a3 3 0 0 0-3 3a3 3 0 0 0 3 3a3 3 0 0 0 3-3a3 3 0 0 0-3-3m0 8a5 5 0 0 1-5-5a5 5 0 0 1 5-5a5 5 0 0 1 5 5a5 5 0 0 1-5 5m0-12.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5" />
                        </svg>
                        Detail
                    </a>';
    
                    return $span;
                })
                ->rawColumns(['action', 'status_user'])
                ->make(true);
        }

        $title_page = "Administrators";
        return view('admin', compact('title_page'));
    }

    public function details($user_id){
        $user = User::withTrashed()->find($user_id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        
        $title_page = $user->role === 'admin' ? 'Detail Administrator' : 'Detail Member';

        return view('user-details', compact('title_page', 'user'));
    }

    public function administrators_add(){
        $title_page = "Create New Admin";
        return view('admin-add', compact('title_page'));   
    }
    
    public function administrators_create(Request $request)
    {
        $formData = $request->validate([
            'customField-1' => 'required|string|max:255',
            'customField-2' => 'nullable|string|max:255',
            'customField-3' => 'required|email|max:255|unique:users,email_address',
            'customField-4' => [
                'required',
                'string',
                'regex:/^8[1-9][0-9]{6,11}$/',
            ]
        ], [
            'customField-1.required' => 'First Name is required.',
            'customField-2.string'   => 'Last Name must be a string.',
            'customField-3.required' => 'Email is required.',
            'customField-3.email'    => 'Please enter a valid email address.',
            'customField-3.unique'   => 'This email is already in use.',
            'customField-4.required' => 'Phone number is required.',
            'customField-4.regex'    => 'Phone number must be an Indonesian number (e.g., 81234567890 without +62).',
        ]);

        try {
            DB::beginTransaction();

            $user = User::create([
                'first_name'    => $formData['customField-1'],
                'last_name'     => $formData['customField-2'] ?? null,
                'email_address' => $formData['customField-3'],
                'phone_number'  => $formData['customField-4'],
                'profession'    => null,
                'gender'        => null,
                'knowing_from'  => null,
                'role'          => 'admin',
                'password'      => Hash::make('Password123'),
            ]);

            $user->assignRole('admin');

            DB::commit();

            return redirect()->route('administrators')->with('success', 'New admin created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            \Illuminate\Support\Facades\Log::error('Admin creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Creation failed! Please try again.');
        }
    }

}

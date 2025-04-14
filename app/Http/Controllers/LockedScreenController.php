<?php

namespace App\Http\Controllers;

use App\Http\Requests\VerifyPinRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class LockedScreenController extends Controller
{
    /**
     * Show the lock screen page.
     */
    public function showLockScreen()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Set screen lock session
        Session::put('screen_locked', true);
        
        $user = Auth::user();
        return view('authentications.lock-screen', compact('user'));
    }

    /**
     * Handle the lock screen PIN verification.
     */
    public function verifyPin(VerifyPinRequest $request)
    {
        $user = Auth::user();
        $inputPin = $request->input('pin');

        // Debug information
        Log::info('Pin Verification Attempt', [
            'input_pin' => $inputPin,
            'user_id' => $user->id,
            'user_name' => $user->fullname,
            'has_company_profile' => $user->companyProfile ? 'Yes' : 'No',
            'stored_pin' => $user->pin_code // This will show hashed pin
        ]);

        // Check if the provided PIN matches the user's stored PIN
        if (Hash::check($inputPin, $user->pin_code)) {
            // Remove screen lock session
            Session::forget('screen_locked');
            
            // Check if user has a company profile
            $isCompany = $user->companyProfile !== null;
            
            Log::info('Pin Verification Success - Redirecting', [
                'user_id' => $user->id,
                'has_company_profile' => $isCompany ? 'Yes' : 'No',
                'redirect_route' => $isCompany ? 'dash.company' : 'dash.individual'
            ]);

            // Redirect based on whether the user has a company profile
            return redirect()->route($isCompany ? 'dash.company' : 'dash.individual')
                           ->with('success', 'Welcome back!');
        }

        Log::info('Pin Verification Failed', [
            'user_id' => $user->id,
            'input_pin' => $inputPin
        ]);

        return back()->withErrors(['pin' => 'Invalid PIN provided.']);
    }

    /**
     * Log out the user and redirect to login.
     */
    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('auth.login');
    }
}

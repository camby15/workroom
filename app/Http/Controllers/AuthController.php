<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\{Session, Log};
use App\Http\Requests\LoginRequest;
use App\Mail\OtpMail;

class AuthController extends Controller
{
    /**
     * Request OTP for login.
     */
    public function requestOtp(LoginRequest $request)
    {
        // Check for user by email or phone number
        $user = User::where('personal_email', $request->contact)
            ->orWhere('phone_number', $request->contact)
            ->first();

        if (!$user) {
            return back()->with(
                'error',
                'No user found with this email or phone number.'
            );
        }

        // Generate OTP
        $otp = random_int(100000, 999999);                               // Generate a random 6-digit OTP
        Session::put('otp', $otp);                                       // Store OTP in session
        Session::put('user_id', $user->id);                              // Store user ID in session
        Session::put('contact_used', $request->contact);                 // Store the contact method used
         
        // Send OTP via email using queue
         if (filter_var($request->contact, FILTER_VALIDATE_EMAIL)) {
           Mail::to($user->personal_email)->queue(new OtpMail($user, $otp));
      
        } else {
            // Send OTP via SMS
            Http::get('https://sms.shrinqghana.com/sms/api', [
                'action' => 'send-sms',
                'api_key' => 'SWpvdEx1bGtNSXl2Tk9JT0ZxdG0=',
                'to' => $user->phone_number,
                'from' => 'SHRINQ',
                'sms' => "Your OTP is: $otp",
            ]);
        }

        return redirect()
            ->route('auth.token')
            ->with('success', 'OTP has been sent.');
    }

    /**
     * Verify the token entered by the user.
     */
    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string|min:4|max:8',
        ]);
    
        $sessionOtp = (string) Session::get('otp');
    
        if ($request->input('token') !== $sessionOtp) {
            $user = User::find(Session::get('user_id'));
            auth()->login($user);
    
            // Clear session data after successful login
            Session::forget(['otp', 'user_id', 'otp_generated_at']);
    
            // Check if the user is associated with a company profile
            if ($user->companyProfile) {
                Log::info('Setting company ID in session', [
                    'user_id' => $user->id,
                    'company_id' => $user->id,
                    'email' => $user->personal_email
                ]);
                
                // Store the company ID in session for sub-user management
                Session::put('selected_company_id', $user->id);
                
                // Store sub-user PINs in session
                $subUsers = \App\Models\CompanySubUser::where('company_id', $user->id)->get();
                foreach ($subUsers as $subUser) {
                    Session::put('user_pins.' . $subUser->id, '****');
                }
                
                return redirect()
                    ->route('dash.company')
                    ->with('success', 'Welcome ' . $user->companyProfile->company_name . '! Login successful.');
            }
    
            return redirect()
                ->route('dash.individual')
                ->with('success', 'Welcome ' . $user->first_name . '! Login successful.');
        }
    
        return back()->with('error', 'Invalid token (OTP). Please try again.');
    }

    /**
     * Resend OTP to user.
     */
    public function resendOtp()
    {
        $userId = Session::get('user_id');
        $contactUsed = Session::get('contact_used');
        
        if (!$userId || !$contactUsed) {
            return redirect()->route('login')->with('error', 'Session expired. Please try logging in again.');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found. Please try logging in again.');
        }

        // Generate new OTP
        $otp = random_int(100000, 999999);
        Session::put('otp', $otp);

        // Send OTP using the same contact method as before
        if (filter_var($contactUsed, FILTER_VALIDATE_EMAIL)) {
            Mail::to($contactUsed)->queue(new OtpMail($user, $otp));
        } else {
            // Send OTP via SMS
            Http::get('https://sms.shrinqghana.com/sms/api', [
                'action' => 'send-sms',
                'api_key' => 'SWpvdEx1bGtNSXl2Tk9JT0ZxdG0=',
                'to' => $contactUsed,
                'from' => 'SHRINQ',
                'sms' => "Your OTP is: $otp",
            ]);
        }

        return back()->with('success', 'New OTP has been sent to ' . $contactUsed);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminAuthController extends Controller
{
    public function showForgotForm()
    {
        return view('admin.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        $admin = User::where('email', $request->email)->first();
        
        if (!$admin) {
            return back()->withErrors(['email' => 'Email address not found in our records.']);
        }
        
        $token = Str::random(60);
        
        \DB::table('password_resets')->updateOrInsert(
            ['email' => $admin->email],
            ['token' => $token, 'created_at' => now()]
        );
        
        $resetLink = url("/admin/reset-password?token={$token}&email={$admin->email}");
        
        // Send email
        Mail::send('emails.admin-password-reset', [
            'name' => $admin->name,
            'resetLink' => $resetLink
        ], function ($message) use ($admin) {
            $message->to($admin->email)
                    ->subject('Admin Password Reset - IUEA Voting System');
        });
        
        return back()->with('success', 'Password reset link has been sent to your email address.');
    }
    
    public function showResetForm(Request $request)
    {
        $token = $request->token;
        $email = $request->email;
        
        return view('admin.reset-password', compact('token', 'email'));
    }
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);
        
        $reset = \DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();
        
        if (!$reset) {
            return back()->withErrors(['email' => 'Invalid or expired reset link. Please request a new one.']);
        }
        
        $admin = User::where('email', $request->email)->first();
        $admin->password = Hash::make($request->password);
        $admin->save();
        
        \DB::table('password_resets')->where('email', $request->email)->delete();
        
        return redirect('/admin/login')->with('success', 'Password reset successful. Please login with your new password.');
    }
}
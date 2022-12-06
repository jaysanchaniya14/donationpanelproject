<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function loginPage(Request $request)
    {
        if (auth('admin')->user()) {
            return redirect(route('dashboard'));
        }
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials, $request->has('remember'))) {

            return redirect(route('dashboard'))
                ->withSuccess('You have Successfully logged in');
        }

        return redirect()->back()->withInput()->withErrors(['email' => 'Sorry! You have entered invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(route('login'));
    }

    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }


    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $admin = Admin::where('email', $request->email)->first();
        if(!$admin){
            return redirect()->back()->withInput()->withErrors(['email' => "Sorry! We don't have any account with this email."]);
        }

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $admin->notify(new ResetPasswordNotification($token));

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function resetPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }


    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        $update = DB::table('password_resets')->where(['token' => $request->token])->first();

        if (!$update) {
            return back()->withErrors(['password' => 'Something went wrong']);
        }

        if(strtotime($update->created_at. "+10 minutes") < time()){
            return back()->withErrors(['password' => 'Your token is expired, please try again.']);
        }

        $user = Admin::where('email', $update->email)->first();
        if(!$user){
            $user = User::where('email', $update->email)->first();
        }

        if(!$user){
            return back()->withErrors(['password' => 'Something went wrong']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $update->email)->delete();

        return redirect(route('login'))->with('message', 'Your password has been successfully changed!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }


        Admin::whereId(auth()->user()->id)->update([
            'password' => bcrypt($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }

    public function profileEdit(Request $request){
        return view('account.update-profile');
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:admins,email,'.Auth::user()->id,
        ]);

        $admin = Auth::user();
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        if ($request->hasfile('profile')) {
            $path = $request->file('profile')->store('images/users');
            $admin->profile = Storage::url($path);
        }
        $admin->update();
        return back();
    }

    public function profile(Request $request){
        return view('account.profile');
    }
}

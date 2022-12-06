<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Donation;
use App\Models\User;
use App\Models\UserOtp;
use App\Notifications\VerificationOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function profile(Request $request){
        $user = Auth::user();

        return $this->respondWithData($user, "User profile data");
    }

    public function updateProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        $user = User::find(Auth::user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;

        if($request->hasFile('profile')){
            $url = $this->upload_user_profile($request->file('profile'));
            if(!$url){
                return $this->respondWithError("Can not upload profile image", 422);
            }
            //remove old file
            if($user->profile){
                Storage::delete(str_replace("/storage", "", $user->profile));
            }

            $user->profile = $url;
        }
        $user->save();

        $project = new ProjectController();
        $user->statistics = $project->statistics($request, false);
        return $this->respondWithData($user, __('api.user.profile_update_success'));
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required',
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }
        $user = Auth::user();
        if(Hash::check($request->current_password, $user->password)){
            $user->password = bcrypt($request->new_password);
            $user->save();

            return $this->respondSuccess(__("api.user.password_change_success"));
        }
        else{
            return $this->respondWithError(__("api.user.invalid_password"));
        }
    }

    public function deactivateAccount(Request $request){
        $user = Auth::user();
        $user->is_active = 0;
        $user->save();
        $user->tokens()->delete();
        return $this->respondSuccess(__("api.user.account_deactivated"));
    }

    public function deleteAccount(Request $request){
//        $validator = Validator::make($request->all(), [
//            'password' => 'required',
//        ]);
//
//        if($validator->fails()){
//            $errors = collect($validator->errors());
//            $error = $errors->unique()->first();
//            return $this->respondWithError($error[0]);
//        }

        $user = Auth::user();

        $can_delete = true;
        if($request->password){
            if(!Hash::check($request->password, $user->password)) {
                $can_delete = false;
            }
        }

        if($can_delete){
            $user->tokens()->delete();
            $user->delete();

            return $this->respondSuccess(__("api.user.account_deleted"));
        }
        else{
            return $this->respondWithError(__("api.user.invalid_password"));
        }
    }

    public function changeEmail(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.Auth::user()->id,
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        if($request->email == Auth::user()->email){
            return $this->respondWithError("New email and current email is same");
        }

        $otp = mt_rand(1001, 9999);

        $user = UserOtp::updateOrCreate([
            'email' => $request->email
        ], [
            'otp' => $otp,
            'otp_expiry' => date('Y-m-d H:i:s', strtotime("+2 minutes"))
        ]);

        $user->notify(new VerificationOtp($otp));

        return $this->respondSuccess(__('api.auth.otp_send_success'));
    }

    public function verifyEmail(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email',
            'otp' => 'required'
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        $otp = UserOtp::where('email', $request->email)->first();

        if(!$otp){
            return $this->respondWithError(__("api.something_wrong"));
        }

        if($otp->otp != $request->otp){
            return $this->respondWithError(__("api.auth.invalid_otp"));
        }

        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        UserOtp::where('email', $request->email)->delete();

        return  $this->respondSuccess(__('api.user.email_updated'));
    }

    public function guestData(Request $request){
        $validator = Validator::make($request->all(), [
            'device_token' => 'required'
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        $donation = Donation::where('payment_status', 'success');
        $response['total_donations'] = $donation->sum('amount');
        $response['donation_count'] = $donation->count();
        return $this->respondWithData($response, 'Guest user data');
    }

    public function contactUs(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'contact_no' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        $contact = new ContactUs();
        $contact->email = $request->email;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->phone_no = $request->contact_no;
        $contact->subject = $request->subject;
        $contact->description = $request->message;
        $contact->save();

        return $this->respondSuccess(__('api.contact_us'));
    }
}

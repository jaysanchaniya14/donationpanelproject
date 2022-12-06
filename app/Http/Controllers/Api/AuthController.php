<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceToken;
use App\Models\User;
use App\Models\UserOtp;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerificationOtp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
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

    public function verifyOtp(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'otp' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'password' => 'required_without:social_id',
            'device_type' => 'required|in:android,ios',
            'device_token' => 'required',
            'social_id' => 'required_without:password',
            'login_type' => 'required_without:password|in:google,facebook,apple',
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

        if(time() > strtotime($otp->otp_expiry)){
//            return $this->respondWithError(__("api.auth.otp_expired"));
        }

        //generate random password for social login
        $password = $request->password ?? Str::random(16);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = bcrypt($password);
        $user->language = $this->defaultLanguage();
        $user->currency = $this->defaultCurrency();
        $user->login_type = $request->login_type;
        $user->social_id = $request->social_id;
        $user->save();

        //generate API token
        $token = $user->createToken($request->username);
        $user->token = $token->plainTextToken;

        //save device details with token
        $device_token = new DeviceToken();
        $device_token->token_id = $token->accessToken->id;
        $device_token->user_id = $user->id;
        $device_token->device_type = $request->device_type;
        $device_token->device_token = $request->device_token;
        $device_token->save();

        $project = new ProjectController();
        $user->statistics = $project->statistics($request, false);

        //remove OTP data
        UserOtp::where('email', $request->email)->delete();

        return $this->respondWithData($user, __('api.auth.otp_verified'));
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'device_type' => 'required|in:android,ios',
            'device_token' => 'required'
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            if($user->is_disabled){
                return $this->respondWithError(__('api.auth.account_disabled'));
            }
            $user->is_active = 1;
            $user->save();

            $token = $user->createToken($user->username);
            $user->token = $token->plainTextToken;

            //save device details with token
            $device_token = new DeviceToken();
            $device_token->token_id = $token->accessToken->id;
            $device_token->user_id = $user->id;
            $device_token->device_type = $request->device_type;
            $device_token->device_token = $request->device_token;
            $device_token->save();

            $project = new ProjectController();
            $user->statistics = $project->statistics($request, false);

            return $this->respondWithData($user, __('api.auth.login_success'));
        }

        return $this->respondWithError(__('api.auth.invalid_credentials'));
    }

    public function socialLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'social_id' => 'required',
            'login_type' => 'required|in:google,facebook,apple',
            'device_type' => 'required|in:android,ios',
            'device_token' => 'required'
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        $user = User::where('login_type' , $request->login_type)
            ->where('social_id', $request->social_id)->first();

        if($user){
            $user->is_active = 1;
            $user->save();

            $token = $user->createToken($user->username);
            $user->token = $token->plainTextToken;

            //save device details with token
            $device_token = new DeviceToken();
            $device_token->token_id = $token->accessToken->id;
            $device_token->user_id = $user->id;
            $device_token->device_type = $request->device_type;
            $device_token->device_token = $request->device_token;
            $device_token->save();

            $project = new ProjectController();
            $user->statistics = $project->statistics($request, false);

            return $this->respondWithData($user, __('api.auth.login_success'));
        }

        return $this->respondWithError(__('api.auth.user_not_exists'));
    }

    public function socialRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'device_type' => 'required|in:android,ios',
            'device_token' => 'required',
            'social_id' => 'required',
            'login_type' => 'required|in:google,facebook,apple',
            'email_changed' => 'required|boolean'
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        $user = User::where('login_type' , $request->login_type)
            ->where('social_id', $request->social_id)->first();

        if($user){
            $token = $user->createToken($user->username);
            $user->token = $token->plainTextToken;

            //save device details with token
            $device_token = new DeviceToken();
            $device_token->token_id = $token->accessToken->id;
            $device_token->user_id = $user->id;
            $device_token->device_type = $request->device_type;
            $device_token->device_token = $request->device_token;
            $device_token->save();

            $project = new ProjectController();
            $user->statistics = $project->statistics($request, false);

            return $this->respondWithData($user, __('api.auth.login_success'));
        }

        if($request->email_changed == true){
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
        else{
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = bcrypt(Str::random(16));
            $user->language = $this->defaultLanguage();
            $user->currency = $this->defaultCurrency();
            $user->login_type = $request->login_type;
            $user->social_id = $request->social_id;
            $user->save();

            //generate API token
            $token = $user->createToken($request->username);
            $user->token = $token->plainTextToken;

            //save device details with token
            $device_token = new DeviceToken();
            $device_token->token_id = $token->accessToken->id;
            $device_token->user_id = $user->id;
            $device_token->device_type = $request->device_type;
            $device_token->device_token = $request->device_token;
            $device_token->save();

            $project = new ProjectController();
            $user->statistics = $project->statistics($request, false);

            return $this->respondWithData($user, __('api.auth.login_success'));
        }
    }

    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
        ], [
            'email.exists' => __('api.auth.email_account_not_found')
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $user = User::where('email', $request->email)->first();
        $user->notify(new ResetPasswordNotification($token, true));

        return $this->respondSuccess(__("api.auth.forgot_password_success"));
    }

    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        $data = DB::table('password_resets')->where(['token' => $request->token])->first();
        if(!$data){
            return $this->respondWithError(__("api.something_wrong"));
        }

        if(strtotime($data->created_at. "+10 minutes") < time()){
            return $this->respondWithError(__("api.auth.password_token_expired"));
        }

        $user = User::where('email', $data->email)->first();
        if(!$user){
            return $this->respondWithError(__("api.something_wrong"));
        }
        $user->password = bcrypt($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $data->email)->delete();

        return $this->respondSuccess(__("api.auth.password_reset_success"));
    }

    public function logout(Request $request){
        $token = Auth::user()->currentAccessToken();
        DeviceToken::where('token_id', $token->id)->delete();

        $token->delete();

        return $this->respondSuccess(__("api.auth.logout_success"));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Exceptions\Exception;

class AdminController extends Controller
{
   
    public function index(Request $request){
        if($request->ajax()){
            $users = Admin::where("is_master",0) ->orderBy("id", "desc")->get();

            try {
                return datatables($users)
                    ->addIndexColumn()
                   
                    ->make(true);
            }
            catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return view('admin.index');
    }



    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:admins,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }

        $admins = new Admin();
        $admins->first_name = $request->first_name;
        $admins->last_name = $request->last_name;
        $admins->email = $request->email;
        $admins->password = bcrypt($request->password);
        if ($request->hasfile('profile')) {
            $path = $request->file('profile')->store('images/users');
            $admins->profile = Storage::url($path);
        }
        $admins->save();
        return $this->respondSuccess("New admin has been added");
    }

    public function edit(Request $request ,Admin $admin)
    {
        return $this->respondWithData($admin, "Admin data");
    }


    public function delete(admin $admin)
    {

        $admin->delete();
        return $this->respondSuccess("sub-admin has been removed");
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:admins,email,'.$request->id,

        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }

        $admins = Admin::find($request->id);
        $admins->first_name = $request->first_name;
        $admins->last_name = $request->last_name;
        $admins->email = $request->email;

        if ($request->hasfile('profile')) {
            $path = $request->file('profile')->store('images/users');
            $admins->profile = Storage::url($path);
        }
        $admins->save();
        return $this->respondSuccess("Admin has been updated");
    }
    

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
           
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }
        
                
        $admin = Admin::find($request->id); 
        if (!Hash::check($request->old_password, $admin->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Old password is wrong',
            ]);
        }

        Admin::whereId($request->id)->update([
            'password' => bcrypt($request->new_password)
        ]);

        return $this->respondSuccess( "Admin Password has been updated");
    }


}

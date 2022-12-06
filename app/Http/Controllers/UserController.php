<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Exceptions\Exception;

class UserController extends Controller
{
    //
    public function index(Request $request){
        if($request->ajax()){
            $users = User::with('donations')->orderBy('id','desc')->get();

            try {
                return datatables($users)
                     ->addIndexColumn()
                     ->editColumn('user_amount', function ($row) {
                        return '$' . number_format($row->user_amount, 2);
                    })
                    ->make(true);
            }
            catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return view('user.index');
    }

    public function destroy(Request $request, User $id){
        if($id->profile){
            Storage::delete(str_replace("/storage", "", $id->profile));
        }
        $id->project->each->delete();
        $id->delete();

        return $this->respondSuccess("User has been removed");
    }

    public function changeStatus(Request $request, User $id){
        $id->is_disabled = !$id->is_disabled;

        $id->save();

        if($id->is_disabled){
            return $this->respondSuccess("User has been activated");
        }
        else{
            return $this->respondSuccess("User has been deactivated");
        }
    }


    public function subproject(Request $request, User $id){
        if($request->ajax()){

            $users = Project::where('user_id', $id->id)->with('parent_project')
                ->orderBy('id', 'desc')->get();
            try {
                return datatables($users)
                    ->addIndexColumn()
                    ->editColumn('start_date', function($row){
                        return date(getDateFormat(), strtotime($row->start_date));
                    })

                    ->editColumn('end_date', function($row){
                        return $row->end_date ? date(getDateFormat(), strtotime($row->end_date)) : '-';
                    })
                    ->editColumn('raised_amount', function($row){
                        return '$'.number_format($row->raised_amount, 2);
                    })

                    ->editColumn('goal', function($row){
                        if(!$row->goal){
                                return '-';
                            }
                        return '$'.number_format($row->goal, 2);
                    })

                    ->make(true);
            }
            catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
        $user = $id;

        return view('user.subproject', compact('user'));
    }




    public  function view( $id)
    {
        return view('user.view')
        ->with('user', User::find($id));
    }

    public function viewsubproject(Request $request, User $id){
        if($request->ajax()){

            $users = Project::where('user_id', $id->id)->with('parent_project')
                ->orderBy('id', 'desc')->get();
            try {
                return datatables($users)
                    ->addIndexColumn()
                    ->editColumn('start_date', function($row){
                        return date(getDateFormat(), strtotime($row->start_date));
                    })

                    ->editColumn('end_date', function($row){
                        return $row->end_date ? date(getDateFormat(), strtotime($row->end_date)) : '-';
                    })
                    ->editColumn('raised_amount', function($row){
                        return '$'.number_format($row->raised_amount, 2);
                    })

                    ->editColumn('goal', function($row){
                        if(!$row->goal){
                                return '-';
                            }
                        return '$'.number_format($row->goal, 2);
                    })

                    ->make(true);
            }
            catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
        $user = $id;

        return view('user.view', compact('user'));
    }

    public function viewdonation(Request $request,  User $id){
        if($request->ajax()){
            $users = Donation::where('user_id', $id->id)->with('user')
                ->with('project')
                ->orderBy('id', 'desc')->get();

            try {
                return datatables($users)
                    ->addIndexColumn()
                    ->addColumn('title', function($row){
                        return $row->project ? $row->project->title  : '-';
                    })

                    ->editColumn('created_at', function($row){
                        return date(getDateFormat(), strtotime($row->created_at));
                    })
                    ->editColumn('amount', function($row){
                        return '$' . number_format($row->amount, 2);
                    })
                    ->addColumn('raised_amount', function ($row) {
                        return '$' . number_format($row->project->raised_amount, 2);
                    })
                    ->addColumn('goal', function ($row) {
                        if (!$row->project->goal) {
                            return '-';
                        }
                        return '$' . number_format($row->project->goal, 2);
                    })

                    ->make(true);
            } catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
        $user = $id;

        return view('user.view', compact('user'));
    }
    
}

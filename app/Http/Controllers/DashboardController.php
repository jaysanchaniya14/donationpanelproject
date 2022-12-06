<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Project;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index(Request $request)
    {

        if($request->ajax()){
            $data['new_projects'] = Project::where(function($q) use ($request){
                if($request->start_date && $request->end_date){
                    $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
                }
            })->where('is_active', 1)->count();

            $data['projects_completed'] = Project::where(function($q) use ($request){
                    if($request->start_date && $request->end_date){
                        $q->whereBetween('completion_date', [$request->start_date, $request->end_date]);
                    }
                })->where('is_active', 1)
                ->where('is_completed', 1)->count();

            $data['new_users'] = User::where(function($q) use ($request){
                if($request->start_date && $request->end_date){
                    $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
                }
            })->where('is_disabled', 0)->count();

            $data['donation_amount'] = Donation::where(function($q) use ($request){
                if($request->start_date && $request->end_date){
                    $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
                }
            })->where('payment_status', 'success')->sum('amount');
            $data['donation_amount'] = "$". number_format($data['donation_amount'], '2');

            $data['donors'] = Donation::select('user_id')->where(function($q) use ($request){
                if($request->start_date && $request->end_date){
                    $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
                }
            })->where('payment_status', 'success')->distinct('user_id')->count();

            $data['top_donors'] = User::select('id', 'profile', 'first_name', 'last_name')
                ->withCount(['donations as total_amount' => function($q) use($request){
                    $q->select(DB::raw('SUM(amount) as total_amount'))
                        ->whereBetween('created_at', [$request->start_date, $request->end_date]);
                }])
                ->having('total_amount', '>', 0)
                ->where('is_disabled', 0)
                ->orderByDesc('total_amount')
                ->take(5)->get();

            $data['chart']['donation'] = Donation::selectRaw("(DATE_FORMAT(created_at, '%Y-%m-%d %H')) as datetime, sum(amount) as total_amount,
                UNIX_TIMESTAMP(DATE_FORMAT(created_at, '%Y-%m-%d %H')) * 1000 as js_timestamp")
                ->where(function($q) use ($request){
                    if($request->start_date && $request->end_date){
                        $q->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    }
                })
                ->groupBy('datetime')->get();


            foreach ($data['top_donors'] as $donation){
                $donation['total_amount'] = "$". number_format($donation['total_amount'], '2');
            }

            return $this->respondWithData($data, "Dashboard data");
        }

        return view('dashboard');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Exceptions\Exception;

class DonationController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){

            $donations = Donation::with('user')
                ->with('project')
                ->where(function($q) use ($request){
                    if($request->s_start && $request->s_end){
                        $q->whereRaw("created_at >= '".$request->s_start."'")
                            ->whereRaw("created_at <= '".$request->s_end."'");
                    }
                })
                ->orderBy('id', 'desc')->get();

            try {
                return datatables($donations)
                    ->addIndexColumn()
                    ->addColumn('user_name', function($row){
                        return $row->user ? $row->user->username  : '-';
                    })
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

        return view('transaction.index');
    }
}

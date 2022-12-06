<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Exceptions\Exception;

class ContactusController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $contacts = ContactUs::orderBy('id', 'desc')->get();

            try {
                return datatables($contacts)
                    ->addIndexColumn()
                    ->editColumn('created_at', function($row){
                        return date(getDateFormat(), strtotime($row->created_at));
                    })
                    ->make(true);
            }
            catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
        return view('contact.contactus');
       
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Exceptions\Exception;

class FaqController extends Controller
{
    public function index(Request $request){
        if($request->ajax()){
            $faqs = Faq::orderBy('id', 'desc')->get();

            try {
                return datatables($faqs)
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
        return view('contact.faq');
      
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required'
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }

        $faq = new Faq();
        $faq->question = $request->question;
        $faq->answer = $request->answer;
       
      
       
        $faq->save();
        return $this->respondSuccess("New FAQ has been added");
    }

  

    public function edit(Request $request ,Faq $faq)
    {
        return $this->respondWithData($faq, "Faq details");
    }

    public function update(Request $request ,Faq $faq)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'answer' => 'required'
           
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0], 200);
        }
      
        $faq->question = $request->question;
        $faq->answer = $request->answer;
       
        $faq->save();
        return $this->respondSuccess("FAQ has been updated");
    }

    public function destroy(Faq $faq)
    {
       

        $faq->delete();
        return $this->respondSuccess("FAQ has been removed");
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Project;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    private $currency_file = "currencies.json";
    public function index(Request $request){
        $query = Donation::with('project');

        if($request->device_token){
            $query->where('device_token', $request->device_token);
        }
        elseif($user = $request->user('sanctum')){
            $query->where('user_id', $user->id);
        }
        else{
            return $this->respondWithError("Please provide device token");
        }

        $donations = $query->orderBy('id', 'desc')->paginate(10);

        $urls['urls'] = [
            'next_url' => $donations->nextPageUrl(),
            'prev_url' => $donations->previousPageUrl(),
        ];

        $urls['total'] = $donations->total();

        return $this->respondWithAdditionalData("donation", array_merge(['donations' => $donations->items()], $urls), 'success');
    }

    public function getInvoice(Request $request, Donation $donation){

        $file = "invoices/invoice_".$donation->id.".pdf";
        if(!Storage::exists($file)){
            $pdf = Pdf::loadView('pdf.invoice', compact('donation'))
                ->setPaper('a4');
            Storage::put($file, $pdf->output());
        }
        return $this->respondWithAdditionalData(
            "donation_invoice", [
                'invoice' => config('app.url').Storage::url($file)
            ],
            'success');
    }

    public function getCurrencies(Request $request){

        if(!Storage::disk('internal')->exists($this->currency_file)){
            return $this->respondWithError(__('api.something_wrong'));
        }
        $currencies = Storage::disk('internal')->get($this->currency_file);

        $data = [];
        foreach (json_decode($currencies) as $key => $value){
            $data[] = [
                'key' => $key,
                'value' => $value->name,
                'symbol' => $value->symbolNative
                ];
        }
        return $this->respondWithAdditionalData("currencies", ['currencies' => $data], 'success');
    }

    public function updateCurrency(Request $request){
        $validator = Validator::make($request->all(), [
            'currency' => 'required',
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        $currencies = Storage::disk('internal')->get($this->currency_file);
        $currencies = json_decode($currencies);
        if(!property_exists($currencies, strtoupper($request->currency))){
            return $this->respondWithError(__('api.payments.invalid_currency'));
        }

        $request->user()->currency = strtoupper($request->currency);
        $request->user()->save();

        return $this->respondSuccess(__('api.payments.currency_update_success'));
    }

    public function leaderBoard(Request $request){
        $data = [];

        for($i = 1; $i <= 12; $i++){
            $list = Donation::with('user')
                ->whereHas('user', function($q){
                    $q->where('is_disabled', 0);
                })
                ->select('*', DB::raw('sum(amount) as total_amount'))
                ->whereYear('created_at', '=', date('Y'))
                ->whereMonth('created_at', '=', "0$i")
                ->orderByDesc('total_amount')
                ->groupBy('user_id')
                ->paginate(10);

            $donations = [];
            foreach($list as $donation){
                $temp['id'] = $donation->user->id;
                $temp['profile'] = $donation->user->profile;
                $temp['first_name'] = $donation->user->first_name;
                $temp['last_name'] = $donation->user->last_name;
                $temp['username'] = $donation->user->username;
                $temp['total_amount'] = $donation->total_amount;

                $donations[] = $temp;
            }

            $list = Donation::select('*', DB::raw('sum(amount) as total_amount'))
                ->whereYear('created_at', '=', date('Y'))
                ->whereNull('user_id')
                ->whereMonth('created_at', '=', "0$i")
                ->orderByDesc('total_amount')
                ->groupBy('device_token')
                ->paginate(10);

            foreach($list as $donation){
                $temp['id'] = null;
                $temp['profile'] = null;
                $temp['first_name'] = null;
                $temp['last_name'] = null;
                $temp['username'] = null;
                $temp['total_amount'] = $donation->total_amount;

                $donations[] = $temp;
            }

            $amount = array_column($donations, 'total_amount');
            array_multisort($amount, SORT_DESC, $donations);

            $data[strtolower(date('F', mktime(0, 0, 0, $i, 10)))] = array_slice($donations, 0, 10);
        }

        return $this->respondWithAdditionalData("leaderboard", ['leaderboard' => $data], 'success');
    }

    public function currencyRate(Request $request){
        $validator = Validator::make($request->all(), [
            'currency' => 'required',
        ]);

        if($validator->fails()){
            $errors = collect($validator->errors());
            $error = $errors->unique()->first();
            return $this->respondWithError($error[0]);
        }

        $response = Http::withHeaders([
            "apikey" => env('CURRENCY_CONVERTER_API_KEY')
        ])->get('https://api.apilayer.com/exchangerates_data/convert', [
            'amount' => 1,
            'from' => $this->defaultCurrency(),
            'to' => strtoupper($request->currency)
        ]);

        $data = $response->json();
        if($response->failed()){
            if(isset($data['error']) && $data['error']['code'] == "invalid_to_currency"){
                return $this->respondWithError(__('api.payments.invalid_currency'));
            }
            else{
                return $this->respondWithError(__('api.something_wrong'));
            }
        }else{
            return $this->respondWithAdditionalData(
                "currency_rate", [
                'currency_rate' => $data['info']['rate']
            ], 'success');
        }
    }

    public function donations(Request $request, Project $project){
        $donations = Donation::select('id', 'user_id', 'project_id', 'amount')
            ->with('user')
            ->where('project_id', $project->id)
            ->where('payment_status', 'success')
            ->get();

        return $this->respondWithAdditionalData('donations', ['donations' => $donations], "success");
    }
}

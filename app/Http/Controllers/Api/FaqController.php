<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Legal;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function getLegals(Request $request){
        $legals = Legal::orderByDesc('id')->first();

        return $this->respondWithAdditionalData("legals", ['legals' => $legals], 'success');
    }

    public function getFAQs(Request $request){
        $faqs = Faq::orderbydesc('id')->get();
        return $this->respondWithAdditionalData("faqs", ['faqs' => $faqs], 'success');
    }
}

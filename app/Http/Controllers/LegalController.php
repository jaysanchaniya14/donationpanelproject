<?php

namespace App\Http\Controllers;

use App\Models\Legal;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function edit(Request $request, $type){
        $legal = Legal::first();

        if(!$legal){
            $legal = new Legal();
        }

        return view('legal.'.$type, compact('legal'));
    }

    public function update(Request $request){
        $legal = Legal::first();
        if(!$legal){
            $legal = new Legal();
            $legal->tou = "";
            $legal->imprint = "";
            $legal->about_us = "";
            $legal->privacy_policy = "";
        }
        $key = $request->legal_type;
        $legal->$key = $request->legal_data;
        $legal->save();

        return redirect()->back()->with('success', 'Data updated successfully');
    }
}

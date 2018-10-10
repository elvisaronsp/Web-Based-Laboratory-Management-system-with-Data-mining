<?php

namespace App\Http\Controllers;

use App\BloodSuger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function bloodSuger(Request $request){
        $bs = new BloodSuger();
        $bs->paymentStatus=$request->payment;
        $bs->userId=$request->id;
        $bs->bloodSuger=$request->bsvalue;
        $bs->save();
        return back();
    }
}

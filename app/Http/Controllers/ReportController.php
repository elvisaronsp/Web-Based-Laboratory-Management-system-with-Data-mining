<?php

namespace App\Http\Controllers;

use App\BloodSuger;
use App\LipidProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


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

    public function lipid(Request $request){
        $lp = new LipidProfile();
        $lp->paymentStatus=$request->payment;
        $lp->userId=$request->id;
        $lp->serum=$request->serum;
        $lp->hdl=$request->hdl;
        $lp->vldl=$request->vldl;
        $lp->trigly=$request->trigly;
        $lp->cholestrol=$request->cholestrol;
        $lp->save();
        return back();

    }


}


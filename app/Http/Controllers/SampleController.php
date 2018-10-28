<?php

namespace App\Http\Controllers;

use App\Sample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SampleController extends Controller
{
    public function addSample(Request $request){
        $sm =new Sample();
        $sm->sampleId=$request->sid;
        $sm->date=$request->sdate;
        $sm->save();
        Session::put('sampleadd', 'Sample Added Successfully');
        return back();
    }

    public function deleteSample(Request $request){
        DB::table('samples')->where('id',$request->sid)->delete();
        return back();
    }
}


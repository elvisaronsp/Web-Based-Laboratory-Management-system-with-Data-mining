<?php

namespace App\Http\Controllers;

use App\BloodSuger;
use App\FullBloodCount;
use App\LipidProfile;
use App\LiverFunction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
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

        $user=DB::table('users')->where('id',$request->id)->first();
        $usere=$user->email;

        if($request->bsvalue>=120){
            $data = array('name'=>"$user->name", "body" => "Test mail");

            Mail::send('email', $data, function($message) use($usere) {
                $message->to('wvd.51461@gmail.com')
                    ->subject('Regarding Your Lab Reports');
                $message->from('akashsahan963@gmail.com','Mebi Lab');
            });
        }




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

    public function fbc(Request $request){
        $fbc = new FullBloodCount();
        $fbc->paymentStatus=$request->payment;
        $fbc->userId=$request->id;
        $fbc->neutrophil=$request->neutrophil;
        $fbc->lymphocytes=$request->lymphocytes;
        $fbc->monocytes=$request->monocytes;
        $fbc->hemoglobin=$request->hemoglobin;
        $fbc->rbc=$request->rbc;
        $fbc->save();
        return back();

    }

    public function liver(Request $request){
        $lf = new LiverFunction();
        $lf->paymentStatus=$request->payment;
        $lf->userId=$request->id;
        $lf->totalProtein=$request->totalProtein;
        $lf->albumin=$request->albumin;
        $lf->globulin=$request->globulin;
        $lf->alkaline=$request->alkaline;
        $lf->totalBilirubin=$request->totalBilirubin;
        $lf->save();
        return back();

    }


}


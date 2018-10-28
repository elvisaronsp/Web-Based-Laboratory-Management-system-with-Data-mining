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
use Illuminate\Support\Facades\Session;


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

        if($request->bsvalue>=120 or $request->bsvalue<=85){
            $data = array('name'=>"$user->name", "body" => "Test mail");

            Mail::send('email', $data, function($message) use($usere) {
                $message->to($usere)
                    ->subject('Regarding Your Lab Reports');
                $message->from('akashsahan963@gmail.com','Mebi Lab');
            });
        }else{
            $last = BloodSuger::where('userId',$request->id)->orderBy('id', 'desc')->take(5)->get();
            $c=DB::table('blood_sugers')->where('userId',$request->id)->count();
            $count = 0;
            $value = array();

            if($c>=5){


                foreach ($last as $l){

                    array_push($value,$l->bloodSuger);
                }

                for($i=0;$i<4;$i++){

                    if($value[$i]-$value[$i+1]>4){

                        $count++;
                    }
                }


                if($count==4){
                    $data = array('name'=>"$user->name", "body" => "Test mail");

                    Mail::send('email', $data, function($message) use($usere) {
                        $message->to($usere)
                            ->subject('Regarding Your Lab Reports');
                        $message->from('akashsahan963@gmail.com','Mebi Lab');
                    });
                }else{
                    if($value[0]-$value[4]>=15 or $value[4]-$value[0]>15){
                        $data = array('name'=>"$user->name", "body" => "Test mail");

                        Mail::send('email', $data, function($message) use($usere) {
                            $message->to($usere)
                                ->subject('Regarding Your Lab Reports');
                            $message->from('akashsahan963@gmail.com','Mebi Lab');
                        });
                    }


                }
            }
        }



        Session::put('rpa', 'Report Updated Successfully');
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
        Session::put('rpa', 'Report Updated Successfully');
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
        Session::put('rpa', 'employee Updated Successfully');
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
        Session::put('rpa', 'employee Updated Successfully');
        return back();

    }

    public function addPatient(Request $request){
        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->gender=$request->gender;
        $user->dob=$request->dob;
        $user->save();
        Session::put('pa', 'Patient Updated Successfully');
        return back();
    }


}


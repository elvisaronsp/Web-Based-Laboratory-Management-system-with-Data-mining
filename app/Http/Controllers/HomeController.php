<?php

namespace App\Http\Controllers;

use App\BloodSuger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = DB::table('users')->where('role','patient')->get();
        $lipidProfile = DB::table('lipid_profiles')->where('userId',Auth::user()->id)->orderBy('id','desc')->get();
        $sugers = DB::table('blood_sugers')->where('userId',Auth::user()->id)->orderBy('id','desc')->get();
        $fbc= DB::table('full_blood_counts')->where('userId',Auth::user()->id)->orderBy('id','desc')->get();
        $lft= DB::table('liver_functions')->where('userId',Auth::user()->id)->orderBy('id','desc')->get();
        $slp= DB::table('serums')->where('userId',Auth::user()->id)->orderBy('id','desc')->get();

        $sm = DB::table('samples')->get();
        $emp = DB::table('employees')->get();

        return view('home',compact('user','lipidProfile','sugers','fbc','lft','sm','emp','slp'));
        //return view('home',(['user'=>$user,'sugers'=>$suger,'lipidProfile'=>$lipidProfile]));
    }

    public function uploadPhoto(Request $request){
        $request->file('pic')->move(
            base_path() . '/public/img/', Auth::user()->id
        );

        return back();
    }
}

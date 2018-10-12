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
        $lipidProfile = DB::table('lipid_profiles')->where('userId',Auth::user()->id)->get();
        $sugers = DB::table('blood_sugers')->where('userId',Auth::user()->id)->get();

        return view('home',compact('user','lipidProfile','suger'));
        //return view('home',(['user'=>$user,'sugers'=>$suger,'lipidProfile'=>$lipidProfile]));
    }

    public function uploadPhoto(Request $request){
        $request->file('pic')->move(
            base_path() . '/public/img/', Auth::user()->id
        );

        return back();
    }
}

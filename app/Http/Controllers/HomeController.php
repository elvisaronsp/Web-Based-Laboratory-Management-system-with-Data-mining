<?php

namespace App\Http\Controllers;

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

        return view('home',compact('user'));
    }

    public function uploadPhoto(Request $request){
        $request->file('pic')->move(
            base_path() . '/public/img/', Auth::user()->id
        );

        return back();
    }
}

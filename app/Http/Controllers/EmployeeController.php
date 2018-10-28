<?php

namespace App\Http\Controllers;

use App\Employee;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    public function addMLT(Request $request){
        $user = new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt($request->password);
        $user->gender=$request->gender;
        $user->dob=$request->dob;
        $user->role="MLT";
        $user->save();
        Session::put('mlt', 'MLT Added Successfully');
        return back();
    }

    public function addEmployee(Request $request){
        $user = new Employee();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->salary=$request->salary;
        $user->gender=$request->gender;
        $user->dob=$request->dob;
        $user->position=$request->position;
        $user->cno=$request->cno;
        $user->address=$request->address;
        $user->save();
        Session::put('em', 'employee Added Successfully');
        return back();
    }

    public function deleteEmployee(Request $request){
        DB::table('employees')->where('id',$request->eid)->delete();
        Session::put('emdel', 'employee Deleted Successfully');
        return back();

    }

    public function updateEmployee(Request $request){
        DB::table('employees')
            ->where('id', $request->eid)
            ->update([
                'name' =>$request->name,
                'email' =>$request->email,
                'salary'=>$request->salary,
                'gender'=>$request->gender,
                'dob'=>$request->dob,
                'position'=>$request->position,
                'cno'=>$request->cno,
                'address'=>$request->address
                ]);
        Session::put('emup', 'employee Updated Successfully');
        return back();
    }
}

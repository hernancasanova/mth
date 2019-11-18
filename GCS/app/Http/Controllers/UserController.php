<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Str;
use DB;

class UserController extends Controller
{
    //
    public function login(Request $request){
    	/*$usuario=$request->usuario;
    	$contraseña=$request->contraseña;
    	$userExist=DB::table('users')->where([
	    	['name', $usuario],
	    	['password',$contraseña],
			])->exists();
		$equalPasswords=false;
		$userExist=DB::table('users')->where('name',$usuario)->exists();
	    if($userExist){
	    	$hashedPassword=DB::table('users')->where('name',$usuario)->value('password');
	    	$equalPasswords=Hash::check($contraseña, $hashedPassword);
	    }
        if($equalPasswords){
        	return response([
        		'equalPasswords' => $equalPasswords,
	            'status_code' => 200,
	        ], 200);
        }
        else{
        	return response([
        		'userExist' => $userExist,
	            'status_code' => 404,
	        ], 200);
        }*/
    }
    public function update(Request $request, $id){
        //if (!(Hash::check($request->get('contrasenaActual'), Auth::user()->password))) {
        if (!(Hash::check($request->get('contrasenaActual'), auth()->user()->password))) {
            // The passwords not matches
            //return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
            //return response()->json(['errors' => ['current'=> ['Current password does not match']]], 422);
            return response([
                'status_code' => 421,
            ], 200);
        }
        //uncomment this if you need to validate that the new password is same as old one

        if(strcmp($request->get('contrasenaActual'), $request->get('contrasenaNueva')) == 0){
            return response([
                'status_code' => 422,
            ], 200);
            //Current password and new password are same
            //return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
            //return response()->json(['errors' => ['current'=> ['New Password cannot be same as your current password']]], 422);
        }
        /*$validatedData = $request->validate([
            'contrasenaActual' => 'required',
            'contrasenaNueva' => 'required|string|min:6|confirmed',
        ]);*/
        //Change Password
        $user = auth()->user();
        $user->password = Hash::make($request->get('contrasenaNueva'));
        $user->save();
        return response([
                'status_code' => 200,
            ], 200);
    }
}

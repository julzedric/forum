<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class AdminLoginController extends Controller
{
	//use AuthenticatesUsers;

	public function __construct()
    {
        $this->middleware('guest:admin',['except'=>['logout']]);
    }

    public function showLoginForm()
    {
    	return view('admin.admin-login');
    }

    public function login(Request $request)
    {
    	//Validate the form
    	$this->validate($request, [
    		'email'	=>	'required|email',
    		'password'	=>	'required|min:6'
    		]);
    	//Attempt to log the user
    	$cred = [
    		'email' => $request->email,
    		'password' => $request->password
    	];
    	$remember = $request->remember_admin;
    	if (Auth::guard('admin')->attempt($cred,$remember)) {
    		//if successful, redirect to dashboard
    		return redirect()->intended(route('admin.dashboard'));
    	}else{

    		return redirect()->back()->withInput($request->only('email', 'remember'));

    	}
    	
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}

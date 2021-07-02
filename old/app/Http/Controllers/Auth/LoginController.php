<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/form-builder/forms';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
   
    public function post_login_admin(Request $request)
    {
        
       //dd($request->all());

        $all= $request->all();
        $validator = Validator::make($all, [
            'email' => 'required|email',
            'password' => 'required',
                
            ]);

    if($validator->passes()) {
        
        if(Auth::guard('admin')->attempt(['email'=>$all['email'], 'password' =>$all['password'] ,'type'=>1]))
        {
            //dd("Here");
            return redirect()->intended('/form-builder/forms');
        }
        else
        {
            //  dd('not');

            return redirect()->back()
         
           ->withErrors(['match'=>'Email id password not matched! Try again '
           ]);
        }
          // return back()->withInput($request->only('email'));
           // return redirect()->intended('login')->with('status', 'Invalid Login Credentials !');
        }else{
            return redirect()->back()->withErrors($validator);
        }

    }

    public function post_login_user(Request $request)
    {
        

       

        $all= $request->all();
        if (Auth::attempt(['email'=>$all['email'], 'password' =>$all['password'] ,'type'=>1])) 
        {
            dd("Here");
            return redirect()->intended('home');
        }
        else
        {
           //  dd('not');

  
           return back()->withInput($request->only('email'));
           // return redirect()->intended('login')->with('status', 'Invalid Login Credentials !');
        }

    }

    public function logout(Request $request)
    {     
            if(\Auth::guard('admin')->check())
            {
                \Auth::guard('admin')->logout();
                //$request->session()->invalidate();
            }
            return  redirect('/');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

   



}

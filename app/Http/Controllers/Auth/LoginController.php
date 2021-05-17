<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;
use Socialite;
use App\User;
use Illuminate\Support\Facades\DB;

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


    public function redirectToFacebook() {
       
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback() {
        
      try {
            
            
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('email', $user->email)->first();
            
            
            
            if ($finduser) {
                
                //$userD=['name'=>$finduser->name, 'email'=>$finduser->email];
                //Auth::login($finduser);
                Auth::guard('user')->login($finduser);
                return redirect('/');
                //return redirect('/?signup=true')->with('userData', $userD);
            } else {
                
                //$userD=['name'=>$user->name, 'email'=>$user->email];
              
                $form = DB::table('forms')->where('identifier', 'signup')->first();
				//dd($user->email);	
              
               $newUser = User::create(['name' => $user->name,'type'=>'2', 'email' => $user->email, 'facebook_id' => $user->id]);
                
              	$arr=[];
                $arr['fname']= $user->name;
                $arr['lname']="";
                $arr['email']=$user->email;
                $input = json_encode(json_encode($arr));
                $id=$newUser->id;
                $selectedGrades=[];
                $allGrades=['1','2','3','4','5'];
                $birth_year=[];
               
                $data=['user_id' => $id,
                    'content' => $input,
                    'form_id'=>$form->id,
                    'selected_grades'=>json_encode($selectedGrades),
                    'all_grades'=>json_encode($allGrades),
                    'birth_years'=>json_encode($birth_year),
                    "created_at"=> now(),
                    "updated_at"=> now()
                ];
                  
                
                DB::table('form_submissions')->insert($data);
                //Auth::login($newUser);
                Auth::guard('user')->login($newUser);
                return redirect('/');
                //return redirect('/?signup=true')->with('userData', $userD);
                //return redirect()->back();
                
            }
        }
        catch(\Exception $e) {
            return redirect('/');
        }
    }


    public function redirectToGoogle() {
       
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback() {
        
        try {
            
            
            $user = Socialite::driver('google')->user();
            $finduser = User::where('email', $user->email)->first();
            
            
            
            if ($finduser) {
                
                //$userD=['name'=>$finduser->name, 'email'=>$finduser->email];
                //Auth::login($finduser);
                Auth::guard('user')->login($finduser);
                return redirect('/');
                //return redirect('/?signup=true')->with('userData', $userD);
            } else {
                
                $form = DB::table('forms')->where('identifier', 'signup')->first();
                //dd($form);
                $newUser = User::create(['name' => $user->name,'type'=>'2', 'email' => $user->email, 'facebook_id' => $user->id]);
                //dd($newUser);
                $arr=[];
                $arr['fname']= $user->name;
                $arr['lname']="";
                $arr['email']=$user->email;
                $input = json_encode(json_encode($arr));
                $id=$newUser->id;
                $selectedGrades=[];
                $allGrades=['1','2','3','4','5'];
                $birth_year=[];
               
                $data=['user_id' => $id,
                    'content' => $input,
                    'form_id'=>$form->id,
                    'selected_grades'=>json_encode($selectedGrades),
                    'all_grades'=>json_encode($allGrades),
                    'birth_years'=>json_encode($birth_year),
                    "created_at"=> now(),
                    "updated_at"=> now()
                ];
                  
                
                DB::table('form_submissions')->insert($data);
                //Auth::login($newUser);
                Auth::guard('user')->login($newUser);
                return redirect('/');
               
                
                //$userD=['name'=>$user->name, 'email'=>$user->email];
                //$newUser = User::create(['name' => $user->name, 'email' => $user->email, 'facebook_id' => $user->id]);
                //Auth::login($newUser);
               
                //return redirect('/?signup=true')->with('userData', $userD);
                //return redirect()->back();
            }
        }
        catch(\Exception $e) {
            return redirect('/');
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

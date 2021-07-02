<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use jazmy\FormBuilder\Models\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use jazmy\FormBuilder\Models\Submission;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Transformers\Json;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Contentful\Delivery\Client as DeliveryClient;
use Ajay;


class LoginController extends Controller
{
    public function __construct(DeliveryClient $client) 
    {
      $this->middleware('auth:user', ['only' => ['userDashboard']]);
      $this->client = $client;
      $this->query = new \Contentful\Delivery\Query();
        $this->renderer = new \Contentful\RichText\Renderer();

    }
   
    public function loginForm()
    {
       
        return view('user_auth.login');
    }

    /* @POST
*/
public function login(Request $request){
    
       $all=$request->all();
       $validator = Validator::make($all, [
        'email' => 'required|email',
        'password' => 'required',
            
        ]);


        if($validator->passes()) {
            
          $auth=\Auth::guard('user')->attempt([
                'email' => $request->email,
                'password' => $request->password,
                'type'=>'2',
                'active'=>'1'
                ]);
                
           if($auth)
           {
            $user_auth=Auth::guard('user')->user();
            $id=$user_auth->id;
            $ret= $this->userGrades($id);
           
         
            return response()->json(['status'=>true,'message'=>'Login successfully.']);

           }else{
            return response()->json(['status'=>false,'message'=>'Id password not matched.']);

           } 
			
        }
        return response()->json([
            'status'=>'invalid',
            'errors' => $validator->getMessageBag()->toArray()
            ]);

    
}
/* GET
*/
public function logout(Request $request)
{
  if(\Auth::guard('user')->check())
    {
     //dd(\Auth::guard('user'));

      \Auth::guard('user')->logout();
      //  $request->session()->invalidate();
    }
    return  redirect('/');
}




    public function userSignup(Request $request)
    {
        
      $all=$request->all();
      $selectedGrades= $all['selectedGrades'];
      $year= date("Y");
      
      foreach($selectedGrades as $grade)
      {
         $birth_year[]=$year-5-$grade;
      }
     
      $allGrades=$all['allGades'];
      
      $formData=$all['formData'];
     // $password=$all['password'];
      
      //dd($formData);
       
      
      foreach($formData as $openKey=>$openVal)
      {
        
          $arr[$openVal['name']]=$openVal['value'];
      }
    
      $fname=$arr['fname'];
      $lname=$arr['lname'];
      $email=$arr['email'];
      $password=$arr['password'];
    
    $validator = Validator::make($arr, [
        
        'email' => 'required|email|unique:users',
        ]);
         
    if ($validator->passes()) {

        $user=User::create([
            'name' => $fname.' '.$lname,
            'email' => $email,
            'password' => Hash::make($password),
            'type'=>'2',
        ]);  




        DB::beginTransaction();

        try {
          
            $input = json_encode($arr);
           
            $form = Form::where('identifier', 'signup')->firstOrFail();
          
            $form->submissions()->create([
                'user_id' => $user->id,
                'content' => $input,
                'selected_grades'=>json_encode($selectedGrades),
                'all_grades'=>json_encode($allGrades),
                'birth_years'=>json_encode($birth_year)
            ]);
             

            DB::commit();

            $data=[
               'fname'=>$fname,
               'lname'=>$lname
              ];
             
              // $listID="caa284fd88"; 
              // $segment_id=262305;
              // // forget password  $template_id=101185;
              // $template_id=101205;
               Ajay::SendSignupMail($email,$fname,$lname,$selectedGrades);



            try {
            Mail::send('emails.signup', $data, function($message)  use ($email, $fname, $lname)
             {
               $message->to($email,$fname.' '.$lname)->subject('Welcome to Postcard signup');
             });
            }catch(Exception $e)
            {
              
            }
            
            return response()->json([
                'status'=>true,
                'message' => 'data inserted successfully'
                ]);

            
            

      } catch (Throwable $e) {
            info($e);

            DB::rollback();

            
            return response()->json([
                'status'=>false,
                'error' => Helper::wtf()
                ]);
        }
    
    
    
    }
      //dd($arr);

      //dd($form2data);
      return response()->json([
        'status'=>false,
        //'error'=>$validator->errors()->all()
        'errors' => $validator->getMessageBag()->toArray()
        ]);

    }

    public function userUpdate(Request $request)
    {
     
      $all=$request->all();
      
      $user_auth=Auth::guard('user')->user();
      
      $selectedGrades= $all['selectedGrades'];
      $allGrades=$all['allGades'];

      $year= date("Y");
      
      foreach($selectedGrades as $grade)
      {
         $birth_year[]=$year-5-$grade;
      }
      
      $formData=$all['formData'];
     // $password=$all['password'];
      
      //dd($formData);
      
      
      foreach($formData as $openKey=>$openVal)
      {
        
          $arr[$openVal['name']]=$openVal['value'];
      }
    
      
      $fname=$arr['fname'];
      $lname=$arr['lname'];
      

    
      $user= User::find($user_auth->id);
      $user->name=$fname.' '.$lname;
      $user->save();

      $email=$user->email;


      $input = json_encode(json_encode($arr));
      $upData= [
                'content' => $input,
                'selected_grades'=>json_encode($selectedGrades),
                'all_grades'=>json_encode($allGrades),
                'birth_years'=>json_encode($birth_year)
              ];
      
        $form_submissions= DB::table('form_submissions')
        
        ->where('user_id','=',$user_auth->id)
        ->update($upData);
        
        $data=[
          'fname'=>$fname,
          'lname'=>$lname
         ];


         

        //  $listID="caa284fd88"; 
        //  $segment_id=262305;
        //  // forget password  $template_id=101185;
        //   $template_id=101353;
           Ajay::SendProfileUpdateMail($email,$fname,$lname,$selectedGrades);


         


        try {
            Mail::send('emails.updateProfile', $data, function ($message) use ($email, $fname, $lname) {
                $message->to($email, $fname.' '.$lname)->subject('Postcard updated form successfully');
            });
        }catch(Exception $e)
        {
          
        }
        if($form_submissions)
        {
          return response()->json([
          'status'=>true,
          'message' => 'data inserted successfully'
          ]);
        }else{

          return response()->json([
            'status'=>false,
            'message' => 'Something Went wrong'
            ]);

        }
        
         }

    public function userDash()
    {

        $user = auth()->user();
       
       

      $detail= DB::table('form_submissions as t1')
       
        ->where('user_id','=',$user->id)
        ->first();

        $json_data=(Array)json_decode(json_decode($detail->content));


        $form_data=DB::table('forms')
         ->where('id','=',$detail->form_id)
         ->first();

       $form_array= json_decode($form_data->form_builder_json);
       foreach($form_array as $openKey=>$openVal)
       {
           $New_form_arr[$openVal->name]=$openVal->label;
       }
        
       $form_grade_data=DB::table('forms')
         ->where('id','=','4')
         ->first();

        
         $form_grade_array= json_decode($form_grade_data->form_builder_json);
         
        // dd();
        $form_grade_array=  $form_grade_array[0]->values;
         foreach($form_grade_array as $openGKey=>$openGVal)
         {
            

             $New_grade_arr[ $openGVal->value ]=$openGVal->label;
         }
       


       // echo '<pre>'; print_r($New_form_arr);

        $selectedGrades=$json_data['PrevSelectData'];
        $selectedGradesArr=json_decode($selectedGrades);



         foreach($New_form_arr as $new_form_key=>$New_form_val)
         {
            
           if(!empty($json_data[$new_form_key]))
           {
            $Main_modified_array[$New_form_val]=$json_data[$new_form_key];
           }
            
         }
          
         foreach($selectedGradesArr as $gKey=>$gVal)
         {
            
            $New_grade_arr_with_key[$gVal]=$New_grade_arr[$gVal];
         }
       

    //    echo '<pre>'; print_r($New_grade_arr);
    //    echo '<pre>'; print_r($json_data);
    //    echo '<pre>'; print_r(json_decode($selectedGrades));
      // echo '<pre>'; print_r($Main_modified_array);
       //echo '<pre>'; print_r($New_grade_arr_with_key);
       
                   

        return view('user_panel.show')->with('values_array',$Main_modified_array)
        ->with('grades_array',$New_grade_arr_with_key);


    }


    public function userGrades($userId)
    {
        
      $detail= DB::table('form_submissions as t1')
       
      ->where('user_id','=',$userId)
      ->first();
       $selectedGradesArr=json_decode($detail->selected_grades);
       Session::put('grades_array_data',$selectedGradesArr);
     
      return ['detail'=>$detail,
      'selectedGradesArr'=>$selectedGradesArr];
    
    }
    public function userDashboard(){
      
         $user_auth=Auth::guard('user')->user();
      
         $id=$user_auth->id;
       
        $ret=$this->userGrades($id);

        
        $detail=$ret['detail'];
        $selectedGradesArr=$ret['selectedGradesArr'];


         $json_data=(Array)json_decode(json_decode($detail->content));
        

        
       
        $form_data=DB::table('forms')
         ->where('id','=',$detail->form_id)
         ->first();

        $form_array=json_decode($form_data->form_builder_json);
         
       

        foreach($form_array as $openKey=>$openVal)
       {
         
           $New_form_arr_form[$openVal->name]=$openVal;
       }
      
       foreach($form_array as $openKey=>$openVal)
       {
           $New_form_arr[$openVal->name]=$openVal->label;
       }
        
       

       $form_grade_data=DB::table('forms')
         ->where('id','=','4')
         ->first();

        
         $form_grade_array= json_decode($form_grade_data->form_builder_json);
       
       
        
        $form_grade_array=  $form_grade_array[0]->values;
        foreach($form_grade_array as $openGKey=>$openGVal)
         {
            

             $New_grade_arr[ $openGVal->value ]=$openGVal->label;
         }
         
          //print_r($New_grade_arr);

       // echo '<pre>'; print_r($New_form_arr);

        
         
      
         //dd($selectedGradesArr);


         foreach($New_form_arr as $new_form_key=>$New_form_val)
         {
            
           if(!empty($json_data[$new_form_key]))
           {
            $Main_modified_array[$New_form_val]=$json_data[$new_form_key];
            
           }
            
         }
        


         foreach($New_form_arr_form as $new_form_key=>$New_form_val)
         {
            //dd($New_form_val);
           if(!empty($json_data[$new_form_key]))
           {
            $New_form_val->value=$json_data[$new_form_key];
            
           }
            
         }
         
         //dd(array_values($New_form_arr_form));

         
         foreach($selectedGradesArr as $gKey=>$gVal)
         {
            
            $New_grade_arr_with_key[$gVal]=$New_grade_arr[$gVal];
         }
      
         
         

         //dd($New_grade_arr_with_key);
       
         $form1 = $form_grade_data->form_builder_json;
         $form2=json_encode(array_values($New_form_arr_form));
         //$form1 = Form::where('identifier', 'form1')->firstOrFail();
         
        return view('site.other_pages.dashboard',compact('form2','form1'))->with('values_array',$Main_modified_array)
        ->with('grades_array',$New_grade_arr_with_key)->with('client',$this->client)
        ->with('detail',$json_data)->with('detail1',$detail)
        ->with('renderer',$this->renderer)->with('query',$this->query);

       //return view('site.other_pages.dashboard');

    }

    
   
    public function forget_password(Request $request)
    {
        $all=$request->all();
     

       $validator = Validator::make($all, [
        
        'email' => 'required|email',
        ]);
         
        if($validator->passes()) {
          $email=$all['email'];
          
          $user=User::where ('email', $email)->first();
          
         
       if ($user){

                  //create a new token to be sent to the user. 
                DB::table('password_resets')->insert([
                    'email' => $email,
                    'token' => str_random(60), //change 60 to any length you want
                    'created_at' => Carbon::now()
                ]);

                $tokenData = DB::table('password_resets')
                ->where('email', $email)->first();

               $token=$tokenData->token;

            $data=[
              'name'=>$user->name,
              'token'=>$token,
              'email'=>$email

            ];
               
           $link_reset= url("/password_reset/$email/$token");
            
           
           $fname= $user['name'];

           $listID="caa284fd88"; 
           $segment_id=262305;
           // forget password  $template_id=101185;
           // $template_id=101185;
           $template_id=101345;
           
          //  Ajay::SendResetPasswordMail($listID,$template_id,$segment_id,$email,$fname,$link_reset);

          try {
            $mail=Mail::send('emails.reset_pass', $data, function($message)  use ($email)
             {
               $message->to($email)->subject('Postcard password reset link');
             });
            } 
            catch (Exception $e) {

            }
             return response()->json([
              'status'=>true,
              //'error'=>$validator->errors()->all()
              'message' => 'email successfully send'
              ]);

            

       }else{
        return response()->json([
          'status'=>2,
          //'error'=>$validator->errors()->all()
          'message' => "Email id Not found Please signup"
          ]);
        
       }

    }else{
      return response()->json([
        'status'=>false,
        //'error'=>$validator->errors()->all()
        'errors' => $validator->getMessageBag()->toArray()
        ]);
    }


    }

    public function password_reset($email,$token)
    {
      $form2 = Form::where('identifier', 'signup')->firstOrFail();
      $form1 = Form::where('identifier', 'form1')->firstOrFail();
     return view('site.other_pages.password_reset',compact('form1','form2'))
      ->with('token',$token)->with('email',$email)
      ->with('client',$this->client) ->with('renderer',$this->renderer)->with('query',$this->query);
    }
    

    public function update_password(Request $request)
    {

     $all=$request->all();
     
     $validator = Validator::make($all, [
        
      'token' => 'required',
      'email' => 'required|email',
      'password' => 'required|confirmed',
      ]);
       
      if($validator->passes()) {

        $token=$all['token'];
        $email=$all['email'];
        $password=$all['password'];

        
     $tokenData = DB::table('password_resets')
     ->where('token', $token)->where('email', $email)->first();
     if(empty($tokenData))
     {
      Session::flash('error', "Your token has expired. Please reset password again");
      return Redirect::back();
     }

     

     $user = User::where('email', $email)->first();
     if (!$user) {
         Session::flash('error', "Your mail id not found");
         return Redirect::back();
     }
     $user->password = Hash::make($password);
     $user->update(); //or $user->save();
     DB::table('password_resets')->where('email', $email)->delete();
     //do we log the user directly or let them login and try their password for the first time ? if yes 
     //Auth::login($user);
    
     Session::flash('success', "Password changed successfully . Login with your new password");
     return Redirect::back();
     //return Redirect::back()->with('message', 'Password updated successfully! Login with your ID password');
   


      }else{

        return Redirect::back()->withErrors($validator);
      }
    
    


    }

    public function reset_status()
    {
      return view('site.other_pages.status');
    }

    public function getInTouch(Request $request)
    {
         $all=$request->all();
         $validator = Validator::make($all, [
        
          'email' => 'required|email',
          'message' => 'required',
          ]);
           
          if($validator->passes()) {

            
          // $data=[
          // 'email'=>$email,
          // 'senderEmail'=>$all['email'],
          
          // 'message'=>$all['message']

          //  ];
         
           $sender=$all['email'];
           $message= $all['message'];

           $data=[
            'senderEmail'=>$sender,
            'message_touch'=>$message
           ];
         $segment_id=262121;
         $template_id=101069;
         $listID="d2ae77bf0e";
        Ajay::SendGetInTouchMail($listID,$template_id , $segment_id, $sender,$message);
        //  Mail::send('emails.get_touch', $data, function($message)  use ($email)
        //   {
        //     $message->to($email)->subject('Get in touch email');
        //   });
         
         return response()->json([
             'status'=>true,
             'message' => ' successfully'
             ]);

          }else{

            return response()->json([
              'status'=>false,
              //'error'=>$validator->errors()->all()
              'errors' => $validator->getMessageBag()->toArray()
              ]);
          }
                 
    }

    
    


    

}

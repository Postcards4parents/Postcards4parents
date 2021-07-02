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
use App\Helper\AuthData as adata;
use App\category;
use App\subcategory;
use Newsletter;
use App\UserQuiz;

class LoginController extends Controller
{
    public function __construct(DeliveryClient $client) 
    {
      $this->middleware('auth:user', ['only' => ['welcomeKit']]);
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
        'password' => 'required|min:4',
            
        ]);


        if($validator->passes()) {

          $user_deactive = User::where('email', '=', $request->email)
          ->where('active', '=', '0')
          ->first();
          if($user_deactive){
            return response()->json(['status'=>false,'message'=>'Account deactivated please contact admin.']);
          }else{
            
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
    'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
    ]);
     
  if ($validator->passes()) {

    DB::beginTransaction();


    $user=User::create([
        'name' => $fname.' '.$lname,
        'email' => $email,
        'password' => Hash::make($password),
        'type'=>'2',
    ]);  






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
          // Ajay::SendSignupMail($email,$fname,$lname,$selectedGrades);
         $this->SendSignupMail($email,$fname,$lname,$selectedGrades);

		$auth=\Auth::guard('user')->attempt([
                          'email' => $email,
                          'password' => $password,
                          'type'=>'2',
                          'active'=>'1'
                          ]);
        //try {
        //Mail::send('emails.signup', $data, function($message)  use ($email, $fname, $lname)
         //{
           //$message->to($email,$fname.' '.$lname)->subject('Welcome to Postcard signup');
         //});
        //}catch(Exception $e)
        //{
          
        //}
        
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
   
     //  Ajay::SendProfileUpdateMail($email,$fname,$lname,$selectedGrades);
    $this->SendProfileUpdateMail($email,$fname,$lname,$selectedGrades);

     


    try {
        Mail::send('emails.updateProfile', $data, function ($message) use ($email, $fname, $lname) {
            $message->to($email, $fname.' '.$lname)->subject('Postcards Your profile has been updated');
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
  $form_grade_array=  $form_grade_array[0]->values;
  foreach($form_grade_array as $openGKey=>$openGVal)
  {
    $New_grade_arr[ $openGVal->value ]=$openGVal->label;
  }
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
public function welcomeKit(){
  $user_auth=Auth::guard('user')->user();
  $userD = $user_auth->type;
  $Username = $user_auth->name;
  $id=$user_auth->id;
  $userquiz = new UserQuiz();
  $quizresponse = ($userquiz->where('user_id',$id)->latest()->first() !== null) ? $userquiz->where('user_id',$id)->latest()->first()->response : '';
  if(isset($quizresponse) && ($quizresponse !== '')){
		$resp = json_decode($quizresponse);
	  }else{
		  $resp = '';
		  }
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
  if(empty($New_grade_arr_with_key)){
    $New_grade_arr_with_key="";
  }
  $form1 = $form_grade_data->form_builder_json;
  $form2=json_encode(array_values($New_form_arr_form));
  $welcomeKit = $this->client->getEntry('1bRUF3EaTV1AdVcxszz9EO');
  $query = $this->query->setContentType("parentTestimonial");
  $quote_entry = $this->client->getEntries($query);
  $count = count($quote_entry);
  $rand = mt_rand(0,($count-1));

  $subscription = DB::table('offer_payemnt_tbl')->where('offer_payemnt_tbl.user_id',$id)->get()->toArray();
  
  /*quiz questions if not attempted */
  $query = $this->query->setContentType("quiz");
  $entries_pre = $this->client->getEntries($query);
  
  //echo '<pre>'; print_r($quote_entry); echo '</pre>'; exit;
  return view('site.other_pages.welcomeKit',compact('form2','form1'))
  ->with('values_array',$Main_modified_array)
  ->with('grades_array',$New_grade_arr_with_key)
  ->with('client',$this->client)
  ->with('detail',$json_data)
  ->with('Usertype', $userD)
  ->with('quiz', $entries_pre[0]->quizQuestions)
  ->with('detail1',$detail)
  ->with('query_result', $resp)
  ->with('subscription',$subscription)
  ->with('renderer',$this->renderer)
  ->with('query',$this->query)
  ->with('quotation',$quote_entry[$rand])
  ->with('Username',$Username)
  ->with('welcomeKitPages', $welcomeKit->welcomeKitPages);

  //return view('site.other_pages.dashboard');

}

public function yourPostcards(){
  
$user_auth=Auth::guard('user')->user();
$userD = $user_auth->type;
$Username = $user_auth->name;
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
if(empty($New_grade_arr_with_key)){
  $New_grade_arr_with_key="";
}
$form1 = $form_grade_data->form_builder_json;
$form2=json_encode(array_values($New_form_arr_form));


// echo '<pre>'; print_r($entries_pre[0]);die;

// $welcomeKit = $this->client->getEntry('1Dlv57MRy1GWEwhFFGv1tv');
// echo "<pre>";
// print_r($welcomeKit->officeHours->ooVideoLink);die;
// print_r($welcomeKit->officeHours->ooVideoLink);die;
  $query = $this->query->setContentType("parentTestimonial");
  $quote_entry = $this->client->getEntries($query);
  //echo '<pre>'; print_r($quote_entry); exit;
  $count = count($quote_entry);
  $rand = mt_rand(0,$count-1);
return view('site.other_pages.postcardOfficeHour',compact('form2','form1'))
->with('values_array',$Main_modified_array)
->with('grades_array',$New_grade_arr_with_key)
->with('client',$this->client)
->with('detail',$json_data)
->with('Usertype', $userD)
->with('detail1',$detail)
->with('renderer',$this->renderer)
->with('query',$this->query)
->with('quotation',$quote_entry[$rand])
->with('Username',$Username)
// ->with('postcard', $entries_pre)
;

}

public function storyCircle(){
    
  $user_auth=Auth::guard('user')->user();
  $userD = $user_auth->type;
  $Username = $user_auth->name;
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
  if(empty($New_grade_arr_with_key)){
    $New_grade_arr_with_key="";
  }
  $form1 = $form_grade_data->form_builder_json;
  $form2=json_encode(array_values($New_form_arr_form));
  // $welcomeKit = $this->client->getEntry('1bRUF3EaTV1AdVcxszz9EO');
    
  return view('site.other_pages.storyCircle',compact('form2','form1'))
  ->with('values_array',$Main_modified_array)
  ->with('grades_array',$New_grade_arr_with_key)
  ->with('client',$this->client)
  ->with('detail',$json_data)
  ->with('Usertype', $userD)
  ->with('detail1',$detail)
  ->with('renderer',$this->renderer)
  ->with('query',$this->query)
  ->with('Username',$Username)
  // ->with('welcomeKitPages', $welcomeKit->welcomeKitPages)
  ;

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

$subscription = DB::table('offer_payemnt_tbl')->leftJoin('manage_plans','offer_payemnt_tbl.plan_id','=','manage_plans.plan_id')->where('offer_payemnt_tbl.user_id',$id)->get()->toArray();

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

    if(empty($New_grade_arr_with_key)){
    $New_grade_arr_with_key="";
    }
    

    //dd($New_grade_arr_with_key);

    $form1 = $form_grade_data->form_builder_json;
    $form2=json_encode(array_values($New_form_arr_form));
    //$form1 = Form::where('identifier', 'form1')->firstOrFail();
    
  return view('site.other_pages.dashboard',compact('form2','form1','subscription'))->with('values_array',$Main_modified_array)
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
               $message->to($email)->subject('Postcards password reset');
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
           $User_email = env('GET_TOUCH_MAIL');
           
        //  $segment_id=262121;
        //  $template_id=101069;
        //  $listID="d2ae77bf0e";
        // Ajay::SendGetInTouchMail($listID,$template_id , $segment_id, $sender,$message);
         Mail::send('emails.get_touch', $data, function($message)  use ($User_email)
          {
            $message->to($User_email)->subject('Get in touch email');
          });
         
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


    function pc_permute($items, $perms = array( )) {
      if (empty($items)) {
          $return = array($perms);
      }  else {
          $return = array();
          for ($i = count($items) - 1; $i >= 0; --$i) {
               $newitems = $items;
               $newperms = $perms;
           list($foo) = array_splice($newitems, $i, 1);
               array_unshift($newperms, $foo);
               $return = array_merge($return, $this->pc_permute($newitems, $newperms));
           }
      }
      return $return;
  }

    function combination()
    {
      $value = array('0','1', '2', '3');
     echo '<pre>'; print_r($this->pc_permute($value));



    }

    function test_mail(){
     echo 'Ho';
     $res= Mail::raw('Text to e-mail', function ($message) {
        $message->to('ajay.kumar@sourcesoftsolutions.com');
     });

    //  $res=Mail::send(array(), array(), function ($message) {
    //   $message->to('ajay.kumar@sourcesoftsolutions.com')
    //     ->subject("test")
    //     ->from("hello@postcardsforparents.com");
        
    // });
   
     print_r($res);exit;


    }


    public  function SendProfileUpdateMail($email,$fname,$lname,$grade)
    {
        // $listID=caa284fd88; 
        // $segment_id=262305;
        //  $template_id=101185;
       // $listID="d2ae77bf0e";
       $MailChimp = Newsletter::getApi();
       
       
      
       
    
       $return=Newsletter::getMember($email,'list3');
       
        
        if ($return['status'] !='404') {
            foreach ($return['tags'] as $tag) {
                $tag_num=$tag['name'];
                if(is_numeric($tag_num))
                {
                $old_tags[]=[
                'name'=>$tag_num,
                'status' => 'inactive'
                ];
              }
            }
        }
        $subscriber_hash=md5(strtolower($email));
       
        $tag_url="lists/d2ae77bf0e/members/$subscriber_hash/tags";
       if(!empty($old_tags)){
        
        
        $remove_tags=['tags'=>$old_tags];
        
        $remove=$MailChimp->post($tag_url,$remove_tags);
       }

       foreach ($grade as $gd) {
        $new_tags[]=[
        'name'=>$gd,
        'status' => 'active'
        ];
      }

        $add_tags=['tags'=>$new_tags];
        
        $add=$MailChimp->post($tag_url,$add_tags);

       
        Newsletter::subscribeOrUpdate($email, ['FNAME'=>$fname, 'LNAME'=>$lname], 'list3');
        
}


public function SendSignupMail( $email,$fname,$lname,$grade)
    {
        // $listID=caa284fd88;
       
        // $segment_id=262305;
        //  $template_id=101185;
        // $listID="d2ae77bf0e";
        $MailChimp = Newsletter::getApi();
         
        $return=Newsletter::getMember($email,'list3');

        
        
        if ($return['status'] !='404') {

            foreach ($return['tags'] as $tag) {
                $tag_num=$tag['name'];
                if(is_numeric($tag_num))
                {
                $old_tags[]=[
                'name'=>$tag_num,
                'status' => 'inactive'
                ];
              }
            }
            $subscriber_hash=md5(strtolower($email));
       
            $tag_url="lists/d2ae77bf0e/members/$subscriber_hash/tags";
           if(!empty($old_tags)){
            
            
            $remove_tags=['tags'=>$old_tags];
            
            $remove=$MailChimp->post($tag_url,$remove_tags);
           }
    
           foreach ($grade as $gd) {
            $new_tags[]=[
            'name'=>$gd,
            'status' => 'active'
            ];
          }
    
            $add_tags=['tags'=>$new_tags];
            
            $add=$MailChimp->post($tag_url,$add_tags);
    
           
            Newsletter::subscribeOrUpdate($email, ['FNAME'=>$fname, 'LNAME'=>$lname], 'list3');
         
    




        }else{
            Newsletter::subscribeOrUpdate($email, ['FNAME'=>$fname, 'LNAME'=>$lname], 'list3' , ['tags' => $grade]);

        }
      



    }
    

}

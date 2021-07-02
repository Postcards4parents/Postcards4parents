<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user_details;
use App\User;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Validation\Rule;
use jazmy\FormBuilder\Models\Form;
use jazmy\FormBuilder\Models\Submission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    public function __construct() 
    {
      $this->middleware('auth:admin', ['only' => ['index']]);
    }

    public function index()
    {
        
        if(!empty($_GET['new']))
        {
            $new_time_stmap= time();
            return view('user.list')->with('updated',$_GET['new']+5)->with('new_time_stmap',$new_time_stmap);
        }else{
            return view('user.list');
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    function userDatatable()
    {

        $content = DB::table('users as t1')
        ->join('form_submissions as t2', 't1.id', '=', 't2.user_id')
        ->select(
           DB::raw('t1.id as id,t1.name as uname,t1.email as email,(CASE 
            WHEN t1.active = "0" THEN "Deactive" 
            ELSE "Active" END
            ) AS act'))
        //->select(['t1.id as id','t1.name as uname','t1.email as email','t1.active as act'])
        ->where('t2.form_id','=','2')
        ->where('t1.type','=','2')
       // ->where('t1.active','!=','0')
        ->get();

       // dd($content);
       
    //    foreach($sub as $ss)
    //    {
    //     //$content1=(array)json_decode($ss->content);
    //     $content1['id']= $ss->id ; 
    //     $content1['user_id']= $ss->user_id ; 
    //     $content1['user_name']= $ss->uname ; 
    //     $content1['email']= $ss->email ;
       
        
    //    // $content[]=(object)$content1;
    //     $content[]=(object)$content1;
        
    //    }
       
    // $content=collect($content);
    // dd($content);
    

    return DataTables::of($content)
    
        ->addColumn('action', function ($row) {
            
            if($row->act=='Deactive')
             {
               $activate='<a data-toggle="tooltip" id="'.$row->id.'" title="Activate"  class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-ok activate"></i> </a>';  
             }else{
                $activate= '<a data-toggle="tooltip" id="'.$row->id.'" title="Deactivate"  class="btn btn-xs btn-edit btn-warning"><i class="glyphicon glyphicon-pencil deactivate"></i> </a>';  
             }
           
        return '<a data-toggle="tooltip" title="View" href="'. route('user.show', $row->id) .'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-eye-open"></i></a>
        '.$activate.' 
        
        <a data-toggle="tooltip" id="'.$row->id.'" title="Delete"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </a> ';
       })
      ->make(true);



       
    //     $all=User::with('user_detail');

       
        
    //     return DataTables::eloquent($all)
    //    ->addColumn('action', function ($row) {
    //     return '<a data-toggle="tooltip" title="View" href="'. route('user.show', $row->id) .'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-eye-open"></i></a>
    //     <a data-toggle="tooltip" title="Edit" href="'. route('user.edit', $row->id) .'"  class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> </a>
    //     <a data-toggle="tooltip" id="'.$row->id.'" title="Delete"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </a> ';
    //    })

     
    //    ->toJson();

       

    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $all=$request->all();
      
       
        
        $validator = Validator::make($all, [
            'parent_fname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',

              ]);
             // dd($all);

        if ($validator->passes()) {

            $user = new User();
            $user->name = Input::get('parent_fname').Input::get('parent_lname');
            $user->email = Input::get('email');
            $user->password =  Hash::make(Input::get('password'));
            $user->save();
            
            $user_detail = new user_details();
            $user_detail->parent_fname = Input::get('parent_fname');
            $user_detail->parent_lname = Input::get('parent_lname');
            $user_detail->country = Input::get('country');
            $user_detail->parent_gender = Input::get('parent_gender');
            $user_detail->child_fname = Input::get('child_fname');
            $user_detail->child_grade = Input::get('child_grade');
            $user_detail->child_gender = Input::get('child_gender');
            $user_detail->sibling_fname = Input::get('sibling_fname');
            $user_detail->sibling_grade = Input::get('sibling_grade');
            $user_detail->sibling_gender = Input::get('sibling_gender');


    
            
            $user->user_detail()->save($user_detail);

           return response()->json(['status'=>true]);
        }


        return response()->json([
            'status'=>false,
            //'error'=>$validator->errors()->all()
            'errors' => $validator->getMessageBag()->toArray()
            ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        
     
        $detail= DB::table('form_submissions')
       
        ->where('user_id','=',$id)
        ->first();

       
        
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

        
         $selectedGradesArr=json_decode($detail->selected_grades);
      
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
      
         
        
        // $form1 = Form::where('identifier', 'form1')->firstOrFail();

        // return view('site.other_pages.dashboard',compact('form2','form1'))->with('values_array',$Main_modified_array)
        // ->with('grades_array',$New_grade_arr_with_key)
        // ->with('detail',$json_data)->with('detail1',$detail);
       
       $birth_years=json_decode($detail->birth_years);
                   

        return view('user.view')->with('values_array',$Main_modified_array)
        ->with('grades_array',$New_grade_arr_with_key)->with('birth_years',$birth_years);





    }
    public function show_old($id)
    {

        $detail= DB::table('form_submissions as t1')
       
        ->where('user_id','=',$id)
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
       
       
                   

        return view('user.view')->with('values_array',$Main_modified_array)
        ->with('grades_array',$New_grade_arr_with_key);





    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
       
        $all = DB::table('form_submissions')

        ->where('id','=',$id)
        ->first();
         //echo '<pre>';print_r($all[0]->user_detail);
        //exit;
        return view('user.edit')->with('all',$all);
     }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       

        $all=$request->all();
        //dd($all);
       
        
        $validator = Validator::make($all, [
            'parent_fname' => 'required',
            
           
              ]);
             // dd($all);

        if ($validator->passes()) {
            $id= $all['id'];
            $uid= $all['uid'];
            $user = User::find($id);
            $user->name = Input::get('parent_fname').Input::get('parent_lname');
           // $user->email = Input::get('email');
            //$user->password =  Hash::make(Input::get('password'));
            $user->save();
            
            $user_detail = user_details::find($uid);
            $user_detail->parent_fname = Input::get('parent_fname');
            $user_detail->parent_lname = Input::get('parent_lname');
            $user_detail->country = Input::get('country');
            $user_detail->parent_gender = Input::get('parent_gender');
            $user_detail->child_fname = Input::get('child_fname');
            $user_detail->child_grade = Input::get('child_grade');
            $user_detail->child_gender = Input::get('child_gender');
            $user_detail->sibling_fname = Input::get('sibling_fname');
            $user_detail->sibling_grade = Input::get('sibling_grade');
            $user_detail->sibling_gender = Input::get('sibling_gender');


    
            
           $ret= $user->user_detail()->save($user_detail);
           
           return response()->json(['status'=>true]);
        }


        return response()->json([
            'status'=>false,
            //'error'=>$validator->errors()->all()
            'errors' => $validator->getMessageBag()->toArray()
            ]);







    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $user = user::where('id',$id)->delete();
        $user_detail = Submission::where('user_id',$id)->delete();
       
   
        if($user)
        {
           $status= ['status'=>true ];
        }
        return response()->json($status);
    }

    public function userDeactive(Request $request)
    {
       $all=$request->all();
       $id=$all['id'];
       

       $user = User::find($id);
       $user->active = 0;
      // $user->email = Input::get('email');
       //$user->password =  Hash::make(Input::get('password'));
     $save=$user->save();

       
     if($save)
     {
        $status= ['status'=>true ];
     }
     return response()->json($status);

    }

    public function userActive(Request $request)
    {
       $all=$request->all();
       $id=$all['id'];
       

       $user = User::find($id);
       $user->active = 1;
      // $user->email = Input::get('email');
       //$user->password =  Hash::make(Input::get('password'));
     $save=$user->save();

       
     if($save)
     {
        $status= ['status'=>true ];
     }
     return response()->json($status);

    }
    

}

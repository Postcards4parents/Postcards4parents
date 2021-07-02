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

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

        $sub = DB::table('users as t1')
        ->join('form_submissions as t2', 't1.id', '=', 't2.user_id')
        ->select(['t2.*','t1.name as uname'])
        ->where('t2.form_id','=','2')
        ->get();
       
       foreach($sub as $ss)
       {
        $content1=(array)json_decode($ss->content);
        $content1['id']= $ss->id ; 
        $content1['user_id']= $ss->user_id ; 
        $content1['user_name']= $ss->uname ; 
       
        
        $content[]=(object)$content1;
        
        
       }
    $content=collect($content);
    
      
    return DataTables::of($content)
    
        ->addColumn('action', function ($row) {
        return '<a data-toggle="tooltip" title="View" href="'. route('user.show', $row->id) .'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-eye-open"></i></a>
        <a data-toggle="tooltip" title="Edit" href="'. route('user.edit', $row->id) .'"  class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> </a>
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
        $all=User::with('user_detail')->where('id',$id)->get();

        return view('user.view')->with('all',$all);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $all=User::with('user_detail')->where('id',$id)->get();

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
        $user_detail = user_details::where('user_id',$id)->delete();
   
        if($user)
        {
           $status= ['status'=>true ];
        }
        return response()->json($status);
    }
}

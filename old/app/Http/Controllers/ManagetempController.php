<?php

namespace App\Http\Controllers;

use App\Managetemp;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\DB;
use App\User;
use DataTables;
use App\category;


class ManagetempController extends Controller
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
            return view('mtemp.list')->with('updated',$_GET['new']+5)->with('new_time_stmap',$new_time_stmap);
        }else{
            return view('mtemp.list');
        }




    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('mtemp.create');


    }

    public function mtempDatatable()
    {

        

        $all=Managetemp::with('subcategory')->with('category'); 
        //$all=category::with('cat_mail_template')->with('sub_cat_mail_template')->get();
        //echo '<pre>';print_r($cc);
        //exit;

      


        return DataTables::eloquent($all)
       ->addColumn('action', function ($row) {
        return '
        <a data-toggle="tooltip" title="Edit" href="'. route('mtemp.edit', $row->id) .'"  class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> </a>
        <a data-toggle="tooltip" id="'.$row->id.'" title="Delete"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </a> ';
       })

     
       ->toJson();
        
        
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
            'cat_id' => 'required',
            'subcat_id' => 'required',
            'mail_subject'=>'required'
            
        ]);


        if ($validator->passes()) {
            $cat=Managetemp::create($all);
           

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
     * @param  \App\Managetemp  $managetemp
     * @return \Illuminate\Http\Response
     */
    public function show(Managetemp $managetemp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Managetemp  $managetemp
     * @return \Illuminate\Http\Response
     */
    public function edit($managetemp)
    {
       
        $all=Managetemp::with('subcategory')->with('category')
        ->where("id",'=',$managetemp)->first();

        return view('mtemp.edit')->with('temp',$all);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Managetemp  $managetemp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      
     $all=$request->all();
     $validator = Validator::make($all, [
        'cat_id' => 'required',
        'subcat_id' => 'required',
        'mail_subject'=>'required'
        
    ]);


    if ($validator->passes()) {
        $id=$all['id'];
           $values = array_except($request->all(), ['_token','id']);
           Managetemp::where('id', $id)->update($values);
       
       

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
     * @param  \App\Managetemp  $managetemp
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $del = Managetemp::where('id',$id)->delete();
   
        if($del)
        {
           $status= ['status'=>true ];
        }else{
            $status= ['status'=>false ];
        }
        return response()->json($status);



    }
}

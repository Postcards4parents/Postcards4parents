<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\User;
use Validator;
use App\category;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        //$_GET['new'];
        //echo time()+60;
       // exit;
        if(!empty($_GET['new']))
        {
            $new_time_stmap= time();
            return view('category.list')->with('updated',$_GET['new']+5)->with('new_time_stmap',$new_time_stmap);
        }else{
            return view('category.list');
        }

        
    }

    public function categoryDatatable()
    {
       return DataTables::of(category::query())
       ->addColumn('action', function ($row) {
        return '<a data-toggle="tooltip" title="View" href="'. route('category.show', $row->id) .'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-eye-open"></i></a>
        <a data-toggle="tooltip" title="Edit" href="'. route('category.edit', $row->id) .'"  class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> </a>
        <a data-toggle="tooltip" id="'.$row->id.'" title="Delete"  class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> </a> ';
       })

     
      ->make(true);
        
        
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
       
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
            'name' => 'required',
            
        ]);


        if ($validator->passes()) {
            $cat=category::create($all);
           

			return response()->json(['status'=>true,'success'=>'Category added successfully.']);
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
        $where = array('id' => $id);
        $cat  = category::where($where)->first();
        return view('category.view')->with('cat',$cat);
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $where = array('id' => $id);
        $cat  = category::where($where)->first();
        return view('category.edit')->with('cat',$cat);
        
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
       
       $all= $request->all();
       //echo '<pre>';print_r($all);
       //exit;

      
        
       $validator = Validator::make($all, [
           'name' => 'required',
           
       ]);


       if ($validator->passes()) {
            
           $id=$all['cat_id'];
           $values = array_except($request->all(), ['_token','cat_id']);
           category::where('id', $id)->update($values);
           
           
           return response()->json(['status'=>true,'success'=>'Category updated successfully.']);
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
        
        $cat = category::where('id',$id)->delete();
   
        if($cat)
        {
           $status= ['status'=>true ];
        }
        return response()->json($status);
    }
}

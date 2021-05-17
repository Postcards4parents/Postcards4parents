<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\User;
use Validator;
use App\category;
use Session;
use App\subcategory;
use Illuminate\Support\Facades\DB;

class SubcategoryController extends Controller
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
            return view('sub_category.list')->with('updated',$_GET['new']+5)->with('new_time_stmap',$new_time_stmap);
        }else{
            return view('sub_category.list');
        }

        
    }

    public function subcategoryDatatable()
    {
         $sub = DB::table('categories as t1')
         ->join('categories as t2', 't1.cat_id', '=', 't2.id')
         ->select(['t1.*','t2.name as catname'])
         ->where('t1.cat_id','>','0')
         ->get();
   
    
       return DataTables::of($sub)
       ->addColumn('action', function ($row) {
        return '<a data-toggle="tooltip" title="View" href="'. route('subcategory.show', $row->id) .'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-eye-open"></i></a>
        <a data-toggle="tooltip" title="Edit" href="'. route('subcategory.edit', $row->id) .'"  class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> </a>
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

        //$all=category::where(['cat_id'=>'0'])->get();
        
        $all=category::where('cat_id','=',0)->pluck('name','id');
        return view('sub_category.create')->with('cat',$all);
       
    }
    public function subcategoryByCat(Request $request)
    {
        $all=$request->all();
       
        $da=category::where('cat_id','=',$all['id'])->pluck('name','id');
     
        return response()->json([
            'status'=>true,
            
            'data' => $da
            ]);
       
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
           

			return response()->json(['status'=>true,'success'=>'Subcategory added successfully.']);
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
        $allcat=category::where('cat_id','=',0)->pluck('name','id');
        $sub = DB::table('categories as t1')
         ->join('categories as t2', 't1.cat_id', '=', 't2.id')
         ->select(['t1.*','t2.name as catname'])
         ->where('t1.cat_id','>','0')
         ->where('t1.id','=',$id)
         ->first();
         
       
        return view('sub_category.view')->with('cat',$sub)->with('allcat',$allcat);
       
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $allcat=category::where('cat_id','=',0)->pluck('name','id');
        $sub = DB::table('categories as t1')
         ->join('categories as t2', 't1.cat_id', '=', 't2.id')
         ->select(['t1.*','t2.name as catname'])
         ->where('t1.cat_id','>','0')
         ->where('t1.id','=',$id)
         ->first();
         
       
        return view('sub_category.edit')->with('cat',$sub)->with('allcat',$allcat);
        
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
            
           $id=$all['id'];
           $values = array_except($request->all(), ['_token','id']);
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

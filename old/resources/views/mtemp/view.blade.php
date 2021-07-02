@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Subcategory Management</h1>
@stop

@section('content')
<div class="row">

    <div class="col-md-12">
   
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">View subcategory </h3>
        </div>
        <?php 
         //echo '<pre>';  print_r($cat);
         //exit;
        
        ?>
        <form role="form" id="form">
          <div class="box-body">
               <input type="hidden" id="cat_id" value="{{$cat->id }}" /> 
               <div id="catname" class="form-group col-md-6">
                <label for="categoryName">Select category name</label>
                {!! Form::select('cat_id', $allcat, $cat->cat_id, array('class' => 'form-control','id'=>'cat_id','disabled')); !!}
              
                
              </div>
            <div id="name" class="form-group col-md-6">
              <label for="categoryName">Category name</label>
            <input disabled type="text" value="{{$cat->name}}" required class="form-control" id="categoryName" placeholder="category name">
              
            </div>
            <div  class="form-group col-md-6">
              <label for="ageGroup">Age group </label>
            <input disabled type="text" value="{{$cat->age_group}}" class="form-control" id="ageGroup" placeholder="age Group">
              
            </div>
              
            <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Description</label>
            <input disabled type="text" value="{{$cat->description}}" class="form-control" id="description" placeholder="description">
            </div>
             
        
            
            
          </div>
          <div style="margin-left:15px;" class="box-footer">
          <a href="{{url('subcategory')}}" class="btn btn-success" > Back to List </a>
              
          </div>
        </form>
       
      </div>
     
    
    
     

    </div>
  </div>
  

@stop
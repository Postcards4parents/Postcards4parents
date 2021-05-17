@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Category Management</h1>
@stop

@section('content')
<div class="row">

    <div class="col-md-12">
   
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">create category </h3>
        </div>
      
        <form role="form">
          <div class="box-body">
           
            <div class="form-group col-md-6">
              <label for="categoryName">Category name</label>
              <input type="text" class="form-control" id="categoryName" placeholder="category name">
            </div>
            <div class="form-group col-md-6">
              <label for="ageGroup">Age group </label>
              <input type="text" class="form-control" id="ageGroup" placeholder="age Group">
            </div>
            
            

            
              <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Description</label>
                <input type="text" class="form-control" id="description" placeholder="description">
              </div>
             
              
            
            
          </div>
          <div style="margin-left:15px;" class="box-footer">
              <button id="submitCat" type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
       
      </div>
      
    
    
     

    </div>
  </div>
  

@stop

@section('adminlte_js')
<script>
    $( document ).ready(function() {
      $("#submitCat").click(function(e){
        e.preventDefault();
        $.ajax({
        url: "demo_test.txt",
        
        success: function(result){
       
        console.log(result);
     
      }});
    });
    });
    
    
    </script>


@stop
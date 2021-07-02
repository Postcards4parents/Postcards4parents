@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Your details</h1>
@stop

@section('content')


    <div class="col-md-12">
   
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Your Selected Grades</h3>
        </div>
        
        <form role="form" id="form">
          <div class="box-body">
          

           
            @foreach($grades_array as $gKey=>$gVal)
            <div  class="form-group col-md-4">
              <input type="text" disabled value="{{$gVal}}" class="form-control" id="parent_lname" placeholder="Parent last name">
              
            </div>
            @endforeach

            
          
  
            
     
            
          </div>
        
        </form>
       
       </div>
      </div>
 
  
    <div class="row">
    <div class="col-md-12">
   
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Your details</h3>
          
        </div>
        
        <form role="form" id="form">
          <div class="box-body">
           @foreach($values_array as $vKey=>$vVal)
            <div id="valid_parent_fname" class="form-group col-md-4">
            <label for="categoryName">{{$vKey}}</label>
              <input type="text" disabled value="{{$vVal}}" class="form-control" id="parent_fname" placeholder="Parent first name">
            </div>
            @endforeach

          </div>
        
        </form>
       
       </div>
      </div>
    </div>
  
 @stop
@section('my_js')

@stop

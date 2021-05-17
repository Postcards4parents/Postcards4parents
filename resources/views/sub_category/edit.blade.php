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
          <h3 class="box-title">Edit category </h3>
          
        </div>
        <?php
         
         //echo '<pre>';  print_r($allcat);
         //echo '<pre>';  print_r($cat);
         //exit;
        
        ?>
        <form role="form" id="form">
          <div class="box-body">
               <input type="hidden" id="id" value="{{$cat->id }}" /> 
               <div id="catname" class="form-group col-md-6">
                <label for="categoryName">Select category name</label>
                {!! Form::select('cat_id', $allcat, $cat->cat_id, array('class' => 'form-control','id'=>'cat_id')); !!}
              
                
              </div>
            <div id="name" class="form-group col-md-6">
              <label for="categoryName">Subcategory name</label>
            <input type="text" value="{{$cat->name}}" required class="form-control" id="categoryName" placeholder="subcategory name">
              
            </div>
            <div  class="form-group col-md-6">
              <label for="ageGroup">Age group </label>
            <input type="text" value="{{$cat->age_group}}" class="form-control" id="ageGroup" placeholder="age Group">
              
            </div>
              
            <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Description</label>
            <input type="text" value="{{$cat->description}}" class="form-control" id="description" placeholder="description">
            </div>
             
        
            
            
          </div>
          <div style="margin-left:15px;" class="box-footer">
              <button id="submitCat"  type="submit" class="btn btn-primary">Update</button>
              <a href="{{url('subcategory')}}" class="btn btn-success" > Back to List </a>
          </div>
        </form>
       
      </div>
     
    
    
     

    </div>
  </div>
  
 
@stop
@section('my_js')
<script>
  $( document ).ready(function() {
      
    $("#submitCat").click(function(e){
    
            e.preventDefault();
            var formData = {
                  "_token": "{{ csrf_token() }}",
                  name: jQuery('#categoryName').val(),
                  age_group: jQuery('#ageGroup').val(),
                  description: jQuery('#description').val(),
                  id:jQuery('#id').val(),
                  cat_id:jQuery('#cat_id').val()
              };
          
          $.ajax({

              url: "{{ url('subcategory/update') }}",
              type:"PUT",
              data:formData,
              dataType: 'json',
              success: function(data){
              if(data.status==true)
              {
                  // $('#form').trigger("reset");
                  $(".form-group").removeClass("has-error");
                  toastr.success('Subcategory updated', 'subcategory Updated successfully');
                  var date = new Date();
                  var timestamp = Math.round(date.getTime()/1000);
                  window.location.href="{{ url('subcategory') }}?new="+timestamp;
                
                //  window.location.href="{{ url('category') }}";
              }else{
                  jQuery.each(data.errors, function(key, value){
                      toastr.error( value);    
                  $("#"+key).addClass("has-error");
                  });

              }
             
             


              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {

          },
          complete: function(data) {
          
          }
          });
          

  });
  });
  


      
  
  </script>
@stop
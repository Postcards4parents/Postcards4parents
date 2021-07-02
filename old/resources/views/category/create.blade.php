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
      
        <form role="form" id="form">
          <div class="box-body">
                
            <div id="name" class="form-group col-md-6">
              <label for="categoryName">Category name</label>
              <input type="text" required class="form-control" id="categoryName" placeholder="category name">
              
            </div>
            <div  class="form-group col-md-6">
              <label for="ageGroup">Age group </label>
              <input type="text" class="form-control" id="ageGroup" placeholder="age Group">
              
            </div>
              
            <div class="form-group col-md-6">
                <label for="exampleInputPassword1">Description</label>
                <input type="text" class="form-control" id="description" placeholder="description">
            </div>
             
        
            
            
          </div>
          <div style="margin-left:15px;" class="box-footer">
               <button id="submitCat"  type="submit" class="btn btn-primary">Submit</button>
               <a href="{{url('category')}}" class="btn btn-success" > Back to List </a>
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
              };
          
          $.ajax({

              url: "{{ url('category') }}",
              type:"POST",
              data:formData,
              dataType: 'json',
              success: function(data){
              if(data.status==true)
              {
                  $('#form').trigger("reset");
                  $(".form-group").removeClass("has-error");
                  toastr.success('Category created', 'New category added successfully');
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
  
$('#list').click(function(){
//alert("clicked");
window.location.href="{{url('category')}}";
});

      
  
  </script>


@stop

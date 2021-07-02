@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>User Management</h1>
@stop

@section('content')
<div class="row">

    <div class="col-md-12">
   
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">create user </h3>
          
        </div>
        
        <form role="form" id="form">
          <div class="box-body">
            

            {{-- <div id="catname" class="form-group col-md-4">
              <label for="categoryName">Select category name</label>
              {!! Form::select('cat_id', $cat, null, array('class' => 'form-control','id'=>'cat_id')); !!}
            
              
            </div> --}}
            <div id="valid_parent_fname" class="form-group col-md-4">
              <label for="categoryName">Parent first name</label>
              <input type="text" required class="form-control" id="parent_fname" placeholder="Parent first name">
              
            </div>
            <div  class="form-group col-md-4">
              <label for="ageGroup">Parent last name </label>
              <input type="text" class="form-control" id="parent_lname" placeholder="Parent last name">
              
            </div>
            <div id="valid_email" class="form-group col-md-4">
              <label for="categoryName">Email</label>
              <input type="text" required class="form-control" id="email" placeholder="Email">
              
            </div>
            <div id="valid_password" class="form-group col-md-4">
              <label for="categoryName">Password</label>
              <input type="password" required class="form-control" id="password" placeholder="Password">
              
            </div>
           
            <div id="" class="form-group col-md-4">
              <label for="categoryName">Country</label>
              <input type="text" required class="form-control" id="country" placeholder="Country">
              
            </div>
          
  
            <div id="" class="form-group col-md-4">
              <label for="categoryName"> Parent Gender</label>
              <select id="parent_gender" class="form-control">
            
                <option value="male">Male</option>
                <option value="female">Female</option>

              </select>
            </div>
            
             
          
            <div class="form-group col-md-4">
                <label for="exampleInputPassword1">Child first name</label>
                <input type="text" class="form-control" id="child_fname" placeholder="Child first name">
            </div>
            <div class="form-group col-md-4">
              <label for="exampleInputPassword1">Child grade</label>
              <input type="text" class="form-control"  id="child_grade" placeholder="Child grade">
          </div>
          <div id="" class="form-group col-md-4">
              <label for="categoryName">Child gender</label>
              <select  id="child_gender" class="form-control">
            
                  <option value="male">Male</option>
                  <option value="female">Female</option>

              </select>
            </div>
          
        <div class="form-group col-md-12">
         
          <div class="checkbox">
          <label>
          <input id="sibling_group_info" type="checkbox" > Do You Have Another Child?
          </label>
          </div>
      </div>
      <div id="sibling_group">
      <div class="form-group col-md-4">
        <label for="exampleInputPassword1">Sibling first name</label>
        <input type="text" class="form-control"  id="sibling_fname" placeholder="Sibling first name">
    </div>
    <div class="form-group col-md-4">
      <label for="exampleInputPassword1">Sibling grade</label>
      <input type="text" class="form-control" id="sibling_grade" placeholder="Sibling grade">
  </div>
  <div id="" class="form-group col-md-4">
      <label for="categoryName">Sibling gender</label>
      <select class="form-control" id="sibling_gender">
          <option value="male">Male</option>
          <option value="female">Female</option>
      </select>
   </div>
      </div>
            
          </div>
          <div style="margin-left:15px;" class="box-footer">
               <button id="submitCat"  type="submit" class="btn btn-primary">Submit</button>
               <a href="{{url('user')}}" class="btn btn-success" > Back to List </a>
            </div>
        </form>
       
      </div>
      
    
    
     

    </div>
  </div>
 

@stop
@section('my_js')

<script>
  $( document ).ready(function() {
    $('#sibling_group').hide();

    $('#sibling_group_info').change(function(){
              
              $('#sibling_group').toggle();
     });
     


    $("#submitCat").click(function(e){
          
                  e.preventDefault();
                  var formData = {
                  "_token": "{{ csrf_token() }}",
                  parent_fname: jQuery('#parent_fname').val(),
                  parent_lname: jQuery('#parent_lname').val(),
                  email: jQuery('#email').val(),
                  password: jQuery('#password').val(),
                  country: jQuery('#country').val(),
                  parent_gender: jQuery('#parent_gender').val(),

                  child_fname: jQuery('#child_fname').val(),
                  child_grade: jQuery('#child_grade').val(),
                  child_gender: jQuery('#child_gender').val(),


                  sibling_fname: jQuery('#sibling_fname').val() ? jQuery('#sibling_fname').val(): "",
                  sibling_grade: jQuery('#sibling_grade').val() ? jQuery('#sibling_grade').val(): "",
                  sibling_gender: jQuery('#sibling_gender').val() ? jQuery('#sibling_gender').val() : "",
                  

                 
              };
              
          
          $.ajax({

              url: "{{ url('user') }}",
              type:"POST",
              data:formData,
              dataType: 'json',
              success: function(data){
              if(data.status==true)
              {
                  $('#form').trigger("reset");
                  $(".form-group").removeClass("has-error");
                  toastr.success('Subcategory created', 'New subcategory added successfully');
              }else{
                  jQuery.each(data.errors, function(key, value){
                      toastr.error(value);    
                  $("#"+'valid_'+key).addClass("has-error");
                  
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

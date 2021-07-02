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
          <h3 class="box-title">Edit user </h3>
          
        </div>
        @php
        
        $newSub=json_decode($all->content);
       
        $newArr= (array)$newSub;
        dd($newArr);
        echo '<pre>'; print_r(($newArr['text-1568906692227']));    

        @endphp

         <?php
          $out= $all[0];
          // if(!empty($out->user_detail))
          // {
          //    $detail=(array)$out->user_detail;
          // }else{
          //   $detail=[];
          // }
         ?>
        
         <?php 
          //echo '<pre>';print_r($out);
          //exit;
          ?>
        <form role="form" id="form">
          <div class="box-body">
            
          <input type="hidden" id="uid" value="{{$out['id']}}" >
            {{-- <div id="catname" class="form-group col-md-4">
              <label for="categoryName">Select category name</label>
              {!! Form::select('cat_id', $cat, null, array('class' => 'form-control','id'=>'cat_id')); !!}
            
              
            </div> --}}
            <div id="valid_parent_fname" class="form-group col-md-4">
            <label for="categoryName">Parent first name</label>
            <input type="text" value="{{$out->user_detail->parent_fname}}" required class="form-control" id="parent_fname" placeholder="Parent first name">
              
            </div>
            <div  class="form-group col-md-4">
              <label for="ageGroup">Parent last name </label>
              <input type="text" value="{{$out->user_detail->parent_lname}}" class="form-control" id="parent_lname" placeholder="Parent last name">
              
            </div>
            <div id="valid_email" class="form-group col-md-4">
              <label for="categoryName">Email</label>
              <input disabled type="text" value="{{$out->email}}" required class="form-control" id="email" placeholder="Email">
              
            </div>
         
           
            <div id="" class="form-group col-md-4">
              <label for="categoryName">Country</label>
              <input type="text" value="{{$out->user_detail->country}}" required class="form-control" id="country" placeholder="Country">
              
            </div>
          
  
            <div id="" class="form-group col-md-4">
              <label for="categoryName"> Parent Gender</label>
              <?php 
              $gender_arr=[
                     'male'=>'Male',
                     'female'=>'Female'

              ];

              ?>
              {!! Form::select('parent_gender',  $gender_arr,$out->user_detail->parent_gender , array('class' => 'form-control','id'=>'parent_gender')); !!}
              {{-- <select id="parent_gender" class="form-control">
                @if($out->user_detail->parent_gender =='male')
                
                @else
                @endif
                <option  value="male">Male</option>
                
                <option value="female">Female</option>
                
              </select> --}}
            </div>
            
             
          
            <div class="form-group col-md-4">
                <label for="exampleInputPassword1">Child first name</label>
                <input type="text" value="{{$out->user_detail->child_fname}}" class="form-control" id="child_fname" placeholder="Child first name">
            </div>
            <div class="form-group col-md-4">
              <label for="exampleInputPassword1">Child grade</label>
              <input type="text" value="{{$out->user_detail->child_grade}}" class="form-control"  id="child_grade" placeholder="Child grade">
          </div>
          <div id="" class="form-group col-md-4">
              <label for="categoryName">Child gender</label>
              {!! Form::select('child_gender',  $gender_arr,$out->user_detail->child_gender , array('class' => 'form-control','id'=>'child_gender')); !!}
              
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
        <input type="text" value="{{$out->user_detail->sibling_fname}}" class="form-control"  id="sibling_fname" placeholder="Sibling first name">
    </div>
    <div class="form-group col-md-4">
      <label for="exampleInputPassword1">Sibling grade</label>
      <input type="text" value="{{$out->user_detail->sibling_grade}}" class="form-control" id="sibling_grade" placeholder="Sibling grade">
  </div>
  <div id="" class="form-group col-md-4">
      <label for="categoryName">Sibling gender</label>
      {!! Form::select('sibling_gender',  $gender_arr,$out->user_detail->sibling_gender , array('class' => 'form-control','id'=>'sibling_gender')); !!}
      
   </div>
      </div>
            
          </div>
          <div style="margin-left:15px;" class="box-footer">
               <button id="submitCat"  type="submit" class="btn btn-primary">Update</button>
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
    // $('#sibling_group').hide();

    $('#sibling_group_info').change(function(){
              
              $('#sibling_group').toggle();
     });
     $("input").keypress(function(e){
      
     var event_id=e.target.offsetParent.id;
     $("#"+event_id).removeClass("has-error");

     });


    $("#submitCat").click(function(e){
          
                  e.preventDefault();
                  var formData = {
                  "_token": "{{ csrf_token() }}",
                  id: jQuery('#uid').val(),
                  uid:{{$out->user_detail->id}},
                  parent_fname: jQuery('#parent_fname').val(),
                  parent_lname: jQuery('#parent_lname').val(),
                  //email: jQuery('#email').val(),
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

              url: "{{ url('user/update') }}",
              type:"PUT",
              data:formData,
              dataType: 'json',
              success: function(data){
              if(data.status==true)
              {
                  $('#form').trigger("reset");
                  $(".form-group").removeClass("has-error");
                  toastr.success('User updated', 'user updated successfully');
                  var date = new Date();
                  var timestamp = Math.round(date.getTime()/1000);
                  window.location.href="{{ url('user') }}?new="+timestamp;
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

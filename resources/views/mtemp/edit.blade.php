@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Mail template Management</h1>
@stop

@section('content')
<div class="row">

    <div class="col-md-12">
      {{-- {{$temp->id}}
      {{$temp->cat_id}}
      {{$temp->subcat_id}}
      {{$temp->mail_subject}}
      {{$temp->mail_desc}}
      {{$temp->subcategory->name}}
      {{$temp->category->name}} --}}
      <?php 
       // echo '<pre>';print_r($temp);
        ?>
   
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">edit mail template </h3>
          
        </div>
        
        <form role="form" id="form">
          <div class="box-body">
            <div id="mail_cat_id" class="form-group col-md-6">
              <label for="categoryName">Select category name</label>
              {!! Form::select('cat_id', Ajay::category(), $temp->cat_id, array('class' => 'form-control','id'=>'cat_id')); !!}
            </div> 
            
            <div id="mail_subcat_id" class="form-group col-md-6">
              <label for="categoryName">Sub category name</label>
              <select class="form-control" id="subcatId">

                <option value="">Select</option>
              </select>
            
              
            </div>

            <div id="mail_mail_subject"  class="form-group col-md-12">
              <label for="ageGroup">Mail Subject</label>
              <input type="text" value="{{$temp->mail_subject}}" class="form-control" id="mailsub" placeholder="Mail subject">
              
            </div>
              
           
             <div id="mail_mail_desc" class="form-group col-md-12">
              <label for="exampleInputPassword1">Template Description</label>
            <textarea id="mail_desc">{{$temp->mail_desc}}</textarea>
            </div>
          </div>
          
          <div style="margin-left:15px;" class="box-footer">
               <button id="submitCat"  type="submit" class="btn btn-primary">Update</button>
               <a href="{{url('mtemp')}}" class="btn btn-success" > Back to List </a>
          </div>
        </form>
       
      </div>
      
    
    
     

    </div>
  </div>
@stop
@section('my_js')


<script src="{{ asset('vendor/ckeditor4/ckeditor.js') }}"></script> 
 <script>
  $( document ).ready(function() {
   
   var sub_id="{{$temp->subcat_id}}";
   
   

    $('select').on('change',function(e){
      console.log(e);
      var event_id=e.target.offsetParent.id;
      console.log(event_id);
      $("#"+event_id).removeClass("has-error");

  });  


  CKEDITOR.replace( 'mail_desc' );
  


    subCatData(1);
   
$("#cat_id").on('change',function(e){
  subCatData(2);
});

function subCatData(sid)
{
        var pdata={
          "_token": "{{ csrf_token() }}",
          "id":$("#cat_id").val(),
        };
        $.ajax({
            url:"{{ url('subcategoryByCat') }}",
            type:"POST",
            data:pdata,
            dataType: 'json',
            success: function(data){
            
              console.log(Object.keys(data.data).length);
              
            if(Object.keys(data.data).length)
            {
                      //validation class
                      $("#mail_subcat_id").removeClass("has-error");
                      $("#subcatId").empty().append(
                      $.map(data.data, function(v,k){
                        if(sid ==1)
                        {
                          if(sub_id==k){
                            return $("<option selected>").val(k).text(v);
                          }else{
                            return $("<option>").val(k).text(v);
                          }
                          

                        }else{
                          return $("<option>").val(k).text(v);
                        }

                        
                      })
                      );
            }else{
              $("#subcatId").empty().append("<option value=''>Select</option>");
              if(sid > 1)
              {
                toastr.error( "No subcategory found for this");   
              }
               
            }
            

            },
            error: function(err){
              console.log('fail');  
              console.log(err);
            }
        });
  }




    $("#submitCat").click(function(e){
     
     
     var mail_des=  CKEDITOR.instances['mail_desc'].getData();
     
     
    
            e.preventDefault();
            var formData = {
                  "_token": "{{ csrf_token() }}",
                  id:"{{$temp->id}}",
                  cat_id: jQuery('#cat_id').val(),
                  subcat_id: jQuery('#subcatId').val(),
                  mail_subject: jQuery('#mailsub').val(),
                  mail_desc:mail_des,
              };
              
          
          $.ajax({

              url: "{{ url('mtemp/update') }}",
              type:"PUT",
              data:formData,
              dataType: 'json',
              success: function(data){
              if(data.status==true)
              {
                  $('#form').trigger("reset");
                  $(".form-group").removeClass("has-error");
                  toastr.success('Template created', 'New template html added successfully');
                  var date = new Date();
                  var timestamp = Math.round(date.getTime()/1000);
                  window.location.href="{{ url('mtemp') }}?new="+timestamp;
              }else{
                  jQuery.each(data.errors, function(key, value){
                      toastr.error( value);  
                      console.log(key);  
                  $("#mail_"+key).addClass("has-error");
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
 <style>
 .ck-editor__editable {
    min-height: 300px;
}
 </style>

@stop

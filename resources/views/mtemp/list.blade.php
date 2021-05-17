@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Manage template list</h1>
    
@stop
@section('content')

<div class="box box-primary">
   <div class="box-header">
     <h3 class="box-title">Manage temp list</h3>
     <a href="{{url('mtemp/create')}}" class="btn btn-success pull-right" > Create template </a>
   </div>
   <!-- /.box-header -->
   <div class="box-body">
      
      <table class="table table-bordered" id="table">
         <thead>
            <tr>
               <th>Category</th>
               <th>Subcategory</th>
               <th>Subject</th>
               <th>Action</th>
            </tr>
         </thead>
      </table>
   </div>
   <!-- /.box-body -->
 </div>

@stop
@section('my_js')
<script>
   @if(!empty($updated) && $new_time_stmap <= $updated)
       toastr.success('Template updated', 'Template Updated successfully');
   @endif
     $(function() {
           $('#table').DataTable({
           processing: true,
           serverSide: true,
           ordering: false,
           ajax: '{{ url('mtemplist') }}',  
           columns: [
                    { data: 'subcategory.name', name: 'subcategory.name' },
                    { data: 'category.name', name: 'category.name' },
                    { data: 'mail_subject', name: 'mail_subject' },
                    { data: 'action',name: 'action', orderable: false, searchable: false},
                   
                  ]
        });
     });


     $(document).ready(function() {

   

     $('#table').DataTable().on('click', '.btn-danger', function (e) { 
        
        e.preventDefault();
         var ID=this.id;
        swal({
         title: "Are you sure?",
         text: "Delete this record!",
         icon: "warning",
         buttons: [
           'No, cancel it!',
           'Yes, I am sure!'
         ],
         dangerMode: true,
       }).then(function(isConfirm) {
         if (isConfirm) {
           $.ajax({

              url: "{{ url('mtemp') }}"+'/'+ID,
              type:"DELETE",
              data:{ 
                 _method: 'DELETE',
                 "_token": "{{ csrf_token() }}",
                 "id" : ID
                 },
              dataType: 'json',
              success: function(data){
                 console.log(data);
              if(data.status==true)
              {
               $('#table').DataTable().ajax.reload();
               
               swal({
               title: 'Deleted!',
               text: 'Deleted successfully',
               icon: 'success'
               }).then(function() {
                 
                 
               });
                
              }}
              });

           
         } else {
           swal("Cancelled", "Your record is safe :)", "error");
         }
       });







     });
    
    });




    </script>


@stop

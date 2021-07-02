@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Users detail</h1>
    
@stop
@section('content')

<div class="box box-primary">
   <div class="box-header">
     <h3 class="box-title">Signup users list</h3>
     {{-- <a href="{{url('user/create')}}" class="btn btn-success pull-right" > Create user </a> --}}
   </div>
   <!-- /.box-header -->
   <div class="box-body">
      <table class="table table-bordered" id="table">
         <thead>
            <tr>
               <th>Email</th>
               <th>Name</th>
               <th>Status</th>
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
       toastr.success('User updated', 'user Updated successfully');
   @endif
     $(function() {
           $('#table').DataTable({
           processing: true,
           serverSide: true,
           ordering: false,
           ajax: '{{ url('userlist') }}',  
           columns: [
                    { data: 'email', name: 'email' },
                    { data: 'uname', name: 'uname' },
                    { data: 'act', name: 'act' },
                    
                    { data: 'action',name: 'action', orderable: false, searchable: false},
                   
                  ]
        });
     });


     $(document).ready(function() {

   

     $('#table').DataTable().on('click', '.btn-danger', function (e) { 
        
        e.preventDefault();
         var ID=this.id;
        swal.fire({
         title: "Are you sure?",
         text: "Delete this record!",
         icon: "warning",
         buttons: [
           'No, cancel it!',
           'Yes, I am sure!'
         ],
         dangerMode: true,
       }).then(function(isConfirm) {
         if (isConfirm.value) {
           $.ajax({

              url: "{{ url('user') }}"+'/'+ID,
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
               
               swal.fire({
               title: 'Deleted!',
               text: 'Deleted successfully',
               icon: 'success'
               }).then(function() {
                 
                 
               });
                
              }}
              });

           
         } else {
           swal.fire("Cancelled", "Your record is safe :)", "error");
         }
       });







     });


     $('#table').DataTable().on('click', '.btn-edit', function (e) { 
        
      e.preventDefault();
         var ID=this.id;
        swal.fire({
         title: "Are you sure?",
         text: "Deactivate this record!",
         icon: "warning",
         buttons: [
           'No, cancel it!',
           'Yes, I am sure!'
         ],
         dangerMode: true,
       }).then(function(isConfirm) {
         if (isConfirm.value) {
           $.ajax({

              url: "{{ url('userDeactive') }}",
              type:"POST",
              data:{ 
                 _method: 'POST',
                 "_token": "{{ csrf_token() }}",
                 "id" : ID
                 },
              dataType: 'json',
              success: function(data){
                 console.log(data);
              if(data.status==true)
              {
               $('#table').DataTable().ajax.reload();
               
               swal.fire({
               title: 'Deactivated!',
               text: 'Deactivated successfully',
               icon: 'success'
               }).then(function() {
                 
                 
               });
                
              }}
              });

           
         } else {
           swal.fire("Cancelled", "Your record is safe :)", "error");
         }
       });







     });


     $('#table').DataTable().on('click', '.btn-primary', function (e) { 
        
        e.preventDefault();
           var ID=this.id;
          swal.fire({
           title: "Are you sure?",
           text: "Activate this record!",
           icon: "warning",
           buttons: [
             'No, cancel it!',
             'Yes, I am sure!'
           ],
           dangerMode: true,
         }).then(function(isConfirm) {
           if (isConfirm.value) {
             $.ajax({
  
                url: "{{ url('userActive') }}",
                type:"POST",
                data:{ 
                   _method: 'POST',
                   "_token": "{{ csrf_token() }}",
                   "id" : ID
                   },
                dataType: 'json',
                success: function(data){
                   console.log(data);
                if(data.status==true)
                {
                 $('#table').DataTable().ajax.reload();
                 
                 swal.fire({
                 title: 'Activated!',
                 text: 'Activated successfully',
                 icon: 'success'
                 }).then(function() {
                   
                   
                 });
                  
                }}
                });
  
             
           } else {
             swal.fire("Cancelled", "Your record is safe :)", "error");
           }
         });
  
  
  
  
  
  
  
       });

    
    });




    </script>


@stop

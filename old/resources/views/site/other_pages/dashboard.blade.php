@extends('site.layout.main')

@section('title')
Post card
@endsection

@section('content')


<section class="topBanner accountInfo">
  <div class="container">
    <div class="row">
      <aside class="col-lg-3 col-md-4 d-none d-md-block">
        <ul class="leftLinks">
          <li><a href="{{ url('userDashboard') }}"><i class="far fa-user"></i> Account Info</a></li>
          <li><a href="{{ url('user_log/logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </aside>
      <aside class="col-lg-9 col-md-8 col-12">
          @php 
          //print_r($detail1->content);
          @endphp

        {{-- {{dd($detail)}} --}}
        <h2>Account Info</h2>
        <div class="infoBox">
            <h3>Grades info</h3>
            {{-- <a href="#" class="edit">Edit</a> --}}
            @foreach($grades_array as $gKey=>$gVal)
            <p class="proName">{{$gVal}}</p>
            
            @endforeach
         </div>
        <div class="infoBox">
          <h3>Personal Info</h3>
          <a href="#" id="clickBtn2" data-toggle="modal" data-target="#stepModal2" class="edit">Edit Information</a> 
          @foreach($values_array as $vKey=>$vVal)
          <p>{{$vKey}}: {{$vVal}}</p>
          @endforeach
          
          
          
        </div>

        {{-- <div class="infoBox">
          <h3>Password</h3>
          <a href="#" class="edit">Edit</a>
          <p class="proName">Current Password</p>
          <p><input type="Password" disabled="" name="" value="password"></p>
        </div> --}}

      </aside>
    </div>
  </div>
</section>


@endsection

@section('script')
@php
$disabledrag=1;

//dd($Disabledrag);
@endphp
<script>
  setTimeout(function(){
      $('#email').hide();
     // document.getElementById("email").disabled=true;
      @foreach($grades_array as $gKey=>$gVal)
          var gKey= {{$gKey}};
          //console.log(gKey);
          
          document.getElementById("{{$gKey}}").checked = true;
          
      @endforeach
  },2000);

$(document).ready(function() {

$('#finalUpdate').on('click', function(e) {

if($('#form3')[0].checkValidity()) {
  e.preventDefault();

  Swal.fire({
  title: 'Are you sure?',
  text: "Are you sure Update information",
  icon: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Update it!'
}).then((result) => {
  if (result.value) {
    
            var chk_arr = document.getElementsByName("checkname[]");
                    console.log(chk_arr);
                    var selectArr = [];
                    var allArr = [];
                    chk_arr.forEach(function(e, index) {
                        allArr[index] = e.id;
                        if (e.checked == true) {
                            selectArr[index] = e.id;
                        }

                    });
                    selectArr = selectArr.filter(x => x != null);
                    if (selectArr.length == 0) {
                        toastr.error("Minimum selection one grade is required");

                    } else {

                                      var selectArr= (selectArr);
                                      var allArr= (allArr);
                                      console.log(selectArr);
                                      console.log(allArr);
                                      
                                      var form3 ={
                                  'selectedGrades':selectArr,
                                  'allGades':allArr,
                                  'formData':$('#form3').serializeArray()

                                };
                                
                                
                              console.log(form3);
                              window.showLoading();
                              var csrf="{{ csrf_token() }}";
                              $('.lds-dual-ring').show();
                              $.ajax({
                                  url: "{{ url('userUpdate') }}",
                                  type: "POST",
                                  data: form3,
                                  headers: {'X-CSRF-TOKEN':csrf },
                                  dataType: 'json',
                                  success: function(data) {
                                    console.log(data);
                                    window.closeLoading();
                                    if(data.status==true)
                                    {
                                    
                                      toastr.success('Profile Updated', 'Your profile updated successfully');
                                        
                                        
                                        
                                    }else{

                                    jQuery.each(data.errors, function(key, value){
                                      toastr.error(value);
                                                    
                                    });
                                  }
                                  setTimeout(function(){
                                          window.location="{{url('userDashboard')}}";
                                        },1000);
                                },
                                  error: function(XMLHttpRequest, textStatus, errorThrown) {

                                  },
                                  complete: function(data) {

                                  }
                              });     
                  
                  
                  
                  
                }

    }
});
 

  

}else{
  //toastr.error("Please fill all required fields");
  $('#form3').parsley();

}


});

  });
</script>
@endsection
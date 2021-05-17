<!-- jQuery library --> 

<script src="{{ asset('site/js/jquery.min.js')}}"></script> 
<!-- Bootstrap JS --> 
<script src="{{ asset('site/js/popper.min.js')}}"></script> 
<script src="{{ asset('site/js/bootstrap.min.js')}}"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<!-- jQuery for Sliders --> 
<script src="{{ asset('site/js/owl.carousel.js')}}"></script> 



<script>
  
  $('#recent').owlCarousel({        
  margin:30, 
  dots:false,
  nav:true,
  loop:false,
  mouseDrag:false,     
  autoplay:false,
  autoplayTimeout:3500,smartSpeed:700,
  singleItem:true,
  responsiveClass:true,
  responsive:{
  0:{items:1,},480:{items:2,},768:{items:3,mouseDrag:true,},1000:{items:3,},1400:{items:3,}}});
  </script> 
  <script>$(document).ready(function() {$("#info").owlCarousel({items : 1,nav:true,dots:false,loop:true,autoplay:true,autoplayTimeout:4000,smartSpeed:1800,autoplayHoverPause:false});});
  $(document).ready(function() {$("#testinomials").owlCarousel({items : 1,nav:false,dots:false,loop:true,autoplay:true,autoplayTimeout:3500,smartSpeed:1600,autoplayHoverPause:false});});
  </script> 
  <!-- jQuery for menu --> 
  <script type="text/javascript" src="{{ asset('site/js/menu.js')}}"></script> 
  <script type="text/javascript">
      jQuery(document).ready(function($) {

      window["closeLoading"] = function() {
       Swal.close();

      };

      window["showLoading"] = function() {
      Swal.fire({
          //title: 'loading...',
          closeOnEsc: false,
          allowOutsideClick: false,

          showCancelButton: false, // There won't be any cancel button
          showConfirmButton: false ,
          onOpen: () => {
            swal.showLoading();
          }
        });
  
};
        
        jQuery('.siteMenus').stellarNav({
          breakpoint:575,
          position: 'right',
        });
      });
    </script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js" defer></script>
@if(empty($disabledrag))
@php //dd($user_data); 
@endphp
<!-- jQuery for Drag Box --> 
  <script src="{{ asset('site/js/jquery-ui.js')}}"></script> 
  <script>
    $( function() {
      $( "#draggable" ).draggable();
    } );
    </script> 
  @endif
  <script>
    $(window).scroll(function(){
      if ($(window).scrollTop() >=50) {
        $('header').addClass('fixed-header');
       
      }
      else {
        $('header').removeClass('fixed-header');
        
      }
    });	
  $('#clickBtn1').click(function () {
       $('#dg1').hide();
       $('#dg2').show();
   });

   $('#clickBtn2').click(function () {
       
       $('#dgn').show();
   });

   $('#anotherSignup1').click(function () {
       $('#dg1').hide();
       $('#dg2').show();
   });
   $('#anotherSignup2').click(function () {
       $('#dg1').hide();
       $('#dg2').show();
   });
   $('#SignupInLogin').click(function () {
       $('#dg1').hide();
       $('#dg2').show();
   });
  
    $('#bkBtn1').click(function (e) {
      e.preventDefault();
       $('#dg4').hide();
       $('#dg3').show();
   });
    $('#bkBtn2').click(function (e) {
      e.preventDefault();
       $('#dg5').hide();
       $('#dg4').show();
   });	
  $('#closeBtn').click(function () {
    
       $('#dg2').show();
       $('#dg3').show();
       $('#dg1').show();
   });
  </script> 
  
  <script>
    $(document).ready(function() {
    
    $('#selectAll').click(function(e){
      e.preventDefault();
      $(".dragabox input:checkbox").prop('checked', function(i, current) { return !current; });
    });

    $('.clear').on('click', function(e) {
 
  toastr.close();
  });
   
  });
  
    $('#myForm').on('submit', function(e){
    $('#searchModal').modal('show');
    e.preventDefault();
  });

  function hide(target) {
    document.getElementById(target).style.display = 'none';
}


$('#finalSubmit').on('click', function(e) {


if($('#form3')[0].checkValidity()) {

  e.preventDefault();
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
           
          toastr.info("Minimum selection one grade is required");

        } else {

         var selectArr= (selectArr);
         var allArr= (allArr);
        
          var p1 = $("#password").val();
          var p2 = $("#confirm_password").val();
          e.preventDefault();
          if (p1 != p2) {
            toastr.info("Password does not matched");  
              
          }else{


              var form3 ={
                'selectedGrades':selectArr,
                'allGades':allArr,
                'formData':$('#form3').serializeArray()

              };
              
              
            
            window.showLoading();
            var csrf="{{ csrf_token() }}";
            $('.lds-dual-ring').show();
            $.ajax({
                url: "{{ url('userSignup') }}",
                type: "POST",
                data: form3,
                headers: {'X-CSRF-TOKEN':csrf },
                dataType: 'json',
                success: function(data) {
                  console.log(data);
                  window.closeLoading();
                  if(data.status==true)
                  {
                  
                    toastr.success('Signup Completed', 'Please Login with your ID PASSWORD');
                      
                      setTimeout(function(){
                        window.location.assign("{{url('payment/1T37AJFpbKtV6mgv2kC3Gb')}}");
                      },1000);
                      
                  }else{

                  jQuery.each(data.errors, function(key, value){
                    toastr.error(value);
                                  
                  });
                }
              },
                error: function(XMLHttpRequest, textStatus, errorThrown) {

                },
                complete: function(data) {

                }
            });


        }



}
}else{

  $('#form3').parsley();
  

}


});

</script> 

  
	<script type="text/javascript">
		window.FormBuilder = {
			csrfToken: '{{ csrf_token() }}',
		}
	</script>
	
	
	<script src="{{ asset('vendor/formbuilder/js/jquery-formbuilder/form-builder.min.js') }}" defer></script>
	<script src="{{ asset('vendor/formbuilder/js/jquery-formbuilder/form-render.min.js') }}" defer></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.1/parsley.min.js" ></script>
	<script src="{{ asset('vendor/formbuilder/js/clipboard/clipboard.min.js') }}?b=ck24" defer></script>
	<script src="{{ asset('vendor/formbuilder/js/moment.js') }}"></script>
	<!-- <script src="{{ asset('vendor/formbuilder/js/footable/js/footable.min.js') }}" defer></script> -->
	<script src="{{ asset('vendor/formbuilder/js/script.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>



	<!-- <link rel="stylesheet" type="text/css" href="{{ asset('vendor/formbuilder/js/footable/css/footable.standalone.min.css') }}"> -->
	<link rel="stylesheet" type="text/css" href="{{ asset('vendor/formbuilder/css/styles.css') }}{{ jazmy\FormBuilder\Helper::bustCache() }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


 
    <script src="{{ asset('vendor/formbuilder/js/form2_render.js') }}{{ jazmy\FormBuilder\Helper::bustCache() }}" defer></script>
    <script>
      
       @if(empty($disabledrag))
       window._form_builder_content = {!! json_encode($form2->form_builder_json) !!}
       @elseif($Usertype==2)
       window._form_builder_content = {!! json_encode($form2) !!}
       @endif
      
      @if(empty($disabledrag))
      window._form1_builder_content = {!! json_encode($form1->form_builder_json) !!}
      @elseif($Usertype==2)
      window._form1_builder_content = {!! json_encode($form1) !!}
      @endif
     
    </script>
<script>
$(document).ready(function(){
 
      @if(!empty($_GET['signup']))
      var al="@php echo $_GET['signup'];  @endphp";
      if(al=="true")
      {
       
        $("#stepModal1").modal('show');
        $('#dg1').hide();
        $('#dg2').show();
      }
      @endif
       
       @if(!empty(Session::get('userData')))
         @php 
         $userD=Session::get('userData');
         $names= $userD['name'];
         $nameArr=explode(" ",$names);
         $nameNum=count($nameArr);
         $email=$userD['email'];
         if($nameNum > 1){

           $fname=$nameArr[0];
           $lname=$nameArr[1];

         }else{
          $fname=$nameArr[0];
          $lname="";

         }
         @endphp
         var fname="{{$fname}}";
         var lname="{{$lname}}";
         var email="{{$email}}";
         
         setTimeout(function(){ 
        
          $("#fname").val(fname);
          $("#lname").val(lname);
          $("#email").val(email);
   
         
}, 1000);
        
         @endif
      
       
        
      
      

      $('#login').on('click',function(e){
       
        if($('#myform')[0].checkValidity()) {
        e.preventDefault();
       // loader_toast();
        var uname=document.getElementById('user_email').value;
        var pass=document.getElementById('user_password').value;      
    
        var pdata={ 
            "_token": "{{ csrf_token() }}",
            "email":uname ,
            "password":pass 
            };
        $.ajax({
        type:"POST",
        url:"{{url('user_log/login')}}",
        data:pdata,
        dataType:'json',
        success:function(data){
           console.log(data);
           //clear_loader_toast();
          if(data.status==true)
          {
            
            toastr.success('Login Success!');
           // window.location="{{url('userDashboard')}}";
           location.reload();
    
          }else if(data.status==false)
          {
            toastr.error(data.message);
          }
          else{
            $.each(data.errors, function(key, value){
              toastr.error(value);
                // $("#myform").removeClass("was-validated");
                //  $("#invalid_"+key).addClass("invalid-feedback ");
                //  $("#user_"+key).addClass("is-invalid");
            });
    
          }
    
    
        },
        error:function(XMLHttpRequest,textStatus , errorThrown){
    
        }
    });
    
    }else{
    
      $("#myform").parsley();
      //toastr.error("Please fill all required fields.");
    }
    
 });


 $('#loginDetail').on('click',function(e){
       
       if($('#myformDetail')[0].checkValidity()) {
       e.preventDefault();
      // loader_toast();
       var uname=document.getElementById('user_email_detail').value;
       var pass=document.getElementById('user_password_detail').value;      
   
       var pdata={ 
           "_token": "{{ csrf_token() }}",
           "email":uname ,
           "password":pass 
           };
       $.ajax({
       type:"POST",
       url:"{{url('user_log/login')}}",
       data:pdata,
       dataType:'json',
       success:function(data){
          console.log(data);
          //clear_loader_toast();
         if(data.status==true)
         {
           
           toastr.success('Login Success!');
           location.reload(true);
          // window.location="{{url('userDashboard')}}";
   
         }else if(data.status==false)
         {
           toastr.error(data.message);
         }
         else{
           $.each(data.errors, function(key, value){
             toastr.error(value);
               // $("#myform").removeClass("was-validated");
               //  $("#invalid_"+key).addClass("invalid-feedback ");
               //  $("#user_"+key).addClass("is-invalid");
           });
   
         }
   
   
       },
       error:function(XMLHttpRequest,textStatus , errorThrown){
   
       }
   });
   
   }else{
   
   $('#myformDetail').parsley();
     //toastr.error("Please fill all required fields.");
   }
   
});

 $('#forgetPassWord').on('click',function(e){

  if($('#myforgetform')[0].checkValidity()) {
        e.preventDefault();
        window.showLoading(); 
         var email=document.getElementById('user_email_for').value;
       //var pass=document.getElementById('user_password').value;      
    
        var pdata={ 
            "_token": "{{ csrf_token() }}",
            "email":email 
           
            };
        $.ajax({
        type:"POST",
        url:"{{url('forget_password')}}",
        data:pdata,
        dataType:'json',
        success:function(data){
           console.log(data);
           window.closeLoading();
          if(data.status==true)
          {
            
            toastr.success('Reset link successfully sent','Mail Success');
            window.location="{{url('/')}}";
    
          }else if(data.status==2)
          {
            toastr.error('Email Id not found please signup', 'Email not found');
          }
          else{
            $.each(data.errors, function(key, value){
              toastr.error(value);
              
            });
    
          }
    
    
        },
        error:function(XMLHttpRequest,textStatus , errorThrown){
    
        }
    });
    
    }else{
    
     // toastr.info("Please fill Email fields.");
      $('#myforgetform').parsley();
    }

 });
});
 </script>
 
<script>
 $('#btngetIN').on('click',function(e){

 
if($('#getInTouch')[0].checkValidity()) {
      e.preventDefault();
      window.showLoading(); 
       var email=$("#touchEmail").val();;
       var message=$("#touchMessage").val();

     //var pass=document.getElementById('user_password').value;      
  
      var pdata={ 
          "_token": "{{ csrf_token() }}",
          "email":email ,
          "message":message
         
          };
      $.ajax({
      type:"POST",
      url:"{{url('getInTouch')}}",
      data:pdata,
      dataType:'json',
      success:function(data){
         console.log(data);
         window.closeLoading();
        if(data.status==true)
        {
          
          toastr.success('Message send successfully','Success');
          window.location="{{url('/')}}";
  
        }
        else{
          $.each(data.errors, function(key, value){
            toastr.error(value);
            
          });
  
        }
  
  
      },
      error:function(XMLHttpRequest,textStatus , errorThrown){
  
      }
  });
  
  }else{
  
  $("#getInTouch").parsley();
    //toastr.info("Please fill Required fields.");
  }

});


$('#btngetINAbout').on('click',function(e){

 
if($('#getInTouchAbout')[0].checkValidity()) {
      e.preventDefault();
      window.showLoading(); 
       var email=$("#touchEmailAbout").val();
       var message=$("#touchMessageAbout").val();

     //var pass=document.getElementById('user_password').value;      
  
      var pdata={ 
          "_token": "{{ csrf_token() }}",
          "email":email ,
          "message":message
         
          };
      $.ajax({
      type:"POST",
      url:"{{url('getInTouch')}}",
      data:pdata,
      dataType:'json',
      success:function(data){
         console.log(data);
         window.closeLoading();
        if(data.status==true)
        {
          
          toastr.success('Message send successfully','Success');
          $("#touchEmailAbout").val(" ");
          $("#touchMessageAbout").val(" ");
          //window.location="{{url('/')}}";
  

        }
        else{
          $.each(data.errors, function(key, value){
            toastr.error(value);
            
          });
  
        }
  
  
      },
      error:function(XMLHttpRequest,textStatus , errorThrown){
  
      }
  });
  
  }else{
    $("#getInTouchAbout").parsley();
    //toastr.error("Please fill Required fields.");
  }

});








$('#SearchSub').on('click',function(e){

if($('#searchMod')[0].checkValidity()) {
      e.preventDefault();
       window.showLoading(); 
       var search_key=$("#searchField").val();
       var pdata={ 
          "_token": "{{csrf_token()}}",
          "search_key":search_key,
         };
      $.ajax({
      type:"POST",
      url:"{{url('SearchModule')}}",
      data:pdata,
      dataType:'json',
      success:function(data){
         console.log(data);
         window.closeLoading();
        if(data.status==true)
        {
          
          var html = "";
          if(data.data)
          {
            //toastr.success('Search Completed','Success');
            var maindata=data.data;
            var mainDataLength=data.data.length;
            

            for(i=0;i<data.data.length;i++)
            {
             
              var entry_id=maindata[i].entry_id;
              var developmentCategory_name=maindata[i].developmentCategory_name;
              var IntroText=maindata[i].IntroText;
              var IntroImage_url=maindata[i].IntroImage_url;
              var grade_name=maindata[i].grade_name;
              var pre_title=maindata[i].pre_title;
              var pre_seo = pre_title.replace(/\s+/g, '-').toLowerCase();
             

            var url="{{url('details')}}"+'/'+entry_id+'/'+pre_seo;
              
            
            var in2="<figure>"+"<a href='"+url+"'>"+ "<img src='"+IntroImage_url+"' class='img-fluid' >"   +"</a>"+"</figure>";
            in2+="<h3>"+"<a href='"+ url+"'>"+  pre_title  +"</a>"+"</h3>";
            in2+=IntroText;
            in1="<div class='item' >"+in2+"</div>";
            html +="<div class='col-md-3 col-sm-6' >"+in1+"</div>";
            
            }
          //  var searchVal=$("#searchField").val();
            var moreUrl="{{url("MoreSearchModule")}}"+'/'+search_key;

            html2="<p>"+"<a href='"+ moreUrl+"'>"+"Read more search results"+"</a>"+"</p>";
            //console.log(html);
            document.getElementById('resData').innerHTML=html;
            document.getElementById('more').innerHTML=html2;
             
            //$("#resData").append(html);
            

            
            
          }else{

            //toastr.error('No data found for given search');
            html += "<div id='abc'>No data found </div>";
            document.getElementById("resData").innerHTML=html;

          }
          
         
          //window.location="{{url('/')}}";
  
        }
        else{
          $.each(data.errors, function(key, value){
            toastr.error(value);
            
          });
  
        }
  
  
      },
      error:function(XMLHttpRequest,textStatus , errorThrown){
  
      }
  });
  
  }else{
    
    $("#searchMod").parsley();
    toastr.info("Please fill Search keywords.");
  }

});



$('#SearchFirstClick').on('click',function(e){
 


 e.preventDefault();
 var search_key=$('#SearchDataHome').val();
       if(search_key)
       {

      window.showLoading(); 
      $("#searchField").val(search_key);
      var pdata={ 
          "_token": "{{csrf_token()}}",
          "search_key":search_key,
         };
         
      $.ajax({
      type:"POST",
      url:"{{url('SearchModule')}}",
      data:pdata,
      dataType:'json',
      success:function(data){
         console.log(data);
         window.closeLoading();
        if(data.status==true)
        {
          
          var html = "";
          if(data.data)
          {
            //toastr.success('Search Completed','Success');
            var maindata=data.data;
            var mainDataLength=data.data.length;
            

            for(i=0;i<data.data.length;i++)
            {
             
              var entry_id=maindata[i].entry_id;
              var developmentCategory_name=maindata[i].developmentCategory_name;
              var IntroText=maindata[i].IntroText;
              var IntroImage_url=maindata[i].IntroImage_url;
              var grade_name=maindata[i].grade_name;
              var pre_title=maindata[i].pre_title;
              var pre_seo = pre_title.replace(/\s+/g, '-').toLowerCase();

              var url="{{url('details')}}"+'/'+entry_id+'/'+pre_seo;
              console.log(url);
            
            var in2="<figure>"+"<a href='"+url+"'>"+ "<img src='"+IntroImage_url+"' class='img-fluid' >"   +"</a>"+"</figure>";
            in2+="<h3>"+"<a href='"+ url+"'>"+  pre_title  +"</a>"+"</h3>";
            in2+=IntroText;
            in1="<div class='item' >"+in2+"</div>";
            html +="<div class='col-md-3 col-sm-6' >"+in1+"</div>";
            
            }
            var searchVal=$("#searchField").val();
            var moreUrl="{{url("MoreSearchModule")}}"+'/'+searchVal;

            html2="<p>"+"<a href='"+ moreUrl+"'>"+"Read more search results"+"</a>"+"</p>";
            //console.log(html);
            document.getElementById('resData').innerHTML=html;
            document.getElementById('more').innerHTML=html2;
             
            //$("#resData").append(html);
            

            
            
          }else{

            //toastr.error('No data found for given search');
            html += "<div id='abc'>No data found </div>";
            document.getElementById("resData").innerHTML=html;

          }
          
         
          //window.location="{{url('/')}}";
  
        }
        else{
          $.each(data.errors, function(key, value){
            toastr.error(value);
            
          });
  
        }
  
  
      },
      error:function(XMLHttpRequest,textStatus , errorThrown){
  
      }
  });

  };


});

 
$("#forgetPass").on('click',function(e){
        $("#loginModal").modal('hide');    
        });



    </script>
 <!--  -->
 
<script src=" https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
	$(document).ready(function() {
			$('#learning').dataTable( {
    "bLengthChange": false,
    "bSort" : false
  } );
		});
</script>
<script>
  

//facebook pixel
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '383809325544913');
fbq('track', 'PageView');

</script>

<noscript><img height="1" width="1" style="display:none"
      src="https://www.facebook.com/tr?id=383809325544913&ev=PageView&noscript=1" />
</noscript>


<!doctype html>
<html lang="en">
@include('site.layout.header_style')
<body>
 @php
 if(Auth::guard('user')->check())
        {
         $user_auth=Auth::guard('user')->user();
         $Usertype=$user_auth->type;
         $Username=$user_auth->name;
         
         $grades_arr=Session::get('grades_array_data'); 
         
                                 
              $first=['0'];
              $second=['1','2','3'];
              $third=['4','5'];
              if(!empty($grades_arr))
              {
                     foreach($grades_arr as $gkey=>$gval)
                     {
                     $first_menu[]=in_array($gval,$first);
                     
                     $second_menu[]=in_array($gval,$second); 
                     $third_menu[]=in_array($gval,$third); 
                     } 
              }else{
                     $first_menu=[]; 
                     $second_menu=[]; 
                     $third_menu=[]; 
                   }

                                 
                                  
                                 
         
        }else{
         $Usertype="";
         $Username="";
        }

 @endphp
@include('site.layout.header')

@yield('content') 

@include('site.layout.footer')
@include('site.layout.footer_script')
@yield('script')
</body>
</html>

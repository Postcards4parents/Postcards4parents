<!-- Header -->
<header>
<!-- Msg Box -->
<div class="alert textBlock fade show">
    <button type="button" class="close" data-dismiss="alert"><img src="{!! asset('site/') !!}/images/close3.png" class="img-fluid"></button>
    Research-based ideas for parents to connect and support your kids' development
</div>
<div class="headerMain">
      <div class="container">
          <div class="row">
              <div class="col-md-5 col-sm-12 order-md-2 logoSite">
                <a href="{{url('/')}}"><img src="{!! asset('site/') !!}/images/logo.png" class="img-fluid"></a>
              </div>
              <div class="col-md-4 col-sm-6">
                  <div class="siteMenus">
                      <ul>
                          <li><a  @if(Request()->segment(1)=='/') class="active"  @endif href="{{url('postcards')}}" >Postcards</a>
                              <ul>
                                  @if($Usertype =='2')
                                  
                                  @if(in_array(true,$first_menu))<li><a href="{{url('kindergarten')}}">Kindergarten</a></li>@endif
                              
                                  @if(in_array(true,$second_menu))<li><a href="{{url('grades-1-3')}}">Grades 1-3</a></li>@endif
                                  @if(in_array(true,$third_menu))<li><a href="{{url('grades-4-5')}}">Grades 4-5</a></li>@endif
                                  @else
                                  {{-- <li><a href="{{url('kindergarten')}}">Kindergarten</a></li>
                              
                                  <li><a href="{{url('grades-1-3')}}">Grades 1-3</a></li>
                                  <li><a href="{{url('grades-4-5')}}">Grades 4-5</a></li> --}}
                                  @endif
                                </ul>
                          </li>
                        <li><a @if(Request()->segment(1)=='toolkit') class="active"  @endif href="{{url('toolkit')}}">Toolkit</a></li>
                        <li><a @if(Request()->segment(1)=='about') class="active"  @endif href="{{url('about')}}">About</a></li>
                      </ul>
                  </div>
              </div>
              <div class="col-md-3 col-sm-6 order-md-3">
                  <div class="loginBox">
                      <!-- <a href="#" class="signUp">Sign <span>up</span></a> -->
                      <div class="login">
                          @if($Usertype==2)
                               @php
                               $fname=explode(" ",$Username);   
                               @endphp
                               <h3 class="userLogin dropdown">
                                <a href="#" data-toggle="dropdown" aria-expanded="false"><i class="far fa-user"></i> Hi {{ ucfirst($fname[0]) }}!</a>
                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 31px, 0px);">
                                <a class="dropdown-item" href="{{url('userDashboard')}}">Account Info</a>
                                <a class="dropdown-item" href="{{url('user_log/logout')}}">Logout</a>
                                </div>
                              </h3>
                            
                           @else    
                           <h3><a href="#" data-toggle="modal" data-target="#loginModal">Member Login</a></h3> 
                           @endif
                          <div class="searchField">
                             {{-- <form id="myForm" method="post" action="#">  --}}
                                  <input id="SearchDataHome"   type="text" name="SearchDataHome" placeholder="Search Postcards">
                                  
                                  <button type="submit" id="SearchFirstClick" data-toggle="modal" data-target="#searchModal"><i  class="fas fa-search"></i></button>
                               {{-- </form> --}}
                          </div>
                          <ul class="ulLinks">
                              <li><a target="blank" href="https://www.facebook.com/Postcards-for-Parents-820084901661452"><i class="fab fa-facebook-square"></i></a></li>
                              <li><a target="blank" href="https://www.instagram.com/postcardsforparents"><i class="fab fa-instagram"></i></a></li>
                              <li><a target="blank" href="https://www.youtube.com/channel/UCm5ySrWmzLmKteNtzHynDXA"><i class="fab fa-youtube"></i></a></li>
                              <li><a href="#" data-toggle="modal" data-target="#inTouch"><i class="fas fa-envelope"></i></a></li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
   
 <div class="headerTwo">
            <div class="container">
              <div class="row">
                <div class="col-md-4 col-sm-12 order-md-2 logoSite"> <a href="{{url('/')}}"><img src="{!! asset('site/') !!}/images/logo1.png" class="img-fluid"></a> </div>
                <div class="col-md-4 col-sm-6">
                  <div class="siteMenus right desktop"><a href="#" class="menu-toggle"><span class="bars"><span></span><span></span><span></span></span> </a><a href="#" class="menu-toggle"><span class="bars"><span></span><span></span><span></span></span> </a>
                    <ul><a href="#" class="close-menu full"><span class="icon-close"></span></a><a href="#" class="close-menu full"><span class="icon-close"></span></a>
                      <li class="has-sub"><a  @if(Request()->segment(1)=='/') class="active"  @endif href="{{url('postcards')}}" >Postcards</a>
                      
                        <ul style="display: none;">
                            @if($Usertype =='2')
                            @if(in_array(true,$first_menu))<li><a href="{{url('kindergarten')}}">Kindergarten</a></li>@endif
                              
                            @if(in_array(true,$second_menu))<li><a href="{{url('grades-1-3')}}">Grades 1-3</a></li>@endif
                            @if(in_array(true,$third_menu))<li><a href="{{url('grades-4-5')}}">Grades 4-5</a></li>@endif
                            @else
                            {{-- <li><a href="{{url('kindergarten')}}">Kindergarten</a></li>
                        
                            <li><a href="{{url('grades-1-3')}}">Grades 1-3</a></li>
                            <li><a href="{{url('grades-4-5')}}">Grades 4-5</a></li> --}}
                            @endif
                                
                        </ul>
                      
                      <a class="dd-toggle" href="#"><span class="icon-plus"></span></a><a class="dd-toggle" href="#"><span class="icon-plus"></span></a><a class="dd-toggle" href="#"><span class="icon-plus"></span></a></li>
                      <li><a @if(Request()->segment(1)=='toolkit') class="active"  @endif href="{{url('toolkit')}}">Toolkit</a></li>
                      <li><a @if(Request()->segment(1)=='about') class="active"  @endif href="{{url('about')}}">About</a></li>
                    </ul>
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 order-md-3">
                  <div class="loginBar">
                    <ul class="logins">
                      <li>
                          
                        <a data-toggle="modal" data-target="#searchModal" href="#">Search</a>
                      </li>
                      
                      @if($Usertype =='2')
                      
                      <li><a href="{{url('user_log/logout')}}" >Logout</a></li>

                      @else
                      <li><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>
                      
                      @endif
                      
                    </ul>
                    <ul class="ulLinks">
                      <li><a target="blank" href="https://www.facebook.com/Postcards-for-Parents-820084901661452"><i class="fab fa-facebook-square"></i></a></li>
                      <li><a target="blank" href="https://www.instagram.com/postcardsforparents"><i class="fab fa-instagram"></i></a></li>
                      <li><a target="blank" href="https://www.youtube.com/channel/UCm5ySrWmzLmKteNtzHynDXA"><i class="fab fa-youtube"></i></a></li>
                      <li><a href="#" data-toggle="modal" data-target="#inTouch"><i class="fas fa-envelope"></i></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
</header>
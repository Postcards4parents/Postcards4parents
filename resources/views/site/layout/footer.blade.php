<!-- footer -->
<footer>
    <div class="container">
      <ul>
          
        <?php //sleep(1); ?>
        @php
         
       
          $q=new \Contentful\Delivery\Query();
         // $client=new \Contentful\Delivery\Client("env('CONTENTFUL_USE_PREVIEW')","env('CONTENTFUL_SPACE_ID')","env('CONTENTFUL_ENVIRONMENT_ID')");
          
          $querycat=$q->setContentType("contentCategory")
          // ->where("fields.gradeLevel.sys.id[in]","AIVo1XaZ0g26hplK") 
          
          
           ->where("limit", "10");
          // ->where("sys.publishedCounter[gte]","1");
          // $query
        $entries_cat =$client->getEntries($querycat);
       
        $total= $entries_cat->count();
        @endphp

          @foreach($entries_cat as $cat)
          @php
          $catIdd=$cat->getId();
          $catName=$cat->get('contentType');
          $catName_seo=strtolower(str_replace(' ', '-', $catName));
          @endphp
          <li><a href='{{url("catlist/$catIdd/$catName_seo")}}'>{{$cat->get('contentType')}}</a></li>
      
          @endforeach





      </ul>
    <p>Copyright {{ date('Y') }} Postcards for Parents. All rights reserved. </p>
    <p>See our <a href="{{url('privacy-policy')}}">Privacy policy</a> and <a href="{{url('terms-of-use')}}">Terms of Use</a></p>
    </div>
  </footer>
  <!-- The login Modal -->
<div class="modal fade getModal loginBx" id="loginModal">
  <div class="modal-dialog modal-dialog-centered">
      
      <div class="modal-content">
          <div class="modal-body">
              <button type="button" class="close" data-dismiss="modal"><img src="{!! asset('site/') !!}/images/close1.png"></button>
              <div class="getTuch">
                 
                  <div class="row">
                      <div class="col-12 col-lg-3">
                          <h3>Welcome back!</h3>
                      </div>
                      <div class="col-12 col-lg-9">
                      <form  id="myform" name="myform" class="was-validated" method="POST">
                        <div class="row">
                      <div class="col-12 col-lg-5">
                          <input type="email"  id="user_email" name="user_email" placeholder="Email" required="required"    >
                          <input type="password" id="user_password" name="user_pass" placeholder="Enter Password" required="required"  >
                          <div class="formLinks">
                              <ul>
<li><a href="#" id="forgetPass" data-toggle="modal" data-target="#forgetModal">Forgot password</a></li>
<li><a href="{{ url('auth/facebook') }}"><img src="{!! asset('site/') !!}/images/facebook_icon.png"></a></li>
<li><a href="{{ url('auth/google') }}"><img src="{!! asset('site/') !!}/images/gmail_icon.png"></a></li>
<li><a id="SignupInLogin" data-toggle="modal" data-target="#stepModal1" href="#">Sign up!</a></li>
                              </ul>
                          </div>
                      </div>
                      <div class="col-12 col-md-4 col-lg-3">
                          {{-- <button id="login" type="submit" class="btnSubmit">Submit!</button> --}}
                          <input class="btnSubmit" id="login" type="submit" name="submit" value="Submit!">
                      </div></div>
                    </form>
                  </div>
                  </div>
                 
              </div>
          </div>
      </div>
   
  </div>
</div>

  <!-- The Forget Password Modal -->
  <div class="modal fade getModal loginBx" id="forgetModal">
    <div class="modal-dialog modal-dialog-centered">
        
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal"><img src="{!! asset('site/') !!}/images/close1.png"></button>
                <div class="getTuch">
                   
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <h3>Forgot your password?</h3>
                        </div>
                        <div class="col-12 col-lg-9">
                        <form  id="myforgetform" name="myforgetform" class="was-validated" method="POST">
                        <div class="row">
                        <div class="col-12 col-lg-5">
                            
                             Please fill in your email address

                            
                            <input type="email"  id="user_email_for" name="user_email_for" placeholder="Email" required="required"    >
                            
                            <div class="formLinks">
                                {{-- <ul>
                                    <li><a href="#" data-toggle="modal" data-target="#forgetModal"></a></li>
                                    <li><a href="#"></a></li>
                                </ul> --}}
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-3">
                            {{-- <button id="login" type="submit" class="btnSubmit">Submit!</button> --}}
                            <input class="btnSubmit" id="forgetPassWord" type="submit" name="submit" value="Submit!">
                        </div></div>
                      </form>
                    </div>
                    </div>
                   
                </div>
            </div>
        </div>
     
    </div>
  </div>


 
<!-- DragBox -->
@php
if($Usertype=='2')
{
  $disabledrag=1;
}
@endphp
@php
         $pre_k = $client->getEntry("7gazpRR71NsWIQyscha73k");
         
         
         $name=$pre_k->get('name');
         
         if(!empty($name))
         {
          $head= $name;
         }else{
           $head="";
         }   
         $desc=$pre_k->get('description');
        // echo '<pre>';print_r($desc);
         if(!empty($desc))
         {
          $k_desc= $renderer->render($desc);
         }else{
           $k_desc="";
         }
             
         $link_logo = $pre_k->get('image', null, false);
           
           if(!empty($link_logo)){
             $link_logo_res = $client->resolveLink($link_logo);
            
             if(!empty($link_logo_res->getFile()))
             {
              $link_logo_res_url= $link_logo_res->getFile()->getUrl();
             }
             
           }else{
            $link_logo_res_url="";
           }

        @endphp
  @if(empty($disabledrag))
<div id="draggable" class="ui-widget-content dragabox">

  <div id="dg1" class="dgBox">
    <a class="closeBtn" href="javascript:void();" onclick="hide('draggable')"><img src="{!! asset('site/') !!}/images/close4.png" class="img-fluid"></a>
   
    <h3>{{$head}}</h3>
   
    <figure><img src="{{$link_logo_res_url}}" class="img-fluid"></figure>
    <!--<a href="#" class="goBtn">Go<img src="images/arrow.png" class="img-fluid"></a>-->
    <button id="clickBtn1" type="submit" class="goBtn" data-toggle="modal" data-target="#stepModal1">Go<img src="{!! asset('site/') !!}/images/arrow.png" class="img-fluid"></button>
  </div>
</div>


<!-- Steps Modal -->
<div class="modal fade stepsM" id="stepModal1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content"> 
      
      <!-- Modal body -->
      <div class="modal-body dragabox">
        <button id="closeBtn" type="button" class="close" data-dismiss="modal"><img src="{!! asset('site/') !!}/images/close.png"></button>
        <div id="dg2" class="dgBox1" style="display:none;">
          <div class="row">
            <aside class="col-md-4 col-lg-4">
              <h3>{{$head}}</h3>
              <figure><img src="{{$link_logo_res_url}}" class="img-fluid"></figure>
              <div class="receive">
                {!! $k_desc !!}
              </div>
            </aside>
            <aside class="col-md-8 col-lg-7">
              <div id="dg3">
                <div class="levHeading">What grade is your child in? <span id="selectAll"></span></div>
               
                <div class="modalForm">
                  
                    <div id="form1render" ></div>
                 
                  <div class="levHeading" style="margin-top:10px;">Create Account</div>
                  <form id="form3" data-parsley-validate method="POST">
				  <div class="formLinks signupForm clearfix mb-1">
                        <ul>
                          <!-- <li><a href="#" id="forgetPass" data-toggle="modal" data-target="#forgetModal">Forgot password</a></li> -->
                          <li class="ml-0"><a href="{{ url('auth/facebook') }}"><img src="{!! asset('site/') !!}/images/facebook_icon.png"> Login with Facebook</a></li>
                          <li><a href="{{ url('auth/google') }}"><img src="{!! asset('site/') !!}/images/gmail_icon.png"> Login with Google</a></li>
                          <!-- <li><a id="SignupInLogin" data-toggle="modal" data-target="#stepModal1" href="#">Sign up!</a></li> -->
                        </ul>
                   </div>
                  <div class="modalForm">
                      <div id="form2render" ></div>
                      <input type="password" id="password" data-parsley-minlength="4" required="required" name="password" placeholder="Password" class="txtInp">
                      <p id="passwordHelpBlock" class="form-text text-muted">
                              Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.
                      </p>
                      <input type="password" id="confirm_password" data-parsley-minlength="4" required="required" name="confirm_password" required placeholder="Confirm Password" class="txtInp">                      
                    <button type="submit" id="finalSubmit" class="subBtn">Sign up!<img src="{!! asset('site/') !!}/images/arrow.png" class="img-fluid"></button>
                    {{-- <button type="submit" class="subBtn">Sign up!<img src="images/arrow.png" class="img-fluid"></button> --}}
                  </div>    
                </form>              
                </div>
                
              </div>
             
            </aside>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- [{"type":"checkbox-group","required":true,"label":"Signup Form - Grades","className":"abc","name":"grade_detail","values":[{"label":"K","value":"0"},{"label":"1st","value":"1"},{"label":"2nd","value":"2"},{"label":"3rd","value":"3"},{"label":"4th","value":"4"},{"label":"5th","value":"5"},{"label":"6th","value":"6"},{"label":"7th","value":"7"},{"label":"8th","value":"8"},{"label":"9th","value":"9"},{"label":"10th","value":"10"},{"label":"11th","value":"11"},{"label":"12th","value":"12"}]}] -->
@else

<!-- Steps Modal 2 edit-->
<div class="modal fade stepsM" id="stepModal2">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content"> 
        <!-- Modal body -->
        <div class="modal-body dragabox">
          <button id="closeBtn" type="button" class="close" data-dismiss="modal"><img src="{!! asset('site/') !!}/images/close.png"></button>
          <div id="dgn">
            
            <div class="row">
              <aside class="col-md-4 col-lg-3">
                <h3>{{$head}}</h3>
                <figure><img src="{{$link_logo_res_url}}" class="img-fluid"></figure>
                <div class="receive">
                  {!! $k_desc !!}
                </div>
              </aside>
              <aside class="col-md-8 col-lg-7">
                <div>
                  <div class="levHeading">What grade(s)? <span id="selectAll">SELECT ALL THAT APPLY</span></div>
                 
                  <div class="modalForm">
                    <div class="row">
                      <div id="form1render" ></div>
                    </div>
                    <div class="levHeading" style="margin-top:10px;">Your Account</div>
                    <form id="form3" method="POST">
                    <div class="modalForm">
                        <div id="form2render" ></div>
                                       
                     
                      <button type="submit" id="finalUpdate" class="subBtn">Update<img src="{!! asset('site/') !!}/images/arrow.png" class="img-fluid"></button>
                     
                  </div>    
                  </form>              
                  </div>
                  
                </div>
                
              </aside>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  @endif


<!-- Search Modal -->
<div class="modal fade searchM" id="searchModal">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><img src="{!! asset('site/') !!}/images/close2.png"></button>
        <div class="row">
          <div class="col-12 col-lg-4">
            <h3>Search Postcards</h3>
          </div>
          <div class="col-12 col-lg-5">
            <form id="searchMod" name="searchMod" method="post">
            <div class="seInput">
              <input type="text" id="searchField" required name="searchField" placeholder="Enter Search keywords">
              <button id="SearchSub" type="submit"><i class="fas fa-search"></i></button>
            </div>
            </form>
          </div>
        </div>
        <div class="clearfix"></div>
        <section class="recentList postCards">
          <div id="resData" class="row">
          
          
          </div>
          <div id="more" class="row">
          
          
            </div>
        </section>
      </div>
    </div>
  </div>
</div>

<!-- Get in Touch Modal -->
<div class="modal fade getModal" id="inTouch">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal"><img src="{!! asset('site/') !!}/images/close1.png"></button>
        <form method="post" id="getInTouch" name="getInTouch"> 
        <div class="getTuch">
          <div class="row">
            <div class="col-12 col-lg-3">
              <h3>Get in touch.</h3>
            </div>
            <div class="col-12 col-lg-5">
              <input required type="email" id="touchEmail" placeholder="Email">
              <textarea id="touchMessage" required placeholder="Message"></textarea>
            </div>
            <div class="col-12 col-md-4 col-lg-3">
              <input class="btnSubmit" type="submit" id="btngetIN" name="btngetIN" value="Submit!">
            </div>
          </div>
        </div>
        </form>

      </div>
    </div>
  </div>
</div>


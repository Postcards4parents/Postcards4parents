<!doctype html>
<html lang="en">
<head>
    
    <!-- Bootstrap core CSS -->
    <link href="http://148.76.75.204/postcards/public/site/css/bootstrap.min.css " rel="stylesheet">
    
    <!-- Fonts CSS -->
    <link href="http://148.76.75.204/postcards/public/site/css/fonts.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lexend+Exa&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:300,400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- Dragbox Css -->
    <link rel="stylesheet" href="http://148.76.75.204/postcards/public/site/css/jquery-ui.css">
    <!-- Slider Css -->
    
    
    <!-- Custom styles -->
    <link href="http://148.76.75.204/postcards/public/site/css/style.css" rel="stylesheet" type="text/css">

</head>

<body>


<section class="stepsM registerPage">
		<div class="container my-auto">
			<div class="dragabox">
			        <button id="closeBtn" type="button" class="close" data-dismiss="modal"><img src="http://148.76.75.204/postcards/public/site/images/close.png"></button>
			        <div id="dg2" class="dgBox1" style="">
			          <div class="row">
			            <aside class="col-md-4 col-lg-4">
			              <h3>Try for FREE!</h3>
			              <figure><img src="//images.ctfassets.net/gy7ud7gkbg08/2fqAeJOGvHeskGDE0lkBXA/59e45ae74635eac79319a33f9e859e52/shape.png" class="img-fluid"></figure>
			              <div class="receive">
			                <p>Join parents across the country who are increasing their skills for family joy &amp; thriving.</p>
			                <h4>Our personalized subscription service is currently only available for parents with children in grades K–5.</h4>
			              </div>
			            </aside>
			            <aside class="col-md-8 col-lg-7">
			              <div id="dg3" class="pt-4 pb-4">
			                <div class="levHeading">What grade is your child in? <span id="selectAll"></span></div>
			               
			                <div class="modalForm">
			                  
			                    <div id="form1render"><div class="rendered-form"><div><label><span class="grade-name">K</span><input type="checkbox" class="cus" name="checkname[]" id="0"><span class="checkmark"></span></label><label><span class="grade-name">1st</span><input type="checkbox" class="cus" name="checkname[]" id="1"><span class="checkmark"></span></label><label><span class="grade-name">2nd</span><input type="checkbox" class="cus" name="checkname[]" id="2"><span class="checkmark"></span></label><label><span class="grade-name">3rd</span><input type="checkbox" class="cus" name="checkname[]" id="3"><span class="checkmark"></span></label><label><span class="grade-name">4th</span><input type="checkbox" class="cus" name="checkname[]" id="4"><span class="checkmark"></span></label><label><span class="grade-name">5th</span><input type="checkbox" class="cus" name="checkname[]" id="5"><span class="checkmark"></span></label></div></div></div>
			                 
			                  <div class="levHeading" style="margin-top:10px;">Create Account</div>
			                  <form id="form3" data-parsley-validate="" method="POST" novalidate="" action="{{url('/userSignup')}}">
							 	{{ csrf_field() }}
							  <div class="formLinks signupForm clearfix mb-1">
			                        <ul>
			                          <!-- <li><a href="#" id="forgetPass" data-toggle="modal" data-target="#forgetModal">Forgot password</a></li> -->
			                          <li class="ml-0"><a href="http://148.76.75.204/postcards/public/auth/facebook"><img src="http://148.76.75.204/postcards/public/site/images/facebook_icon.png"> Login with Facebook</a></li>
			                          <li><a href="http://148.76.75.204/postcards/public/auth/google"><img src="http://148.76.75.204/postcards/public/site/images/gmail_icon.png"> Login with Google</a></li>
			                          <!-- <li><a id="SignupInLogin" data-toggle="modal" data-target="#stepModal1" href="#">Sign up!</a></li> -->
			                        </ul>
			                   </div>
			                  <div class="modalForm">
			                      <div id="form2render"><div class="rendered-form"><div><input type="text" placeholder="Parent first name" class="txtInp" name="fname" id="fname" required="required" aria-required="true"></div><div><input type="text" placeholder="Parent last name" class="txtInp" name="lname" id="lname" required="required" aria-required="true"></div><div><input type="email" placeholder="Email" class="txtInp" name="email" id="email" required="required" aria-required="true"></div></div></div>
			                      <input type="password" id="password" data-parsley-minlength="4" required="required" name="password" placeholder="Password" class="txtInp">
			                      <p id="passwordHelpBlock" class="form-text text-muted">
			                              Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.
			                      </p>
			                      <input type="password" id="confirm_password" data-parsley-minlength="4" required="required" name="confirm_password" placeholder="Confirm Password" class="txtInp">

			                    <div class="row justify-content-end no-gutters">
			                    	<button type="submit" id="finalSubmit" class="subBtn">Sign up!<img src="http://148.76.75.204/postcards/public/site/images/arrow.png" class="img-fluid"></button>
			                	</div>
			                    
			                  </div>    
			                </form>              
			                </div>
			                
			              </div>
			             
			            </aside>
			          </div>
			        </div>
			</div>
		</div>
</section>

<script src="http://148.76.75.204/postcards/public/site/js/jquery.min.js"></script> 
<!-- Bootstrap JS --> 
<script src="http://148.76.75.204/postcards/public/site/js/popper.min.js"></script> 
<script src="http://148.76.75.204/postcards/public/site/js/bootstrap.min.js"></script> 
<!-- jQuery for Sliders --> 

</body>
</html>
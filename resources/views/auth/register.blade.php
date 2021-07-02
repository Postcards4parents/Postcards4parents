@extends('site.layout.mainpay')

@section('content')
<?php

$home_top = $client->getEntry( "69AK26dD9qYKpX946I7xLp" );
$heading = $home_top->get( 'headline' );
if ( !empty( $heading ) ) {
    $r_head = $renderer->render( $heading );
} else {
    $r_head = "";
}

$supportingText = $home_top->get( 'supportingText' );
if ( !empty( $supportingText ) ) {
    $r_support = $renderer->render( $supportingText );
} else {
    $r_support = "";
}

$banner_media = $home_top->get( 'bannerMedia', null, false );
if ( !empty( $banner_media ) ) {
    $banner_media_u = $client->resolveLink( $banner_media );
    $banner_media_url = $banner_media_u->getFile()->getUrl();
} else {
    $banner_media_url = "";
}

// dd($home_top);
?>
<style>
.stepsM .dragabox{
	background: #f9d36f !important;
	}
.registerPage.stepsM{
	background: #f9d36f !important;
	}
#form3{
		padding-bottom:40px;
	}
</style>
<section class="stepsM registerPage">
         <div class="container my-auto">
            <div class="dragabox">
               <a class="close" href="{{url('/')}}"><img src="https://postcardsforparents.com/site/images/close.png"></a>
               <div id="dg2" class="dgBox1" style="">
                  <div class="row">
                     <aside class="col-md-4 col-lg-4">
                        <h3>Try for FREE!</h3>
                        <figure><img src="http://images.ctfassets.net/gy7ud7gkbg08/2fqAeJOGvHeskGDE0lkBXA/59e45ae74635eac79319a33f9e859e52/shape.png" class="img-fluid"></figure>
                        <div class="receive">
                           <p>Join parents across the country who are increasing their skills for family joy &amp; thriving.</p>
                           <h4>Our personalized subscription service is currently only available for parents with children in grades K–5.</h4>
                        </div>
                     </aside>
                     <aside class="col-md-8 col-lg-7">
                        <div id="dg3" class="pt-4 pb-4">
                           <div class="loginForm">
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
									<button type="submit" id="finalSubmit" class="subBtn next1">Sign up!<img src="{!! asset('site/') !!}/images/arrow.png" class="img-fluid"></button>
									{{-- <button type="submit" class="subBtn">Sign up!<img src="images/arrow.png" class="img-fluid"></button> --}}
								  </div>    
								</form>              
								</div>
								
							  </div>
                           </div>
                           <div class="formBox paymentForm paymentTab" style="display:none;">
                              <nav>
								  <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist"> <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><img src="{{asset('site/images/card.jpg')}}"></a> <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><img src="{{asset('site/images/paypal.jpg')}}"></a> </div>
								</nav>
								<div class="tab-content" id="nav-tabContent">
									
								  <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
									<form role="form" id="contact-form" class="contact-form" action="{{url('storepayment')}}" method="post">
										{{ csrf_field() }}
									  <div class="row">
										  
										@if($errors->any())
											<ul>
											{!! implode('', $errors->all('<li><span class="text-danger">:message</span></li>')) !!}
											</ul>
										@endif
									<div class="col-md-12"><div class="form-group"><h5>Use code "P4P30FREE" to get Free 30 days trial</h5></div></div>
								<div class="col-md-12">
										  <div class="form-group">
											<input name="coupon" class="form-control"  type = "text" maxlength = "16" placeholder="Coupon Code" id="coupon">
											 <div class="brdBtm">&nbsp;</div> 
								   <span class="text-danger" id="invalid" style="display:none">Invalid Coupon code</span>
										  </div>
										</div>
										<div class="col-md-12">
										  <div class="form-group">
											<select name="offer_name" class="form-control" id="offer">
												@foreach($arg as $args)
												  <option value="{{$args->plan_id}}">{{$args->plan_name}}</option>
												@endforeach
											</select>
											 <div class="brdBtm">&nbsp;</div> 
								   
										  </div>
										</div>
										
										<div class="col-md-12">
										  <div class="form-group">
											<input name="cardnumber" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "16" placeholder="Card Number">
											 <div class="brdBtm">&nbsp;</div> 
										  </div>
										</div>
										
										<div class="col-md-12">
										  <div class="form-group">
											<input type="text" class="form-control" id="" name="nameoncard" placeholder="Name on card">
											<div class="brdBtm">&nbsp;</div>  
										  </div>
										</div>
									  </div>
									  <div class="row">
										  <div class="col-md-12">Expiration Month / Year</div>
										<div class="col-md-6">
										  <div class="form-group">
												<select name="month">
												  <option vlaue="" >Select Month</option>
												  <?php 
													for($i=1; $i<13; $i++){
															echo "<option value='$i'>$i</option>";
														}
												  ?>
												</select>
											 <div class="brdBtm">&nbsp;</div> 
										  </div>
										</div>
										<div class="col-md-6">
										  <div class="form-group">
											 <select name="year">
												  <option vlaue="" >Select Year</option>
												  <?php 
													for($i=2021; $i<2100; $i++){
															echo "<option value='$i'>$i</option>";
														}
												  ?>
												  
											  </select>
											<div class="brdBtm">&nbsp;</div>  
										  </div>
										</div>
									  </div>
									  <div class="row">
										<div class="col-md-12">
										  <div class="form-group">
											<input class="form-control" name="cvv" placeholder="Security Number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "3" />
											 <div class="brdBtm">&nbsp;</div> 
										  </div>
										</div>
										<div class="col-md-12">
											Country
										  <div class="form-group">
											  <select name="country">
												  <option>Select One</option>
												  @foreach($countries as $key => $value)
													  <option value="{{$key}}">{{$value}}</option>
													  
												  @endforeach
											  </select>
											 <div class="brdBtm">&nbsp;</div> 
										  </div>
										</div>
										<div class="col-md-12">
										  <div class="form-group">
											<input type="text" name="address" class="form-control" id="" placeholder="Address">
											 <div class="brdBtm">&nbsp;</div> 
										  </div>
										</div>
										<div class="col-md-12">
										  <div class="form-group">
											<input type="text" name="city" class="form-control" id="" placeholder="City">
											 <div class="brdBtm">&nbsp;</div> 
										  </div>
										</div>
										<div class="col-md-12">
										  <div class="form-group">
											<input type="text" name="state" class="form-control"  id="" placeholder="State">
											 <div class="brdBtm">&nbsp;</div> 
										  </div>
										</div>
										<div class="col-md-12">
										  <div class="form-group">
											<input type="text" class="form-control"  name="zipcode"  id="" placeholder="Zip/Postal Code">
											 <div class="brdBtm">&nbsp;</div> 
										  </div>
										</div>  
										<div class="col-md-12">
											<div class="form-check">
												<input type="checkbox" class="form-check-input" id="exampleCheck1" name="agreement" style="width: 28px;" required="required">
												<label class="form-check-label" for="exampleCheck1" style="padding: 13px 14px; font-size:17px;">I agree to the <a href="{{ url('terms-of-use')}}" target="_blank">Terms of Use</a> and <a href="{{ url('privacy-policy')}}" target="_blank">Privacy Policy</a></label>
										  </div>
										</div>
									  </div>	
									  <div class="row">
										<div class="col-md-12">
										  <button type="submit" class="btn main-btn pull-right">Start Free Trial</button>
										</div>
									  </div>
									</form>

								  </div>
								  <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
									  <div class="row">
								<div class="col-md-12" id="paypal-button-container-P-5HB944653H3709631MCIXMDY"></div>


									  </div>
								  </div>
								</div>
                           </div>
                        </div>
                     </aside>
                  </div>
               </div>
            </div>
         </div>
      </section>
@endsection

@section('title')
Payment
@endsection

@section('script') 
<script>
	var showpayment = function () {
			var value = $('.radiocheck:checked').val();
			$("#secfirst").hide();
			$("#secsecond").show();
		}
function customRadio(radioName){
        var radioButton = $('input[name="'+ radioName +'"]');
        $(radioButton).each(function(){
            $(this).wrap( "<span class='custom-radio'></span>" );
            if($(this).is(':checked')){
                $(this).parent().addClass("selected");
            }
        });
        $(radioButton).click(function(){
            if($(this).is(':checked')){
                $(this).parent().addClass("selected");
            }
            $(radioButton).not(this).each(function(){
                $(this).parent().removeClass("selected");
            });
        });
    }
    $(document).ready(function (){
        customRadio("gender");
		customRadio("2");
		customRadio("1");
		customRadio("3");

  
    })
</script> 
 <script>
           
        $('#datepicker, #datepicker2').datepicker({
            uiLibrary: 'bootstrap'
        });
</script>
<script src="https://www.paypal.com/sdk/js?client-id=AQrlM_k396ttJ2JvH_4k6a60-IEzA08FtpZfUwD7ciiSpUcvBbgfdIcqc-NE3mEfh1C5Oh5jel-va4vU&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script> 
<script>
  paypal.Buttons({
      style: {
          shape: 'rect',
          color: 'gold',
          layout: 'vertical',
          label: 'subscribe'
      },
      createSubscription: function(data, actions) {
        return actions.subscription.create({
          /* Creates the subscription */
          plan_id: 'P-5HB944653H3709631MCIXMDY'
        });
      },
      onApprove: function(data, actions) {
        alert(data.subscriptionID); // You can add optional success message for the subscriber here
      }
  }).render('#paypal-button-container-P-5HB944653H3709631MCIXMDY'); // Renders the PayPal button
</script>
<script>
$(document).ready(function() {
  $("#coupon").on('blur',function(){
    var token = $("input[name=_token]").val();
    var coupon = $(this).val();
    if(coupon !== ''){
        $.ajax({
          url: '{{url("/")}}/payment/couponcheck',
          type:'POST',
          data:{coupon:coupon,_token:token},
          success:function(data){
            var obj = JSON.parse(data);
            if(obj.success){
              var res = obj.data;
              var output = '<option value="'+res[0].plan_id+'">'+res[0].plan_name+'</option>';
              if(res[1].plan_id !== undefined){
                output += '<option value="'+res[1].plan_id+'">'+res[1].plan_name+'</option>';
              }
              $("#offer").html(output);
              $("#invalid").hide();
            }
            else{
              $("#invalid").show();
            }
          }
        });
    }


  });
});
</script>
@endsection

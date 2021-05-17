@extends('site.layout.main')

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

<section class="loginPage">
  <div class="container">
    <div class="row justify-content-center d-flex" id="secsecond">
      <div class="col-lg-7">
        <nav>
          <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist"> <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><img src="http://148.76.75.204/postcards/public/site/images/card.jpg"></a> <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><img src="http://148.76.75.204/postcards/public/site/images/paypal.jpg"></a> </div>
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
				<div class="col-md-12"><div class="form-group"><h3>Free 30 day trial - pay $o.oo now</h3></div></div>
        <div class="col-md-12">
                  <div class="form-group">
                    <input name="coupon" class="form-control"  type = "text" maxlength = "16" placeholder="Coupon Code">
					 <div class="brdBtm">&nbsp;</div> 
                  </div>
                </div>
				<div class="col-md-12">
                  <div class="form-group">
                    <select name="offer_name" class="form-control">
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
        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="MFMZRRVJ4MNG4">
<table>
<tr><td><input type="hidden" name="on0" value=""></td></tr><tr><td><select name="os0">
	<option value="option 1">option 1 : $10.00 USD - yearly</option>
	<option value="Option 2">Option 2 : $5.00 USD - monthly</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.sandbox.paypal.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.sandbox.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>


              </div>
		  </div>
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

  


<script src="https://www.paypal.com/sdk/js?client-id=AQx3eycCyMGpuj8RaMU-HmQk-q_qxgFYiDH4oAVN8n3HAd7ENxp_-VFdF1cM_AwdY2UtDx9TC59SNWA0&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script> 
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
          plan_id: 'P-9BC34117TY659012TMCEXWRY'
        });
      },
      onApprove: function(data, actions) {
        alert(data.subscriptionID); // You can add optional success message for the subscriber here
      }
  }).render('#paypal-button-container-P-9BC34117TY659012TMCEXWRY'); // Renders the PayPal button
</script>
@endsection

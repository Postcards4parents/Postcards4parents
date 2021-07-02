@extends('site.layout.main')
@section('content')

@php
  $welcomeMsg = $client->getEntry('7q5JEW2ILAY2HpvXuuTZph');
  $video = $welcomeMsg->get('moduleImages', null, false);
  if(!empty($video)){
    $video = $client->resolveLink($video[0]);
    $videourl= $video->getFile()->getfileName();
  }else{
    $videourl="";
  }
  $vedioLink = explode("&",$videourl);
  $vedioLink2 = explode("=",$vedioLink[0]);
  //print_r ($vedioLink2);
  
@endphp
<style>
  .backed{
	float:left;
	width:100%;
}
  #quizSections1{
	float:left;
	width:100%;
}
</style>
<section class="about-wrap topBanner">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-12 text-center">
        <div class="about-video m-auto">
          <iframe width="100%" height="500" src="https://www.youtube.com/embed/{{$vedioLink2[1]}}?loop=1&playlist={{$vedioLink2[1]}}&showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
      
    </div>
  </div>
</section>
<!-- Banner -->
<section class="wantTolearn home_wantTolearn">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-md-5 mb-3 mb-md-0">
          @php
            $wantLearnMsgs=$wantLearnMsg->get('moduleText1');
            if(!empty($wantLearnMsgs)){
              $wantLearnMsgs= $renderer->render($wantLearnMsgs);
            }else{
              $wantLearnMsgs="";
            }

            $wantLearnMsgImg = $wantLearnMsg->get('moduleImages', null, false);
            if(!empty($wantLearnMsgImg)){
              $wantLearnMsgImg = $client->resolveLink($wantLearnMsgImg[0]);
              $wantLearnMsgImg= $wantLearnMsgImg->getFile()->getUrl();
            }else{
              $wantLearnMsgImg="";
            }
          @endphp            
          {!! $wantLearnMsgs !!}
		  <div class="img mt-3"><img src="{{$wantLearnMsgImg}}" class="img-fluid"></div>
        </div>
		@php 
			if( \Auth::guard('user')->check() ){
			$user_auth = Auth::guard('user')->user();
			//dd($user_auth);
			$userId = $user_auth->id;
			$offerDataa = DB::table('offer_payemnt_tbl')->where('user_id',$userId)->first();
			}else{
			$offerDataa="";
			}
			@endphp
		@if(empty($offerDataa)) 
        <div class="col-md-5">
			<div class="">
			  @foreach($productOffer as $key=>$productOfferList)
				@if(count($productOffer) < 3)
         
				  <div class="mb-4">
					<div class="post-card-content h-100">
					  <h3 class="text-center">{{$productOfferList->productTitle}}</h3>
					  <h5 class="price font-italic mt-2 mb-2 text-center">{{$productOfferList->priceYearlyLabel}}</h5>
					  @if(!empty($productOfferList->priceYearly))
						<!-- <h3 class="price font-italic mt-2 mb-3">${{$productOfferList->priceYearly}}/ye.</h3> -->
					  @endif
					  <p class="orange">{{$productOfferList->callOut}}</p>
					  <p>{{$productOfferList->savings}}</p>
					  @foreach($productOfferList->productFeatures as $key=>$productFeatureList)
						<p><i class="fas fa-check"></i> {{$productFeatureList->productFeature}}</p>
					  @endforeach
					  @if($Usertype!=2)
						<a class="link2" href="{{url('register')}}">Sign up!</a>
					  @else
						<input type="hidden" id="productTitle" value="{{$productOfferList->productTitle}}" >
						<input type="hidden" id="productAmount" value="{{$productOfferList->priceMonthy}}" >
						<a href="{{ url('payment')}}/{{$productFeatureList->getId()}}" class="link2 paymentOffer">Purchase Offer!</a>
					  @endif  
					</div>
				  </div>
				@else
          @if($productOfferList->getId() == '3d23f4B66yvnPO4eoGCe4S')
				  <div class="mb-4">
					<div class="post-card-content h-100">
					  <h3 class="text-center">{{$productOfferList->productTitle}}</h3>
					  <h5 class="price font-italic mt-2 mb-2 text-center">{{$productOfferList->priceYearlyLabel}}</h5>
					  @if(!empty($productOfferList->priceYearly))
						<!-- <h3 class="price font-italic mt-2 mb-3">${{$productOfferList->priceYearly}}/ye.</h3> -->
					  @endif
					  <p class="orange">{{$productOfferList->callOut}}</p>
					  <p>{{$productOfferList->savings}}</p>
					  @foreach($productOfferList->productFeatures as $key=>$productFeatureList)
						<p><i class="fas fa-check"></i> {{$productFeatureList->productFeature}}</p>
					  @endforeach
					  @if($Usertype!=2)
						<a class="link2" href="{{url('register')}}">Sign up!</a>
					  @else
						<input type="hidden" id="productTitle" value="{{$productOfferList->productTitle}}" >
						<input type="hidden" id="productAmount" value="{{$productOfferList->priceMonthy}}" >
						<a href="{{ url('payment')}}/{{$productFeatureList->getId()}}" class="link2 paymentOffer">Purchase Offer!</a>
					  @endif  
					</div>
				  </div>
          @endif
				@endif  
			  @endforeach
			</div>
		</div>
		@endif
      </div>
    </div>
 </section>
 
 <section class="howItWorks">
  <div class="container">
    <?php
      
       $how = $client->getEntry("6ONVwnULynyoJkpB67QgyK");
        
       
       $heading=$how->get('headline');
       if(!empty($heading))
       {
        $r_head1= $renderer->render($heading);
       }else{
         $r_head1="";
       }
       
       $text1=$how->get('text1');
       if(!empty($text1))
       {
        $r_text1= $renderer->render($text1);
       }else{
         $r_text1="";
       }

       $text2=$how->get('text2');
       if(!empty($text2))
       {
        $r_text2= $renderer->render($text2);
       }else{
         $r_text2="";
       }
       $text3=$how->get('text3');
       if(!empty($text3))
       {
        $r_text3= $renderer->render($text3);
       }else{
         $r_text3="";
       }
       $text4=$how->get('text4');
       if(!empty($text4))
       {
        $r_text4= $renderer->render($text4);
       }else{
         $r_text4="";
       }
      
      $banner_image1 = $how->get('image1', null, false);
      if(!empty($banner_image1)){
        $banner_image1_u = $client->resolveLink($banner_image1);
        $banner_image1_url= $banner_image1_u->getFile()->getUrl();
      }else{
        $banner_image1_url="";
      }
      $banner_image2 = $how->get('image2', null, false);
      if(!empty($banner_image2)){
        $banner_image2_u = $client->resolveLink($banner_image2);
        $banner_image2_url= $banner_image2_u->getFile()->getUrl();
      }else{
        $banner_image2_url="";
      }
      $banner_image3 = $how->get('image3', null, false);
      if(!empty($banner_image3)){
        $banner_image3_u = $client->resolveLink($banner_image3);
        $banner_image3_url= $banner_image3_u->getFile()->getUrl();
      }else{
        $banner_image3_url="";
      }
      $banner_image4 = $how->get('image4', null, false);
      if(!empty($banner_image4)){
        $banner_image4_u = $client->resolveLink($banner_image4);
        $banner_image4_url= $banner_image4_u->getFile()->getUrl();
      }else{
        $banner_image4_url="";
      }

      


       $metaDescription=$how->get('metaDescription');
       


       ?>
	    <!-- title -->
	   {!!  $r_head1 !!}	   
      <ul>
        <li>
          <div class="row align-items-end">
            <div class="col-md-8 col-sm-8 col-8">
                <span>1.</span>
              {!!  $r_text1 !!}
              
            </div>
            <div class="col-md-4 col-sm-4 col-4">
            <span><img src="{{$banner_image1_url}}" class="img-fluid"></span>
            </div>
          </div>          
        </li>
        <li>
          <div class="row align-items-end">
            <div class="col-md-8 col-sm-8 col-8">
                <span>2.</span>
                {!!  $r_text2 !!}
            </div>
            <div class="col-md-4 col-sm-4 col-4">
              <img src="{{$banner_image2_url}}" class="img-fluid">
            </div>
          </div>          
        </li>
        <li>
          <div class="row align-items-end">
              <div class="col-md-8 col-sm-8 col-8 order-md-2">
              <span>3.</span>
              {!!  $r_text3 !!}
            
            </div>
            <div class="col-md-4 col-sm-4 col-4">
              <img src="{{$banner_image3_url}}" class="img-fluid">
            </div>
          </div>          
        </li>
        <li>
          <div class="row align-items-end">
            <div class="col-md-8 col-sm-8 col-8 order-md-2">
              <span>4.</span>
              {!!  $r_text4 !!}
              
            </div>
            <div class="col-md-4 col-sm-4 col-4">
              <img src="{{$banner_image4_url}}" class="img-fluid">
            </div>
          </div>          
        </li>
      </ul>
      @if($Usertype != '2')
      <a id="anotherSignup2" data-toggle="modal" data-target="#stepModal1" href="#" class="link2">Sign up!</a> 
      @endif
      {{-- <a href="#" class="link2">Sign up</a> --}}
  </div>
</section>
<!--info panel move here -->
<section class="backed">
  <div class="container">
    <div class="row">
      <div class="col-md-6 mb-sm-3">
        <div class="backed-content">
          @php
            $snapshotMsg = $client->getEntry('3oGdEPfUaD2WSTl3nH7IfN');
            
            $snapshotMsg=$snapshotMsg->get('moduleText1');
            if(!empty($snapshotMsg)){
              $snapshotMsg= $renderer->render($snapshotMsg);
            }else{
              $snapshotMsg="";
            }
          @endphp     
          {!! $snapshotMsg !!}

          <!-- <h2>Backed by research. Trusted by parents.</h2>
          <p>Our content is based on the latest research in Positive Psychology, Cognitive Behavioral Psychology, Attachment Parenting, Child-centered Play Therapy, and brain science.  It is created by Clinical Psychologists, and approved by our Board of Pediatricians, Family Doctors, and Clinical Psychologists, in collaboration with Maine Medical Center.</p> -->
        </div>
      </div>
      <div class="col-md-6">
        
          <div id="testinomials" class="owl-carousel owl-theme">
            @foreach($testinomials as $key=>$testinomialsList)
              @php 
                $testinomial=$testinomialsList->get('testimonial');
                if(!empty($testinomial)){
                  $testinomials= $renderer->render($testinomial);
                }else{
                  $testinomials="";
                }
                $randomNumber = rand(0,2);
              @endphp
              <div class="item">
                <div class="chat-box" style="background-image:url(site/images/chat-box{{$randomNumber}}.png);">
                  {!!  $testinomials !!}
                  <h4>{{$testinomialsList->parentName}}</h4>
                </div>
              </div>
            @endforeach         
        </div>
      </div>
    </div>
  </div>
</section>
<section class="whatsYou home_whatsYou" id="quizSections1">
  <div class="container">
    <form id="regForm" class="multiForm">
      @php $l=1;
      $quiz = array(0=>$quiz[0]);
      @endphp
      
      @foreach($quiz as $key=>$quizQuestion)
        @php 
          $leftColumn=$quizQuestion->get('leftColumnCopy');
          if(!empty($leftColumn)){
            $leftPart= $renderer->render($leftColumn);
          }else{
            $leftPart="";
          }
        @endphp
        <div class="tab">
          <div class="row justify-content-between">
            <div class="col-md-4">
              {!! $leftPart !!}
              <a id="anotherSignup1" href="{{url('/quiz')}}" class="link2 first-btn" style="padding: 20px 60px;
background: #1c9970;
color: #fff;font-size: 18px;
font-weight: 500;display: inline-block;
margin-top: 30px;
font-family: 'Roboto Mono', monospace;
-webkit-box-shadow: 3px 3px 3px rgba(254, 137, 90, 0.5);border-radius: 30px;">Find Out</a>
            </div>
            @if($quizQuestion->quizAnswerFormat->quizAnswerType != "Email capture page")
              <div class="col-md-6 my-auto mainForm2">
            @else
			 	  
              <div class="col-md-7 my-auto">
				 
            @endif
              @if($quizQuestion->quizAnswerFormat->quizAnswerType != "Affirmation page")
                <h3>{{$quizQuestion->quizQuestion}} <span>{{$quizQuestion->instructionForAnswering}}</span></h3>
              @endif
              @if($quizQuestion->quizAnswerFormat->quizAnswerType == "Scale, 1-7")
                
                <div id="form1rendercheck">
                  <!-- <input type="hidden" name="scaleQuesType[]" value="Scale, 1-7"> -->
                  @php
					if(($quizQuestion->variableName) !== ''){
							$value = $quizQuestion->variableName;
						}
					else{
							$value = $quizQuestion->quizQuestion;
						}
                  @endphp
                  <input type="hidden" name="scaleQuestion[]" value="{{$value}}">
                  <div class="nm">
                    <label>1
                      <input type="radio" class="" oninput="this.className = ''" name="scaleOption{{$l}}" value="1">
                      <span class="checkmark"></span>
                    </label>
                    <label>2
                      <input type="radio" class="" oninput="this.className = ''" name="scaleOption{{$l}}" value="2">
                      <span class="checkmark"></span>
                    </label>
                    <label>3
                      <input type="radio" class="" oninput="this.className = ''" name="scaleOption{{$l}}" value="3">
                      <span class="checkmark"></span>
                    </label>
                    <label class="container">4
                      <input type="radio" class="" oninput="this.className = ''" name="scaleOption{{$l}}" value="4">
                      <span class="checkmark"></span>
                    </label>
                    <label>5
                      <input type="radio" class="" oninput="this.className = ''" name="scaleOption{{$l}}" value="5">
                      <span class="checkmark"></span>
                    </label>
                    <label>6
                      <input type="radio" class="" oninput="this.className = ''" name="scaleOption{{$l}}" value="6">
                      <span class="checkmark"></span>
                    </label>
                    <label>7
                      <input type="radio" class="" oninput="this.className = ''" name="scaleOption{{$l}}" value="7">
                      <span class="checkmark"></span>
                    </label>    
                  </div>
                </div>
                <ul class="reatType">
                  @if(!empty($quizQuestion->text1))
                    <li>{{$quizQuestion->text1}}</li>
                  @endif
                  @if(!empty($quizQuestion->text2))
                    <li>{{$quizQuestion->text2}}</li>
                  @endif
                  @if(!empty($quizQuestion->text3))
                    <li>{{$quizQuestion->text3}}</li>
                  @endif
                </ul> 
                @php 
                  $l++; 
                @endphp
              @elseif($quizQuestion->quizAnswerFormat->quizAnswerType == "Multiple choice")
                @php
                  //$noInstAns = filter_var($quizQuestion->instructionForAnswering, FILTER_SANITIZE_NUMBER_INT);
                @endphp
                <ul class="multiRadio">
                  <!-- <input type="hidden" name="choiseQuesType[]" value="Multiple choice"> -->
                  <input type="hidden" name="choiseQuestion[]" value="{{$value}}">
                  @if(!empty($quizQuestion->text1))
                    <li>
                      <label class="radioBtn">{{$quizQuestion->text1}}
                        <input type="checkbox" class="game" value="{{$quizQuestion->text1}}" name="multiChoise[]">
                        <span class="checkmark"></span>
                      </label>
                    </li>
                  @endif
                  @if(!empty($quizQuestion->text2))
                    <li>
                      <label class="radioBtn">{{$quizQuestion->text2}}
                        <input type="checkbox" class="game" value="{{$quizQuestion->text2}}" name="multiChoise[]">
                        <span class="checkmark"></span>
                      </label>
                    </li>
                  @endif
                  @if(!empty($quizQuestion->text3))
                    <li>
                      <label class="radioBtn">{{$quizQuestion->text3}}
                        <input type="checkbox" class="game" value="{{$quizQuestion->text3}}" name="multiChoise[]">
                        <span class="checkmark"></span>
                      </label>
                    </li>
                  @endif
                  @if(!empty($quizQuestion->text4))
                    <li>
                      <label class="radioBtn">{{$quizQuestion->text4}}
                        <input type="checkbox" class="game" value="{{$quizQuestion->text4}}" name="multiChoise[]">
                        <span class="checkmark"></span>
                      </label>
                    </li>
                  @endif
                  @if(!empty($quizQuestion->text5))
                    <li>
                      <label class="radioBtn">{{$quizQuestion->text5}}
                        <input type="checkbox" class="game" value="{{$quizQuestion->text5}}" name="multiChoise[]">
                        <span class="checkmark"></span>
                      </label>
                    </li>
                  @endif
                  @if(!empty($quizQuestion->text6))
                    <li>
                      <label class="radioBtn">{{$quizQuestion->text6}}
                        <input type="checkbox" class="game" value="{{$quizQuestion->text6}}" name="multiChoise[]">
                        <span class="checkmark"></span>
                      </label>
                    </li>
                  @endif
                  @if(!empty($quizQuestion->text7))
                    <li>
                      <label class="radioBtn">{{$quizQuestion->text7}}
                        <input type="checkbox" class="game" value="{{$quizQuestion->text7}}" name="multiChoise[]">
                        <span class="checkmark"></span>
                      </label>
                    </li>
                  @endif
                  @if(!empty($quizQuestion->text8))
                    <li>
                      <label class="radioBtn">{{$quizQuestion->text8}}
                        <input type="checkbox" class="game" value="{{$quizQuestion->text8}}" name="multiChoise[]">
                        <span class="checkmark"></span>
                      </label>
                    </li>
                  @endif
                  @if(!empty($quizQuestion->text9))
                    <li>
                      <label class="radioBtn">{{$quizQuestion->text9}}
                        <input type="checkbox" class="game" value="{{$quizQuestion->text9}}" name="multiChoise[]">
                        <span class="checkmark"></span>
                      </label>
                    </li>
                  @endif
                  @if(!empty($quizQuestion->text10))
                    <li>
                      <label class="radioBtn">{{$quizQuestion->text10}}
                        <input type="checkbox" class="game" value="{{$quizQuestion->text10}}" name="multiChoise[]">
                        <span class="checkmark"></span>
                      </label>
                    </li>
                  @endif
                </ul>
              @elseif($quizQuestion->quizAnswerFormat->quizAnswerType == "Text entry")
                <div class="form-group ansrArea">
                  <label>characters.</label>
                  <textarea name="description" class="" oninput="this.className = ''"></textarea>
                </div>
              @elseif($quizQuestion->quizAnswerFormat->quizAnswerType == "Email capture page")
                <div class="resultBox">
                    <div class="form-group">
                        <input type="text" name="fname" class="" oninput="this.className = ''" placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <input type="text" name="lname" class="" oninput="this.className = ''" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="" oninput="this.className = ''" placeholder="Email Address">
                    </div>
                  <h4>Your child’s grade(s)</h4>
                  <div id="form1renderresults">
                    <div class="cmBtn">
                      <div>
                        <label>pre-K
                          <input type="checkbox" class="cus" name="grade[]" value="pre-K" id="0">
                          <span class="checkmark"></span></label>
                        <label>K
                          <input type="checkbox" class="cus" name="grade[]" value="K" id="1">
                          <span class="checkmark"></span></label>
                        <label>1
                          <input type="checkbox" class="cus" name="grade[]" value="1" id="2">
                          <span class="checkmark"></span></label>
                        <label>2
                          <input type="checkbox" class="cus" name="grade[]" value="2" id="3">
                          <span class="checkmark"></span></label>
                        <label>3
                          <input type="checkbox" class="cus" name="grade[]" value="3" id="4">
                          <span class="checkmark"></span></label>
                        <label>4
                          <input type="checkbox" class="cus" name="grade[]" value="4" id="5">
                          <span class="checkmark"></span></label>
                        <label>5
                          <input type="checkbox" class="cus" name="grade[]" value="5" id="6">
                          <span class="checkmark"></span></label>
                        <label>6-8
                          <input type="checkbox" class="cus" name="grade[]" value="6-8" id="7">
                          <span class="checkmark"></span></label>
                        <label>9-12
                          <input type="checkbox" class="cus" name="grade[]" value="9-12" id="8">
                          <span class="checkmark"></span></label>
                      </div>
                    </div>
                  </div>
                  <ul class="listStar">
                    <li>Our personalized subscription service is currently only available for parents with children in grades K–5. If your child is younger or older, please indicate their grade range, and we will still send your Personal Parenting Profile.</li>
                    <li>If you have more than one child, select the current school grade for each of them. In summer, enter the grade they will be entering.</li>
                  </ul>
                </div>
              @else
              @php
                $affirmationImg = $quizQuestion->get('quizImage', null, false);
                if(!empty($affirmationImg)){
                  $affirmationImgs = $client->resolveLink($affirmationImg);
                  $affirmationImgs= $affirmationImgs->getFile()->getUrl();
                }else{
                  $affirmationImgs="";
                }
              @endphp
                <figure class="text-center">
                  <img src="{{$affirmationImgs}}" style="width:100%;">
                </figure>
              @endif
            </div>
				  
          </div>
        </div>
      @endforeach  
		<div class="col-md-12">
			<div id="finalSubBtn">
			  <!--<button type="button" id="prevBtn" onclick="nextPrev(-1)"> < Previous</button>-->
			  
			</div>
		</div>
      <div style="overflow:auto;" class="justify-content-between row pt-5">
		<div class="col-md-4">&nbsp;</div>
		<div class="col-md-6 d-flex justify-content-between">
			<!--<div class="d-flex number"><p id="quizIndicate">1</p> of <p>{{count($quiz)}}</p></div>--> 			
		</div>
			
      </div>
      <!-- Circles which indicates the steps of the form: -->
      <div style="text-align:center;margin-top:40px; display: none;">
        @foreach($quiz as $key=>$quizQuestion)
          <span class="step"></span>
        @endforeach
        
      </div>
      
    </form>
  </div>
</section>





  <?php //sleep(1); ?>
  
  @endsection

@section('title')
{{ strip_tags($r_head) }}
@endsection

@section('description')
@if(!empty($metaDescription))
{{$metaDescription}}
@endif
@endsection

@section('script')

<script>
  $(".paymentOffer").click(function(){
    var Title   = $('#productTitle').val();
		var Amount  = $('#productAmount').val();
		var Qty     = 1;
		var Desc    = "Postcards offer for Personal Membership";
    //alert(productAmount);
    //return false;
    window.showLoading();
    $.ajax({
			url:"{{ url('payment') }}",
			method:"post",
			data:{"_token": "{{ csrf_token() }}",Title:Title ,Amount:Amount ,Qty:Qty ,Desc:Desc},
			success: function( response ) {
        window.closeLoading();
				window.location.href = response;
			}
			//console.log(data);
		  });
  })
</script> 
<script>
  var max_limit = 3; // Max Limit
  $(document).ready(function (){
      $(".game:input:checkbox").each(function (index){
          this.checked = (".game:input:checkbox" < max_limit);
      }).change(function (){
          if ($(".game:input:checkbox:checked").length > max_limit){
              this.checked = false;
          }
      });
  });
  $(".btnScale").click(function(){
    $(this).parent().addClass('active').siblings().removeClass('active');
  })
</script>  

<script>
  var currentTab2 = 1;
  var currentTab = 0; // Current tab is set to be the first tab (0)
  showTab(currentTab); // Display the current tab

  function showTab(n) {
    // This function will display the specified tab of the form...
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    //... and fix the Previous/Next buttons:
    if (n == 0) {
      document.getElementById("prevBtn").style.display = "none";
    } else {
      document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
      document.getElementById("finalSubBtn").innerHTML = "<button type='button' id='prevBtn' onclick='nextPrev(-1)'> < Previous</button><button type='button' class='getResults' id='nextBtn' onclick='nextPrev(1)''>Get Results!</button>";
    } else {
      document.getElementById("nextBtn").innerHTML = "Next >";
    }
    //... and run a function that will display the correct step indicator:
    fixStepIndicator(n)
  }

  function nextPrev(n) {
	location.assign('quiz');
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;

    currentTab2 = currentTab2 + n;
    $("#quizIndicate").html(currentTab2);
    // if you have reached the end of the form...
    if (currentTab >= x.length) {
      // ... the form gets submitted:
      //document.getElementById("regForm").submit();
      // alert('Quiz submitted!');
      var resultdata = $('#regForm').serializeArray();
      // console.log(resultdata); return false;
      // console.log(JSON.stringify($('#regForm').serialize()));
      //var formData = $("#regForm").serializeArray();
      // var formData=document.getElementById("regForm");
      // alert(formData);  
        $.ajax({
          type: "post",
          url: "{{ url('quizView') }}",
          dataType:"json",
          data: {resultdata:resultdata, "_token": "{{ csrf_token() }}"},
          success: function(data){
            // alert(data);return false;
            $('#quizSections').addClass('d-none');
            $('#quizProfile').removeClass('d-none');
            $("#quizUserName").html(data.data);
            $("#"+data.perspective_taking).removeClass("d-none");
            $("#"+data.play_and_time).removeClass("d-none");
            $("#"+data.democratic).removeClass("d-none");
            $("#"+data.positive_communication).removeClass("d-none");
            $("#"+data.setting_limits).removeClass("d-none");
            $("#"+data.structure_and_routine).removeClass("d-none");
            $("#"+data.expectation).removeClass("d-none");
            $("#"+data.parent_anxity).removeClass("d-none");
            $("#"+data.parent_stress_response).removeClass("d-none");
            
          }
        });



      return false;
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
  }

  function validateForm() {
    // This function deals with validation of the form fields
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    // A loop that checks every input field in the current tab:
    for (i = 0; i < y.length; i++) {
      // If a field is empty...
      if (y[i].value == "") {
        // add an "invalid" class to the field:
        y[i].className += " invalid";
        // and set the current valid status to false
        valid = false;
      }
    }
    // If the valid status is true, mark the step as finished and valid:
    if (valid) {
      document.getElementsByClassName("step")[currentTab].className += " finish";
    }
    return valid; // return the valid status
  }

  function fixStepIndicator(n) {
    // This function removes the "active" class of all steps...
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
      x[i].className = x[i].className.replace(" active", "");
    }
    //... and adds the "active" class on the current step:
    x[n].className += " active";
  }
</script>   
@endsection      

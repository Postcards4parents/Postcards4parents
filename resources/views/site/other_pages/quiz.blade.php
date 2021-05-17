@extends('site.layout.main')



@section('content')
<!-- Banner -->
<!--<section class="topBanner">
    <div class="container">
    
        
      <?php
         
        // $how = $client->getEntry("6ONVwnULynyoJkpB67QgyK");

         $home_top = $client->getEntry("69AK26dD9qYKpX946I7xLp");
         $heading=$home_top->get('headline');
         if(!empty($heading))
         {
          $r_head= $renderer->render($heading);
         }else{
           $r_head="";
         }
         
         $supportingText=$home_top->get('supportingText');
         if(!empty($supportingText))
         {
          $r_support= $renderer->render($supportingText);
         }else{
           $r_support="";
         }

        $banner_media = $home_top->get('bannerMedia', null, false);
        if(!empty($banner_media)){
          $banner_media_u = $client->resolveLink($banner_media);
          $banner_media_url= $banner_media_u->getFile()->getUrl();
        }else{
          $banner_media_url="";
        }

        // dd($home_top);
        ?>
      <div class="row">
        <aside class="col-lg-5 col-md-6">
          {!! $r_head !!}
          {!! $r_support !!}  
         
          {{-- <a href="#" class="link1">Read Postcards</a> --}}
         
          @if($Usertype !='2')
           <a id="anotherSignup1" data-toggle="modal" data-target="#stepModal1" href="#" class="link2">Sign up!</a> 
          @endif
           {{-- <button id="anotherSignup" type="submit" class="link2 a" data-toggle="modal" data-target="#stepModal1">Sign up!</button> --}}
        </aside>
        <aside class="col-lg-7 col-md-6 my-auto">
        <img src="{{$banner_media_url}}" class="img-fluid">
  
        </aside>
      </div>
    </div>
  </section>-->


</section>
<section class="whatsYou" id="quizSections">
  <div class="container">
    <form id="regForm" class="multiForm">
      @php $l=1;
      unset($quiz[0]);
      $quiz = array_values($quiz);
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
            @if(($quizQuestion->quizAnswerFormat->quizAnswerType == "Email capture page") && ($Usertype==2))
            @else
              {!! $leftPart !!}
            @endif
            </div>
            @if($quizQuestion->quizAnswerFormat->quizAnswerType != "Email capture page")
              <div class="col-md-6 my-auto mainForm2">
            @else
			 	  
              <div class="col-md-7 my-auto">
				 
            @endif
              @if(($quizQuestion->quizAnswerFormat->quizAnswerType != "Affirmation page"))
                @if($Usertype==2)
                @else
                <h3>{{$quizQuestion->quizQuestion}} <span>{{$quizQuestion->instructionForAnswering}}</span></h3>
                @endif
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
                      <input type="radio" class="" oninput="this.className = ''" name="scaleOption{{$l}}" value="4" checked="checked">
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
                @if($Usertype==2)
                
                @else
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
                @endif
                  
                  
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
			<div style="float:right;" id="finalSubBtn">
				<button type="button" id="prevBtn" onclick="nextPrev(-1)"> < Previous</button>
				<button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
			</div>
		</div>
      <div style="overflow:auto;" class="justify-content-between row pt-5">
		<div class="col-md-4">&nbsp;</div>
		<div class="col-md-6 d-flex justify-content-between">
		<div class="d-flex number"><p id="quizIndicate">1</p> of <p>{{count($quiz)}}</p></div> 
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

<div class="yelloBg d-none" id="quizProfile">
  <section class="newSection">
    <div class="container">
      <div class="row">
        <div class="col-xl-3">
          @php
            $snapshotMsg=$snapshotMsg->get('moduleText1');
            if(!empty($snapshotMsg)){
              $snapshotMsg= $renderer->render($snapshotMsg);
            }else{
              $snapshotMsg="";
            }
          @endphp     
          {!! $snapshotMsg !!}
        </div>
        <div class="col-xl-9">
          <div class="">
            <ul class="nav nav-pills d-flex flex-nowrap tabBtn" role="tablist">
              @foreach($welcomeKitPages as $key=>$welcomeKitPagesList)
                <li class="nav-item"><a <?php if($welcomeKitPagesList->pageTitle == 'Snapshot Summary'){ echo"class='active'";}?> data-toggle="pill" href="#menuTab{{$key++}}">{{$welcomeKitPagesList->pageTitle}}</a></li>
              @endforeach
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content">
              @foreach($welcomeKitPages as $keey=>$welcomeKitPagesList2)
                @php
                $leftColumnDESC=$welcomeKitPagesList2->get('pageText');
                if(!empty($leftColumnDESC)){
                  $leftColumnDec= $renderer->render($leftColumnDESC);
                }else{
                  $leftColumnDec="";
                }
                @endphp
                <div id="menuTab{{$keey++}}" class="tab-pane <?php if($welcomeKitPagesList2->pageTitle == 'Snapshot Summary'){ echo"active";} else{echo"fade";}?>">
                  @if($welcomeKitPagesList2->pageTitle == 'Snapshot Summary')
                  <div id="chartDiv" style="width: 780px; height: 500px; margin: 0px auto;"></div>
                  @endif
                  <div class="row pl-5">
                    @if($welcomeKitPagesList2->pageTitle == 'Snapshot Summary')
                    
					  @php
					  $display = "d-none";
					  @endphp
                      <div class="col-md-12"><h2 id="quizUserName">Hi Kate!</h2></div>
                      @else
						@php
					  $display = "d-none";
					  @endphp
                    @endif
                  <div class="col-md-12">{!! $leftColumnDec !!}</div>
                    @foreach($welcomeKitPagesList2->welcomeKitContentChunks as $welcomeKitContentChunksList)
                      @php
                      $chunkContent=$welcomeKitContentChunksList->get('parentFeedback');
                                        if(!empty($chunkContent)){
                                            $chunkContentData= $renderer->render($chunkContent);
                                            $id = $welcomeKitContentChunksList->getID();
                                            
                                        }else{
                                            $chunkContentData="";
                                        }
                                        $chunkImage = $welcomeKitContentChunksList->get('imageToGoWithContent', null, false);
                                        if(!empty($chunkImage)){
                                            $chunkImage_u = $client->resolveLink($chunkImage[0]);
                                            $chunkImage_u_url= $chunkImage_u->getFile()->getUrl();
                                        }else{
                                            $chunkImage_u_url="";
                                        }
                                        @endphp
                                        @if(empty($chunkImage_u_url))
											<div class="col-md-12 {{ $display}}" id="{{ $id }}" >
                                            <div class="col-md-12">{!! $chunkContentData !!}</div>
                                            </div>  
                                        @else
                                        <div class="col-md-12 row {{ $display}}" id="{{ $id }}">
                                        <div class="col-md-8">{!! $chunkContentData !!}</div>
                                        <div class="col-md-3"><img src="{{$chunkImage_u_url}}" class="img-fluid"></div>
                                        </div>
                                        @endif
                                          
                                        @endforeach
                                        
                                    </div>
                                    </div>
                                @endforeach  
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="wantTolearn">
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
              @if(count($productOffer)<3)                  
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
                   `   <p><i class="fas fa-check"></i> {{$productFeatureList->productFeature}}</p>
                    @endforeach
                    @if($Usertype!=2)
                      <a id="SignupInLogin" class="link2" data-toggle="modal" data-target="#stepModal1" href="#">Sign up!</a>
                    @else
                      <input type="hidden" id="productTitle" value="{{$productOfferList->productTitle}}" >
                      <input type="hidden" id="productAmount" value="{{$productOfferList->priceMonthy}}" >
                      <a href="payment/{{$productOfferList->getId()}}" class="link2 paymentOffer">Purchase Offer!</a>
                    @endif  
                  </div>
                </div>
              @else
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
                      <a id="SignupInLogin" class="link2" data-toggle="modal" data-target="#stepModal1" href="#">Sign up!</a>
                    @else
                      <input type="hidden" id="productTitle" value="{{$productOfferList->productTitle}}" >
                      <input type="hidden" id="productAmount" value="{{$productOfferList->priceMonthy}}" >
                      <a href="payment/{{$productOfferList->getId()}}" class="link2 paymentOffer" >Purchase Offer !</a>
                    @endif  
                  </div>
                </div>
              @endif  
            @endforeach
          </div>
		</div>
		@endif 
      </div>
    </div>
  </section>    
      
</div>






 
  @endsection

@section('title')
Quiz
@endsection

@section('description')
@if(!empty($metaDescription))
{{$metaDescription}}
@endif
@endsection

@section('script')
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
<script type="text/javascript" src="{{asset('site/js/jscharting.js')}}"></script>
<script type="text/javascript" src="{{asset('site/js/types.js')}}"></script>
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
            if(data.snapshot_cluster_1 !== null){
              $("#"+data.snapshot_cluster_1).removeClass("d-none");
            }
            if(data.snapshot_cluster_2 !== null){
              $("#"+data.snapshot_cluster_2).removeClass("d-none");
            }
            if(data.snapshot_cluster_3 !== null){
              $("#"+data.snapshot_cluster_3).removeClass("d-none");
            }
            if(data.snapshot_cluster_4 !== null){
              $("#"+data.snapshot_cluster_4).removeClass("d-none");
            }
            if(data.snapshot_cluster_5 !== null){
              $("#"+data.snapshot_cluster_5).removeClass("d-none");
            }
            if(data.snapshot_cluster_6 !== null){
              $("#"+data.snapshot_cluster_6).removeClass("d-none");
            }
            $("#"+data.perspective_taking).removeClass("d-none");
            $("#"+data.self_regulation).removeClass("d-none");
            $("#"+data.play_and_time).removeClass("d-none");
            $("#"+data.democratic).removeClass("d-none");
            $("#"+data.positive_communication).removeClass("d-none");
            $("#"+data.setting_limits).removeClass("d-none");
            $("#"+data.autonomy).removeClass("d-none");
            $("#"+data.parent_joy).removeClass("d-none");
            $("#"+data.structure_and_routine).removeClass("d-none");
            $("#"+data.expectation).removeClass("d-none");
            $("#"+data.parent_anxity).removeClass("d-none");
            $("#"+data.parent_stress_response).removeClass("d-none");
            if(data.login == "loggedin"){
              location.assign("{{ url('/welcomeKit')}}");
            }
            setTimeout(function() {
		 
              var chart = JSC.chart('chartDiv', {
        debug: true,
        legend_visible: false,
        defaultTooltip_enabled: false,
        xAxis_spacingPercentage: 0.4,
        yAxis: [
			{
            id: 'ax1',
            scale_range: [-6,6],
            defaultTick: { padding: 10, enabled: false },
           // customTicks: [0, 300, 600, 700, 800, 850],
            line: { width: 10, color: 'smartPalette:pal1' },
          },
          {
            id: 'ax2',
            scale_range: [-6,6],
            defaultTick: { padding: 10, enabled: false },
           // customTicks: [0, 300, 600, 700, 800, 850],
            line: { width: 10, color: 'smartPalette:pal2' },
          },
        ],
        defaultSeries: {
          type: 'gauge column roundcaps',
          shape: {
            label: {
              text: '%value',
              align: 'center',
              verticalAlign: 'middle',
            },
          },
        },
        series: [
          {
            type: 'column roundcaps',
            name: 'Employee Attune',
            yAxis: 'ax1',
            palette: {
              id: 'pal1',
              pointValue: '{%yValue/12}',
              ranges:  [
                { value: [-6,-1], color: '#00000045' },
				{ value: [-1,0], color: '#0000009e' },
                { value: [0, 1], color: '#000000c9' },
				{ value: [1, 2], color: '#8ecfac' },
				{ value: [2, 6], color: '#1c9970' },
              ],
            },
            shape_label: { style: { fontSize: 28 } },
            points: [['x', [-6, data.emp_attune]]],
			shape: {
            label: {
              text: 'Connection',
              align: 'center',
              verticalAlign: 'middle',
            },
          },
          },
		  {
            type: 'column roundcaps',
            name: 'Struc Control',
            yAxis: 'ax2',
            palette: {
              id: 'pal2',
              pointValue: '%yValue',
              ranges: [
                { value: [-6,-5], color: '#00000045' },
                { value: [-5,-4], color: '#0000009e' },
                { value: [-4, -3], color: '#000000c9' },
				{ value: [-3, -2], color: '#8ecfac' },
				{ value: [-2, 2], color: '#1c9970' },
				{ value: [2, 3], color: '#8ecfac' },
				{ value: [3, 4], color: '#000000c9' },
				{ value: [4, 5], color: '#0000009e' },
				{ value: [5, 6], color: '#00000045' },
				
              ],
            },
            shape_label: { style: { fontSize: 28 } },
            points: [['x', [-6, data.struc_control]]],
			shape: {
            label: {
              text: 'Empowerment',
              align: 'center',
              verticalAlign: 'middle',
            },
          },
          },
        ],
      });},100);
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
@endsection      

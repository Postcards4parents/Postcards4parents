@extends('site.layout.main')

@section('title')
Post card
@endsection

@section('content')
@php 
$user_auth=Auth::guard('user')->user();
$name = $user_auth->name;
$names = explode(' ',$name);
$query_result = (array)$query_result;
//$query_result = array();
//echo "<pre>"; print_r($query_result); echo "</pre>"; exit;
@endphp

<section class="topBanner accountInfo">
  <div class="container">
    <div class="row">
        <aside class="col-lg-3 col-md-4 d-none d-md-block">
            <ul class="leftLinks">
                <li><a href="{{ url('welcomeKit') }}"><i class="far fa-user"></i> Welcome Kit</a></li>
                <li><a href="{{ url('postcards-office-hours') }}"><i class="far fa-file-alt"></i> Your Postcards</a></li>
                <!-- <li><a href="{{ url('story-circle') }}"><i class="far fa-file-alt"></i> Story Circle</a></li> -->
                <li><a href="{{ url('userDashboard') }}"><i class="fas fa-info"></i> Account Info</a></li>
                <li><a href="{{ url('quiz') }}"><i class="fas fa-award"></i> Take Survey</a></li>	
                <li><a href="{{ url('user_log/logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </aside>
        <aside class="col-lg-9 col-md-8 col-12">
            <h2>{{$names[0]}}’s Room</h2>
            <div class="qot">“ {{$quotation->get('summaryOfTestimonial')}}”<span>– {{$quotation->get('authorName')}}</span></div>
            @if(array_key_exists("setting_limits",$query_result))
            <section class="newSection">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
							
                            <div class="">
                                <ul class="nav nav-pills d-flex flex-nowrap" role="tablist">
                                @foreach($welcomeKitPages as $key=>$welcomeKitPagesList)
								@if($welcomeKitPagesList->pageTitle == 'Snapshot Summary')
                                    <li class="nav-item"><a <?php if($welcomeKitPagesList->pageTitle == 'Snapshot Summary'){ echo"class='active'";}else{}?> data-toggle="pill" href="#menuTab{{$key++}}">{{$welcomeKitPagesList->pageTitle}}</a></li>
								@else
								<li class="nav-item"><a <?php if(!empty($subscription)){ echo"class=''"; ?> data-toggle="pill" href="#menuTab{{$key++}}" <?php }else{ echo"class='disabled'"; ?> data-toggle="tooltip" data-placement="top" title="Subscribe below to unlock your full Welcome Kit!" <?php } ?> >{{$welcomeKitPagesList->pageTitle}}</a></li>
                                @endif
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
                                        <!--<figure class="p-5 text-center"><img src="{!! asset('site/') !!}/images/graph.png" class="img-fluid"></figure>-->
										<div id="chartDiv" style="width: auto; max-width:100%; height: 500px; margin: 0px auto;"></div>
                                    @endif
                                    <div class="row pl-5">
                                        @if($welcomeKitPagesList2->pageTitle == 'Snapshot Summary')
										@php
											$namez = explode(" ",$Username);
										@endphp
                                        <div class="col-md-12"><h2 id="quizUserName">Hi {{$namez[0]}}!</h2></div>
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
										$display = "d-none";
                                        if(in_array("$id",$query_result,TRUE)){
												$display = "";
												
												}
											
                                        @endphp
                                        @if(empty($chunkImage_u_url))
											<div class="col-md-12 {{ $display}}" id="{{ $id }}">
                                            <div class="col-md-12">{!! $chunkContentData !!}</div>
                                            </div>  
                                        @else
                                        
                                        <div class="row {{ $display}}" id="{{ $id }}">
                                        <div class="col-md-7">{!! $chunkContentData !!}</div>
                                        <div class="col-md-5"><img src="{{$chunkImage_u_url}}" class="img-fluid"></div>
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
            @else
            <section class="whatsYou home_whatsYou" id="">
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
					<div class="container">
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
            @endif
        </aside>
    </div>
  </div>
</section>


@endsection
@section('script')
@php
        $disabledrag=1;
		if(isset($query_result['emp_attune'])){
		$emp_attune = ($query_result['emp_attune'] !== null) ? $query_result['emp_attune'] : 0;
		$low_attune = $emp_attune - 3;
		$struck = ($query_result['struc_control'] !== null) ? $query_result['struc_control']: 0;
		$low_struck = $struck -3;
		}
		else{
			$emp_attune =0;
			$struck =0;
		}
    @endphp
    <script type="text/javascript" src="{{asset('site/js/jscharting.js')}}"></script>
<script type="text/javascript" src="{{asset('site/js/types.js')}}"></script>

@if(array_key_exists("setting_limits",$query_result))    
<script type="text/javascript">
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
              pointValue: '{%yValue}',
              ranges: [
                { value: [-6,-3], color: '#FF5353' },
                { value: [-2,1], color: '#FFD221' },
                { value: [2,6], color: '#77E6B4' },
               
              ]
            },
            shape_label: { style: { fontSize: 28 } },
            points: [['x', [-6, {{$query_result['emp_attune']}}]]],
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
                { value: [-6,-5], color: '#FF5353' },
                { value: [-4,-3], color: '#FFD221' },
                { value: [-2,2], color: '#77E6B4' },
                { value: [3,4], color: '#FFD221' },
                { value: [5,6], color: '#FF5353' },
               
              ]
            },
            shape_label: { style: { fontSize: 28 } },
            points: [['x', [-6, {{$query_result['struc_control']}}]]],
			shape: {
            label: {
              text: 'Empowerment',
              align: 'center',
              verticalAlign: 'middle',
            },
          },
          },
        ],
      });},300);
    </script>
@endif
@endsection


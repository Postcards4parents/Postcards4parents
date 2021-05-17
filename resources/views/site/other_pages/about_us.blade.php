@extends('site.layout.main')



@section('content')

<!-- Banner -->
<section class="topBanner">
    <div class="container">
      <div class="row">
        <aside class="col-lg-5 col-md-6">
            @php
    //         $parser = $client->getRichTextParser();
    // dd($parser);
 
         $pre_k = $client->getEntry("26NY9JqK2WIEGeeTtPNTuX");

         ///dd($pre_k);
         
         //7ezazPktjgOULFTPmvL3Gj
        //  $out_arr=json_decode(json_encode($pre_k))->fields;
        //  echo '<pre>'; print_r(count((array)$out_arr));  
         
         
        //     exit;
         $name=$pre_k->get('title');
         
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

        $k_media = $pre_k->get('featureImage', null, false);
      
        if(!empty($k_media)){
          $k_media_u = $client->resolveLink($k_media);
          if(!empty($k_media_u->getFile()))
          {
            $k_media_url= $k_media_u->getFile()->getUrl();
          }else{

            $k_media_url="";
          }
          
        }else{
          $k_media_url="";
        }
        



         //Section 1 - Main Title 1

         $section1Title=$pre_k->get('section1Title');
        // echo '<pre>';print_r($desc);
         if(!empty($section1Title))
         {
          $section1Title_d= $renderer->render($section1Title);
         }else{
           $section1Title_d="";
         }
         
          ///
        $section1Title1=$pre_k->get('section1Title1');
         
         if(!empty($section1Title1))
         {
          $section1Title1= $section1Title1;
         }else{
           $section1Title1="";
         }   
         

         $section1Desc1=$pre_k->get('section1Desc1');
        // echo '<pre>';print_r($desc);
         if(!empty($section1Desc1))
         {
          $section1Desc1= $renderer->render($section1Desc1);
         }else{
           $section1Desc1="";
         }
         
        $section1Image1 = $pre_k->get('section1Image1', null, false);
      
        if(!empty($section1Image1)){
          $section1Image1_u = $client->resolveLink($section1Image1);
          if(!empty($section1Image1_u->getFile()))
          {
            $section1Image1_url= $section1Image1_u->getFile()->getUrl();
          }else{

            $section1Image1_url="";
          }
          
        }else{
          $section1Image1_url="";
        }


        ///

        ///
        $section1Title2=$pre_k->get('section1Title2');
         
         if(!empty($section1Title2))
         {
          $section1Title2= $section1Title2;
         }else{
           $section1Title2="";
         }   
         

         $section1Desc2=$pre_k->get('section1Desc2');
        // echo '<pre>';print_r($desc);
         if(!empty($section1Desc2))
         {
          $section1Desc2= $renderer->render($section1Desc2);
         }else{
           $section1Desc2="";
         }
         
        $section1Image2 = $pre_k->get('section1Image2', null, false);
      
        if(!empty($section1Image2)){
          $section1Image2_u = $client->resolveLink($section1Image2);
          if(!empty($section1Image2_u->getFile()))
          {
            $section1Image2_url= $section1Image2_u->getFile()->getUrl();
          }else{

            $section1Image2_url="";
          }
          
        }else{
          $section1Image2_url="";
        }


        ///


        ///
        $section1Title3=$pre_k->get('section1Title3');
         
         if(!empty($section1Title3))
         {
          $section1Title3= $section1Title3;
         }else{
           $section1Title3="";
         }   
         

         $section1Desc3=$pre_k->get('section1Desc3');
        // echo '<pre>';print_r($desc);
         if(!empty($section1Desc3))
         {
          $section1Desc3= $renderer->render($section1Desc3);
         }else{
           $section1Desc3="";
         }
         
        $section1Image3 = $pre_k->get('section1Image3', null, false);
      
        if(!empty($section1Image3)){
          $section1Image3_u = $client->resolveLink($section1Image3);
          if(!empty($section1Image3_u->getFile()))
          {
            $section1Image3_url= $section1Image3_u->getFile()->getUrl();
          }else{

            $section1Image3_url="";
          }
          
        }else{
          $section1Image3_url="";
        }


        ///

         ///
         $section1Title4=$pre_k->get('section1Title4');
         
         if(!empty($section1Title4))
         {
          $section1Title4= $section1Title4;
         }else{
           $section1Title4="";
         }   
         

         $section1Desc4=$pre_k->get('section1Desc4');
        // echo '<pre>';print_r($desc);
         if(!empty($section1Desc4))
         {
          $section1Desc4= $renderer->render($section1Desc4);
         }else{
           $section1Desc4="";
         }
         
        $section1Image4 = $pre_k->get('section1Image4', null, false);
      
        if(!empty($section1Image4)){
          $section1Image4_u = $client->resolveLink($section1Image4);
          if(!empty($section1Image4_u->getFile()))
          {
            $section1Image4_url= $section1Image4_u->getFile()->getUrl();
          }else{

            $section1Image4_url="";
          }
          
        }else{
          $section1Image4_url="";
        }


        ///
         //Section 2

         $section2Title=$pre_k->get('section2Title');
        // echo '<pre>';print_r($desc);
         if(!empty($section2Title))
         {
          $section2Title_d= $renderer->render($section2Title);
         }else{
           $section2Title_d="";
         }
         
         $section2Desc=$pre_k->get('section2Desc');
        // echo '<pre>';print_r($desc);
         if(!empty($section2Desc))
         {
          $section2Desc_d= $renderer->render($section2Desc);
         }else{
          $section2Desc_d="";
         }

         //Section 3

         $section3Title=$pre_k->get('section3Title');
        // echo '<pre>';print_r($desc);
         if(!empty($section3Title))
         {
          $section3Title_d= $renderer->render($section3Title);
         }else{
           $section3Title_d="";
         }
         
         $section3Desc=$pre_k->get('section3Desc');
        // echo '<pre>';print_r($desc);
         if(!empty($section3Desc))
         {
          $section3Desc_d= $renderer->render($section3Desc);
         }else{
          $section3Desc_d="";
         }

         //section 4

         $section4Title1=$pre_k->get('section4Title1');
         
         if(!empty($section4Title1))
         {
          $section4Title1= $section4Title1;
         }else{
           $section4Title1="";
         }   
         

         $section4Desc1=$pre_k->get('section4Desc1');
        // echo '<pre>';print_r($desc);
         if(!empty($section4Desc1))
         {
          $section4Desc1= $renderer->render($section4Desc1);
         }else{
           $section4Desc1="";
         }
         
        $section4Image1 = $pre_k->get('section4Image1', null, false);
      
        if(!empty($section4Image1)){
          $section4Image1_u = $client->resolveLink($section4Image1);
          if(!empty($section4Image1_u->getFile()))
          {
            $section4Image1_url= $section4Image1_u->getFile()->getUrl();
          }else{

            $section4Image1_url="";
          }
          
        }else{
          $section4Image1_url="";
        }


        ///4.2
        $section4Title2=$pre_k->get('section4Title2');
         
         if(!empty($section4Title2))
         {
          $section4Title2= $section4Title2;
         }else{
           $section4Title2="";
         }   
         

         $section4Desc2=$pre_k->get('section4Desc2');
        // echo '<pre>';print_r($desc);
         if(!empty($section4Desc2))
         {
          $section4Desc2= $renderer->render($section4Desc2);
         }else{
           $section4Desc2="";
         }
         
        $section4Image2 = $pre_k->get('section4Image2', null, false);
      
        if(!empty($section4Image2)){
          $section4Image2_u = $client->resolveLink($section4Image2);
          if(!empty($section4Image2_u->getFile()))
          {
            $section4Image2_url= $section4Image2_u->getFile()->getUrl();
          }else{

            $section4Image2_url="";
          }
          
        }else{
          $section4Image2_url="";
        }

         

           $metaDescription_get=$pre_k->get('metaDescription');

            
        
    
       @endphp
               
        <h1>{{ $head }}</h1>
        <p>{!! $k_desc !!}</p>
        @if($Usertype !='2')
        <a id="anotherSignup1" data-toggle="modal" data-target="#stepModal1" href="#" class="link2">Sign up!</a> 
        @endif
        </aside>
        <aside class="col-lg-7 col-md-6 my-auto">
        <img src="{{$k_media_url}}" class="img-fluid">
  
        </aside>
      </div>
    </div>
  </section>
  <!-- Recent Postcards -->

  @php
    $whyContent = $client->getEntry('1Ke6JhajrWkaO29DOomM21');
    //echo"<pre>";
    //print_r($whyContent);
  @endphp  
  
<!-- +++++++ Start whyDont +++++++ -->
	<section class="whyDont why_Dont">
		<div class="container">
			<h2 class="ttl"><span>Why</span>
                @php 
                 $snapshotMsg1=$whyContent->get('moduleText1');
                  if(!empty($snapshotMsg1)){
                    $snapshotMsg1= $renderer->render($snapshotMsg1);
                  }else{
                    $snapshotMsg1="";
                  }
                @endphp     
                {!! $snapshotMsg1 !!}
            </h2>
			<div class="row">
				<div class="col-md-6 mb-4">
					@php   
					  $snapshotMsg2=$whyContent->get('moduleText2');
					  if(!empty($snapshotMsg2)){
						$snapshotMsg2= $renderer->render($snapshotMsg2);
					  }else{
						$snapshotMsg2="";
					  }
					@endphp
					<div class="row flex-sm-row-reverse">
						<div class="col-sm-8">
							<div class="box_Content">
								<span>1.</span>
								{!! $snapshotMsg2 !!}
							</div>
						</div>
						 @php 
						  $Icons = $whyContent->get('moduleImages', null, false);
						 
						  if(!empty($Icons)){
							$Icons = $client->resolveLink($Icons[0]);
							//echo '<pre>'; print_r($Icon); echo '</pre>'; exit;
							$Iconurls= "https:".$Icons->getFile()->getUrl();
							
						  }else{
							$Iconurls="";
						  }
						@endphp
  		
						<div class="col-sm-4">
							<div class="box_img">
								<span><img src="{{$Iconurls}}" class="img-fluid"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 mb-4">
					@php 
		              $snapshotMsg3=$whyContent->get('moduleText3');
		              if(!empty($snapshotMsg3)){
		                $snapshotMsg3= $renderer->render($snapshotMsg3);
		              }else{
		                $snapshotMsg3="";
		              }
		            @endphp
					<div class="row flex-sm-row-reverse">
						<div class="col-sm-8">
							<div class="box_Content">
								<span>2.</span>
								{!! $snapshotMsg3 !!}
							</div>
						</div>
						@php 
						  $Icons = $whyContent->get('moduleImages', null, false);
						 
						  if(!empty($Icons)){
							$Icons = $client->resolveLink($Icons[1]);
							//echo '<pre>'; print_r($Icon); echo '</pre>'; exit;
							$Iconurls= "https:".$Icons->getFile()->getUrl();
							
						  }else{
							$Iconurls="";
						  }
						@endphp
  		
						<div class="col-sm-4">
							<div class="box_img">
								<span><img src="{{$Iconurls}}" class="img-fluid"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 mb-md-0 mb-4">
					@php 
		              $snapshotMsg4=$whyContent->get('moduleText4');
		              if(!empty($snapshotMsg4)){
		                $snapshotMsg4= $renderer->render($snapshotMsg4);
		              }else{
		                $snapshotMsg4="";
		              }
		            @endphp 
					<div class="row">
						<div class="col-sm-8">
							<div class="box_Content">
								<span>3.</span>
								{!! $snapshotMsg4 !!}
							</div>
						</div>
						@php 
						  $Icons = $whyContent->get('moduleImages', null, false);
						 
						  if(!empty($Icons)){
							$Icons = $client->resolveLink($Icons[2]);
							//echo '<pre>'; print_r($Icon); echo '</pre>'; exit;
							$Iconurls= "https:".$Icons->getFile()->getUrl();
							
						  }else{
							$Iconurls="";
						  }
						@endphp
  		
						<div class="col-sm-4">
							<div class="box_img">
								<span><img src="{{$Iconurls}}" class="img-fluid"></span>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6 mb-md-0 mb-4">
					@php 
		              $snapshotMsg5=$whyContent->get('moduleTest5');
		              if(!empty($snapshotMsg5)){
		                $snapshotMsg5= $renderer->render($snapshotMsg5);
		              }else{
		                $snapshotMsg5="";
		              }
		            @endphp 
					<div class="row">
						<div class="col-sm-8">
							<div class="box_Content">
								<span>4.</span>
								{!! $snapshotMsg5 !!}
							</div>
						</div>
						@php 
						  $Icons = $whyContent->get('moduleImages', null, false);
						 
						  if(!empty($Icons)){
							$Icons = $client->resolveLink($Icons[3]);
							//echo '<pre>'; print_r($Icon); echo '</pre>'; exit;
							$Iconurls= "https:".$Icons->getFile()->getUrl();
							
						  }else{
							$Iconurls="";
						  }
						@endphp
  		
						<div class="col-sm-4">
							<div class="box_img">
								<span><img src="{{$Iconurls}}" class="img-fluid"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
 <!-- +++++++ End whyDont +++++++ -->
  <section class="eachWeekly">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <h2 class="ttl">
               <span>What</span>
               
               {!! $section1Title_d !!}
              </h2>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
              <div class="eachBox">
                <figure> <img src="{{$section1Image1_url}}" class="img-fluid"> </figure>
                <h3>{{$section1Title1}}</h3>
                {!! $section1Desc1 !!}
              </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="eachBox">
                  <figure> <img src="{{$section1Image2_url}}" class="img-fluid"> </figure>
                  <h3>{{$section1Title2}}</h3>
                  {!! $section1Desc2 !!}
                </div>
              </div>

              <div class="col-12 col-sm-6 col-lg-3">
                  <div class="eachBox">
                    <figure> <img src="{{$section1Image3_url}}" class="img-fluid"> </figure>
                    <h3>{{$section1Title3}}</h3>
                    {!! $section1Desc3 !!}
                  </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="eachBox">
                      <figure> <img src="{{$section1Image4_url}}" class="img-fluid"> </figure>
                      <h3>{{$section1Title4}}</h3>
                      {!! $section1Desc4 !!}
                    </div>
                  </div>
          </div>
        </div>
      </section>
 
  <section class="howSection">
   	<div class="container">
  		<div class="row">
  			<div class="col-md-6">
  				<!-- <h2 class="ttl"><span>HOW</span></h2> -->
          @php
            $snapshotMsgGi = $client->getEntry('PVBDI9ZRLshb8BfdYyHa1');
            
            $snapshotMsg=$snapshotMsgGi->get('moduleText1');
            if(!empty($snapshotMsg)){
              $snapshotMsg= $renderer->render($snapshotMsg);
            }else{
              $snapshotMsg="";
            }
          @endphp     
          {!! $snapshotMsg !!}
  				<!-- <h2>Know <br>Connect <br>Empower <br>Self-care</h2>
  				<p>On every topic we cover, we share findings from latest science (KNOW), describe what may be going for you child developmentally and how you can connect (CONNECT), and give tips to empower their growth (EMPOWER). Then we encourage you to check in with you – because parenting is a two-way relationships. </p> -->
  			</div>
        @php 
          $Icon = $snapshotMsgGi->get('moduleImages', null, false);
         
          if(!empty($Icon)){
            $Icon = $client->resolveLink($Icon[0]);
            //echo '<pre>'; print_r($Icon); echo '</pre>'; exit;
            $Iconurl= "https:".$Icon->getFile()->getUrl();
            
          }else{
            $Iconurl="";
          }
        @endphp
  			<div class="col-md-6"><img src="{{$Iconurl}}" class="img-fluid"></div>
  		</div>
  	</div>
  </section>
  <section class="teamParents">
        <div class="container">
          <div class="row">
            <div class="col-12 col-md-5 col-xl-6">
              <h2 class="ttl"><span>Team</span>{!! $section3Title_d !!} </h2>
            </div>
            <div class="col-12 col-md-7 col-xl-6">
              {!!  $section3Desc_d !!}
            </div>
            <div class="clearfix"></div>
            <div class="col-12 col-md-6">
              <div class="teamList">
                <figure><img src="{{$section4Image1_url}}" class="img-fluid"></figure>
                <h3>{{$section4Title1}}</h3>
                {!! $section4Desc1 !!}
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="teamList">
                <figure><img src="{{$section4Image2_url}}" class="img-fluid"></figure>
                <h3>{{$section4Title2}}</h3>
                {!! $section4Desc2 !!}
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="teamList">
                <figure><img src="{{$section4Image1_url}}" class="img-fluid"></figure>
                <h3>{{$section4Title1}}</h3>
                {!! $section4Desc1 !!}
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="teamList">
                <figure><img src="{{$section4Image2_url}}" class="img-fluid"></figure>
                <h3>{{$section4Title2}}</h3>
                {!! $section4Desc2 !!}
              </div>
            </div>
          </div>
        </div>
      </section>
  <section class="getTuch">
        <div class="container">
          <form method="post" id="getInTouchAbout" name="getInTouchAbout"> 
          <div class="row">
            <div class="col-12 col-lg-3">
              <h3>Get in touch.</h3>
            </div>
            <div class="col-12 col-lg-5">
              <input required="" type="email" id="touchEmailAbout" placeholder="Email">
              <textarea id="touchMessageAbout" required="" placeholder="Message"></textarea>
              
            </div>
            <div class="col-12 col-md-4 col-lg-3">
              <input class="btnSubmit" id="btngetINAbout" type="submit" name="submit" value="Submit!">
            </div>
          </div>
          </form>
        </div>
      </section>
  
 

    
@endsection
@section('title')
{{$head}}
@endsection

@section('description')
@if(!empty($metaDescription))
{{$metaDescription}}
@endif
@endsection

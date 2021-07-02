@extends('site.layout.main')



@section('content')
<!-- Banner -->
<section class="topBanner">
    <div class="container">
        
      <?php
         
         $how = $client->getEntry("6ONVwnULynyoJkpB67QgyK");

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
  </section>
  <!-- info Panel -->
      <?php 
         $home_mid = $client->getEntry("8bPLVoUBAYvBwxc3zMfaD");
         $heading1=$home_mid->get('headline');
         if(!empty($heading1))
         {
          $r_head1= $renderer->render($heading1);
         }else{
           $r_head1="";
         }
         
         $supportingText1=$home_mid->get('supportingText');
         if(!empty($supportingText1))
         {
          $r_support1= $renderer->render($supportingText1);
         }else{
           $r_support1="";
         }

   ?>
  <section class="infoPanel">
    <div class="container">
      <div class="row">
        <aside class="col-md-5">
            {!! $r_head1 !!}
            {!! $r_support1 !!}
        </aside>
        @include('site.layout.home_slider')
      </div>
    </div>
  </section>
  <!-- how It Works -->
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
        $metakey=$how->get('metaKeyword');
        
        ?>
        <h2>{!!  $r_head1 !!}</h2>
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
  <?php sleep(3); ?>
  @include('site.layout.recent')
  @endsection

@section('title')
{{ strip_tags($r_head) }}
@endsection

@section('description')
@if(!empty($metaDescription))
{{$metaDescription}}
@endif
@endsection

@section('keywords')
@if(!empty($metakey))
{{$metakey}}
@endif
@endsection

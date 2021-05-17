@extends('site.layout.main')

@section('content')

<!-- Banner -->
<section class="topBanner">
    <div class="container">
      <div class="row">
        <aside class="col-lg-5 col-md-6">
            @php
        //$parser = $client->getRichTextParser();
        // dd($parser);
    
         $pre_k = $client->getEntry("3dNl4GnkBZ1cQ0Hc5Uc2ed");
         
        //7ezazPktjgOULFTPmvL3Gj
        //  $out_arr=json_decode(json_encode($pre_k))->fields;
        //  echo '<pre>'; print_r(count((array)$out_arr));  
         
         
        //     exit;
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

        $k_media = $pre_k->get('image', null, false);
      
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
   $query=$query->setContentType("tool")->where("fields.toolCategory.sys.id[in]",array("1qp80KEEMp5afGbAuk9Jcx"))
        ->orderBy("fields.order",true);
     
   $entries_pre = $client->getEntries($query);
  
   //dd($entries_pre);
  $total=$entries_pre->count();
  $snapshotMsg = $client->getEntry('1qp80KEEMp5afGbAuk9Jcx');
  
   
@endphp

  <section class="bottomList">
        <div class="container">
          <div class="row row-eq-height">
			  <div class="col-md-4 col-sm-6">
				<div class="cToolBox">

          @php
            $snapshotMsg=$snapshotMsg->get('toolCategoryDescription');
            if(!empty($snapshotMsg)){
              $snapshotMsg= $renderer->render($snapshotMsg);
            }else{
              $snapshotMsg="";
            }
          @endphp     
          {!! $snapshotMsg !!}

					<!-- <h2>Connection Tools</h2>
					<p>Tuning in and connecting emotionally with your child is the fundamental practice of parenting. Children need to feel connected to a caring adult to feel safe and be able to think, learn, and take risks to explore the world. Regular connection is also how they develop a deep sense that they are lovable.</p> -->
				</div>
			</div>
               @if($total > 0)
                @php  $i=0; @endphp
                @foreach($entries_pre as $ent_key => $ent_value)  
                @php
                 
                $entry_id=$ent_value->getId();
             
                
               
              
                $i=$i+1;
                $pre_title=$ent_value->get('name');
                
                if(!empty($pre_title))
                 {
                    $pre_title= $pre_title;
                    $pre_name = strtolower(str_replace(' ', '-', $pre_title));
                 }else{
                    $pre_title="";
                    $pre_name = "";
                 }   
        
                $IntroText=$ent_value->get('toolPreviewText');
                 if(!empty($IntroText))
                 {
                    
                    $IntroText= $renderer->render($IntroText); 
                  
                 }else{
                    $IntroText="";
                 }
        
                 $IntroImage = $ent_value->get('toolPreviewImage', null, false);
                 
                if(!empty($IntroImage)){
                  $IntroImage_u = $client->resolveLink($IntroImage);
                  $IntroImage_url= $IntroImage_u->getFile()->getUrl();
                }else{
                    $IntroImage_url="";
                }    
        
                
                $developmentCategory=$ent_value->get('toolCategory',null, false);
                if(!empty($developmentCategory))
                 {
                  try {
                    foreach ($developmentCategory as $tIkey => $tIvalue) {
                     
                  

                  $tIvalueU=$client->resolveLink($tIvalue);
                  
                  $catName=$tIvalueU->get('toolCategoryName');
                  $catID=$tIvalueU->getID();
                  
                  $catArr[$ent_key][]=[
                    'id'=>$catID,
                    'catName'=>$catName
                  ];

                  }
                  }catch(Exception $e)
                  {
                    $catArr=[];
                  }
                 }else{
                  $catArr=[];
                 }

                //echo '<pre>'; print_r($catArr);
                //exit;
                @endphp
            
            <div class="col-md-4 col-sm-6">
              <figure><a href="{{url("toolkitDetails/$entry_id/$pre_name")}}"><img src="{{ $IntroImage_url }}" class="img-fluid"></a></figure>
            <h3><a href="{{url("toolkitDetails/$entry_id/$pre_name")}}">{{ $pre_title }}</a></h3>
            <div class="tType">
               
               @php
               $id= $catArr[$ent_key];
               $count=count($id);
               
                ///echo '<pre>'; print_r($id);
                  //exit;
               @endphp 
               @foreach($id as $ival)
                @php
               $idd= $ival['id'];
               $catName= $ival['catName'];
               @endphp
                <a href='{{ url("catlist2/tool/$idd")}}'>{{$catName}} </a>
               @endforeach 
            
              
            
              </div>
              {!! $IntroText !!}
              </div>
              @endforeach
              @else
               No toolkit postcard found

              @endif



          </div>
        </div>
</section>
     
@php
   $query=$query->setContentType("tool")->where("fields.toolCategory.sys.id[in]",array("5tgvivPaNgBCcvGVePUm8r"))
        ->orderBy("fields.order",true);
     
   $entries_pre = $client->getEntries($query);
  
   //dd($entries_pre);
  $total=$entries_pre->count();
  
  $snapshotMsg = $client->getEntry('5tgvivPaNgBCcvGVePUm8r');
  $snapshotMsg=$snapshotMsg->get('toolCategoryDescription');
  if(!empty($snapshotMsg)){
    $snapshotMsg= $renderer->render($snapshotMsg);
  }else{
    $snapshotMsg="";
  }

@endphp

  <section class="bottomList">
        <div class="container">
          <div class="row row-eq-height">
        <div class="col-md-4 col-sm-6">
        <div class="cToolBox empowerment">
          {!! $snapshotMsg !!}
        </div>
      </div>
               @if($total > 0)
                @php  $i=0;
					$catArr = array();
                 @endphp
                @foreach($entries_pre as $ent_key => $ent_value)  
                @php
                 
                $entry_id=$ent_value->getId();
             
                
               
              
                $i=$i+1;
                $pre_title=$ent_value->get('name');
                
                if(!empty($pre_title))
                 {
                    $pre_title= $pre_title;
                    $pre_name = strtolower(str_replace(' ', '-', $pre_title));
                 }else{
                    $pre_title="";
                    $pre_name = "";
                 }   
        
                $IntroText=$ent_value->get('toolPreviewText');
                 if(!empty($IntroText))
                 {
                    
                    $IntroText= $renderer->render($IntroText); 
                  
                 }else{
                    $IntroText="";
                 }
        
                 $IntroImage = $ent_value->get('toolPreviewImage', null, false);
                 
                if(!empty($IntroImage)){
                  $IntroImage_u = $client->resolveLink($IntroImage);
                  $IntroImage_url= $IntroImage_u->getFile()->getUrl();
                }else{
                    $IntroImage_url="";
                }    
        
                
                $developmentCategory=$ent_value->get('toolCategory',null, false);
                if(!empty($developmentCategory))
                 {
                  try {
                    foreach ($developmentCategory as $tIkey => $tIvalue) {
                     
                  

                  $tIvalueU=$client->resolveLink($tIvalue);
                  
                  $catName=$tIvalueU->get('toolCategoryName');
                  $catID=$tIvalueU->getID();
                  
                  $catArr[$ent_key][]=[
                    'id'=>$catID,
                    'catName'=>$catName
                  ];

                  }
                  }catch(Exception $e)
                  {
                    $catArr=[];
                  }
                 }else{
                  $catArr=[];
                 }

                //echo '<pre>'; print_r($catArr);
                //exit;
                @endphp
            
            <div class="col-md-4 col-sm-6">
              <figure><a href="{{url("toolkitDetails/$entry_id/$pre_name")}}"><img src="{{ $IntroImage_url }}" class="img-fluid"></a></figure>
            <h3><a href="{{url("toolkitDetails/$entry_id/$pre_name")}}">{{ $pre_title }}</a></h3>
            <div class="tType">
               
               @php
               $id1= $catArr[$ent_key];
               $count=count($id1);
               
                ///echo '<pre>'; print_r($id);
                  //exit;
               @endphp 
               @foreach($id1 as $ival)
                @php
               $idd= $ival['id'];
               $catName= $ival['catName'];
               @endphp
                <a href='{{ url("catlist2/tool/$idd")}}'>{{$catName}} </a>
               @endforeach 
            
              
            
              </div>
              {!! $IntroText !!}
              </div>
              @endforeach
              @else
               No toolkit postcard found

              @endif



          </div>
        </div>
</section>

 

       
 



@endsection
@section('title')
{{$head}}
@endsection
			
<style>
	.cToolBox{background: #2baf86;padding: 20px; height: 100%;}
	.cToolBox h2,.cToolBox h3{color: #fff; font-size:35px; margin: 0px;}
	.bottomList .cToolBox p{color: #fff; line-height:32px; font-size:20px; font-family: 'Libre Baskerville', serif;}
  .empowerment{background: #f77345;}
</style>			

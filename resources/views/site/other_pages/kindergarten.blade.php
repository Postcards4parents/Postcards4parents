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
 
         $pre_k = $client->getEntry("6P5IoohtMDrcn4owh2fWlw");
         
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
         $metaDescription=$pre_k->get('metaDescription');
         
       

        

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
 if(empty($_GET['q']))
        {
          $limit=6;
        }else{
          $limit=$_GET['q'];
        }

        if(!empty($_COOKIE['grades']))
        {
          $grades=json_decode($_COOKIE['grades'],true);
          $grade_ID=  $grades['0'];
         

        }else{
          $grade_ID="686BB5L44WWO9JKVjJzVGV";
        }
       
        
        
  $Mainquery=$query->setContentType("postcard")
  ->where("fields.gradeLevel.sys.id",$grade_ID)
  ->where("order", "-(sys.updatedAt)")
  ->where("sys.publishedCounter[gte]","1");
  $total_counts = $client->getEntries($Mainquery)->count();


   $query=$query->setContentType("postcard")
     //->where("fields.contentType.sys.contentType.sys.id","Emotional Development")
     ->orderBy("fields.order",true)
     ->where("fields.gradeLevel.sys.id",$grade_ID)
     ->setLimit($limit)
     ->where("sys.publishedCounter[gte]","1");

    //  $client1 = new \Contentful\Delivery\Client(env('CONTENTFUL_DELIVERY_TOKEN'), 
    // env('CONTENTFUL_SPACE_ID'), env('CONTENTFUL_ENVIRONMENT_ID'));
   $entries_pre = $client->getEntries($query);

   $total=$entries_pre->count();
   //dd($total);
   //dd($entries_pre);
   
   // dd($entries_pre);
   //51hefRXWCDPDCrEGXCehNL
   //4LAKsYurMuPjv0NPMEZif2
   //7hFAY0Adk5rbJ3wwlmnoig
//    $Mquery = $mquery
//          ->setContentType("postcard")
//          //->where("fields.gradeLevel.sys.id[in]","686BB5L44WWO9JKVjJzVGV")
//          //->where("fields.contentType.sys.id", "7vPfE70mO8d5Ne0m9TN6i1");
//          ->where("sys.publishedCounter[gte]","1");
         
        
    //  $entries_pre = $mEnvProxy->getEntries($Mquery);
    //  dd($entries_pre);
    
    //     $total_no_pre=count($entries_pre);

    // $sub= $contentDynamic->DataExcess($entries_pre[1]);
    //      dd($sub);
   
    //dd($cont);
    //$ct=json_decode(json_encode($cont))->content;
    //dd(json_decode(json_encode($cont))->content);
    //$parser = new \Contentful\RichText\Parser();
    
    // $cont=$entries_pre[0]->get('contextAndIssue');
    // $node = $renderer->render($cont);
    
    
    
    //$cont1= $renderer->render($cont); 
   
@endphp

       
  <section class="recentList postCards">
    <div class="container">
      <h2>Kindergarten Postcards</h2>
      <div class="row">
        @if($total > 0)
        @php  $i=0; @endphp
        @foreach($entries_pre as $ent_key => $ent_value)  
        @php

        $entry_id=$ent_value->getId();
        //echo '';print_r($ent_value);
        $schoolLevel=$ent_value->get('gradeLevel', null, false);

        if(!empty($schoolLevel))
         {
          
          $schoolLevel_u = $client->resolveLink($schoolLevel);
          $linkID=$schoolLevel_u->getID();
          
          $grade_number=$schoolLevel_u->get('grade');
          $grade_name=$schoolLevel_u->get('gradeTitle');
          $grade_name_seo=strtolower(str_replace(' ', '-', $grade_name));
         }
       
        $allowed_grades=['0'];
       
        if(in_array($grade_number,$allowed_grades))
        {
        $i=$i+1;
        $pre_title=$ent_value->get('title');
        
        if(!empty($pre_title))
         {
            $pre_title= $pre_title;
            $pre_name=strtolower(str_replace(' ', '-', $pre_title));
         }else{
          
            $pre_title="";
            $pre_name=""; 
         }  

         

        //  $IntroText=$ent_value->get('introText');
        //  $arr= json_decode(json_encode($IntroText));
        

        //  foreach($arr->content as  $nkey=>$nval)
        //  {
        //    echo '<pre>';print_r($nval);
        //    if($nval->nodeType=='embedded-asset-block')
        //    {
        //     $id=$nval->data->target->sys->id;
          
        //       $asset = $client->getAsset($id);
        //       //echo '<pre>';print_r();
        //       $ctype=$asset->getFile()->getContentType();
               

        //         if($ctype=='image/jpeg')
        //         {
        //           echo 'JPEG';
        //          echo $curl=$asset->getFile()->getUrl();

        //         }else if($ctype=='audio/mpeg'){
        //          echo 'mp3';
        //          echo $curl=$asset->getFile()->getUrl();
        //         }
        //    }else if($nval->nodeType=='embedded-entry-block')
        //    {
        //      $id=$nval->data->target->sys->id;
        //      $ent=$client->getEntry($id);
        //     // $de= $renderer->render($ent->get('sectionHeader'));
        //      dd($ent->get('sectionHeader'));


        //      $ar=(array)$nval->data->target->sys;
             
        //      $class ='Contentful\Core\Api\Link';
        //      $instance = new $class($nval->data->target->sys->id , $nval->data->target->sys->linkType );
        //      $linkresolve= $client->resolveLink($instance);
        //      $linkcont=   $renderer->render($instance);
        //      dd($linkcont);
        //      //dd($client->resolveLinkCollection($ar));
            
        //      dd($objso);
        //       $as=$client->resolveLink($nval->data->target->sys);
        //        echo '<pre>';print_r($as);
        //     }
          
        //     //
        //  }
        // exit;
        
        // $schoolLevel=$ent_value->get('gradeLevel', null, false);
         
        //  if(!empty($schoolLevel))
        //  {
          
        //   $schoolLevel_u = $client->resolveLink($schoolLevel);
        
        //    //dd( $schoolLevel_u);
        //   $grade_name=$schoolLevel_u->get('grade');
        //   if($grade_name==0)
        //   {
        //     $grade_name="kindergarten";
        //   }

        //  }else{
        //   $grade_name="";
        //  }


        $IntroText=$ent_value->get('introText');
         if(!empty($IntroText))
         {
            
            $IntroText= $renderer->render($IntroText); 
          
         }else{
            $IntroText="";
         }

         $IntroImage = $ent_value->get('introImage', null, false);
         
        if(!empty($IntroImage)){
          $IntroImage_u = $client->resolveLink($IntroImage);
          $IntroImage_url= $IntroImage_u->getFile()->getUrl();
        }else{
            $IntroImage_url="";
        }    

        

         $developmentCategory=$ent_value->get('contentType',null, false);
         

         if(!empty($developmentCategory))
         {
          $developmentCategoryU=$client->resolveLink($developmentCategory);

          $catID=$developmentCategoryU->getID();
          
          $developmentCategory_name=$developmentCategoryU->get('contentType');
          $developmentCategory_name_seo=strtolower(str_replace(' ', '-', $developmentCategory_name));
         }else{
           $developmentCategory_name="";
           $developmentCategory_name_seo="";
         }
         
       
        
       
         //getEditorInterface
          //  $IntroText=$ent_value->getField('introText','en-US');
        
            
          //   $IntroText= $renderer->render($IntroText); 
          //   dd($IntroText);

          
         
         
         
         
        // $developmentCategory=$ent_value->getField('introImage','en-US');
         
       
        //  $ass= $mEnvProxy->getAsset($developmentCategory['sys']['id']);
        //  $image_url=$ass->getFile('en-US')->getUrl();



         
         //dd($ass->getId());
         //getAsset($assetId);
        //  $related_post=$ent_value->get('gradeLevel', null, false);
        //  $IntroImage_u = $client->resolveLink($related_post[0]);
        //  //dd($IntroImage_u);

        @endphp
        <div class="col-md-4 col-sm-6">
          <div class="item">
            <figure><a href="{{url("details/$entry_id/$pre_name")}}"><img src="{{ $IntroImage_url }}" class="img-fluid"></a></figure>
          <h3><a href="{{url("details/$entry_id/$pre_name")}}"> {{ $pre_title }} </a></h3>
                {!!  $IntroText !!}
              <span><a href="{{ url("gradelist/$linkID/$grade_name_seo") }}">{{$grade_name}}</a></span> 
              <span><a href="{{ url("catlist/$catID/$developmentCategory_name_seo") }}">{{ $developmentCategory_name }}</a></span>
              {{-- {{$related_post_id}} --}}
          </div>
          </div>
          @php  } @endphp
             @endforeach
             <div class="clearfix"></div>
@if($total_counts > $limit)      
<p onclick="load_more()" class="loadMore"><span>Load More</span></p>
@endif
           @php
            
           if($i==0){ @endphp
   <div class="col-md-12 col-sm-12">
    No Postcards related to this category grade
    </div>
           @php } @endphp
          @else
          <div class="col-md-12 col-sm-12">
              No Postcards related to this category grade
               </div>
          @endif
          </div>		
          </div>   
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


@section('script')
<script>
var currentURL=location.protocol + '//' + location.host + location.pathname;
@php
$goLimit=$limit+6;
@endphp
function load_more()
{

var Durl=window.location.href;
var limit="{{$goLimit}}";
console.log(Durl);
location.href=currentURL+"?q="+limit;
}
</script>
@endsection



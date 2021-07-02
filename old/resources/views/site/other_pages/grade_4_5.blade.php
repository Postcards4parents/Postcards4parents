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
 
         $pre_k = $client->getEntry("9LCb8C2eNcRcu7KyY7qvj");
         
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
 if(empty($_GET['q']))
        {
          $limit=6;
        }else{
          $limit=$_GET['q'];
        }
        

  $Mainquery=$query->setContentType("postcard")
  ->where("fields.gradeLevel.sys.id[in]","30jZuVYF5iC69qef2Uio6X,DjlsGthkqlj8rs5qjPUSr")
  ->where("order", "-(sys.updatedAt)")
 
  ->where("sys.publishedCounter[gte]","1");
  $total_counts = $client->getEntries($Mainquery)->count();


   $query=$query->setContentType("postcard")
     //->where("fields.contentType.sys.contentType.sys.id","Emotional Development")
     ->where("fields.gradeLevel.sys.id[in]","30jZuVYF5iC69qef2Uio6X,DjlsGthkqlj8rs5qjPUSr")
     ->orderBy("fields.order",true)
     ->setLimit($limit)
     ->where("sys.publishedCounter[gte]","1");

    //  $client1 = new \Contentful\Delivery\Client(env('CONTENTFUL_DELIVERY_TOKEN'), 
    // env('CONTENTFUL_SPACE_ID'), env('CONTENTFUL_ENVIRONMENT_ID'));
   $entries_pre = $client->getEntries($query);
   
   $total=$entries_pre->count();
 
   
   
@endphp

       
  <section class="recentList postCards">
    <div class="container">
      <h2>Grades 4-5 Postcards</h2>
      <div class="row">
          @if($total > 0)
        @php  $i=0; @endphp
        @foreach($entries_pre as $ent_key => $ent_value)  
        @php

        
        //echo '';print_r($ent_value);
        $schoolLevel=$ent_value->get('gradeLevel', null, false);
        if(!empty($schoolLevel))
         {
          
          $schoolLevel_u = $client->resolveLink($schoolLevel);
          $linkID=$schoolLevel_u->getID();
          $grade_number=$schoolLevel_u->get('grade');
          $grade_name=$schoolLevel_u->get('gradeTitle');
         }
       
        $allowed_grades=['4','5'];
        
        if(in_array($grade_number,$allowed_grades))
        {
          $i=$i+1;
        $pre_title=$ent_value->get('title');
        
        if(!empty($pre_title))
         {
            $pre_title= $pre_title;
         }else{
            $pre_title="";
         }   

      
        $entry_id=$ent_value->getId();

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
          
         }else{
           $developmentCategory_name="";
         }

        
       
        
       
    

        @endphp
        <div class="col-md-4 col-sm-6">
          <div class="item">
            <figure><a href="{{url("details/$entry_id")}}"><img src="{{ $IntroImage_url }}" class="img-fluid"></a></figure>
          <h3><a href="{{url("details/$entry_id")}}"> {{ $pre_title }} </a></h3>
                {!!  $IntroText !!}
              <span><a href="{{ url("gradelist/$linkID") }}">{{$grade_name}}</a></span> 
              <span><a href="{{ url("catlist/$catID") }}">{{ $developmentCategory_name }}</a></span>
              {{-- {{$related_post_id}} --}}
          </div>
          </div>
          @php } @endphp
             @endforeach
        <div class="clearfix"></div>
        @if($total_counts > $limit)      
        <p onclick="load_more()" class="loadMore"><span>Load More</span></p>
        @endif
   @php if($i==0){ @endphp
   <div class="col-md-12 col-sm-12">
   <center> No Postcards related to this category grade</center>
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
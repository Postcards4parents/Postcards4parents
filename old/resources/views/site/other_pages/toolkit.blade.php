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
   $query=$query->setContentType("tool")
        ->orderBy("fields.order",true)
     //->where("fields.contentType.sys.contentType.sys.id","Emotional Development")
     //->where("fields.gradeLevel.sys.id[in]","51hefRXWCDPDCrEGXCehNL","4LAKsYurMuPjv0NPMEZif2","7hFAY0Adk5rbJ3wwlmnoig")
     ->where("sys.publishedCounter[gte]","1");

    //  $client1 = new \Contentful\Delivery\Client(env('CONTENTFUL_DELIVERY_TOKEN'), 
    // env('CONTENTFUL_SPACE_ID'), env('CONTENTFUL_ENVIRONMENT_ID'));
   $entries_pre = $client->getEntries($query);
  
   //dd($entries_pre);
  $total=$entries_pre->count();
  
   
@endphp

  <section class="bottomList">
        <div class="container">
          <div class="row row-eq-height">
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
                 }else{
                    $pre_title="";
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
              <figure><a href="{{url("toolkitDetails/$entry_id")}}"><img src="{{ $IntroImage_url }}" class="img-fluid"></a></figure>
            <h3><a href="{{url("toolkitDetails/$entry_id")}}">{{ $pre_title }}</a></h3>
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
                <a href="{{ url("catlist2/tool/$idd")}}">{{$catName}} </a>
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
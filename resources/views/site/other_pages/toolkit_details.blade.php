@extends('site.layout.main')



@section('content')

<section class="topBanner paraBlock">
    <div class="container">
      <div class="row">
      @php
        
      
        $ent_value = $client->getEntry("$detail_id");
         
            
              //dd($ent_value);
               $pre_title=$ent_value->get('name');
                
                if(!empty($pre_title))
                 {
                    $pre_title= $pre_title;
                    $pre_title_title= $pre_title;
                 }else{
                    $pre_title="";
                    $pre_title_title="";
                 }  
        
                $toolText=$ent_value->get('toolText');
                 if(!empty($toolText))
                 {
                    
                    $toolText= $renderer->render($toolText); 
                  
                 }else{
                    $toolText="";
                 }
        
                 $howToDoIt=$ent_value->get('howToDoIt');
                 if(!empty($howToDoIt))
                 {
                    
                  $howToDoIt= $renderer->render($howToDoIt); 
                  
                 }else{
                  $howToDoIt="";
                  }
                   
                  $toolConclusion=$ent_value->get('toolConclusion');
                 if(!empty($toolConclusion))
                 {
                    
                  $toolConclusion= $renderer->render($toolConclusion); 
                  
                 }else{
                  $toolConclusion="";
                  }



                  
              $toolInstructions=$ent_value->get('toolInstructions');
              
              foreach ($toolInstructions as $tkey => $tvalue) {

                
                $toolInstructionName=$tvalue->get('toolInstructionName');
                $toolInstructionText=$tvalue->get('toolInstructionText');
                
               //echo '<pre>';print_r($toolInstructionText);
                if(!empty($toolInstructionText)){
                  $toolInstructionText=$renderer->render($toolInstructionText);
                }else{
                  $toolInstructionText="";
                }  
                
                
               
               

                $toolInstructionArr[]=[
                   'toolInstructionName'=>$toolInstructionName,
                   'toolInstructionText'=>$toolInstructionText
                  ];
                }
                
              
              $toolImage=$ent_value->get('toolImage',null,false);
              
              if(!empty($toolImage))
              {
                foreach ($toolImage as $tIkey => $tIvalue) {

                 $tIvalue_u = $client->resolveLink($tIvalue);

                 $tIvalue_url[]= $tIvalue_u->getFile()->getUrl();

            
                     }
              }else{
                $tIvalue_url=[];
              }
              
                


                $usefulTools=$ent_value->get('toolIcon');
                if(!empty($usefulTools))
                {
                  $toolIcon_url= $usefulTools->getFile()->getUrl();
                }else{
                  $toolIcon_url="";
                }
                
              $toolConclusion=$ent_value->get('toolConclusion');
              if(!empty($toolConclusion))
              {
                $toolConclusion= $renderer->render($toolConclusion); 
              }else{
                $toolConclusion="";
              }


              $developmentCategory=$ent_value->get('toolCategory',null, false);
                if(!empty($developmentCategory))
                 {
                  try {
                    foreach ($developmentCategory as $tIkey => $tIvalue) {
                     
                  

                  $tIvalueU=$client->resolveLink($tIvalue);
                  
                  $catName=$tIvalueU->get('toolCategoryName');
                  $catID=$tIvalueU->getID();
                  
                  $catArr[]=[
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
        
              
              $howToDoIt=$ent_value->get('howToDoIt');
              if(!empty($howToDoIt))
              {
                $howToDoIt= $renderer->render($howToDoIt); 
              }else{
                $howToDoIt="";
              }
              $metaDescription=$ent_value->get('metaDescription');
             

              
        

      @endphp
        <aside class="col-md-9">
          <h1>{{ $pre_title }}</h1>
          <ul>
            
          <li>
            @foreach($catArr as $cKey=>$cVal)
            @php 
            $id= $cVal['id'];
            @endphp 
            <a href="{{ url("catlist/$id")}}">{{$cVal['catName'] }}</a>
            @endforeach
          </li>
          </ul>
        
        </aside>
      </div>
    </div>
  </section>

  <section class="contentPanel">
    <div class="container">
      <div class="row">
        <aside class="col-md-9">
          {{-- <figure><img src="images/self-esteem.jpg" class="img-fluid"></figure> --}}
          @if(!empty($toolText))
             {!! $toolText !!}
          @endif
          
          @if(!empty($tIvalue_url))
          @foreach($tIvalue_url as $ttVal)
          <img src="{{ $ttVal }}" class="img-fluid">
          @endforeach
             
          @endif

          @if(!empty($howToDoIt))
          <h3 class="bd">HOW TO DO IT</h3>
          
          {!! $howToDoIt !!}
             
          @endif

          {{-- @if(!empty($toolInstructionArr))
            @foreach($toolInstructionArr as $iikey=>$iival)
            <strong>{{ $iival['toolInstructionName'] }}</strong>
            {!! $iival['toolInstructionText']  !!}
            @endforeach
          @endif --}}

          
          @if(!empty($toolInstructionArr))
          <div id="accordion">
          @foreach($toolInstructionArr as $iikey=>$iival)
          @php
          $number= ($iikey+1); 
          @endphp
            <div class="card">
            <div class="card-header" id="heading-{{$number}}">
            <h5 class="mb-0"> <a role="button" data-toggle="collapse" href="#collapse-{{$number}}" aria-expanded="false" aria-controls="collapse-{{$number}}" class="collapsed"> {{$number}}. {{ $iival['toolInstructionName'] }} </a> </h5>
              </div>
            <div id="collapse-{{$number}}" class="collapse" data-parent="#accordion" aria-labelledby="heading-{{$number}}" style="">
                <div class="card-body">
                  {!! $iival['toolInstructionText']  !!}
                </div>
              </div>
            </div>
          @endforeach
        </div> 
        @endif

        @if(!empty($toolConclusion))
        {{-- <h3>Conclusion</h3> --}}
        
        {!! $toolConclusion !!}
           
        @endif

       

          @if(!empty($toolIcon_url))
         
            <ul class="tools">
              
              <li>
                <figure><img src="{{$toolIcon_url}}" class="img-fluid"></figure>
                
              </li>
            </ul>
          @endif

          
        </aside>
        <aside class="col-md-3 recentList">
             <h4>Recent Postcards</h4>
             @php
             $day_before = date( 'Y-m-d', strtotime('-2 month' ) );
                
                $query=$query->setContentType("postcard")
                //->where("fields.gradeLevel.sys.id[in]","686BB5L44WWO9JKVjJzVGV") 
                ->where("sys.createdAt[gte]",$day_before)
                ->where("order", "-(sys.createdAt)")
                ->setLimit(10);
                //->where("sys.publishedCounter[gte]","1");
           
             $entries_pre =$client->getEntries($query);
             $total=$entries_pre->count();
                
           @endphp
            @if($total > 0)
            <ul>
                @foreach($entries_pre as $ent_key => $ent_value) 
                @php
                //dd();
       
                $entry_id=$ent_value->getId();
                $pre_title=$ent_value->get('title');
                    
                    if(!empty($pre_title))
                     {
                        $pre_title= $pre_title;
                     }else{
                        $pre_title="";
                     }   
            
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
            
                    $schoolLevel=$ent_value->get('gradeLevel', null, false);
                     //echo '<pre>';print_r($schoolLevel);
                     if(!empty($schoolLevel))
                     {
                      
                      $schoolLevel_u = $client->resolveLink($schoolLevel);
                    
                       
                      $grade_name=$schoolLevel_u->get('gradeTitle');
                      
            
                     }else{
                      $grade_name="";
                     }
            
                     $developmentCategory=$ent_value->get('contentType',null, false);
                     
            
                     if(!empty($developmentCategory))
                     {
                      $developmentCategoryU=$client->resolveLink($developmentCategory);
                      
                      $developmentCategory_name=$developmentCategoryU->get('contentType');
                      
                     }else{
                       $developmentCategory_name="";
                     }
                     
               @endphp 
              <li> <a href="{{url("details/$entry_id")}}">
                <figure><img src="{{ $IntroImage_url }}" class="img-fluid"></figure>
                {{ $pre_title }} </a> </li>
                @endforeach 
            </ul>

            @else
            No Recent Postcards found
            @endif
          </aside>
        
      </div>
    </div>
  </section>


@endsection

@section('title')
{{$pre_title_title}}
@endsection

@section('description')
@if(!empty($metaDescription))
{{$metaDescription}}
@endif
@endsection


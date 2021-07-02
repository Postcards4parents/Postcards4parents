<!-- Recent Postcards -->

 @include('site.layout.recent_query')
 <?php //sleep(1); ?>
 @php
$Rquery=getIDS($client);


$entries_pre =$client->getEntries($Rquery);
//dd($entries_pre);
$total= $entries_pre->count();
@endphp

<section class="recentList">
    <div class="container">
      <h2>Recent Postcards</h2>
      @if($total > 0)
      <div id="recent" class="owl-carousel owl-theme">
         @foreach($entries_pre as $ent_key => $ent_value) 
         @php
         
        

         $entry_id=$ent_value->getId();
         $pre_title=$ent_value->get('title');
             
             if(!empty($pre_title))
              {
                 $pre_title= $pre_title;
                 $pre_name = strtolower(str_replace(' ', '-', $pre_title)); 
              }else{
                 $pre_title="";
                 $pre_name="";
                 

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
               $linkID=$schoolLevel_u->getID();
                
               $grade_name=$schoolLevel_u->get('gradeTitle');

               $grade_name_seo=strtolower(str_replace(' ', '-', $grade_name));
               
     
              }else{
               $grade_name="";
               $grade_name_seo="";
              }
            
              $developmentCategory=$ent_value->get('contentType',null, false);
              try{
              if(!empty($developmentCategory))
              {
               $developmentCategoryU=$client->resolveLink($developmentCategory);
              
               $catID=$developmentCategoryU->getID();
               
               $developmentCategory_name=$developmentCategoryU->get('contentType');
               $developmentCategory_name_seo=strtolower(str_replace(' ', '-', $developmentCategory_name)); ;

              }else{
                $developmentCategory_name="";
                $developmentCategory_name_seo="";
              }
            }catch(Exception $e)
            {
              $developmentCategory_name="";
              $catID="";
              $developmentCategory_name_seo="";
            }
            
     
        @endphp 
         
         <div class="item">
            <figure><a href="{{url("details/$entry_id/$pre_name")}}"><img src="{{ $IntroImage_url }}" class="img-fluid"></a></figure>
              <h3><a href="{{url("details/$entry_id/$pre_name")}}">{{ $pre_title }}</a></h3>
              {!!  $IntroText !!}
              <div class="rdMore"><a href="{{url("details/$entry_id/$pre_name")}}">Read more <i class="fas fa-angle-right"></i></a></div>
              <span><a href="{{ url("gradelist/$linkID/$grade_name_seo") }}">{{$grade_name}}</a></span>
              <span><a href="{{ url("catlist/$catID/$developmentCategory_name_seo") }}">{{ $developmentCategory_name }}</a></span>
          </div>
          @endforeach 
          

        </div>
      @else
      <h3>No Recent Postcards found</h3>   
      @endif
    </div>
  </section>
 


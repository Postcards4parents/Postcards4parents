<!-- Recent Postcards -->

<section class="recentList">
    <div class="container">
      <h2>Recent Postcards</h2>
      <div id="recent" class="owl-carousel owl-theme">
          
          @php
          $day_before = date( 'Y-m-d', strtotime('-1 month' ) );
     
          $query=$query->setContentType("postcard")
          //->where("fields.gradeLevel.sys.id[in]","686BB5L44WWO9JKVjJzVGV") 
          ->where("sys.createdAt[gte]",$day_before)
          ->where("order", "-(sys.createdAt)")
          ->where("limit", "10")
          ->where("sys.publishedCounter[gte]","1");
     
       $entries_pre =$client->getEntries($query);
       foreach($entries_pre as $ent_key => $ent_value)  
           {
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
   
         
        <div class="item">
            <figure><a href="#"><img src="{{ $IntroImage_url }}" class="img-fluid"></a></figure>
              <h3><a href="#">{{ $pre_title }}</a></h3>
              {!!  $IntroText !!}
              <span><a href="#">{{$grade_name}}</a></span>
              <span><a href="#">{{ $developmentCategory_name }}</a></span>
          </div>
       
          @php
           }   
          @endphp
          
        
          
      </div>
    </div>
  </section>

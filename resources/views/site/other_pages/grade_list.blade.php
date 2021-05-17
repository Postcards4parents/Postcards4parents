@extends('site.layout.main')

@section('title')
Post card
@endsection

@section('content')

<section class="topBanner results">
    <div class="container">
        @php
        $gradeList = $client->getEntry("$detail_id");
        $gradeTitle=$gradeList->get('gradeTitle');
        $query=$query->setContentType("postcard")
        ->where("fields.gradeLevel.sys.id","$detail_id");
        //->where("sys.publishedCounter[gte]","1");
        $entries_pre = $client->getEntries($query);
        
        $total =$entries_pre->count();
        @endphp
        <div class="col-md-12">
            <h2> <span>Total {{ $total}} results for... {{$gradeTitle}}</span> </h2>
            
        </div>
        <div class="row">
        @if($total > 0)
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
         }
       
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

        

         $developmentCategory=$ent_value->get('contentType',null, false);
          if(!empty($developmentCategory))
         {
          $developmentCategoryU=$client->resolveLink($developmentCategory);
          
          $developmentCategory_name=$developmentCategoryU->get('contentType');
          
         }else{
           $developmentCategory_name="";
         }

         @endphp
        


        
            <div class="col-md-4 col-sm-6">
                <div class="item">
                  <figure><a href="{{url("details/$entry_id")}}"><img src="{{ $IntroImage_url }}" class="img-fluid"></a></figure>
                 <h3><a href="{{url("details/$entry_id")}}">  {{ $pre_title}} </a></h3>
                {!! $IntroText !!}
                    
                </div>
            </div>
      @endforeach
      @else
      <div class="row">
        <h2>No results found</h2>
      </div>
      @endif
      
    </div>
  </section>


@endsection



@extends('site.layout.main')

@section('title')
Postcards for Parents
@endsection

@section('content')

<section class="recentList postList">
    <div class="container">
        @php
        
        if(empty($_GET['q']))
        {
          $limit=6;
        }else{
          $limit=$_GET['q'];
        }
        
        $Mainquery=$query->setContentType("postcard")
        ->where("fields.gradeLevel.sys.id","4LAKsYurMuPjv0NPMEZif2")
        ->orderBy("fields.order",true)
        
        ->where("sys.publishedCounter[gte]","1");
        $total_counts = $client->getEntries($Mainquery)->count();
        

        $query=$query->setContentType("postcard")
        ->where("fields.gradeLevel.sys.id","4LAKsYurMuPjv0NPMEZif2")
        ->orderBy("fields.order",true)
        ->setLimit($limit)
        //->where("order", "fields.order")
        
        ->where("sys.publishedCounter[gte]","1");
        $entries_pre = $client->getEntries($query);
        
        
        $total =$entries_pre->count();
        
        @endphp
        
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
              try{
              if(!empty($developmentCategory))
              {
               $developmentCategoryU=$client->resolveLink($developmentCategory);
              
               $catID=$developmentCategoryU->getID();
               
               $developmentCategory_name=$developmentCategoryU->get('contentType');
               
              }else{
                $developmentCategory_name="";
              }
            }catch(Exception $e)
            {
              $developmentCategory_name="";
              $catID="";
            }
         $schoolLevel=$ent_value->get('gradeLevel', null, false);
              //echo '<pre>';print_r($schoolLevel);
              if(!empty($schoolLevel))
              {
               
               $schoolLevel_u = $client->resolveLink($schoolLevel);
               $linkID=$schoolLevel_u->getID();
                
               $grade_name=$schoolLevel_u->get('gradeTitle');
               
     
              }else{
               $grade_name="";
              }

         @endphp
        


        
            <div class="col-md-4 col-sm-6">
                <div class="item">
                  <figure><a href="{{url("details/$entry_id")}}"><img src="{{ $IntroImage_url }}" class="img-fluid"></a></figure>
                 <h3><a href="{{url("details/$entry_id")}}">  {{ $pre_title}} </a></h3>
                {!! $IntroText !!}
                <span><a href="{{ url("gradelist/$linkID") }}">{{$grade_name}}</a></span>
              <span><a href="{{ url("catlist/$catID") }}">{{ $developmentCategory_name }}</a></span>
                    
                </div>
            </div>
      @endforeach
         <div class="clearfix"></div>


@if($total_counts > $limit)      
<p onclick="load_more()" class="loadMore"><span>Load More</span></p>
@endif      
      
      @else
      <div class="row">
        <h2>No results found</h2>
      </div>
      @endif
      
    </div>
  </section>


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


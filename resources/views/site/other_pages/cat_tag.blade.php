@extends('site.layout.main')


@section('content')

<section class="topBanner results">
    <div class="container">
        
        @php
       
        //exit;

     
       
           
           $content_type="postcard";
           $D_page="details";
           $field="contentType";
         
       
    
        
        $query_content=$query->setContentType("$content_type")
        //->where("fields.tags.linkId[match]","6fxN7w6NcyMcndGJDGp7Vl")
        ->where("sys.publishedCounter[gte]","1");
        
        $entries_pre = $client->getEntries($query_content);
         



       
        
        $total =$entries_pre->count();
        $i=0;
        @endphp
        <div class="col-md-12">
            <h2> <span>Total <span id="counting"></span> results for... {{$detail_id}}</span> </h2>
                
        </div>

        @if($total > 0)
         
        <div class="row">
        @foreach($entries_pre as $ent_key => $ent_value) 
         
        @php
        

      
        
        $tags=$ent_value->get('tags');
           
           
           if(!empty($tags))
           {
            $tagval=[];
             foreach ($tags as $tkey => $tvalue) {
             
            $tagval[]= $tvalue->get('tag');
           }
           
           }else{
             $tagval=[];
           }
       
          if(!empty($tagval))
          {
             
          $pass=in_array($detail_id, $tagval);
          
            if($pass){
                $i++;

                $entry_id=$ent_value->getId();
        
        
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
            $pre_name=strtolower(str_replace(' ', '-', $pre_title));
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

        

         $developmentCategory=$ent_value->get('contentType',null, false);
        
         if(!empty($developmentCategory))
         {
          $developmentCategoryU=$client->resolveLink($developmentCategory);
         
          $developmentCategory_name=$developmentCategoryU->get('contentType');
          
         }else{
           $developmentCategory_name="";
         }
         
            }

            }else{
                $pass="";
            }  
        
                @endphp
        @if($pass)
        <script>
                document.getElementById("counting").innerHTML="{{$i}}";
          </script>
             
        <div class="col-md-4 col-sm-6">
                <div class="item">
                  <figure><a href="{{url("$D_page/$entry_id/$pre_name")}}"><img src="{{ $IntroImage_url }}" class="img-fluid"></a></figure>
                 <h3><a href="{{url("$D_page/$entry_id/$pre_name")}}">  {{ $pre_title}} </a></h3>
                {!! $IntroText !!}
                    
                </div>
            </div>
      
        @endif
      
      @endforeach
    </div>
      @endif
      @if(empty($i))
      <script>
            document.getElementById("counting").innerHTML="{{$i}}";
      </script>
      <div class="row">
        <h4 style="margin-left: 25px;">No results found for searched tag</h4>
      </div>

      @endif
    </div>
  </section>


@endsection


@section('title')
{{$detail_id}}
@endsection
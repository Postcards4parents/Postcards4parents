@extends('site.layout.main')



@section('content')

<section class="topBanner results">
    <div class="container">
        
        @php
        //dd($tag);
        //exit;

        $catList = $client->getEntry("$detail_id");
        
        
       if($url=='tool')
       {
        $content_type="tool";
        $D_page="toolkitDetails";
        $field="toolCategory";
        $catTitle=$catList->get('toolCategoryName');
        




       } else{
           
           $content_type="postcard";
           $D_page="details";
           $field="contentType";
           $catTitle=$catList->get('contentType');
       }
        
        
        // if($catTitle=='Parenting Tool')
        // {
        //   $content_type="postcardToolkit";
        //   $D_page="toolkitDetails";
        
        // }else{

        //   $content_type="postcard";
        //   $D_page="details";
        // }
        
        $query_content=$query->setContentType("$content_type")
        ->where("fields.$field.sys.id","$detail_id");
        //->where("sys.publishedCounter[gte]","1");
        
        $entries_pre = $client->getEntries($query_content);
        //dd($entries_pre);
        
        $total =$entries_pre->count();
        
        @endphp
        <div class="col-md-12">
            <h2> <span>Total {{ $total}} results for... {{$catTitle}}</span> </h2>
                
        </div>

        @if($total > 0)
    
        <div class="row">
        @foreach($entries_pre as $ent_key => $ent_value) 
         
        @php
                 
                $entry_id=$ent_value->getId();
                $pre_title=$ent_value->get('name');
                
                if(!empty($pre_title))
                 {
                    $pre_title= $pre_title;
                    $pre_name=strtolower(str_replace(' ', '-', $pre_title));
                 }else{
                    $pre_title="";
                    $pre_name="";
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


                 
        
                @endphp
        
        <div class="col-md-4 col-sm-6">
            <div class="item">
              <figure><a href="{{url("$D_page/$entry_id/$pre_name")}}"><img src="{{ $IntroImage_url }}" class="img-fluid"></a></figure>
             <h3><a href="{{url("$D_page/$entry_id/$pre_name")}}">  {{ $pre_title}} </a></h3>
            {!! $IntroText !!}
                
            </div>
        </div>
      
      @endforeach
    </div>
      @else
      <div class="row">
        <h4 style="margin-left: 25px;">No results found</h4>
      </div>
      @endif
    </div>
  </section>


@endsection

@section('title')
{{$catTitle}}
@endsection



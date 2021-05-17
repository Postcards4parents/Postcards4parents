@extends('site.layout.main')

@section('title')
Post card
@endsection

@section('content')


<section class="thanks">
    <div class="container">
    <div class="row">
        @php
         $pre_k = $client->getEntry("5NTpq848XpkLe3LT9zchCw");
         
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
        //dd($k_media);
        if(!empty($k_media)){
          $k_media_u = $client->resolveLink($k_media);
          try{
          if(!empty($k_media_u->getFile()))
          {
            $k_media_url= $k_media_u->getFile()->getUrl();
         
          }else{

            $k_media_url="";
          }
        }catch(Exception $e)
        {

        }
        }else{
          $k_media_url="";
        }

        @endphp

        <aside class="col-md-5">
                {!! $k_desc !!}   
        </aside>
        <aside class="col-md-7 d-none d-md-block">
            <img src="{{$k_media_url}}" class="img-fluid">
        </aside>
    </div>
    </div>
</section>
@endsection
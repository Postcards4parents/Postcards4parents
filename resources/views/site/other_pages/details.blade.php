@extends('site.layout.main')



@section('content')

<section class="topBanner paraBlock">
    <div class="container">
      <div class="row">
          
      @php

     
  
  //
      //echo '<pre>';print_r($ent_value);

      //   $query=$query->setContentType("postcard")
      //   //->where("sys.id","$detail_id")
      //  // ->orderBy("fields.order",true)
      //   //->where("include", "0")
      //   // ->where("skip", "10")
      //   //->setSkip(3) 
      //   //->where("order", "fields.order")
      //   ->orderBy('sys.createdAt')
      //   ->where("sys.publishedCounter[gte]","1");

        
      //   $ent_value = $client->getEntries($query);
      //   foreach ($ent_value as $key => $value) {
         
      //      $id[]=$value->getID();

      //   }
      //  $searched=array_search("7i24eqoRuEcHwocGIYz2oH",$id);
      //  print_r($searched);
      //  dd($id);

    
    if(!empty($_COOKIE['grade_number']))
    {
      $cookie_grades_arr=json_decode($_COOKIE['grade_number']);
      $querycat=$query->setContentType("grade");
          //->where("sys.publishedCounter[gte]","1");
    $entries_grade =$client->getEntries($querycat);
    
    foreach($entries_grade as $egrade)
    {
        if(!empty($egrade))
        {
           $grade_number=$egrade->get('grade');
           $grade_ID=$egrade->getID();
           $grade_title=$egrade->get('yourXGrader');
           $grade_arr_id[$grade_number]=$grade_ID;
           $grade_arr_id_name[$grade_number]=[
             'id'=>$grade_ID,
             'title'=>$grade_title
        ];
      }
    }
    
    foreach($cookie_grades_arr as $gVal)
    {
       $Gids[]=$grade_arr_id[$gVal];

    }

    $Gids_ids=implode(',',$Gids);
    $query=$query->setContentType("postcard")
        ->where("fields.gradeLevel.sys.id[in]",$Gids_ids) 
        ->orderBy('sys.createdAt')
        ->orderBy('sys.id');
        //->where("sys.publishedCounter[gte]","1");
    $ent_value = $client->getEntries($query);

    }else{

      $query=$query->setContentType("postcard")
        ->orderBy('sys.createdAt')
        ->orderBy('sys.id');
        
        //->where("sys.publishedCounter[gte]","1");
      $ent_value = $client->getEntries($query);

    }
     


       //dd($ent_value);die;

       
        
        foreach ($ent_value as $key => $value) {
        
            $ids[]=$value->getID();

            $title[]=$value->get('title');

 
         }
        $post_id= request()->segment(2);
        
         //seach start from 0 
        $searched=array_search($post_id,$ids);
        
        //count start from 1
        $count=$ent_value->count();

      if(($searched+1)==$count)
   {
 
  $prev_title=$title[$searched-1];
  $next_title=0;

}else if($searched==0){
    
    $prev_title=0;
    $next_title=$title[$searched+1];
}else{
    $prev_title=$title[$searched-1];
    $next_title=$title[$searched+1];
}

 //print_r($prev_title);
 //dd($next_title);

      try{
          $ent_value = $client->getEntry("$detail_id");

         }catch(Exception $e){

          $ent_value ="";
          
          $url= url('/');
          
          ?>
         
          <script>
          var url="<?php echo $url ?>";
          alert("No data found for given query"+" Redirecting..");
          
          location.href=url;
           
          </script>
          
        <?php 
        exit;
      }
        
     
        $pre_title=$ent_value->get('title');
             
             if(!empty($pre_title))
              {
                 $pre_title= $pre_title;
                 $pre_title_title= $pre_title;
              }else{
                 $pre_title="";
                 $pre_title_title="";
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

               $grade_number= $schoolLevel_u->get('grade');
                      
                      $cookie_name = "grade_number";
                      
                      if(!empty($_COOKIE['grade_number']))
                      {
                        
                       $grade_saved_arr=json_decode($_COOKIE['grade_number']);

                         
                       
                       if(!in_array("$grade_number",$grade_saved_arr))
                       {
                         
                           array_push($grade_saved_arr ,$grade_number );
                           
                           $encoded_grades=json_encode($grade_saved_arr);
                           setcookie($cookie_name,$encoded_grades,time() + (10 * 365 * 24 * 60 * 60), "/");

                       
                        }
                      }else{
                        $grade_number_arr[]=$grade_number;
                        $encoded_grades=json_encode($grade_number_arr);
                        setcookie($cookie_name,$encoded_grades,time() + (10 * 365 * 24 * 60 * 60), "/");

                      }

               
               
     
              }else{
               $grade_name="";
               $grade_number="";
               $grade_name_seo="";
               
              }
     
              

              $developmentCategory=$ent_value->get('contentType',null, false);
              
     
              if(!empty($developmentCategory))
              {
               $developmentCategoryU=$client->resolveLink($developmentCategory);
               $catID=$developmentCategoryU->getID();
               $developmentCategory_name=$developmentCategoryU->get('contentType');
               $developmentCategory_name_seo=strtolower(str_replace(' ', '-', $developmentCategory_name));
              }else{
                $developmentCategory_name="";
                $catID="";
                $developmentCategory_name_seo="";
              }


              if($catID=='7dO2Fb2ypfgUDFOsld7OqO'){
                $supportingyourself=1;
              }else{
                $supportingyourself=0;
              }


              $contextAndIssue=$ent_value->get('contextAndIssue');
             
              
              if(!empty($contextAndIssue))
              {
                
                
                $contextAndIssue= $renderer->render($contextAndIssue); 
                
               
              }else{
                $contextAndIssue="";
              }

              // $goodNews=$ent_value->get('goodNews');
             
              
              // if(!empty($goodNews))
              // {
                
                
              //   $goodNews= $renderer->render($goodNews); 
                
               
              // }else{
              //   $goodNews="";
              // }
              

              $whatsGoingOnText=$ent_value->get('whatsGoingOnText');
             
              
              if(!empty($whatsGoingOnText))
              {
                
                
                $whatsGoingOnText= $renderer->render($whatsGoingOnText); 
                
               
              }else{
                $whatsGoingOnText="";
              }
              

              $supportingYourChild=$ent_value->get('supportingYourChild');
             
              
              if(!empty($supportingYourChild))
              {
                
                
                $supportingYourChild= $renderer->render($supportingYourChild); 
                
               
              }else{
                $supportingYourChild="";
              }

              $illustration=$ent_value->get('illustration',null, false);
             
              
              if(!empty($illustration))
              {
                
                
                $illustration_u = $client->resolveLink($illustration);
                $illustration_url= $illustration_u->getFile()->getUrl();

                 
                
               
              }else{
                $illustration_url="";
              }

              

             
                $usefulTools=$ent_value->get('usefulTools');

               
               
                foreach ($usefulTools as $ukey => $uvalue) {
                $toolName=$uvalue->get('name');
                $toolID=$uvalue->getID();
                
                $toolPreviewImage=$uvalue->get('toolIcon',null,false);
                if(!empty($toolPreviewImage))
                {
                  $toolPreviewImage_u = $client->resolveLink($toolPreviewImage);
                
                $toolPreviewImage_url= $toolPreviewImage_u->getFile()->getUrl();
               
                }else{
                  $toolPreviewImage_url="";
                }
                

                $Toolarray[]=[
                   'toolName'=>$toolName,
                   'toolIcon'=>$toolPreviewImage_url,
                   'toolId'=>$toolID
                  ];
                }
              
               
                $reflection=$ent_value->get('reflection');
             
              
             if(!empty($reflection))
             {
               
               
              $reflection= $renderer->render($reflection); 
               
              
             }else{
              $reflection="";
             }
             $sources=$ent_value->get('sources');

             


             foreach ($sources as $skey => $svalue) {
                $studyName=$svalue->get('studyName');
                $studyBibliography=$svalue->get('studyBibliography');
                $renderbio=$renderer->render($studyBibliography);

                $Sourcearray[]=[
                   'studyName'=>$studyName,
                   'studyDesc'=>$renderbio
                  ];
                

                
                }

            $tags=$ent_value->get('tags');
           
           
            if(!empty($tags))
            {
              foreach ($tags as $tkey => $tvalue) {
              
             $tagval[]= $tvalue->get('tag');
            }
            
            }else{
              $tagval="";
            }
              

            $metaDescription_get=$ent_value->get('metaDescription');

            if(!empty($metaDescription_get)){
             
              $metaDescription=$renderer->render($metaDescription_get);
            }else{
              $metaDescription="";
            }
            
   if(!empty($supportingyourself)){

              $ideas=$ent_value->get('ideas');
              
              foreach ($ideas as $ikey => $ivalue) {
                $ideaTitle=$ivalue->get('ideaTitle');
                $idea=$ivalue->get('idea');
                $renderIdea=$renderer->render($idea);

                $Ideaarray[]=[
                   'ideaTitle'=>$ideaTitle,
                   'ideaDesc'=>$renderIdea
                  ];
                }
             


   }else{


      
       
                        
        if(empty($UselectedGrades))
                  {
                    

                        if(!empty($_GET['e']))
                        {
                          $email_grade=$_GET['g'];
                          $userGrades=[$email_grade];

                              
                        }else{
                          $userGrades="";
                        }
                  
                  }else{

                    $userGrades=json_decode($UselectedGrades);
                  }           

        if(!empty($userGrades))
        {
              $atThisAgeLinked=$ent_value->get('atThisAgeLinked');
              foreach ($atThisAgeLinked as $atThisAgekey => $atThisAgeValue) {

                $grade=$atThisAgeValue->get('grade');
              
              foreach($grade as $atGrade){
                
                $this_grade=$atGrade->get('grade');   
              
                if(in_array($this_grade,$userGrades))
                {
                  $at_this_age=$atThisAgeValue->get('atThisAge');
                  $render_at_this=$renderer->render($at_this_age);

              
                  $Atthisarray[$this_grade][]=[
                
                'renderAtthis'=>$render_at_this
                
                ];
                }
                
              
                  }

                  } 
                  $ideas=$ent_value->get('ideas');
                    
                    // dd($grade_arr_id);        
                    foreach ($ideas as $ikey => $ivalue) {
                      
                      $ideaForGrades=$ivalue->get('ideaForGrades');
                        
                      foreach($ideaForGrades as $deaForg){
                        
                        $this_grade=$deaForg->get('grade');   
                        $ideaTitle=$ivalue->get('ideaTitle');
                        $idea=$ivalue->get('idea');
                        $renderIdea=$renderer->render($idea);

                        if(in_array($this_grade,$userGrades))
                        {
                          $Ideaarray[$this_grade][]=[
                          'title'=>$ideaTitle,
                          'ideaDesc'=>$renderIdea
                        ];
                        }
                          
                      
                        }
                      }

                    }

  //dd($Ideaarray);

   }           






     @endphp
        <aside id="dCategory" class="col-md-9 {{$developmentCategory_name }}">
          <h1>{{ $pre_title }}</h1>
          <ul>
          <li><a href="{{ url("gradelist/$linkID/$grade_name_seo") }}">{{$grade_name}}</a></li>

          <li><a href="{{ url("catlist/$catID/$developmentCategory_name_seo") }}">{{$developmentCategory_name }}</a></li>
          </ul>
         {!! $contextAndIssue !!} 
         {{-- {!! $goodNews !!}    --}}
        </aside>
      </div>
    </div>
  </section>

  <section class="contentPanel">
    <div class="container">
      <div class="row">
        <aside class="col-md-9">
          {{-- <figure><img src="images/self-esteem.jpg" class="img-fluid"></figure> --}}
          @if(!empty($illustration_url))
          <img src="{{ $illustration_url }}" class="img-fluid">
          
             
          @endif
         
          @if(!empty($whatsGoingOnText))
          <h3 class="bd">WHAT’S GOING ON?</h3>
          
          {!! $whatsGoingOnText !!}
             
          @endif
          

          
                  {{-- login --}}

    @php
    if(!empty($_GET['e']))
    {
    $encrypted=$_GET['e'];
    try{
      $decrypted_string = \Illuminate\Support\Facades\Crypt::decrypt($encrypted);
    }
    catch(Exception $e){
      $decrypted_string="";
     
    }
   }else{
    $decrypted_string="";
   }
    
   @endphp
   @if($Usertype !='2')
  
  
   
   @if($decrypted_string =='MAILER')
   @if(!empty($supportingyourself))
              @if(!empty($supportingYourChild))
              <h3 class="bd">SUPPORTING YOUR SELF</h3>
              {!! $supportingYourChild !!}
              @endif                  
              
              @if(!empty($Ideaarray))
                                        <div id="accordion">
                                        @foreach($Ideaarray as $iikey=>$iival)
                                        @php
                                        $number= ($iikey+1); 
                                        @endphp
                                          <div class="card">
                                          <div class="card-header" id="heading-{{$number}}">
                                          <h5 class="mb-0"> <a role="button" data-toggle="collapse" href="#collapse-{{$number}}" aria-expanded="false" aria-controls="collapse-{{$number}}" class="collapsed"> {{$number}}. {{ $iival['ideaTitle'] }} </a> </h5>
                                            </div>
                                          <div id="collapse-{{$number}}" class="collapse" data-parent="#accordion" aria-labelledby="heading-{{$number}}" style="">
                                              <div class="card-body">
                                              {!! $iival['ideaDesc']  !!}
                                              </div>
                                            </div>
                                          </div>
                                        @endforeach
                                      </div> 
            @endif
@else

            @php 
            //dd($userGrades);
            //dd($_GET['g']);

            $usergrade_eval=$_GET['g'];
            @endphp
            @if(!empty($userGrades))  

            @php  
            $grade_name_title=$grade_arr_id_name[$usergrade_eval]['title'];
            //dd($grade_name_title);
            if(!empty($Atthisarray)){
              $Atthisval= $Atthisarray[$usergrade_eval];
            }


            if(!empty($Ideaarray)){
              $Ideaval=$Ideaarray[$usergrade_eval];
            }

            //print_r($Atthisval);
            //dd($Ideaval);
            @endphp
            <h3 class="bd">SUPPORTING YOUR {{$grade_name_title}}</h3>
              @if(!empty($Atthisval)) 
              @foreach($Atthisval as $AtthisvalKey=>$AtthisvalVal)
              {!! $AtthisvalVal['renderAtthis'] !!}
              @endforeach
              @endif
            
            @if(!empty($Ideaval))
                                      <div id="accordion">
                                      @foreach($Ideaval as $iikey=>$iival)
                                      @php
                                      $number= ($iikey+1); 
                                      @endphp
                                        <div class="card">
                                        <div class="card-header" id="heading-{{$number}}">
                                        <h5 class="mb-0"> <a role="button" data-toggle="collapse" href="#collapse-{{$number}}" aria-expanded="false" aria-controls="collapse-{{$number}}" class="collapsed"> {{$number}}. {{ $iival['title'] }} </a> </h5>
                                          </div>
                                        <div id="collapse-{{$number}}" class="collapse" data-parent="#accordion" aria-labelledby="heading-{{$number}}" style="">
                                            <div class="card-body">
                                            {!! $iival['ideaDesc']  !!}
                                            </div>
                                          </div>
                                        </div>
                                      @endforeach
                                    </div> 
              @endif
              @endif

@endif
                           
                           @if(!empty($Toolarray))
                           <h3 class="bd">USEFUL TOOLS</h3>
                           <ul class="tools">
                             @foreach($Toolarray as $Tkey=>$Tval)
                             @php
                            $Tid=$Tval['toolId'];   
                            $SEO_toolkit=$Tval['toolName'];
                            $SEO_toolkit_name=strtolower(str_replace(' ', '-', $SEO_toolkit));
                             @endphp
                             <li>
                             <figure><a href="{{url("toolkitDetails/$Tid/$SEO_toolkit_name")}}"><img src="{{$Tval['toolIcon']}}" class="img-fluid"></a></figure>
                               <span><a href="{{url("toolkitDetails/$Tid/$SEO_toolkit_name")}}">{{$Tval['toolName']}}</a></span> </li>
                             @endforeach
                           </ul>
                           @endif
 
                           @if(!empty($reflection))
                             <h3 class="bd">REFLECTION</h3>
                             
                             {!! $reflection !!}
                               
                           @endif
                           
                           @if(!empty($Sourcearray))
                           <div class="sources"> <span>SOURCES</span>
                             @foreach($Sourcearray as $Skey=>$Sval)
                             {!! $Sval['studyDesc'] !!}
                             @endforeach
                           </div>
                           @endif
 
                           @if(!empty($tagval))
                           <div class="sTags">
                             
                           @foreach($tagval as $Tkey=>$Tval)
                           <strong>
                               <a href="{{ url("cattag/tag/$Tval") }}">{{ $Tval }}</a>
                           </strong>
                           @endforeach
                         </div>
                           {{-- <div class="sources"> <span>SOURCES</span>
                             @foreach($Sourcearray as $Skey=>$Sval)
                             {!! $Sval['studyDesc'] !!}
                             @endforeach
                           </div> --}}
                           @endif

   @else
   
 
   
    
   



  <div class="loginInner">

      
      @php
    //         $parser = $client->getRichTextParser();
    // dd($parser);
 
         $pre_k = $client->getEntry("6qWdCAaA6Clsgcii4UGNn5");
         
         //7ezazPktjgOULFTPmvL3Gj
        //  $out_arr=json_decode(json_encode($pre_k))->fields;
        //  echo '<pre>'; print_r(count((array)$out_arr));  
         
         
        //     exit;
          
         $desc=$pre_k->get('description');
        // echo '<pre>';print_r($desc);
         if(!empty($desc))
         {
          $k_desc= $renderer->render($desc);
         }else{
           $k_desc="";
         }

        
    @endphp




            {!! $k_desc !!}
      
          
          <form id="myformDetail" name="myformDetail" class="was-validated" method="POST">
              <div class="row">
                  <aside class="col-sm-9">
              <input type="email" id="user_email_detail" name="user_email_detail" placeholder="Email" required="required">
              <input type="password" id="user_password_detail" name="user_pass_detail" placeholder="Enter Password" required="required">
              <div class="formLinks">
                  <ul>
                      <li><a href="#" id="forgetPassDetail" data-toggle="modal" data-target="#forgetModal">Forgot password</a></li>
                  <li><a href="{{ url('auth/facebook') }}"><img src="{!! asset('site/') !!}/images/facebook_icon.png"></a></li>
            <li><a href="{{ url('auth/google') }}"><img src="{!! asset('site/') !!}/images/gmail_icon.png"></a></li>
          
            <li><a id="anotherSignup2" data-toggle="modal" data-target="#stepModal1" href="#" class="link2">Sign up!</a>
                       
                        
                      </li>
                  </ul>
              </div>
            </aside>
            <aside class="col-sm-3"><input class="btnSubmit" id="loginDetail" type="submit" name="loginDetail" value="Submit!"></aside>
                 
          </div>
              
              
         
          
              
              
          
        </form>
      
     
  </div>

  @endif
@else



@if(!empty($supportingyourself))
                        @if(!empty($supportingYourChild))
                        <h3 class="bd">SUPPORTING YOUR SELF</h3>
                        {!! $supportingYourChild !!}
                        @endif                  
                          

                           @if(!empty($Ideaarray))
                            <div id="accordion">
                            @foreach($Ideaarray as $iikey=>$iival)
                            @php
                            $number= ($iikey+1); 
                            @endphp
                              <div class="card">
                              <div class="card-header" id="heading-{{$number}}">
                              <h5 class="mb-0"> <a role="button" data-toggle="collapse" href="#collapse-{{$number}}" aria-expanded="false" aria-controls="collapse-{{$number}}" class="collapsed"> {{$number}}. {{ $iival['ideaTitle'] }} </a> </h5>
                                </div>
                              <div id="collapse-{{$number}}" class="collapse" data-parent="#accordion" aria-labelledby="heading-{{$number}}" style="">
                                  <div class="card-body">
                                  {!! $iival['ideaDesc']  !!}
                                  </div>
                                </div>
                              </div>
                            @endforeach
                          </div> 
                          @endif
  @else

                          @if(!empty($userGrades))  
                          @foreach($userGrades as $new_ekey=>$usergrade_eval)
                          @php  
                          
                           @$grade_name_title=$grade_arr_id_name[$usergrade_eval]['title'];
                          //dd($grade_name_title);
                          if(!empty($Atthisarray)){
                            @$Atthisval= $Atthisarray[$usergrade_eval];
                          }
                          
                          
                          if(!empty($Ideaarray)){
                            @$Ideaval=$Ideaarray[$usergrade_eval];
                          }
                          
                          //print_r($Atthisval);
                          //dd($Ideaval);
                          @endphp
                          <h3 class="bd">SUPPORTING YOUR {{$grade_name_title}}</h3>
                            @if(!empty($Atthisval)) 
                            @foreach($Atthisval as $AtthisvalKey=>$AtthisvalVal)
                            {!! $AtthisvalVal['renderAtthis'] !!}
                            @endforeach
                            @endif
                           
                            @if(!empty($Ideaval))
                                                     <div id="accordion">
                                                     @foreach($Ideaval as $iikey=>$iival)
                                                     @php
                                                     $number= ($iikey+1); 
                                                     @endphp
                                                       <div class="card">
                                                       <div class="card-header" id="heading-{{$number}}">
                                                       <h5 class="mb-0"> <a role="button" data-toggle="collapse" href="#collapse-{{$number}}" aria-expanded="false" aria-controls="collapse-{{$number}}" class="collapsed"> {{$number}}. {{ $iival['title'] }} </a> </h5>
                                                         </div>
                                                       <div id="collapse-{{$number}}" class="collapse" data-parent="#accordion" aria-labelledby="heading-{{$number}}" style="">
                                                           <div class="card-body">
                                                           {!! $iival['ideaDesc']  !!}
                                                           </div>
                                                         </div>
                                                       </div>
                                                     @endforeach
                                                   </div> 
                            @endif
                          
                            @endforeach
                            @endif
                          


@endif
                          
                          @if(!empty($Toolarray))
                          <h3 class="bd">USEFUL TOOLS</h3>
                          <ul class="tools">
                            @foreach($Toolarray as $Tkey=>$Tval)
                            @php
                           $Tid=$Tval['toolId'];   
                           $SEO_toolkit=$Tval['toolName'];
                            $SEO_toolkit_name=strtolower(str_replace(' ', '-', $SEO_toolkit));
                           
                            @endphp
                            <li>
                            <figure><a href="{{url("toolkitDetails/$Tid/$SEO_toolkit_name")}}"><img src="{{$Tval['toolIcon']}}" class="img-fluid"></a></figure>
                              <span><a href="{{url("toolkitDetails/$Tid/$SEO_toolkit_name")}}">{{$Tval['toolName']}}</a></span> </li>
                            @endforeach
                          </ul>
                          @endif

                          @if(!empty($reflection))
                            <h3 class="bd">REFLECTION</h3>
                            
                            {!! $reflection !!}
                              
                          @endif
                          
                          @if(!empty($Sourcearray))
                          <div class="sources"> <span>SOURCES</span>
                            @foreach($Sourcearray as $Skey=>$Sval)
                            {!! $Sval['studyDesc'] !!}
                            @endforeach
                          </div>
                          @endif

                          @if(!empty($tagval))
                          <div class="sTags">
                            
                          @foreach($tagval as $Tkey=>$Tval)
                          <strong>
                              <a href="{{ url("cattag/tag/$Tval") }}">{{ $Tval }}</a>
                          </strong>
                          @endforeach
                        </div>
                          {{-- <div class="sources"> <span>SOURCES</span>
                            @foreach($Sourcearray as $Skey=>$Sval)
                            {!! $Sval['studyDesc'] !!}
                            @endforeach
                          </div> --}}
                          @endif
      
       @endif 
        
       

       </aside>
      
       
       <aside class="col-md-3 recentList">
             <h4>Recent Postcards</h4>
             @include('site.layout.recent_query')
             @php

             if(!empty($encoded_grades))
             {
              $option=$encoded_grades;
             }else{
              $option=[];
             }
             $Rquery=getIDS($client,$option);
            //  $new_query=new \Contentful\Delivery\Query();
            //  $day_before = date( 'Y-m-d', strtotime('-2 month' ) );
                
            //     $query1=$new_query->setContentType("postcard")
            //     //->where("fields.gradeLevel.sys.id[in]","686BB5L44WWO9JKVjJzVGV") 
            //     ->where("sys.updatedAt[gte]",$day_before)
            //     ->orderBy("sys.createdAt",true)
            //     //->where("order", "(sys.createdAt)")
            //     ->where("limit", "10")
            //     ->where("sys.publishedCounter[gte]","1");


           
             $entries_pre =$client->getEntries($Rquery);
           
            
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
                       
                     
                       
                      $grade_name=$schoolLevel_u->get('gradeTitle');
                      
                      
                     // echo 'hi ';
                      //dd(json_decode($_COOKIE['grade_number']));
                     

            
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
              <li> <a href="{{url("details/$entry_id/$pre_name")}}">
                <figure><img src="{{ $IntroImage_url }}" class="img-fluid"></figure>
                {{ $pre_title }} </a> 
              </li>
                @endforeach 
            </ul>

            @else
            No Recent Postcards found
            @endif
          </aside>
        
      </div>
    </div>
  </section>
<div class="pageArrows">
@if($prev_title) 
<a id="left" href="#"><i class="fas fa-angle-left"></i><span>{{$prev_title}}</span></a>
@endif
@if($next_title)

<a id="right" href="#"><i class="fas fa-angle-right"></i><span>{{$next_title}}</span></a>
@endif
</div>

@endsection

@section('title')
{{$pre_title_title}}
@endsection
@section('description')
@if(!empty($metaDescription))

{{$metaDescription}}

@endif
@endsection



@section('script')
<script>
var csrf="{{ csrf_token() }}";
var i = 0;
var post_id="{{request()->segment(2)}}";
console.log(post_id);
@if(!empty($Gids_ids))
var gids="{{$Gids_ids}}";
@else
var gids="";
@endif

function PagingAjax(side)
{
  
  window.showLoading();
   
   $.ajax({
     url: "{{ url('DetailPaging') }}",
     type: "POST",
     data: { side:side,post_id:post_id,gids:gids },
     headers: {'X-CSRF-TOKEN':csrf },
     dataType: 'json',
     success: function(data) {
       console.log(data);
     if(data.status==true)
       {
         var dID=data.id;
         var seo_title= data.seo_title;
         if(dID)
         {
        
         location.href="{{url('details')}}/"+dID+'/'+seo_title;
         }

        //window.closeLoading();
         
           
           
       }else{
       //  window.closeLoading();
         alert("No data avilable");
                       
       
     }
 
   },
     error: function(XMLHttpRequest, textStatus, errorThrown) {
 
     },
     complete: function(data) {
 
     }
 });   
}



$('#left').on('click',function(){
  PagingAjax('left');

});

$('#right').on('click',function(){
  
  PagingAjax('right');
});



window.onload = function() {
 //PagingAjax('middle');
};


</script>
@endsection
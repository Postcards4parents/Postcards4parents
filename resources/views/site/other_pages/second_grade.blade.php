
@extends('site.layout.main')

@section('title')
Postcards for Parents
@endsection

@section('content')
<!-- Banner -->
<section class="topBanner">
  <div class="container">
    <div class="row">
      <aside class="col-lg-5 col-md-6">
          @php
  //         $parser = $client->getRichTextParser();
  // dd($parser);

       $pre_k = $client->getEntry("592U5uJl3JtNFzI86hw3sn");
   
       
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

<section>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <ul class="postTabtn">
          <li class="tab1 d-inline-block active">RECENT</li>
          <li class="tab2 d-inline-block">ALLTOPICS</li>
        </ul>
      </div>
    </div>
  </div>
</section>
<section class="recentList recentList topicsAll cls2 d-none">
  <div class="container">
    <div id="pinBoot">
      @php
        $queryIndex = $query->setContentType("indexCategory")->orderBy('sys.createdAt');
        $indexPostcard = $client->getEntries($queryIndex);
      @endphp
      @foreach($indexPostcard as $key=>$postcardList)
        <article class="white-panel">
          <h4>{{$postcardList->indexCategory}}</h4>
          <ul>
          @php 
            $queryPostcard = $query->setContentType("postcard")->where("fields.indexCategory.sys.id",$postcardList->getID());
            $postcards = $client->getEntries($queryPostcard);
          @endphp
          @foreach($postcards as $key2=>$postcardListing)
            @php 
              $entry_id=$postcardListing->getId();
              $pre_title=$postcardListing->get('title');
              if(!empty($pre_title)){
                $pre_title= $pre_title;
                $pre_name = strtolower(str_replace(' ', '-', $pre_title));
              }else{
                $pre_title="";
                $pre_name = "";
              }   
            
            @endphp
            
            <li><a href="{{url("details/$entry_id/$pre_name")}}">{{$postcardListing->indexTopic}}</a></li>  
          @endforeach
        </ul>
      </article>
      @endforeach
    </div>
  </div>
</section>    
<section class="recentList recentList cls1">
    <div class="container">
        @php
        
        if(empty($_GET['q']))
        {
          $limit=6;
        }else{
          $limit=$_GET['q'];
        }

        $q=new \Contentful\Delivery\Query();
        if(Auth::guard('user')->check()){
          $grades_arr=Session::get('grades_array_data');
          $querycat=$q->setContentType("grade");
                 //->where("sys.publishedCounter[gte]","1");
          $entries_grade =$client->getEntries($querycat);
          
          foreach($entries_grade as $egrade){
            if(!empty($egrade)){
              $grade_number=$egrade->get('grade');
              $grade_ID=$egrade->getID();
              $grade_arr_id[$grade_number]=$grade_ID;
            }
          }
          
          foreach($grades_arr as $gVal){
            $Gids[]=$grade_arr_id[$gVal];
          }

          $Mainquery=$query->setContentType("postcard")
                  ->where("fields.gradeLevel.sys.id[in]",implode(',',$Gids))
                  ->orderBy("fields.order",true);
          
          $total_counts = $client->getEntries($Mainquery)->count();
          
          $query=$q->setContentType("postcard")
                  ->where("fields.gradeLevel.sys.id[in]",implode(',',$Gids)) 
                  ->orderBy("fields.order",true)
                  ->setLimit($limit);
        }else{
          $Mainquery=$query->setContentType("postcard")
                      ->orderBy("fields.order",true);
          
          $total_counts = $client->getEntries($Mainquery)->count();

          $query=$q->setContentType("postcard")
                  ->orderBy("fields.order",true)
                  ->setLimit($limit);
        }
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
          $grade_name_seo=strtolower(str_replace(' ', '-', $grade_name));

         }
       
        $pre_title=$ent_value->get('title');
        
        if(!empty($pre_title))
         {
            $pre_title= $pre_title;
            $pre_name = strtolower(str_replace(' ', '-', $pre_title));
         }else{
            $pre_title="";
            $pre_name = "";
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
               $developmentCategory_name_seo=strtolower(str_replace(' ', '-', $developmentCategory_name));

              }else{
                $developmentCategory_name="";
                $developmentCategory_name_seo="";
              }
            }catch(Exception $e)
            {
              $developmentCategory_name="";
              $developmentCategory_name_seo="";
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
                  <figure><a href="{{url("details/$entry_id/$pre_name")}}"><img src="{{ $IntroImage_url }}" class="img-fluid"></a></figure>
                 <h3><a href="{{url("details/$entry_id/$pre_name")}}">  {{ $pre_title}} </a></h3>
                {!! $IntroText !!}
                <span><a href="{{ url("gradelist/$linkID/$grade_name_seo") }}">{{$grade_name}}</a></span>
              <span><a href="{{ url("catlist/$catID/$developmentCategory_name_seo") }}">{{ $developmentCategory_name }}</a></span>
                    
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

<script>
  $(".tab1").click(function(){
        $(".tab1").addClass("active");
        $(".tab2").removeClass("active");
        $(".cls2").addClass("d-none");
        $(".cls1").removeClass("d-none");
   })

  $(".tab2").click(function(){
        $(".tab2").addClass("active");
        $(".tab1").removeClass("active");
        $(".cls2").removeClass("d-none");
        $(".cls1").addClass("d-none");
  })
</script>
<script>
$(document).ready(function() {
$('#pinBoot').pinterest_grid({
no_columns: 3,
padding_x: 10,
padding_y: 10,
margin_bottom: 50,
single_column_breakpoint: 700
});
});

/*
Ref:
Thanks to:
http://www.jqueryscript.net/layout/Simple-jQuery-Plugin-To-Create-Pinterest-Style-Grid-Layout-Pinterest-Grid.html
*/


/*
    Pinterest Grid Plugin
    Copyright 2014 Mediademons
    @author smm 16/04/2014

    usage:

     $(document).ready(function() {

        $('#blog-landing').pinterest_grid({
            no_columns: 4
        });

    });


*/
;(function ($, window, document, undefined) {
    var pluginName = 'pinterest_grid',
        defaults = {
            padding_x: 10,
            padding_y: 10,
            no_columns: 3,
            margin_bottom: 50,
            single_column_breakpoint: 700
        },
        columns,
        $article,
        article_width;

    function Plugin(element, options) {
        this.element = element;
        this.options = $.extend({}, defaults, options) ;
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype.init = function () {
        var self = this,
            resize_finish;

        $(window).resize(function() {
            clearTimeout(resize_finish);
            resize_finish = setTimeout( function () {
                self.make_layout_change(self);
            }, 11);
        });

        self.make_layout_change(self);

        setTimeout(function() {
            $(window).resize();
        }, 500);
    };

    Plugin.prototype.calculate = function (single_column_mode) {
        var self = this,
            tallest = 0,
            row = 0,
            $container = $(this.element),
            container_width = $container.width();
            $article = $(this.element).children();

        if(single_column_mode === true) {
            article_width = $container.width() - self.options.padding_x;
        } else {
            article_width = ($container.width() - self.options.padding_x * self.options.no_columns) / self.options.no_columns;
        }

        $article.each(function() {
            $(this).css('width', article_width);
        });

        columns = self.options.no_columns;

        $article.each(function(index) {
            var current_column,
                left_out = 0,
                top = 0,
                $this = $(this),
                prevAll = $this.prevAll(),
                tallest = 0;

            if(single_column_mode === false) {
                current_column = (index % columns);
            } else {
                current_column = 0;
            }

            for(var t = 0; t < columns; t++) {
                $this.removeClass('c'+t);
            }

            if(index % columns === 0) {
                row++;
            }

            $this.addClass('c' + current_column);
            $this.addClass('r' + row);

            prevAll.each(function(index) {
                if($(this).hasClass('c' + current_column)) {
                    top += $(this).outerHeight() + self.options.padding_y;
                }
            });

            if(single_column_mode === true) {
                left_out = 0;
            } else {
                left_out = (index % columns) * (article_width + self.options.padding_x);
            }

            $this.css({
                'left': left_out,
                'top' : top
            });
        });

        this.tallest($container);
        $(window).resize();
    };

    Plugin.prototype.tallest = function (_container) {
        var column_heights = [],
            largest = 0;

        for(var z = 0; z < columns; z++) {
            var temp_height = 0;
            _container.find('.c'+z).each(function() {
                temp_height += $(this).outerHeight();
            });
            column_heights[z] = temp_height;
        }

        largest = Math.max.apply(Math, column_heights);
        _container.css('height', largest + (this.options.padding_y + this.options.margin_bottom));
    };

    Plugin.prototype.make_layout_change = function (_self) {
        if($(window).width() < _self.options.single_column_breakpoint) {
            _self.calculate(true);
        } else {
            _self.calculate(false);
        }
    };

    $.fn[pluginName] = function (options) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName,
                new Plugin(this, options));
            }
        });
    }

})(jQuery, window, document);
</script>		
<!--    <script>
    $(document).ready(function() {
    $('#pinBoot').pinterest_grid({
    no_columns: 3,
    padding_x: 10,
    padding_y: 10,
    margin_bottom: 50,
    single_column_breakpoint: 700
    });
    });




    /*
        Pinterest Grid Plugin
        Copyright 2014 Mediademons
        @author smm 16/04/2014

        usage:

         $(document).ready(function() {

            $('#blog-landing').pinterest_grid({
                no_columns: 4
            });

        });


    */
    ;(function ($, window, document, undefined) {
        var pluginName = 'pinterest_grid',
            defaults = {
                padding_x: 10,
                padding_y: 10,
                no_columns: 3,
                margin_bottom: 50,
                single_column_breakpoint: 700
            },
            columns,
            $article,
            article_width;

        function Plugin(element, options) {
            this.element = element;
            this.options = $.extend({}, defaults, options) ;
            this._defaults = defaults;
            this._name = pluginName;
            this.init();
        }

        Plugin.prototype.init = function () {
            var self = this,
                resize_finish;

            $(window).resize(function() {
                clearTimeout(resize_finish);
                resize_finish = setTimeout( function () {
                    self.make_layout_change(self);
                }, 11);
            });

            self.make_layout_change(self);

            setTimeout(function() {
                $(window).resize();
            }, 500);
        };

        Plugin.prototype.calculate = function (single_column_mode) {
            var self = this,
                tallest = 0,
                row = 0,
                $container = $(this.element),
                container_width = $container.width();
                $article = $(this.element).children();

            if(single_column_mode === true) {
                article_width = $container.width() - self.options.padding_x;
            } else {
                article_width = ($container.width() - self.options.padding_x * self.options.no_columns) / self.options.no_columns;
            }

            $article.each(function() {
                $(this).css('width', article_width);
            });

            columns = self.options.no_columns;

            $article.each(function(index) {
                var current_column,
                    left_out = 0,
                    top = 0,
                    $this = $(this),
                    prevAll = $this.prevAll(),
                    tallest = 0;

                if(single_column_mode === false) {
                    current_column = (index % columns);
                } else {
                    current_column = 0;
                }

                for(var t = 0; t < columns; t++) {
                    $this.removeClass('c'+t);
                }

                if(index % columns === 0) {
                    row++;
                }

                $this.addClass('c' + current_column);
                $this.addClass('r' + row);

                prevAll.each(function(index) {
                    if($(this).hasClass('c' + current_column)) {
                        top += $(this).outerHeight() + self.options.padding_y;
                    }
                });

                if(single_column_mode === true) {
                    left_out = 0;
                } else {
                    left_out = (index % columns) * (article_width + self.options.padding_x);
                }

                $this.css({
                    'left': left_out,
                    'top' : top
                });
            });

            this.tallest($container);
            $(window).resize();
        };

        Plugin.prototype.tallest = function (_container) {
            var column_heights = [],
                largest = 0;

            for(var z = 0; z < columns; z++) {
                var temp_height = 0;
                _container.find('.c'+z).each(function() {
                    temp_height += $(this).outerHeight();
                });
                column_heights[z] = temp_height;
            }

            largest = Math.max.apply(Math, column_heights);
            _container.css('height', largest + (this.options.padding_y + this.options.margin_bottom));
        };

        Plugin.prototype.make_layout_change = function (_self) {
            if($(window).width() < _self.options.single_column_breakpoint) {
                _self.calculate(true);
            } else {
                _self.calculate(false);
            }
        };

        $.fn[pluginName] = function (options) {
            return this.each(function () {
                if (!$.data(this, 'plugin_' + pluginName)) {
                    $.data(this, 'plugin_' + pluginName,
                    new Plugin(this, options));
                }
            });
        }

    })(jQuery, window, document);
    </script>-->


@endsection


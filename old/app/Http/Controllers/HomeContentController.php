<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Contentful\Delivery\Client as DeliveryClient;
use Contentful\Core\Api\LinkResolverInterface;
use Contentful\RichText\ParserInterface;
use Contentful\RichText\Node\NodeInterface;
use Contentful\RichText\NodeMapper\NodeMapperInterface;
use Contentful\RichText\NodeRenderer\NodeRendererInterface;

use Contentful\RichText\Node\Heading1;
use Contentful\RichText\RendererInterface;
use GuzzleHttp\Client;
use app\Helper\Test;
use app\Helper\ContentAssetHelper;
use app\Helper\ContentEntryInline;
use app\Helper\ContentDynamicExcess;
use app\Helper\ContentEntryBlock;
use app\Helper\ContentHyperlink;
use app\Helper\ContentEntryHyperlink;
use Contentful\RichText\Node\Hyperlink;
use jazmy\FormBuilder\Models\Form;
use Illuminate\Support\Facades\Auth;
use Validator;
use Newsletter;
use Illuminate\Support\Facades\DB;
use app\User;



class HomeContentController extends Controller 
{
   
    private $client;

    public function __construct(DeliveryClient $client)
    {    //cda
    
        $this->client = $client;
        $this->query = new \Contentful\Delivery\Query();
        $this->renderer = new \Contentful\RichText\Renderer();
        $this->contentDynamic=new ContentDynamicExcess;
        $contentHelp= new ContentAssetHelper;
        $ContentEntryInline= new ContentEntryInline;
        $ContentEntryBlock= new ContentEntryBlock;
        $hyperlink =new ContentHyperlink; 
        $Entryhyperlink =new ContentEntryHyperlink; 
        

        $this->renderer->pushNodeRenderer($contentHelp);
        $this->renderer->pushNodeRenderer($ContentEntryInline);
        $this->renderer->pushNodeRenderer($ContentEntryBlock);
        $this->renderer->pushNodeRenderer($hyperlink);
       // $this->renderer->pushNodeRenderer($Entryhyperlink);
        $this->form2 = Form::where('identifier', 'signup')->firstOrFail();
        $this->form1 = Form::where('identifier', 'form1')->firstOrFail();

      
        
        //management api    
        // $this->mclient = new \Contentful\Management\Client(env('CONTENTFUL_oauth_token'));
        // $this->mEnvProxy = $this->mclient->getEnvironmentProxy(env('CONTENTFUL_SPACE_ID'),env('CONTENTFUL_ENVIRONMENT_ID'));
        // $this->mquery=new \Contentful\Management\Query();
        

       

    }

    function authData()
    {
        if(Auth::guard('user')->check())
        {
         $user_auth=Auth::guard('user')->user();
         $Usertype=$user_auth->type;
         $Username=$user_auth->name;
         return $Usertype;
        }else{
        return $Usertype="";
        }
    }
    public function index()
    {
        
       $userD=$this->authData();
      
        $form2= $this->form2;
        $form1= $this->form1;

        return view('site.layout.home',compact('form2','form1'))->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer)
        ->with('contentDynamic', $this->contentDynamic)->with('Usertype',$userD);
        //->with('userType',$this->userType);
    

    }

    
    public function kindergarten()
    {
       
        $userD=$this->authData();
        //  $obj->st();
        //  exit;
        
    //    $parser=$this->client->getNodeParser();
    //     dd($parser);
        // $mquery = $this->mquery
        //  ->setContentType("postcard")
        //  //->where("fields.contentType.sys.id", "7vPfE70mO8d5Ne0m9TN6i1");
        //  ->where("fields.gradeLevel.sys.id[in]","30jZuVYF5iC69qef2Uio6X,686BB5L44WWO9JKVjJzVGV");
        //  //->where('sys.publishedCounter[match]','null');
        //   $env= $this->menvironmentProxy->getEntries($mquery);
        //  dd($env);
        //$parser = $this->client->getNodeParser();
       
          //dd($contentDynamic->DataExcess('am'));
         
          $form2= $this->form2;
          $form1= $this->form1;

         return view('site.other_pages.kindergarten',compact('form2','form1'))->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer)
        //->with('hyper', $this->hyperlink)
        //->with('mEnvProxy',$this->mEnvProxy)->with('mquery',$this->mquery)
        //->with('mclient',$this->mclient)
       
        ->with('contentDynamic', $this->contentDynamic)->with('Usertype',$userD);

       

    }

    public function grade_1_3()
    {
        $userD=$this->authData();
        $form2= $this->form2;
        $form1= $this->form1;

        return view('site.other_pages.grade_1_3',compact('form2','form1'))->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer)
        ->with('contentDynamic', $this->contentDynamic)->with('Usertype',$userD);;

    }

    public function grade_4_5()
    {
        $userD=$this->authData();
        $form2= $this->form2;
        $form1= $this->form1;

        return view('site.other_pages.grade_4_5',compact('form2','form1'))
        ->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer)
        ->with('contentDynamic', $this->contentDynamic)->with('Usertype',$userD);

    }

    public function dashboard(){
        $form2= $this->form2;
        $form1= $this->form1;

        return view('site.other_pages.dashboard',compact('form2','form1'))->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer);
  
      }

    public function toolkit()
    {
        $userD=$this->authData();
        $form2= $this->form2;
        $form1= $this->form1;

        return view('site.other_pages.toolkit',compact('form2','form1'))->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer)
        ->with('contentDynamic', $this->contentDynamic)->with('Usertype',$userD);



    }

    public function about()
    {
        $form2= $this->form2;
        $form1= $this->form1;

        return view('site.other_pages.about_us',compact('form2','form1'))->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer)
        ->with('contentDynamic', $this->contentDynamic);
    }

    public function details($id)
    {
        $userD=$this->authData();
        $form2= $this->form2;
        $form1= $this->form1;
        $detail_id=$id;

        return view('site.other_pages.details',compact('form2','form1'))->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer)
        ->with('contentDynamic', $this->contentDynamic)->with('detail_id',$detail_id)->with('Usertype',$userD);

    }

    public function toolkitDetails($id)
    {
        
        $form2= $this->form2;
        $form1= $this->form1;
        $detail_id=$id;

        return view('site.other_pages.toolkit_details',compact('form2','form1'))->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer)
        ->with('contentDynamic', $this->contentDynamic)->with('detail_id',$detail_id);

    }

    


    public function gradelist($id)
    {
        
       
        $form2= $this->form2;
        $form1= $this->form1;
        $detail_id=$id;

        return view('site.other_pages.grade_list',compact('form2','form1'))->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer)
        ->with('contentDynamic', $this->contentDynamic)->with('detail_id',$detail_id);

    }

    public function catlist($id)
    {
        
       
        $form2= $this->form2;
        $form1= $this->form1;
        $detail_id=$id;
     

        return view('site.other_pages.cat_list',compact('form2','form1'))->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer)
        ->with('contentDynamic', $this->contentDynamic)
        ->with('detail_id',$detail_id);

    }

    public function catlist2($url, $id)
    {
        
       
        $form2= $this->form2;
        $form1= $this->form1;
        $detail_id=$id;
        $url=$url;

        return view('site.other_pages.cat_list2',compact('form2','form1'))->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer)
        ->with('contentDynamic', $this->contentDynamic)
        ->with('detail_id',$detail_id)->with('url',$url);

    }

    public function cattag($url, $id)
    {
        
       
        $form2= $this->form2;
        $form1= $this->form1;
        $detail_id=$id;
        $url=$url;

        return view('site.other_pages.cat_tag',compact('form2','form1'))->with('client',$this->client)
        ->with('query',$this->query)->with('renderer',$this->renderer)
        ->with('contentDynamic', $this->contentDynamic)
        ->with('detail_id',$detail_id)->with('url',$url);

    }

    

    

    public function SearchModule(Request $request)
    {
         $all=$request->all();
         
         $validator = Validator::make($all, [
        
          'search_key' => 'required',
          
          ]);
           
          if($validator->passes()) {

           $search_key=$all['search_key'];
           $query=$this->query->setContentType("postcard")
           ->where("fields.title[match]","$search_key")
           ->setLimit(8)
           ->where("order", "-(sys.createdAt)")
           //->where("fields.contentType.sys.contentType.sys.id","Emotional Development")
           //->where("fields.gradeLevel.sys.id[in]","51hefRXWCDPDCrEGXCehNL","4LAKsYurMuPjv0NPMEZif2","7hFAY0Adk5rbJ3wwlmnoig")
           ->where("sys.publishedCounter[gte]","1");
      
          // $client1 = new \Contentful\Delivery\Client(env('CONTENTFUL_DELIVERY_TOKEN'), 
          // env('CONTENTFUL_SPACE_ID'), env('CONTENTFUL_ENVIRONMENT_ID'));
         $entries_pre = $this->client->getEntries($query);
         $count_entries=$entries_pre->count();
         if($count_entries != 0)
         {
            foreach($entries_pre as $ent_key => $ent_value)
            {
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
                      
                      
                       $IntroText= $this->renderer->render($IntroText); 
                      
                     
                    }else{
                       $IntroText="";
                    }
           
                    $IntroImage = $ent_value->get('introImage', null, false);
                 
                   if(!empty($IntroImage)){
                     $IntroImage_u = $this->client->resolveLink($IntroImage);
                     $IntroImage_url= $IntroImage_u->getFile()->getUrl();
                   }else{
                       $IntroImage_url="";
                   }    
           
                   $schoolLevel=$ent_value->get('gradeLevel', null, false);
                    //echo '<pre>';print_r($schoolLevel);
                    if(!empty($schoolLevel))
                    {
                     
                     $schoolLevel_u = $this->client->resolveLink($schoolLevel);
                   
                      
                     $grade_name=$schoolLevel_u->get('gradeTitle');
                     
           
                    }else{
                     $grade_name="";
                    }
           
                    $developmentCategory=$ent_value->get('contentType',null, false);
                    
           
                    if(!empty($developmentCategory))
                    {
                     $developmentCategoryU=$this->client->resolveLink($developmentCategory);
                     
                     $developmentCategory_name=$developmentCategoryU->get('contentType');
                     
                    }else{
                      $developmentCategory_name="";
                    }
   
                   $data[]=[ 
                   'entry_id'=> $entry_id,
                   'pre_title'=>$pre_title,
                   'IntroText'=>$IntroText,
                   'IntroImage_url'=>$IntroImage_url,
                   'grade_name'=> $grade_name,
                   'developmentCategory_name'=>$developmentCategory_name
               ];
   
            }
            
         }else{
            $data="";
         }
         
         
         
           
         return response()->json([
             'status'=>true,
             'data' =>$data
             ]);

          }else{

            return response()->json([
              'status'=>false,
              //'error'=>$validator->errors()->all()
              'errors' => $validator->getMessageBag()->toArray()
              ]);
          }
                 
    }


    public function MoreSearchModule($keyword)
    {
        

         

           $search_key=$keyword;
           $form2= $this->form2;
           $form1= $this->form1;
      
         
         return view('site.other_pages.more_search',compact('form2','form1'))->with('client',$this->client)
         ->with('query',$this->query)->with('renderer',$this->renderer)
         ->with('contentDynamic', $this->contentDynamic)->with('keyword',$search_key);
 
           
    }


public function thank_you()
{
    $disabledrag=1;
    $form2= $this->form2;
    $form1= $this->form1;

  
  return view('site.other_pages.thank_you',compact('form2','form1','disabledrag'))->with('client',$this->client)
  ->with('query',$this->query)->with('renderer',$this->renderer)
  ->with('contentDynamic', $this->contentDynamic);
  
}
    
public function second_grade()
{
    
    $form2= $this->form2;
    $form1= $this->form1;

  
  return view('site.other_pages.second_grade',compact('form2','form1'))->with('client',$this->client)
  ->with('query',$this->query)->with('renderer',$this->renderer)
  ->with('contentDynamic', $this->contentDynamic);
  
}



public function DetailPaging(Request $request)
{
        $all=$request->all();
        
        $gids=$all['gids'];
        
        if(!empty($gids))
        {

        $query=$this->query->setContentType("postcard")
        ->where("fields.gradeLevel.sys.id[in]",$gids) 
        ->orderBy('sys.createdAt')
        ->orderBy('sys.id')
        
        ->where("sys.publishedCounter[gte]","1");
        }else{

            $query=$this->query->setContentType("postcard")
        ->orderBy('sys.createdAt')
        ->orderBy('sys.id')
        
        ->where("sys.publishedCounter[gte]","1");
        }

        
     
     

        $ent_value = $this->client->getEntries($query);
        
        foreach ($ent_value as $key => $value) {
        
            $ids[]=$value->getID();

            $title[]=$value->get('title');

 
         }
         
         //seach start from 0 
        $searched=array_search($all['post_id'],$ids);
        
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
        
        if($all['side']=='left'){

          $skip=$searched-1;
          

            if($skip > -1)
            {
                
                if(!empty($gids))
                {
        
                $query=$this->query->setContentType("postcard")
                ->where("fields.gradeLevel.sys.id[in]",$gids) 
                ->orderBy('sys.createdAt')
                ->orderBy('sys.id')
                ->setLimit(1)
                ->setSkip($skip)
                ->where("sys.publishedCounter[gte]","1");
                }else{

                $query=$this->query->setContentType("postcard")
                ->orderBy('sys.createdAt')
                ->orderBy('sys.id')
                ->setLimit(1)
                ->setSkip($skip)
                ->where("sys.publishedCounter[gte]","1");
                }

                
             
             
        
                $ent_value = $this->client->getEntries($query)[0];
                echo json_encode(['status'=>true,
                'id'=>$ent_value->getID(),
                'count'=>$count,
                'item_index'=>$searched,
                'skip'=>$skip,
                'next_title'=>$next_title,
                'prev_title'=>$prev_title
                ]);
            }else{

                echo json_encode(['status'=>false,
                'item_index'=>$searched,
                'count'=>$count,
                'skip'=>$skip
                ]);
            }
            
                    




        }else if($all['side']=='right'){

            $skip=$searched+1;
           // print_r($searched);
           // dd($skip);
            if( $count > $skip)
            {
                
                $query=$this->query->setContentType("postcard")
                ->orderBy('sys.createdAt')
                ->orderBy('sys.id')
                ->setLimit(1)
                ->setSkip($skip)
                ->where("sys.publishedCounter[gte]","1");
             
             
        
                $ent_value = $this->client->getEntries($query)[0];
                $res= json_encode(['status'=>true,
                'id'=>$ent_value->getID(),
                'count'=>$count,
                'item_index'=>$searched,
                'skip'=>$skip,
                'next_title'=>    $next_title,
                'prev_title'=>$prev_title
                ]);
                echo $res;
                //dd($res);
            }else{

                echo json_encode(['status'=>false,
                
                'count'=>$count,
                'item_index'=>$searched,
              
                'skip'=>$skip
                ]);
            }

        }else{

           
            $res= json_encode(['status'=>true,
            
            'count'=>$count,
            'item_index'=>$searched,
           
            'next_title'=>$next_title,
            'prev_title'=>$prev_title
            ]);
            echo $res;
             


        }
    }


    public function updateBirthYear() 
    {

      //one time in year cron

      $data = DB::table('users')
    ->join('form_submissions', 'users.id', '=', 'form_submissions.user_id', 'left')
    ->select('users.*','form_submissions.user_id','form_submissions.selected_grades')
    ->get();
    $year= date("Y");
   
    foreach($data  as $mData)
    {
     //echo '<pre>'; print_r($mData);
      if(!empty($mData->selected_grades))
      {
        
       
        $email=$mData->email;
        $selected_grades=$mData->selected_grades;
        $selected_grades_json=json_decode($mData->selected_grades);
        $user_id=$mData->user_id;
        foreach($selected_grades_json as $selKey=>$selval)
        {
              $birth_year[$user_id][]=$year-5-$selval;
        }

        
     }
    }
    
    foreach($birth_year as $bkey=>$bval)
    {
     
      $birth_year_json=json_encode($bval);
      $updated[]= DB::table('form_submissions')
        ->where('user_id', $bkey) 
        ->limit(1)  
        ->update(array('birth_years' => $birth_year_json));

    }
    echo '<pre>'; print_r($updated);

    //dd($updated);
    
  }  



   public function updateGrade()
   {


 

    
    $year=date("Y");
    $data = DB::table('users')
    ->join('form_submissions', 'users.id', '=', 'form_submissions.user_id', 'left')
    ->select('users.*','form_submissions.user_id','form_submissions.selected_grades',
    'form_submissions.birth_years')
    ->get();
    
    foreach($data  as $mData)
    {
     //echo '<pre>'; print_r($mData);
      if(!empty($mData->birth_years))
      {
        
       
        $email=$mData->email;
        $return=Newsletter::getMember($email,'list3');

        
        if ($return['status'] !='404') {
            foreach ($return['tags'] as $tag) {
                $old_tags=[
                'name'=>$tag['name'],
                'status' => 'inactive'
                ];
            }
        
            //dd($old_tags);

            $selected_grades=$mData->selected_grades;
            $selected_grades_json=json_decode($mData->selected_grades);
            $birth_years_json=json_decode($mData->birth_years);
            $user_id=$mData->user_id;

            $userIdByEmail[$email]=$user_id;
        
            foreach ($birth_years_json as $birthKey=>$birthval) {
                $oldGradeVal=$selected_grades_json[$birthKey];
          
                $oldGrade[$email][]=$old_tags;
             
                $new_grade=$year-$birthval-5;


                $newGrade[$email][]=['name'=>($new_grade),
             'status'=>'active'
            ];
            $newGradeEmailArr[$email][]="$new_grade";
            }
        }

      }



    }
  
    //Mailchimp update grades on list 

     $MailChimp = Newsletter::getApi();
     foreach($newGrade as $ngradekey=>$ngradeval)
     {
      
        $newGradeArr=$newGradeEmailArr[$ngradekey];
        
        
        $removeGradeval=$oldGrade[$ngradekey];
      
        $subscriber_hash=md5(strtolower($ngradekey));
       
        $del_tag_url="lists/d2ae77bf0e/members/$subscriber_hash/tags";
        
        $remove_tags=['tags'=>$removeGradeval];
        
        $remove[]=$MailChimp->post($del_tag_url,$remove_tags);
   


       $add_tags=['tags'=>$ngradeval];  
       $add[]=$MailChimp->post($del_tag_url,$add_tags);

       //query

       $user_idd= $userIdByEmail[$ngradekey];

       $updated[]= DB::table('form_submissions')
       ->where('user_id', $user_idd) 
       ->limit(1)  
       ->update(array('selected_grades' => json_encode($newGradeArr)));
       
     }

     return "success";

    // echo '<pre>'; print_r($remove);
    // echo '<pre>'; print_r($add);
    // echo '<pre>'; print_r($updated);
    // exit;


}
  
public function allGradesInList($listId){
  $MailChimp = Newsletter::getApi();
  $url="lists/$listId/segments";
  $segments = $MailChimp->get($url);
  $all_segments=$segments['segments'];
       foreach($all_segments as $seg)
       {
       $grade_name=$seg['name'];
       //echo '<pre>'; print_r($seg['name']);

       $array_grades[$grade_name]=$seg['id'];
      

       }

       return $array_grades;

}


public function colorByCategory($categoryName){
 
  
  if($categoryName=="Emotional Dev't")
  {
     $color="#a678dc";
  }else if($categoryName=="Social Dev't")
  {
    $color="#00a684";
  }else if($categoryName=="Cognitive Dev't")
  {
    $color="#fd8959";
  }else if($categoryName=="Parent Self-care")
  {
    $color="#dd87f1";
  }

 return $color;
}

public function logoByCategory($categoryName){
 
  
    if($categoryName=="Emotional Dev't")
    {
        $full_url="https://images.ctfassets.net/gy7ud7gkbg08/6zFjl0efJmPnopzksrlZWO/0a6ddeac067f6b7139597fa1404a2dd3/logo-purple.png?h=250";

    }else if($categoryName=="Social Dev't")
    {
        $full_url="https://images.ctfassets.net/gy7ud7gkbg08/3StCvX0sfm5M9dWQzxeVrd/fcaebd19589149fd8a14617d1c5b3fac/logo-green.png?h=250";
    }else if($categoryName=="Cognitive Dev't")
    {
        $full_url="https://images.ctfassets.net/gy7ud7gkbg08/5sltumOS6DxjZSvV8GBuV4/427a947799da2b9fef43bbb80ee3bb7d/logo-orange.png?h=250";
    }else if($categoryName=="Parent Self-care")
    {
        $full_url="https://images.ctfassets.net/gy7ud7gkbg08/6Z2CifNzed9837aNb445cc/2e050c774c8afcecad425c49ddcae772/logo.png?h=250";
    }
    
   
   return $full_url;
  
  }





 
  

    public function testmailerCron()
    {

        //automatic login email 
        $string="MAILER";
        $encrypted = \Illuminate\Support\Facades\Crypt::encrypt($string);
        
        //echo $decrypted_string = \Illuminate\Support\Facades\Crypt::decrypt($encrypted);
        
        //dd($encrypted);
       
       
       $currentMonth=date("n");
       $year=date("Y");
       $query=$this->query->setContentType("emailWrapper")
        //->where("sys.id","$detail_id")
       // ->orderBy("fields.order",true)
        //->where("include", "0")
        // ->where("skip", "10")
        //->setSkip(3) 
        //->where("order", "fields.order")
        ->orderBy('sys.createdAt')
        ->where("sys.publishedCounter[gte]","1");

        
        $ent_value = $this->client->getEntries($query);

      
       
        foreach ($ent_value as $key => $ent_value) {

         
         $grade=$ent_value->get('grade',null, false);

         $name=$ent_value->get('emailSequence');
         

         if(!empty($grade))
          {
           
            try {
             
           $tIvalueU=$this->client->resolveLink($grade);
           $grade=$tIvalueU->get('grade');
           
          
           }catch(Exception $e)
           {
            $grade="";
           }
        
          }else{
            $grade="";
          }

        
         

          $month=$ent_value->get('month',null, false);
          if(!empty($month))
           {
            
             try {
              
             $monthU=$this->client->resolveLink($month);
            
            $monthNumber=$monthU->get('monthNumber');
           
            }catch(Exception $e)
            {
             $monthNumber="";
            }
         
          }else{
             $monthNumber="";
           }
           
    


  if ($currentMonth == $monthNumber) {
      $orderInMonth=$ent_value->get('orderInMonth', null, false);
      $todays_date=date("d-M-Y", strtotime("today"));
      //$todays_date=date("d-M-Y", strtotime("tomorrow"));
       $givenSatDAte=date("d-M-Y", strtotime("$orderInMonth saturday $year-$currentMonth"));
    
      //checking postcard date
      // if ($todays_date==$givenSatDAte) {
          $contentCategory=$ent_value->get('contentCategory', null, false);
          if (!empty($contentCategory)) {
              try {
                  $contentCategoryU=$this->client->resolveLink($contentCategory);
               
             
                  $category=$contentCategoryU->get('contentType');
              } catch (Exception $e) {
                  $category="";
              }
          } else {
              $category="";
          }
 
          $postcard=$ent_value->get('postcard', null, false);

           
             
          if (!empty($postcard)) {

            

              try {
                  $postcardU=$this->client->resolveLink($postcard);

                  
                  $entry_id=$postcardU->getId();
      
                  $detail_page_hyper_link_url=url("details/$entry_id");

                  $pcontentType=$postcardU->get('contentType', null, false);
                  if (!empty($pcontentType)) {
                      try {
                          $contentCategoryU=$this->client->resolveLink($pcontentType);
                          
                     
                          $pcategory=$contentCategoryU->get('contentType');
                      } catch (Exception $e) {
                          $pcategory="";
                      }
                  } else {
                      $pcategory="";
                  }
                  
                  
                  

                  $emailSubjectLine=$postcardU->get('emailSubjectLine');

                  $contextAndIssue=$postcardU->get('contextAndIssue');
             
              
                  if (!empty($contextAndIssue)) {
                      $contextAndIssue= $this->renderer->render($contextAndIssue);
                  } else {
                      $contextAndIssue="";
                  }

                  $goodNews=$postcardU->get('goodNews');
             
              
                  if (!empty($goodNews)) {
                      $goodNews= $this->renderer->render($goodNews);
                  } else {
                      $goodNews="";
                  }

                  $forwardToAFriend=$postcardU->get('forwardToAFriend', null, false);
                  if (!empty($forwardToAFriend)) {
                      $forwardToAFriend_u = $this->client->resolveLink($forwardToAFriend);
                      $forwardToAFriendD= $forwardToAFriend_u->get('forwardToAFriend');
                      if (!empty($forwardToAFriendD)) {
                          $forwardToAFriendData= $this->renderer->render($forwardToAFriendD);
                      }
                 
                      $forwardToAFriendLink= $forwardToAFriend_u->get('link');
                  } else {
                      $forwardToAFriendData="";
                      $forwardToAFriendLink="";
                  }




                  $illustration=$postcardU->get('illustration', null, false);
                  if (!empty($illustration)) {
                      $illustration_u = $this->client->resolveLink($illustration);
                      $illustration_url= $illustration_u->getFile()->getUrl();
                  } else {
                      $illustration_url="";
                  }

                  $audioLink=$postcardU->get('audioLink', null, false);
                  if (!empty($audioLink)) {
                      $audioLink_u = $this->client->resolveLink($audioLink);
                
                      $audioLink_url= $audioLink_u->getFile()->getUrl();
                  } else {
                      $audioLink_url="";
                  }



              

                  $whatsGoingOnText=$postcardU->get('whatsGoingOnText');
             
              
                  if (!empty($whatsGoingOnText)) {
                      $whatsGoingOnText= $this->renderer->render($whatsGoingOnText);
                  } else {
                      $whatsGoingOnText="";
                  }


                  $supportingYourChild=$postcardU->get('supportingYourChild');
             
              
                  if (!empty($supportingYourChild)) {
                      $supportingYourChild= $this->renderer->render($supportingYourChild);
                  } else {
                      $supportingYourChild="";
                  }

                  $whatsComingUp=$postcardU->get('whatsComingUp');
             
              
                  if (!empty($whatsComingUp)) {
                      $whatsComingUp= $this->renderer->render($whatsComingUp);
                  } else {
                      $whatsComingUp="";
                  }

              
                  $ideas=$postcardU->get('ideas');
              
                  foreach ($ideas as $ikey => $ivalue) {
                    
                      $ideaTitle=$ivalue->get('ideaTitle');
                      $idea=$ivalue->get('idea');
                      $renderIdea=$this->renderer->render($idea);

                      $Ideaarray[]=[
                   'ideaTitle'=>$ideaTitle,
                   'ideaDesc'=>$renderIdea
                  ];
                  }

                  $recentRelatedPosts=$postcardU->get('recentRelatedPosts', null, false);
              
                  foreach ($recentRelatedPosts as $rkey => $rvalue) {
                      $resolvePost=$this->client->resolveLink($rvalue);
                   
                      $resolvePostHead=$resolvePost->get('title');
                

                  
  
                      $resolvePostHeadArr[]=[
                     'resolvePostHead'=>$resolvePostHead,
                     'post_id'=>$resolvePost->getId()
                    
                    ];
                  }

                 
                 
                  $usefulTools=$postcardU->get('usefulTools');
               
                  foreach ($usefulTools as $ukey => $uvalue) {
                      $toolName=$uvalue->get('name');
                      $toolPreviewImage=$uvalue->get('toolIcon', null, false);
                      if (!empty($toolPreviewImage)) {
                          $toolPreviewImage_u = $this->client->resolveLink($toolPreviewImage);
                
                          $toolPreviewImage_url= $toolPreviewImage_u->getFile()->getUrl();
                      } else {
                          $toolPreviewImage_url="";
                      }
                      $Toolarray[]=[
                   'toolName'=>$toolName,
                   'toolIcon'=>$toolPreviewImage_url
                  ];
                  }

                  //contextAndIssue

              //audiolink
              
              
             // $category=$postcardU->get('contentType');
              } catch (Exception $e) {
                  $category="";
              }
          } else {
              $category="";
          }
  
         
            
          $dynamicContentColor=$this->colorByCategory($pcategory);
          $logo_url=$this->logoByCategory($pcategory);
          
          $site_url=url('/');
          $logoimage="<a target='_blank' href='$site_url'>".'<img style="display:block; border:none;width: 320px;"  src="'.$logo_url.'">'."</a>";
     
          //dd($dynamicContentColor);
          // echo $grade;
          //dd($grade);

          //$emailSubjectLine
          //render
          // $contextAndIssue
          //$goodNews
          //$whatsGoingOnText
          //$supportingYourChild
          //$whatsComingUp
          //Array
          //$Ideaarray
          //$resolvePostHeadArr
          // $Toolarray
          //$forwardToAFriendData="";
          //$forwardToAFriendLink="";

          //$illustration_url;
          


          //dd($resolvePostHeadArr);
      
          //$supportingYourChildHeading=


          //$illuImage="<a target='_blank' href='$site_url'>".'<img style="display:block; border:none;width: 320px;"  src="'.substr($illustration_url, 2).'">'."</a>"; 

          if (!empty($illustration_url)) {
              $illuImage='<img style="display:block; border:none;width:100%;"  src="'.'https:'.$illustration_url.'">';
         
          } else {
              $illuImage="";
          }
      
          //dd($illuImage);
          
          
          

     
      
          if (!empty($audioLink_url)) {
              //$illuImage='"<img height="200" src="'.substr($illustration_url,2).'">';
        
              $audioData="Prefer to listen?" .'<a style="color: rgba(51,51,51,0.5);"  href="'.'https:'.$audioLink_url.'">'."Click for audio"."</a>";
          } else {
              $audioData="";
          }

          
           $name_data="<div style='color:$dynamicContentColor;font-size:17px'>".'Hi'.' '.'*|FNAME|*,'."</div>";
            
          
          
         if (!empty($contextAndIssue)) {
              $contextAndIssue ="<div style='padding:0;margin:0;color:$dynamicContentColor;font-size:17px;line-height:24px;'>".$contextAndIssue."</div>";
          } else {
              $contextAndIssue="";
          }
          //echo $contextAndIssue;
          //echo $name_data;
          //exit;
          if (!empty($goodNews)) {
              $goodNews="<div style='padding:0;margin:0;color:$dynamicContentColor;font-size:17px;line-height:24px;'>".$goodNews."</div>";
          } else {
              $goodNews="";
          }

          if (!empty($whatsGoingOnText)) {
              $whatsGoingOnText= $whatsGoingOnText;
              $whatsGoingOnHeading="<h3 style='padding:10px 0;margin:0;color:$dynamicContentColor;line-height:24px;'>- - - - WHAT'S GOING ON? - - - - </h3>";
          } else {
              $whatsGoingOnText="";
              $whatsGoingOnHeading="";
          }

          if (!empty($supportingYourChild)) {
              $supportingYourChild= $supportingYourChild;
              $supportingYourChildHeading="<h3 style='padding:10px 0;margin:0;color:$dynamicContentColor;line-height:24px;'>- - - - SUPPORTING YOUR CHILD - - - -</h3>";
          } else {
              $supportingYourChild="";
              $supportingYourChildHeading="";
          }

          if (!empty($whatsComingUp)) {
              $whatsComingUp= $whatsComingUp;
              $whatscomingUpHeading="<h3 style='padding:20px 0 0;margin:0;color:$dynamicContentColor;line-height:24px;'>- - - - COMING UP - - - - </h3>";
          } else {
              $whatsComingUp= "";
              $whatscomingUpHeading="";
          }


          if (!empty($forwardToAFriendData)) {
              $forwardToAFriendData= $forwardToAFriendData."<br>";
              $forwardtofriendHeading="<h3 style='padding:10px 0 0;margin:0;color:$dynamicContentColor;line-height:24px;'>- - - - PLEASE PASS ALONG - - - - </h3>";
              $forwardLaststatic="Have any feedback or ideas for us? Please get in touch!";
          } else {
              $forwardToAFriendData= "";
              $forwardtofriendHeading="";
              $forwardLaststatic="";
          }

          if (!empty($forwardToAFriendLink)) {
              $forwardToAFriendLink='<a style="color:#373737;" target="_blank"  href="'.$forwardToAFriendLink.'">'."$forwardToAFriendLink"."</a>";
          } else {
              $forwardToAFriendLink= "";
          }


          if (!empty($resolvePostHeadArr)) {

         //$RELATED_post="<p>".  ."<p>";
              $RELATED_post_cont="";
              foreach ($resolvePostHeadArr  as $resolvePostV) {
                
               $post_id= $resolvePostV['post_id'];

                $url_=url("details/$post_id");
                $RELATED_post_cont.="<p>"."<a style='color:#5c5f60' href='$url_?m=*|EMAIL|*&e=$encrypted' >".$resolvePostV['resolvePostHead']."</a>"."</p>";
              }

              $relatedPostHeading="<h3 style='padding:10px 0 0;margin:0;color:$dynamicContentColor;line-height:24px;'>- - - - IN CASE YOU MISSED - - - - </h3>";
          } else {
              $relatedPostHeading= "";
              $RELATED_post_cont="";
          }
         
         // dd($RELATED_post_cont);
         
      
        
    
       
          if (!empty($Ideaarray)) {

         //$RELATED_post="<p>".  ."<p>";
        
        
              $ideaDesc="";
              foreach ($Ideaarray  as $ideaKey=>$ideaPost) {
        
        $ideaDesc.="<p style='font-family: Arial, Helvetica, sans-serif;padding:0;margin:0;line-height:24px;color:$dynamicContentColor'><a target='_blank' style='color:$dynamicContentColor' href='$detail_page_hyper_link_url?m=*|EMAIL|*&e=$encrypted'> <strong>". ($ideaKey+1).'.'.' '.$ideaPost['ideaTitle'] ."</strong></a></p>";
          //"<p style='padding:5px 0;margin:0;line-height:24px;font-family: Arial, Helvetica, sans-serif;font-size:14px;'>".  $ideaPost['ideaDesc']   ."</p>"  ;
              }
          } else {
              $ideaDesc="";
          }

          //dd($ideaDesc);
    
          if (!empty($Toolarray)) {

         //$RELATED_post="<p>".  ."<p>";
              $usefulToolsContent='';
              foreach ($Toolarray  as $resolveToolarray) {
                 // $resolveURL= substr($resolveToolarray['toolIcon'], 2);
                  $resolveIcon= $resolveToolarray['toolIcon'];

                  $resolveURL='https:'.$resolveIcon;
                  $icon_image='<span><img style="display:block; border:none;width:80px;" src="'.$resolveURL.'">'."<br/>";
                  //$icon_image="<img src=".$resolveURL."    />";
                  $usefulToolsContent.=
          $icon_image.$resolveToolarray['toolName'].'</span>';
              }

              $usefulToolsHeading="<h3 style='padding:10px 0;margin:0;color:$dynamicContentColor;line-height:24px;'>- - - - USEFUL TOOLS - - - - </h3>";
          } else {
              $usefulToolsHeading= "";
              $usefulToolsContent="";
          }

         // dd($usefulToolsContent);
      
       

       $dynamicArray=[
       'name'=>$name_data,
       'contentAndIssue'=>$contextAndIssue,
       'goodNews'=>$goodNews,
       'illustrationImage'=>$illuImage,
       'whatsGoingOnHeading'=>$whatsGoingOnHeading,
       'whatsGoingOnContent'=>$whatsGoingOnText,
       'supportingYourChildHeading'=>$supportingYourChildHeading,
       'supportingYourChildContent'=>$supportingYourChild,
       'whatscomingUpContent'=>$whatsComingUp,
       'whatscomingUpHeading'=>$whatscomingUpHeading,
       'forwardtofriendHeading'=>$forwardtofriendHeading,
       'forwardtofriendContent'=>$forwardToAFriendData,
       'forwardToAFriendLink'=>$forwardToAFriendLink,
       'forwardLaststatic'=>$forwardLaststatic,
       'relatedPostHeading'=>$relatedPostHeading,
       'relatedPostContent'=>$RELATED_post_cont,
       'ideasContent'=>$ideaDesc,
       'usefulToolsHeading'=>$usefulToolsHeading,
       'usefulToolsContent'=>$usefulToolsContent,
       'audioLink'=>$audioData,
       'logoimage' =>$logoimage
      ];

          //dd($dynamicArray);
          //Mailchimp mailer

          $MailChimp = Newsletter::getApi();
          $listID="d2ae77bf0e";

          $all_grades=$this->allGradesInList($listID);
          $segment_id=$all_grades[$grade];
          //$segment_id=262305;
          //$template_id=101885;
          //$template_id=101985;
          $template_id=101993;
        
          $fromName="Kate, Postcards for Parents";
          $replyTo="hello@postcardsforparents.com";
          $subject=$emailSubjectLine;
        
          $defaultOptions = [
            'type' => 'regular',
            'recipients' => [
                'list_id' => $listID,
                'segment_opts'=>[
                    'saved_segment_id'=>$segment_id,

                ]
                
            ],
            'settings' => [
                'subject_line' =>$subject,
                'from_name' =>$fromName,
                'reply_to' =>$replyTo,
                'template_id'=>$template_id
            ],
        ];

        

          $response = $MailChimp->post('campaigns', $defaultOptions);
          //dd($response);
          $campaign_id=$response['id'];
          $url="campaigns/$campaign_id/content";
       
          $parameter=[

            'template'=>[
                'id'=>$template_id,
                'sections'=>$dynamicArray
            ]
        ];

          $compaignForTemplate=$MailChimp->put($url, $parameter);
          $send[]=$MailChimp->post("campaigns/$campaign_id/actions/send");

          $message['success'][$name]="success";
     //end postcard date 
    //   }else{
    //     $message['fail'][$name]="This postcard is not for todays date";
    //   }
      //end postcard month
  }else{

    $message['fail'][$name]="This postcard is not for this month";

  }
  
}
     return $message;
    
     
      //end foreach

    }


}

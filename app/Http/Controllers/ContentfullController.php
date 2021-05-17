<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Contentful\Delivery\Client as DeliveryClient;
use Contentful\Core\Api\LinkResolverInterface;
use Contentful\RichText\ParserInterface;
use Contentful\RichText\Node\NodeInterface;
use Contentful\RichText\NodeMapper\NodeMapperInterface;
use GuzzleHttp\Client;
use Newsletter;



class ContentfullController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $client;

    public function __construct(DeliveryClient $client)
    {
        $this->client = $client;
    }
    public function index()
    {

        $MailChimp = Newsletter::getApi();
        $email="katejhowe@gmail.com";
        $return=Newsletter::getMember($email,'list3');
        foreach($return['tags'] as $tag)
        {
           
            $tags[]=[
                'name'=>$tag['name'],
                'status' => 'inactive'
                ];
        }

       // dd($tags);
        $subscriber_hash=md5(strtolower($email));

        $del_tag_url="lists/d2ae77bf0e/members/$subscriber_hash/tags";
        
        $new_tags=[
        [
            'name'=>'5',
            'status' => 'active',
        ],
        [
            'name'=>$tag['name'],
            'status' => 'active',
        ],

        ];
        $args=['tags'=>$new_tags];    

        //remove tags
        $del_ret=$MailChimp->post($del_tag_url,$args);
        dd($del_ret);









       $date=strtotime("last Saturday");
       $new= date("l jS \of F Y h:i:s A",$date);
       //Get the first Wednesday of December, 2015
       $year=date("Y");
       $month=date("n");
      
echo $todays_day=date("d-M-Y",strtotime("today")).'<br/>';

echo $first= date("d-M-Y", strtotime("1 saturday $year-$month")).'<br/>';
echo $second= date("d-M-Y", strtotime("2 saturday $year-$month")).'<br/>';
echo $third= date("d-M-Y", strtotime("3 saturday $year-$month")).'<br/>';
echo $fourth= date("d-M-Y", strtotime("4 saturday $year-$month")).'<br/>';
echo $fifth= date("d-M-Y", strtotime("5 saturday $year-$month")).'<br/>';
//Result is: Wednesday, 02-Dec-2015

 if($todays_day==$third){
     echo "TRUE";
}


       dd($new);

        return "success";
        //$r=Newsletter::getLastError();
        //dd($r);
        // segment id 12075181
         $MailChimp = Newsletter::getApi();

         dd($MailChimp);

         // $sub=Newsletter::subscribeOrUpdate('arvind.singh@sourcesoftsolutions.com', ['Fname'=>'Foo', 'Lname'=>'Bar'],'list2');
         //dd($sub);

        $url="lists/d2ae77bf0e/segments";
        $segments = $MailChimp->get($url);

        //arvind.singh@sourcesoftsolutions.com

       // dd($segments); 

       

       $all_segments=$segments['segments'];
       foreach($all_segments as $seg)
       {
       $grade_name=$seg['name'];
       //echo '<pre>'; print_r($seg['name']);

       $array_grades[$grade_name]=$seg['id'];
      

       }
       echo '<pre>'; print_r($array_grades);
        exit;

        
      

        $email="ajay.sourcesoft@gmail.com";
        $return=Newsletter::getMember($email,'list3');
        foreach($return['tags'] as $tag)
        {
           
            $tags[]=[
                'name'=>$tag['name'],
                'status' => 'inactive'
                ];
        }

       // dd($tags);
        $subscriber_hash=md5(strtolower($email));

        $del_tag_url="lists/d2ae77bf0e/members/$subscriber_hash/tags";
        
        $new_tags=[
        [
            'name'=>'5',
            'status' => 'active'
        ] 
        ];
        $args=['tags'=>$new_tags];    

        //remove tags
        $del_ret=$MailChimp->post($del_tag_url,$args);
        dd($del_ret);


        

        
        // $temp= $MailChimp->delete("templates/100097");
        //dd($temp);
        // $temp= $MailChimp->get("templates");
        //  dd($temp);
        
        $url="templates";
        $parameter=[
            'name'=>'Update Profile',
            'html'=>view('email_templates.updateProfile')->render()
        ];

        $template = $MailChimp->post($url,$parameter);
        $template_id= $template['id'];
        dd($template);
     

        $subs= Newsletter::subscribeOrUpdate("katejhowe@gmail.com", ['FNAME'=>'Kate', 'LNAME'=>''], 'list3' , ['tags' => ['get_in_touch']]);
        dd($subs);

       $temp= $MailChimp->get("templates");
         dd($temp);
        //create a new tag

        // $url="lists/caa284fd88/segments";
     
        // $param=[
        //     'name'=>'new',
        //     'static_segment'=>[]
        // ];
        // $tag = $MailChimp->post($url,$param);
        // dd($tag);




        //create a new template

        $url="templates";
        $parameter=[
            'name'=>'Signup Template',
            'html'=>view('email_templates.signup')->render()
        ];

        $template = $MailChimp->post($url,$parameter);
        $template_id= $template['id'];
        dd($template);
     
        //get all segments of a list
        //$remo= Newsletter::removeTags(['1', '2'], 'ajay.sourcesoft@gmail.com');
        // Newsletter::subscribeOrUpdate('rincewind@discworld.com', ['firstName'=>'Foo', 'lastname'=>'Bar']);
        //dd($remo);
        //$url="lists/d2ae77bf0e/segments";
        
        // $segments = $MailChimp->get($url);
        // dd($segments);

        //create a new segment

 


        //create a new template

        // $url="templates";
        // $parameter=[
        //     'name'=>'Get In touch template',
        //     'html'=>view('email_templates.get_touch')->render()
        // ];

        // $template = $MailChimp->post($url,$parameter);

        // dd($template);

       
     
        $fromName="Postcard";
        $replyTo="hello@postcardsforparents.com";
        $subject="Get In Touch Mail";
        $listID="d2ae77bf0e";

       

        $defaultOptions = [
            'type' => 'regular',
            'recipients' => [
                'list_id' => $listID,
                'segment_opts'=>[
                    'saved_segment_id'=>262121,

                ]
                
            ],
            'settings' => [
                'subject_line' =>$subject,
                'from_name' =>$fromName,
                'reply_to' =>$replyTo,
                'template_id'=>101069
            ],
        ];

        

        $response = $MailChimp->post('campaigns', $defaultOptions);
        
        $campaign_id=$response['id'];
        //dd($response);
        //campaign change content with template id dynamic content 

        //temp id 100117
        //compaign id 324413b4f0

       // $campaign_id="47b5093161";


        $url="campaigns/$campaign_id/content";
        
        $parameter=[

            'template'=>[
                'id'=>101069,
                'sections'=>[
                    'email'=>"abc@gmail.com",
                    'message'=>"hello"

                ]
            ]
        ];

         $compaignForTemplate=$MailChimp->put($url,$parameter);
         if(!empty($compaignForTemplate['plain_text']))
         {
            $send=$MailChimp->post("campaigns/$campaign_id/actions/send");
         }
         
         echo '<pre>';print_r($compaignForTemplate);
        echo '<pre>';print_r($send);
        
        exit;

      //send compaign
  // $campaign_id="324413b4f0";
//    $send = $MailChimp->post("campaigns/$campaign_id/actions/send");
//    dd($send);
   //end
        
        dd($response);

         





        //create campaign on base of tag

        // $fname="A";
        // $lname='K';
        // $html = "<p>custom</p>";
        // $fromName="Postcard";
        // $replyTo="hello@postcardsforparents.com";
        // $subject="New Testt mail";
        // $listID="d2ae77bf0e";

       

        // $defaultOptions = [
        //     'type' => 'regular',
        //     'recipients' => [
        //         'list_id' => $listID,
        //         'segment_opts'=>[
        //             'saved_segment_id'=>259765,

        //         ]
                
        //     ],
        //     'settings' => [
        //         'subject_line' => $subject,
        //         'from_name' => $fromName,
        //         'reply_to' => $replyTo,
        //         'template_id'=>100117
        //     ],
        // ];

        

        // $response = $MailChimp->post('campaigns', $defaultOptions);
       
        //  dd($response);

         //




        
        
        //get all segments of a list

        // $url="lists/d2ae77bf0e/segments";
        
        // $segments = $MailChimp->get($url);
        // dd($segments);
        


         //get all members from a segment


        //  $url="lists/d2ae77bf0e/segments/259765/members";
        //  $tag = $MailChimp->get($url);
        //  dd($tag);
        
        
        
        
        //create a new tag

        // $url="lists/d2ae77bf0e/segments";
     
        // $param=[
        //     'name'=>'abc',
        //     'static_segment'=>[]
        // ];
        // $tag = $MailChimp->post($url,$param);
        // dd($tag);



        //creating new list
      
        // $url="lists";
        
        // $contact=[
        //     'company'=>'Postcards for Parents',
        //     'city'=>'Portland',
        //     'address1'=>'40 Quebec St',
        //     'state'=>'up',
        //     'zip'=>'04101-3239',
        //     'country'=>'USA',

        // ];

        // $parameter=[
        //    'name'=>'temporary Test List',

        //    'contact'=>$contact,
        //    'permission_reminder'=>"Hello",
        //    'campaign_defaults'=>[
        //        'from_name'=>'Postcard',
        //        'from_email'=>'hello@postcardsforparents.com',
        //        'subject'=>"Signup",
        //        'language'=>'en'

        //    ],
        //    'email_type_option'=>true

        // ];
        // $list = $MailChimp->post($url,$parameter);
        //   $r=Newsletter::getLastError();
        // dd($r);
        // dd($list);

        //

  




         
       //campaign change content with template id dynamic content 

        //temp id 100117
        //compaign id 324413b4f0

    //     $campaign_id="47b5093161";
    //     $url="campaigns/$campaign_id/content";
        
    //     $parameter=[

    //         'template'=>[
    //             'id'=>100117,
    //             'sections'=>[
    //                 'mytext'=>"<p>This is my text set via the the API request</p>"
    //             ]
    //         ]
    //     ];

    //    $compaignForTemplate=$MailChimp->put($url,$parameter);
    //    echo '<pre>';print_r($compaignForTemplate);



        
         //exit;

      //send compaign
  // $campaign_id="324413b4f0";
//    $send = $MailChimp->post("campaigns/$campaign_id/actions/send");
//    dd($send);
   //end






        //creating campaign   

        $fname="A";
        $lname='K';
        $html = "<p>custom</p>";
        $fromName="Postcard";
        $replyTo="hello@postcardsforparents.com";
        $subject="New Testt mail";
        //$html="<h1>Hello world</h1>";
        $listName="list3";

        

      $comp=Newsletter::createCampaign(
            
               $fromName,
               $replyTo,
               $subject,
               $html ,
               $listName,
              $options = [],
              $contentOptions = []
          
          );
        
    dd($comp);
    //




        //create a new template

        // $url="templates";
        // $parameter=[
        //     'name'=>'My new Test Template 2',
        //     'html'=>view('email_templates.signup')->render()
        // ];

        // $template = $MailChimp->post($url,$parameter);

        // dd($template);

        

        


         //test compaign mail

        //  $url= 'campaigns/'."47b5093161"."/actions/test";
        
        //  $parameter=[
        //   'test_emails'=>['ajay.sourcesoft@gmail.com'],
        //   'send_type'=>'html'];
        //  $campaigns = $MailChimp->post($url,$parameter);
        //  dd($campaigns);
         $tem_id="81701";
         $result = $MailChimp->get('templates/'.$tem_id);
         
         dd($result);
         $result = $MailChimp->get('lists');
         $listName="list3";
        $ret= Newsletter::subscribe('ajay.sourcesoft@gmail.com', ['FNAME'=>'Ajay', 'LNAME'=>'Kumar'], 'list3', ['tags' => ['1', '2']]);
         
       //$del=  Newsletter::delete('ajay.sourcesoft@gmail.com',$listName);

         dd( $ret);

         //start delete a compaign
            //  $comp_id="667471adba";
            //  $result = $MailChimp->delete("campaigns/$comp_id");
            //  dd($result);
        //end



         //$campaigns = $MailChimp->get('campaigns');

         
         //dd($campaigns);
         //$result1= Newsletter::subscribeOrUpdate('ajay.kumar@sourcesoftsolutions.com', ['FNAME'=>'Ajay', 'LNAME'=>'Kumar'], 'list3', ['tags' => ['1', '2']]);
         //$error = Newsletter::getLastError();
         //dd($error); 
         //dd($result1);
        
        //  $list_id_testt='d2ae77bf0e';

        //$get= Newsletter::getMember('ajay.kumar@sourcesoftsolutions.com');
        //dd($get);
       //$result = $MailChimp->get('lists');
       //dd($result);
       
       // $list_id_test = 'caa284fd88';
        // $list_id= 'ba1ff7e4d8';
        // $newsletter_subject="Heelo test subject";
        // $newsletter_html="<h1>TESTTTT</h1>";
        // $result = $MailChimp->post($list_id, $newsletter_subject, $newsletter_html);
        // dd($result);
        // $MailChimp->post('campaigns', $options)
       // dd($result);

        // $list_id = 'caa284fd88';

        // $result = $MailChimp->post("lists/$list_id/members", [
		// 		'email_address' => 'ajay.kumar@sourcesoftsolutions.com',
		// 		'status'        => 'subscribed',
        // 	]);
        // $user=[
        //     'fname'=>'A',
        //     'lname'=>'k'
        //    ];
        
        
    
    //Send compaign 
    //   $campaign_id = "5d8a137a92";
        //   $send = $MailChimp->post("campaigns/$campaign_id/actions/send");
        //  dd($send);

//print_r($result);











        // $pre_k = $client->getEntry("6P5IoohtMDrcn4owh2fWlw");
        // $out_arr=json_decode(json_encode($pre_k))->fields;
        // echo '<pre>'; print_r(count((array)$out_arr));  
        // echo '<pre>'; print_r((array)$out_arr);   






       // $entries = $this->client->getEntries();
       // dd($entries);
        //$entries = $this->client->getEntry("7ezazPktjgOULFTPmvL3Gj");
        //echo $entry->getName();
        //$query = (new \Contentful\Delivery\Query())
        //->setContentType('gallery')
        //->setInclude(10);
        
           //assets
          //$entries = $this->client->getAssets();
          //$entries = $this->client->getEntries();
         //$entries = $this->client->getEntry("7ezazPktjgOULFTPmvL3Gj");
         // dd($entries);


        // $entries = $this->client->getEntries($query);
        // dd($entries);
        
        // ->orderBy('fields.idea');

        // $client = new \Contentful\Management\Client('<content_management_api_key>');
        // $environment = $client->getEnvironmentProxy('<space_id>', '<environment_id>');
        // $contentType = $environment->getContentType('<content_type_id>');
         //CFPAT-4K-6tQ_fpgCAva-dYW4oLTB89zJ_GQed9jAiZlsrrD0
         $client1 = new \Contentful\Management\Client(env('CONTENTFUL_oauth_token'));
         $environmentProxy = $client1->getEnvironmentProxy(env('CONTENTFUL_SPACE_ID'),env('CONTENTFUL_ENVIRONMENT_ID'));
         //$entry = $client1->getEntry($spaceId, $environmentId, $entryId);
         //$entries = $environmentProxy->getEntry("7ezazPktjgOULFTPmvL3Gj");
         //$env= $environmentProxy->getContentTypes();
         $query = (new \Contentful\Management\Query())
         ->setContentType("postcard")
         //->where("fields.contentType.sys.id", "7vPfE70mO8d5Ne0m9TN6i1");
         ->where("fields.gradeLevel.sys.id[in]","30jZuVYF5iC69qef2Uio6X,686BB5L44WWO9JKVjJzVGV");
         //->where('sys.publishedCounter[match]','null');
          $env= $environmentProxy->getEntries($query);
         //$env= $environmentProxy->getContentType('postcard');
         dd($env);

         //$client = $this->client;
        
         //$env= $client->getContentTypes();
         //dd($env);
        
        // $env= $client->getEnvironment();
        
        // dd($env);
        //  $environment = $client->getSynchronizationManager();
        //  $result = $environment->startSync();
        //  $items = $result->getItems();
        //  dd($items);
        // $contentTypes = $environment->getPublishedContentTypes();
        // dd($contentTypes);

      // contentful.php 3.0

 




     $query = (new \Contentful\Delivery\Query())
     ->setContentType("postcard")
     //->where('fields.gradeLevel', '2');
     ->where('fields.developmentCategory','Social Development');

     $products = $this->client->getEntries($query);
   
   //  $product = $this->client->getEntry("7ezazPktjgOULFTPmvL3Gj");
   //dd($products);


foreach ($products as $product) {
    // Virtual getter methods, just use "get" and the field ID
    //echo '<pre>';print_r($product);
    //exit;
    echo 'Created at'.' '. $product->getSystemProperties()->getCreatedAt().'<br/>';
    echo 'Heading'.' '.$product->get('headline').'<br/>';
    echo 'gradeLevel'.' '.$product->get('gradeLevel').'<br/>';
    echo 'emailSubjectLine'.' '.$product->get('emailSubjectLine').'<br/>';
    echo 'developmentCategory'.' '.$product->get('developmentCategory').'<br/>';
    //echo $product->getheadline();
    //echo $product->getcontextAndIssue().'<br/>';
    $r=$product->get('goodNews');
    
    $renderer = new \Contentful\RichText\Renderer();
    
    echo 'goodNews'.$output1 = $renderer->render($r).'<br/>';
    echo 'contextAndIssue'.$output2 = $renderer->render($product->get('contextAndIssue')).'<br/>';
    echo 'whatsGoingOnText'.$output3 = $renderer->render($product->get('whatsGoingOnText')).'<br/>';
    echo 'ideasIntro'.$output4 = $renderer->render($product->get('ideasIntro')).'<br/>';
    echo 'idea'.$output5 = $renderer->render($product->get('idea')).'<br/>';
    echo 'idea2'.$output6 = $renderer->render($product->get('idea2')).'<br/>';
    echo 'idea3'.$output7 = $renderer->render($product->get('idea3')).'<br/>';
    echo 'idea4'.$output8 = $renderer->render($product->get('idea4')).'<br/>';
    echo 'idea5'.$output9 = $renderer->render($product->get('idea5')).'<br/>';
    echo 'reflection'.$output10 = $renderer->render($product->get('reflection')).'<br/>';
   // echo 'linksToRelevantTools'.$output11 = $renderer->render($product->get('linksToRelevantTools')).'<br/>';
   // echo 'citation'.$output12 = $renderer->render($product->get('citation')).'<br/>';
    
   
    
    
   
    
    //.$product->getcontextAndIssue()->getCompanyName().PHP_EOL;

    // Virtual properties
     //echo $product->getaudioLink();
     
     $link2 = $product->get('audioLink', null, false);
     $link3 = $product->get('citation', null, false)[0];
     
     //echo $link3->getId();
     //echo $link3->getLinkType();
     //echo '<pre>';print_r($link3[0]);
     //exit;
// Contentful\Core\Api\Link
//echo $link->getId();
//echo $link->getLinkType();
// $asset = $this->client->getAsset($link->getId());
// echo $asset->getTitle().PHP_EOL;
// echo $asset->getFile()->getUrl();
// dd($asset);
$link1 = $product->get('illustration', null, false);
$brand1 = $this->client->resolveLink($link1);
echo 'illustration link'.$brand1->getFile()->getUrl().'<br/>';
$brand2 = $this->client->resolveLink($link2);
echo 'audioLink'.$brand2->getFile()->getUrl().'<br/>';
$brand3 = $this->client->resolveLink($link3);
echo 'citation'.$studyname= $brand3->get('studyName').'<br/>';
 $studyBibliography= $brand3->get('studyBibliography');
echo 'citation'.$url_link=$renderer->render($studyBibliography).'<br/>';

 $linksToRelevantTools=$product->get('linksToRelevantTools');
 echo 'linksToRelevantTools'. $linksToRelevantTools[0].'<br/>';
 echo 'linksToRelevantTools'. $linksToRelevantTools[1].'<br/>';
 echo 'linksToRelevantTools'. $linksToRelevantTools[2].'<br/>';
 echo 'linksToRelevantTools'. $linksToRelevantTools[3].'<br/>';

     //.', Brand:'.$product->brand->companyName.PHP_EOL;

    // Using array-like syntax
    // echo $product['contextAndIssue'].', Brand:'.$product['brand']['companyName'].PHP_EOL;

    // Using the actual getter method
    // echo $product->get('name').', Brand:'.$product->get('brand')->get('companyName').PHP_EOL;
    
}

}






public function index1()
{

    $listID="caa284fd88"; 
    $segment_id=262305;
    $template_id=101885;
    // forget password  $template_id=101185;
    // $template_id=101185;
   

     // $listID=caa284fd88; 
        // $segment_id=262305;
        //  $template_id=101185;
       // $listID="d2ae77bf0e";

       ///Mailer Id 101885

       $MailChimp = Newsletter::getApi();

       //create new template
        $url="templates";
       $parameter=[
           'name'=>'Test Mailer Template 2',
           'html'=>view('email_templates.mailer')->render()
       ];

       $template = $MailChimp->post($url,$parameter);
       dd($template);
      
        //create new template
       //    $url="templates";
    //    $parameter=[
    //        'name'=>'Signup Template',
    //        'html'=>view('email_templates.signup')->render()
    //    ];

    //    $template = $MailChimp->post($url,$parameter);
       
      
      // $subs= Newsletter::subscribeOrUpdate($email, ['FNAME'=>$fname], 'list2' , ['tags' => ['new']]);
       
        
        $fromName="Postcard";
        $replyTo="hello@postcardsforparents.com";
        $subject="Forget password link from Postcard";
        

        $link1="<p>"."Ajay"."</p>"."<p>"."Kumar"."</p>";

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
                'sections'=>[
                    
                    'link2'=>$link1

                ]
            ]
        ];

        $compaignForTemplate=$MailChimp->put($url,$parameter);
        $send=$MailChimp->post("campaigns/$campaign_id/actions/send");
        //dd($compaignForTemplate);
        if(!empty($send)){
            //sleep(5);
            //Newsletter::unsubscribe($email,'list2');
        }

     dd($response);
     exit;



    //$this->client = new \Contentful\Delivery\Client('XFAKBL3qz3zlaDO5XB6Dllc4_7G-pFy7Db37wsRSAdE', 'gy7ud7gkbg08', 'master');
    
    //$entries = $this->client->getEntry("7ezazPktjgOULFTPmvL3Gj");
    //echo $entry->getName();
    //$query = (new \Contentful\Delivery\Query())
    //->setContentType('gallery')
    //->setInclude(10);
    
      //assets
      //$entries = $this->client->getAssets();
      //$entries = $this->client->getEntries();
    //   $entries = $this->client->getEntry("7ezazPktjgOULFTPmvL3Gj");
    //   dd($entries);


    // $entries = $this->client->getEntries($query);
    // dd($entries);
    
    // ->orderBy('fields.idea');



    // $query = new \Contentful\Delivery\Query();
    // $query->select(['fields.slug'])
    // ->setInclude(1)
    // ->setLimit(1)
    // ->setContentType($contentTypeName)
    // ->where('fields.publishedDate', $date, 'lt')
    // ->where('fields.externalUrl', 'false', 'exists')
    // ->orderBy('fields.publishedDate', true);
   
$query = new \Contentful\Delivery\Query();
$query->setContentType("pageBanner");
$products = $this->client->getEntries($query);
//dd($products);
$renderer = new \Contentful\RichText\Renderer();

foreach ($products as $product) {
    //dd($product->get('pageTitle'));
// Virtual getter methods, just use "get" and the field ID
echo $product->get('pageTitle');
echo 'headline'.$output2 = $renderer->render($product->get('headline')).'<br/>';
echo 'supportingText'.$output3 = $renderer->render($product->get('supportingText')).'<br/>';

}

}




public function index2()
{
    //$entries = $this->client->getEntries();
    //dd($entries);
    //$entries = $this->client->getEntry("7ezazPktjgOULFTPmvL3Gj");
    //echo $entry->getName();
    //$query = (new \Contentful\Delivery\Query())
    //->setContentType('gallery')
    //->setInclude(10);
    
      //assets
      //$entries = $this->client->getAssets();
      //$entries = $this->client->getEntries();
    //   $entries = $this->client->getEntry("7ezazPktjgOULFTPmvL3Gj");
    //   dd($entries);


    // $entries = $this->client->getEntries($query);
    // dd($entries);
    
    // ->orderBy('fields.idea');
   
$query = new \Contentful\Delivery\Query();
$query->setContentType("citation");
$products = $this->client->getEntries($query);
//dd($products);
$renderer = new \Contentful\RichText\Renderer();

foreach ($products as $product) {
// Virtual getter methods, just use "get" and the field ID
echo $product->get('studyName');
echo 'studyBibliography'.$output2 = $renderer->render($product->get('studyBibliography')).'<br/>';

exit;
}

}

public function index3()
{
   // $entries = $this->client->getEntries();
   // dd($entries);
    //$entries = $this->client->getEntry("7ezazPktjgOULFTPmvL3Gj");
    //echo $entry->getName();
    //$query = (new \Contentful\Delivery\Query())
    //->setContentType('gallery')
    //->setInclude(10);
    
      //assets
      //$entries = $this->client->getAssets();
      //$entries = $this->client->getEntries();
    //   $entries = $this->client->getEntry("7ezazPktjgOULFTPmvL3Gj");
    //   dd($entries);


    // $entries = $this->client->getEntries($query);
    // dd($entries);
    
    // ->orderBy('fields.idea');



    // $query = new \Contentful\Delivery\Query();
    // $query->select(['fields.slug'])
    // ->setInclude(1)
    // ->setLimit(1)
    // ->setContentType($contentTypeName)
    // ->where('fields.publishedDate', $date, 'lt')
    // ->where('fields.externalUrl', 'false', 'exists')
    // ->orderBy('fields.publishedDate', true);
   
$query = new \Contentful\Delivery\Query();
$query->setContentType("homeBanner");
$products = $this->client->getEntries($query);
//$createdAt = $entry->getSystemProperties()->getCreatedAt();

//$renderer = new \Contentful\RichText\Renderer();

foreach ($products as $product) {
 echo 'Created at'.' '. $product->getSystemProperties()->getCreatedAt().'<br/>';
    //dd($product->get('pageTitle'));
// Virtual getter methods, just use "get" and the field ID
echo $product->get('bannar');
$link1 = $product->get('image1', null, false);
$brand1 = $this->client->resolveLink($link1);
echo 'image1'.$brand1->getFile()->getUrl().'<br/>';
echo '<img src="'.$brand1->getFile()->getUrl().'" />';
echo '<br/>';


$link3 = $product->get('image3', null, false);
$brand3 = $this->client->resolveLink($link3);
echo 'image3'.$brand3->getFile()->getUrl().'<br/>';
echo '<img src="'.$brand3->getFile()->getUrl().'" />';
echo '<br/>';


$link2 = $product->get('image2', null, false);
$brand2 = $this->client->resolveLink($link2);
echo 'image2'.$brand2->getFile()->getUrl().'<br/>';
echo '<img src="'.$brand2->getFile()->getUrl().'" />';
echo '<br/>';

$link4 = $product->get('image4', null, false);
$brand4 = $this->client->resolveLink($link4);
echo 'image4'.$brand4->getFile()->getUrl().'<br/>';
echo '<img src="'.$brand4->getFile()->getUrl().'" />';
echo '<br/>';

$this->index();

}

}


public function index4()
{
    $token = 'CFPAT-4K-6tQ_fpgCAva-dYW4oLTB89zJ_GQed9jAiZlsrrD0';
    $url="https://api.contentful.com/spaces/gy7ud7gkbg08/environments/master/content_types/postcard";
    $client1 = new \GuzzleHttp\Client(['base_uri' => $url]);

    $headers = [
        'Authorization' => 'Bearer ' . $token
    ];

    $request = $client1->request('GET', '', [
        'headers' => $headers,
        'Accept'        => 'application/json',
    ]);
    $response = $request->getBody()->getContents();
    $arr_data= json_decode($response);

    //$renderer = new \Contentful\RichText\Renderer();
    $fields= $arr_data->fields;
    foreach($fields as $field)
    {
        
     if($field->id=='developmentCategory')
     {
       $validation_data=$field->validations[0]->in;
        echo '<pre>';print_r($validation_data);
     }

    }
   // dd($arr_data->fields);
    



}


public function index5()
{
    $token = 'CFPAT-4K-6tQ_fpgCAva-dYW4oLTB89zJ_GQed9jAiZlsrrD0';
    $url="https://api.contentful.com/spaces/gy7ud7gkbg08/environments/master/content_types/homeBanner";
    $client1 = new \GuzzleHttp\Client(['base_uri' => $url]);

    $headers = [
        'Authorization' => 'Bearer ' . $token
    ];

    $request = $client1->request('GET', '', [
        'headers' => $headers,
        'Accept'        => 'application/json',
    ]);
    $response = $request->getBody()->getContents();
    $arr_data= json_decode($response);

    

    $renderer = new \Contentful\RichText\Renderer();
    $fields= $arr_data->fields;
   // $asset = $this->client->getAsset($arr_data->fields[1]->id);
    dd($fields);

    echo '<pre>'; print_r($arr_data->fields);
    exit;
    foreach($fields as $field)
    {
        
     if($field->id=='developmentCategory')
     {
       $validation_data=$field->validations[0]->in;
        echo '<pre>';print_r($validation_data);
     }

    }
   // dd($arr_data->fields);
    



}






    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //working code 
    //     $query = new \Contentful\Delivery\Query();
    //     $query->setContentType("citation");
    //      $products = $this->client->getEntries($query);
    //      foreach ($products as $product) {
    // // Virtual getter methods, just use "get" and the field ID
    //    echo $product->getstudyName();

    // // Virtual properties
    // echo $product->studyName;

    // // Using array-like syntax
    // echo $product['studyName'];

    // // Using the actual getter method
    // echo $product->get('studyName');

//}
       //  dd($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

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
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use DateTime;

class HomeContentController extends Controller
{

    private $client;

    public function __construct(DeliveryClient $client)
    { //cda
        $this->client = $client;
        $this->query = new \Contentful\Delivery\Query();
        $this->renderer = new \Contentful\RichText\Renderer();
        $this->contentDynamic = new ContentDynamicExcess;
        $contentHelp = new ContentAssetHelper;
        $ContentEntryInline = new ContentEntryInline;
        $ContentEntryBlock = new ContentEntryBlock;
        $hyperlink = new ContentHyperlink;
        $Entryhyperlink = new ContentEntryHyperlink;

        $this
            ->renderer
            ->pushNodeRenderer($contentHelp);
        $this
            ->renderer
            ->pushNodeRenderer($ContentEntryInline);
        $this
            ->renderer
            ->pushNodeRenderer($ContentEntryBlock);
        $this
            ->renderer
            ->pushNodeRenderer($hyperlink);
        // $this->renderer->pushNodeRenderer($Entryhyperlink);
        $this->form2 = Form::where('identifier', 'signup')
            ->firstOrFail();
        $this->form1 = Form::where('identifier', 'form1')
            ->firstOrFail();

        //management api
        // $this->mclient = new \Contentful\Management\Client(env('CONTENTFUL_oauth_token'));
        // $this->mEnvProxy = $this->mclient->getEnvironmentProxy(env('CONTENTFUL_SPACE_ID'),env('CONTENTFUL_ENVIRONMENT_ID'));
        // $this->mquery=new \Contentful\Management\Query();
        

        
    }

    function authData()
    {
        if (Auth::guard('user')
            ->check())
        {
            $user_auth = Auth::guard('user')->user();
            $Usertype = $user_auth->type;
            $Username = $user_auth->name;
            return $Usertype;
        }
        else
        {
            return $Usertype = "";
        }
    }

    function userId()
    {
        if (Auth::guard('user')->check())
        {
            $user_auth = Auth::guard('user')->user();
            $Usertype = $user_auth->id;

            return $Usertype;
        }
        else
        {
            return $Usertype = "";
        }
    }
    public function index()
    {

        $userD = $this->authData();
        // print_r($userD);die;

        $form2 = $this->form2;
        $form1 = $this->form1;
        
        $filter=@$_GET['quiz'];
        if(empty($filter)){
            $questionStep=0;
        }else{
            $questionStep=$filter;
        }

        // $query = $this->query->setContentType("quiz");
        // $entries_pre = $this->client->getEntries($query);
        
        $query2 = $this->query->setContentType("parentStory");
        $entries_pre2 = $this->client->getEntries($query2);
        
        $query3 = $this->query->setContentType("productOffer");
        $entries_pre3 = $this->client->getEntries($query3);
//echo '<pre>'; print_r($entries_pre3->getItems()); exit;
        $query4 = $this->query->setContentType("quotesParentTestimonial");
        $entries_pre4 = $this->client->getEntries($query4);

        $query5 = $this->query->setContentType("pageModule");
        $entries_pre5 = $this->client->getEntries($query5);
        
         $wantLearnMsg = $this->client->getEntry('3CVjH7HC6xZLVtZHcH0ykl');

        // $welcomeMsg = $this->client->getEntry('7q5JEW2ILAY2HpvXuuTZph');

        // $welcomeKit = $this->client->getEntry('1bRUF3EaTV1AdVcxszz9EO');

        // echo "<pre>";
        // print_r($welcomeKit->welcomeKitPages[3]->welcomeKitContentChunks[0]);die;
        // print_r($entries_pre2);die

		$query = $this->query->setContentType("quiz");
        $entries_pre = $this->client->getEntries($query);
        return view('site.layout.home', compact('form2', 'form1'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('Usertype', $userD)
            // ->with('quiz', $entries_pre[0]->quizQuestions)
            // ->with('welcomeKitPages', $welcomeKit->welcomeKitPages)
            ->with('quiz', $entries_pre[0]->quizQuestions)
            ->with('productBenefit', $entries_pre2)
            ->with('productOffer', $entries_pre3)
            ->with('testinomials', $entries_pre4)
            ->with('wantLearnMsg', $wantLearnMsg)
            ;
        //->with('userType',$this->userType);
        

        
    }

    public function quizQuestion()
    {
	
        $userD = $this->authData();
        // print_r($userD);die;

        $form2 = $this->form2;
        $form1 = $this->form1;
        
        

        $query = $this->query->setContentType("quiz");
        $entries_pre = $this->client->getEntries($query);
       
        $query3 = $this->query->setContentType("productOffer");
        $entries_pre3 = $this->client->getEntries($query3);
        $snapshotMsg = $this->client->getEntry('DeNuqVVLd1FDl2UZR9iPz');
        $wantLearnMsg = $this->client->getEntry('3CVjH7HC6xZLVtZHcH0ykl');
        $welcomeKit = $this->client->getEntry('1bRUF3EaTV1AdVcxszz9EO');

        // echo "<pre>";
        // print_r($welcomeKit->welcomeKitPages[3]->welcomeKitContentChunks[0]);die;
        // print_r($wantLearnMsg);die;


        return view('site.other_pages.quiz', compact('form2', 'form1'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('Usertype', $userD)
            ->with('quiz', $entries_pre[0]->quizQuestions)
            ->with('productOffer', $entries_pre3)
            ->with('snapshotMsg', $snapshotMsg)
            ->with('wantLearnMsg', $wantLearnMsg)
            ->with('welcomeKitPages', $welcomeKit->welcomeKitPages)
            ;
        //->with('userType',$this->userType);
        

        
    }

    public function kindergarten()
    {

        $userD = $this->authData();
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
        $form2 = $this->form2;
        $form1 = $this->form1;

        return view('site.other_pages.kindergarten', compact('form2', 'form1'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
        //->with('hyper', $this->hyperlink)
        //->with('mEnvProxy',$this->mEnvProxy)->with('mquery',$this->mquery)
        //->with('mclient',$this->mclient)
        
            ->with('contentDynamic', $this->contentDynamic)
            ->with('Usertype', $userD);

    }

    public function grade_1_3()
    {
        $userD = $this->authData();
        $form2 = $this->form2;
        $form1 = $this->form1;

        return view('site.other_pages.grade_1_3', compact('form2', 'form1'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('Usertype', $userD);

    }

    public function grade_4_5()
    {
        $userD = $this->authData();
        $form2 = $this->form2;
        $form1 = $this->form1;

        return view('site.other_pages.grade_4_5', compact('form2', 'form1'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('Usertype', $userD);

    }

    public function dashboard()
    {
        $form2 = $this->form2;
        $form1 = $this->form1;

        return view('site.other_pages.dashboard', compact('form2', 'form1'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer);

    }

    public function toolkit()
    {
        $userD = $this->authData();
        $form2 = $this->form2;
        $form1 = $this->form1;

        return view('site.other_pages.toolkit', compact('form2', 'form1'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('Usertype', $userD);

    }

    public function about()
    {
        $form2 = $this->form2;
        $form1 = $this->form1;
        $userD = $this->authData();

        // $whyContent = $this->client->getEntry('1Ke6JhajrWkaO29DOomM21');
        // echo"<pre>";
        // print_r($whyContent);die;

        return view('site.other_pages.about_us', compact('form2', 'form1'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('Usertype', $userD);
    }

    public function details($id)
    {
        $userD = $this->authData();
        $form2 = $this->form2;
        $form1 = $this->form1;
        $detail_id = $id;
        $UserID = $this->userId();

        if (!empty($UserID))
        {
            $selected_grades = DB::table('form_submissions')->select('selected_grades')
                ->where('user_id', '=', $UserID)->first();
            $selected_user_grades = $selected_grades->selected_grades;
        }
        else
        {
            $selected_user_grades = "";
        }

        return view('site.other_pages.details', compact('form2', 'form1'))->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('detail_id', $detail_id)->with('Usertype', $userD)->with('UselectedGrades', $selected_user_grades);

    }

    public function toolkitDetails($id)
    {

        $form2 = $this->form2;
        $form1 = $this->form1;
        $detail_id = $id;

        return view('site.other_pages.toolkit_details', compact('form2', 'form1'))->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('detail_id', $detail_id);

    }

    public function gradelist($id)
    {

        $form2 = $this->form2;
        $form1 = $this->form1;
        $detail_id = $id;

        return view('site.other_pages.grade_list', compact('form2', 'form1'))->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('detail_id', $detail_id);

    }

    public function catlist($id)
    {

        $form2 = $this->form2;
        $form1 = $this->form1;
        $detail_id = $id;

        return view('site.other_pages.cat_list', compact('form2', 'form1'))->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('detail_id', $detail_id);

    }

    public function catlist2($url, $id)
    {

        $form2 = $this->form2;
        $form1 = $this->form1;
        $detail_id = $id;
        $url = $url;

        return view('site.other_pages.cat_list2', compact('form2', 'form1'))->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('detail_id', $detail_id)->with('url', $url);

    }

    public function cattag($url, $id)
    {

        $form2 = $this->form2;
        $form1 = $this->form1;
        $detail_id = $id;
        $url = $url;

        return view('site.other_pages.cat_tag', compact('form2', 'form1'))->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('detail_id', $detail_id)->with('url', $url);

    }

    public function SearchModule(Request $request)
    {
        $all = $request->all();

        $validator = Validator::make($all, [

        'search_key' => 'required',

        ]);

        if ($validator->passes())
        {

            $search_key = $all['search_key'];
            $query = $this
                ->query
                ->setContentType("postcard")
                ->where("fields.title[match]", "$search_key")->setLimit(8)
                ->where("order", "-(sys.createdAt)");
            //->where("fields.contentType.sys.contentType.sys.id","Emotional Development")
            //->where("fields.gradeLevel.sys.id[in]","51hefRXWCDPDCrEGXCehNL","4LAKsYurMuPjv0NPMEZif2","7hFAY0Adk5rbJ3wwlmnoig")
            //->where("sys.publishedCounter[gte]","1");
            // $client1 = new \Contentful\Delivery\Client(env('CONTENTFUL_DELIVERY_TOKEN'),
            // env('CONTENTFUL_SPACE_ID'), env('CONTENTFUL_ENVIRONMENT_ID'));
            $entries_pre = $this
                ->client
                ->getEntries($query);
            $count_entries = $entries_pre->count();
            if ($count_entries != 0)
            {
                foreach ($entries_pre as $ent_key => $ent_value)
                {
                    $entry_id = $ent_value->getId();
                    $pre_title = $ent_value->get('title');

                    if (!empty($pre_title))
                    {
                        $pre_title = $pre_title;
                    }
                    else
                    {
                        $pre_title = "";
                    }

                    $IntroText = $ent_value->get('introText');

                    if (!empty($IntroText))
                    {

                        $IntroText = $this
                            ->renderer
                            ->render($IntroText);

                    }
                    else
                    {
                        $IntroText = "";
                    }

                    $IntroImage = $ent_value->get('introImage', null, false);

                    if (!empty($IntroImage))
                    {
                        $IntroImage_u = $this
                            ->client
                            ->resolveLink($IntroImage);
                        $IntroImage_url = $IntroImage_u->getFile()
                            ->getUrl();
                    }
                    else
                    {
                        $IntroImage_url = "";
                    }

                    $schoolLevel = $ent_value->get('gradeLevel', null, false);
                    //echo '<pre>';print_r($schoolLevel);
                    if (!empty($schoolLevel))
                    {

                        $schoolLevel_u = $this
                            ->client
                            ->resolveLink($schoolLevel);

                        $grade_name = $schoolLevel_u->get('gradeTitle');

                    }
                    else
                    {
                        $grade_name = "";
                    }

                    $developmentCategory = $ent_value->get('contentType', null, false);

                    if (!empty($developmentCategory))
                    {
                        $developmentCategoryU = $this
                            ->client
                            ->resolveLink($developmentCategory);

                        $developmentCategory_name = $developmentCategoryU->get('contentType');

                    }
                    else
                    {
                        $developmentCategory_name = "";
                    }

                    $data[] = ['entry_id' => $entry_id, 'pre_title' => $pre_title, 'IntroText' => $IntroText, 'IntroImage_url' => $IntroImage_url, 'grade_name' => $grade_name, 'developmentCategory_name' => $developmentCategory_name];

                }

            }
            else
            {
                $data = "";
            }

            return response()->json(['status' => true, 'data' => $data]);

        }
        else
        {

            return response()->json(['status' => false,
            //'error'=>$validator->errors()->all()
            'errors' => $validator->getMessageBag()
                ->toArray() ]);
        }

    }

    public function MoreSearchModule($keyword)
    {

        $search_key = $keyword;
        $form2 = $this->form2;
        $form1 = $this->form1;

        return view('site.other_pages.more_search', compact('form2', 'form1'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('keyword', $search_key);

    }

    public function thank_you()
    {
        $disabledrag = 1;
        $form2 = $this->form2;
        $form1 = $this->form1;

        return view('site.other_pages.thank_you', compact('form2', 'form1', 'disabledrag'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic);

    }

    public function second_grade()
    {
        $userD = $this->authData();
        $form2 = $this->form2;
        $form1 = $this->form1;

        // $queryIndex = $this->query->setContentType("indexCategory")->orderBy('fields.indexCategory');
        // $entries_pre = $this->client->getEntries($queryIndex);

        // echo "<pre>";
        // print_r($entries_pre[0]);die;

        // $leftColumn=$entries_pre[0]->getID();
        // if(!empty($leftColumn)){
        // }else{
        //     $leftPart="";        
        // }

        // $query = $this->query->setContentType("postcard");
        // $entries_pre = $this->client->getEntries($query);
        // echo "<pre>";
        // print_r($entries_pre[0]);die;

        return view('site.other_pages.second_grade', compact('form2', 'form1'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic)
            ->with('Usertype', $userD)
            // ->with('indexPostcard', $entries_pre)
            ;

    }

    public function disclaimer()
    {
        $disabledrag = 1;
        $form2 = $this->form2;
        $form1 = $this->form1;

        return view('site.other_pages.disclaimer', compact('form2', 'form1', 'disabledrag'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic);

    }
    
    //terms-of-services
    public function termsOfUse()
    {
        $disabledrag = 1;
        $form2 = $this->form2;
        $form1 = $this->form1;

        return view('site.other_pages.termsofuse', compact('form2', 'form1', 'disabledrag'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic);

    }
    //code ends here
    
    //terms-of-services
    public function privacyPolicy()
    {
        $disabledrag = 1;
        $form2 = $this->form2;
        $form1 = $this->form1;

        return view('site.other_pages.privacy', compact('form2', 'form1', 'disabledrag'))
            ->with('client', $this->client)
            ->with('query', $this->query)
            ->with('renderer', $this->renderer)
            ->with('contentDynamic', $this->contentDynamic);

    }
    //code ends here

    public function DetailPaging(Request $request)
    {
        $all = $request->all();

        $gids = $all['gids'];

        if (!empty($gids))
        {

            $query = $this
                ->query
                ->setContentType("postcard")
                ->where("fields.gradeLevel.sys.id[in]", $gids)->orderBy('sys.createdAt')
                ->orderBy('sys.id');

            //->where("sys.publishedCounter[gte]","1");
            
        }
        else
        {

            $query = $this
                ->query
                ->setContentType("postcard")
                ->orderBy('sys.createdAt')
                ->orderBy('sys.id');

            //->where("sys.publishedCounter[gte]","1");
            
        }

        $ent_value = $this
            ->client
            ->getEntries($query);

        foreach ($ent_value as $key => $value)
        {

            $ids[] = $value->getID();

            $title[] = $value->get('title');

        }

        //seach start from 0
        $searched = array_search($all['post_id'], $ids);

        //count start from 1
        $count = $ent_value->count();

        if (($searched + 1) == $count)
        {

            $prev_title = $title[$searched - 1];
            $next_title = 0;

        }
        else if ($searched == 0)
        {

            $prev_title = 0;
            $next_title = $title[$searched + 1];
        }
        else
        {
            $prev_title = $title[$searched - 1];
            $next_title = $title[$searched + 1];
        }

        if ($all['side'] == 'left')
        {

            $skip = $searched - 1;

            if ($skip > - 1)
            {

                if (!empty($gids))
                {

                    $query = $this
                        ->query
                        ->setContentType("postcard")
                        ->where("fields.gradeLevel.sys.id[in]", $gids)->orderBy('sys.createdAt')
                        ->orderBy('sys.id')
                        ->setLimit(1)
                        ->setSkip($skip);
                    //->where("sys.publishedCounter[gte]","1");
                    
                }
                else
                {

                    $query = $this
                        ->query
                        ->setContentType("postcard")
                        ->orderBy('sys.createdAt')
                        ->orderBy('sys.id')
                        ->setLimit(1)
                        ->setSkip($skip);
                    //->where("sys.publishedCounter[gte]","1");
                    
                }

                $ent_value = $this
                    ->client
                    ->getEntries($query) [0];
                $ttile = $ent_value->get('title');
                $seo_title = strtolower(str_replace(' ', '-', $ttile));
                echo json_encode(['status' => true, 'id' => $ent_value->getID() , 'seo_title' => $seo_title, 'count' => $count, 'item_index' => $searched, 'skip' => $skip, 'next_title' => $next_title, 'prev_title' => $prev_title]);
            }
            else
            {

                echo json_encode(['status' => false, 'item_index' => $searched, 'count' => $count, 'skip' => $skip]);
            }

        }
        else if ($all['side'] == 'right')
        {

            $skip = $searched + 1;
            // print_r($searched);
            // dd($skip);
            if ($count > $skip)
            {

                $query = $this
                    ->query
                    ->setContentType("postcard")
                    ->orderBy('sys.createdAt')
                    ->orderBy('sys.id')
                    ->setLimit(1)
                    ->setSkip($skip);
                //->where("sys.publishedCounter[gte]","1");
                

                $ent_value = $this
                    ->client
                    ->getEntries($query) [0];
                $ttile = $ent_value->get('title');
                $seo_title = strtolower(str_replace(' ', '-', $ttile));

                $res = json_encode(['status' => true, 'id' => $ent_value->getID() , 'seo_title' => $seo_title, 'count' => $count, 'item_index' => $searched, 'skip' => $skip, 'next_title' => $next_title, 'prev_title' => $prev_title]);
                echo $res;
                //dd($res);
                
            }
            else
            {

                echo json_encode(['status' => false,

                'count' => $count, 'item_index' => $searched,

                'skip' => $skip]);
            }

        }
        else
        {

            $res = json_encode(['status' => true,

            'count' => $count, 'item_index' => $searched,

            'next_title' => $next_title, 'prev_title' => $prev_title]);
            echo $res;

        }
    }

    public function updateBirthYear()
    {

        //one time in year cron
        $data = DB::table('users')->join('form_submissions', 'users.id', '=', 'form_submissions.user_id', 'left')
            ->select('users.*', 'form_submissions.user_id', 'form_submissions.selected_grades')
            ->get();
        $year = date("Y");

        foreach ($data as $mData)
        {
            //echo '<pre>'; print_r($mData);
            if (!empty($mData->selected_grades))
            {

                $email = $mData->email;
                $selected_grades = $mData->selected_grades;
                $selected_grades_json = json_decode($mData->selected_grades);
                $user_id = $mData->user_id;
                foreach ($selected_grades_json as $selKey => $selval)
                {
                    $birth_year[$user_id][] = $year - 5 - $selval;
                }

            }
        }

        foreach ($birth_year as $bkey => $bval)
        {

            $birth_year_json = json_encode($bval);
            $updated[] = DB::table('form_submissions')->where('user_id', $bkey)->limit(1)
                ->update(array(
                'birth_years' => $birth_year_json
            ));

        }
        echo '<pre>';
        print_r($updated);

        //dd($updated);
        
    }

    public function updateGrade()
    {

        $year = date("Y");
        $data = DB::table('users')->join('form_submissions', 'users.id', '=', 'form_submissions.user_id', 'left')
            ->select('users.*', 'form_submissions.user_id', 'form_submissions.selected_grades', 'form_submissions.birth_years')
            ->where('users.type', 2)
            ->get();

        foreach ($data as $mData)
        {
            //echo '<pre>'; print_r($mData);
            if (!empty($mData->birth_years))
            {

                $email = $mData->email;
                $return = Newsletter::getMember($email, 'list3');

                //dd($return);
                if ($return['status'] != '404')
                {
                    foreach ($return['tags'] as $tag)
                    {
                        $tag_num = $tag['name'];
                        if (is_numeric($tag_num))
                        {
                            $old_tags = ['name' => $tag_num, 'status' => 'inactive'];
                        }

                    }

                    $selected_grades = $mData->selected_grades;
                    $selected_grades_json = json_decode($mData->selected_grades);
                    $birth_years_json = json_decode($mData->birth_years);
                    $user_id = $mData->user_id;

                    $userIdByEmail[$email] = $user_id;

                    foreach ($birth_years_json as $birthKey => $birthval)
                    {
                        $oldGradeVal = $selected_grades_json[$birthKey];

                        $oldGrade[$email][] = $old_tags;

                        $new_grade = $year - $birthval - 5;

                        $newGrade[$email][] = ['name' => ($new_grade) , 'status' => 'active'];
                        $newGradeEmailArr[$email][] = "$new_grade";
                    }
                }

            }

        }

        //Mailchimp update grades on list
        $MailChimp = Newsletter::getApi();
        foreach ($newGrade as $ngradekey => $ngradeval)
        {

            $newGradeArr = $newGradeEmailArr[$ngradekey];

            $removeGradeval = $oldGrade[$ngradekey];

            $subscriber_hash = md5(strtolower($ngradekey));

            $del_tag_url = "lists/d2ae77bf0e/members/$subscriber_hash/tags";

            $remove_tags = ['tags' => $removeGradeval];

            $remove[] = $MailChimp->post($del_tag_url, $remove_tags);

            $add_tags = ['tags' => $ngradeval];
            $add[] = $MailChimp->post($del_tag_url, $add_tags);

            //query
            $user_idd = $userIdByEmail[$ngradekey];

            $updated[] = DB::table('form_submissions')->where('user_id', $user_idd)->limit(1)
                ->update(array(
                'selected_grades' => json_encode($newGradeArr)
            ));

        }

        return "success";

        // echo '<pre>'; print_r($remove);
        // echo '<pre>'; print_r($add);
        // echo '<pre>'; print_r($updated);
        // exit;
        

        
    }

    public function allGradesInList($listId)
    {
        $MailChimp = Newsletter::getApi();
        $url = "lists/$listId/segments?count=100";
        $segments = $MailChimp->get($url);
        $all_segments = $segments['segments'];

        foreach ($all_segments as $seg)
        {
            $grade_name = $seg['name'];
            //echo '<pre>'; print_r($seg['name']);
            $array_grades[$grade_name] = $seg['id'];

        }

        return $array_grades;

    }

    public function colorByCategory($categoryName)
    {

        if ($categoryName == "Emotional Dev't")
        {
            $color = "#a678dc";
        }
        else if ($categoryName == "Social Dev't")
        {
            $color = "#00a684";
        }
        else if ($categoryName == "Cognitive Dev't")
        {
            $color = "#fd8959";
        }
        else if ($categoryName == "Parent Self-care")
        {
            $color = "#dd87f1";
        }

        return $color;
    }

    public function BackgroudcolorByCategory($categoryName)
    {

        if ($categoryName == "Emotional Dev't")
        {
            $color = "rgba(166,120,220,0.1)";
        }
        else if ($categoryName == "Social Dev't")
        {
            $color = "rgba(0,166,132,0.1)";

        }
        else if ($categoryName == "Cognitive Dev't")
        {
            $color = "rgba(253,137,89,0.1)";
        }
        else if ($categoryName == "Parent Self-care")
        {
            $color = "rgba(235,110,145,0.1)";
        }

        return $color;
    }

    public function logoByCategory($categoryName)
    {

        if ($categoryName == "Emotional Dev't")
        {
            $full_url = "https://images.ctfassets.net/gy7ud7gkbg08/6zFjl0efJmPnopzksrlZWO/0a6ddeac067f6b7139597fa1404a2dd3/logo-purple.png?h=250";

        }
        else if ($categoryName == "Social Dev't")
        {
            $full_url = "https://images.ctfassets.net/gy7ud7gkbg08/3StCvX0sfm5M9dWQzxeVrd/fcaebd19589149fd8a14617d1c5b3fac/logo-green.png?h=250";
        }
        else if ($categoryName == "Cognitive Dev't")
        {
            $full_url = "https://images.ctfassets.net/gy7ud7gkbg08/5sltumOS6DxjZSvV8GBuV4/427a947799da2b9fef43bbb80ee3bb7d/logo-orange.png?h=250";
        }
        else if ($categoryName == "Parent Self-care")
        {
            $full_url = "https://images.ctfassets.net/gy7ud7gkbg08/6Z2CifNzed9837aNb445cc/2e050c774c8afcecad425c49ddcae772/logo.png?h=250";
        }

        return $full_url;

    }

    public function testmailerCron()
    {

        $testingBypass = true;

        return $this->mailerCron($testingBypass);

    }

    public function mailerCron($testingBypass = NULL)
    {

        //automatic login email
        $string = "MAILER";
        $encrypted = \Illuminate\Support\Facades\Crypt::encrypt($string);

        //echo $decrypted_string = \Illuminate\Support\Facades\Crypt::decrypt($encrypted);
        //dd($encrypted);
        //Testing purpose Next month data checking
        if ($testingBypass)
        {
            $currentMonth = date('n', strtotime('+1 month'));
        }
        else
        {
            $currentMonth = date("n");
        }

        $year = date("Y");

        $query = $this
            ->query
            ->setContentType("emailWrapper")
        //->where("sys.id","$detail_id")
        // ->orderBy("fields.order",true)
        //->where("include", "0")
        // ->where("skip", "10")
        //->setSkip(3)
        //->where("order", "fields.order")
        
            ->orderBy('sys.createdAt');
        // ->where("sys.publishedCounter[gte]","1");
        

        $ent_value = $this
            ->client
            ->getEntries($query);

        foreach ($ent_value as $key => $ent_value)
        {

            $grade = $ent_value->get('grade', null, false);

            $name = $ent_value->get('emailSequence');

            $whatsComingUp = $ent_value->get('whatsComingUp', null, false);

            $whatsComingUparray = [];

            if (!empty($whatsComingUp))
            {

                foreach ($whatsComingUp as $wkey => $wwvalue)
                {

                    $wvalue = $this
                        ->client
                        ->resolveLink($wwvalue);

                    $wTitle = $wvalue->get('title');
                    $introText = $wvalue->get('introText');
                    if (!empty($introText))
                    {
                        $renderintroText = $this
                            ->renderer
                            ->render($introText);
                    }
                    else
                    {
                        $renderintroText = "";
                    }

                    $whatsComingUparray[] = ['comingUpTitle' => $wTitle, 'comingUpDesc' => $renderintroText];
                }
            }
            else
            {
                $whatsComingUparray = [];
            }

            if (!empty($grade))
            {

                try
                {

                    $tIvalueU = $this
                        ->client
                        ->resolveLink($grade);
                    $grade = $tIvalueU->get('grade');

                }
                catch(Exception $e)
                {
                    $grade = "";
                }

            }
            else
            {
                $grade = "";
            }

            $month = $ent_value->get('month', null, false);
            if (!empty($month))
            {

                try
                {

                    $monthU = $this
                        ->client
                        ->resolveLink($month);

                    $monthNumber = $monthU->get('monthNumber');

                }
                catch(Exception $e)
                {
                    $monthNumber = "";
                }

            }
            else
            {
                $monthNumber = "";
            }

            if ($currentMonth == $monthNumber)
            {
                $orderInMonth = $ent_value->get('orderInMonth', null, false);

                //$todays_date=date("d-M-Y", strtotime("tomorrow"));
                $givenSatDAte = date("d-M-Y", strtotime("$orderInMonth saturday $year-$currentMonth"));
                //$givenSatDAte=date("d-M-Y", strtotime("$orderInMonth tuesday $year-$currentMonth"));
                // echo  $grade;
                // dd($givenSatDAte);
                if ($testingBypass)
                {
                    $todays_date = $givenSatDAte;
                }
                else
                {
                    $todays_date = date("d-M-Y", strtotime("today"));
                }

                //checking postcard date
                if ($todays_date == $givenSatDAte)
                {
                    $contentCategory = $ent_value->get('contentCategory', null, false);
                    if (!empty($contentCategory))
                    {
                        try
                        {
                            $contentCategoryU = $this
                                ->client
                                ->resolveLink($contentCategory);

                            $category = $contentCategoryU->get('contentType');
                        }
                        catch(Exception $e)
                        {
                            $category = "";
                        }
                    }
                    else
                    {
                        $category = "";
                    }

                    $postcard = $ent_value->get('postcard', null, false);

                    if (!empty($postcard))
                    {

                        //$Ideaarray=[];
                        //echo '<pre>';print_r($Ideaarray);
                        $postcardU = "";
                        try
                        {
                            $postcardU = $this
                                ->client
                                ->resolveLink($postcard);

                            $entry_id = $postcardU->getId();

                            $detail_page_hyper_link_url = url("details/$entry_id");

                            $pcontentType = $postcardU->get('contentType', null, false);
                            if (!empty($pcontentType))
                            {
                                try
                                {
                                    $contentCategoryU = $this
                                        ->client
                                        ->resolveLink($pcontentType);

                                    $pcategory = $contentCategoryU->get('contentType');
                                }
                                catch(Exception $e)
                                {
                                    $pcategory = "";
                                }
                            }
                            else
                            {
                                $pcategory = "";
                            }

                            $emailSubjectLine = $postcardU->get('emailSubjectLine');

                            $contextAndIssue = $postcardU->get('contextAndIssue');

                            if (!empty($contextAndIssue))
                            {
                                $contextAndIssue = $this
                                    ->renderer
                                    ->render($contextAndIssue);
                            }
                            else
                            {
                                $contextAndIssue = "";
                            }

                            $goodNews = $postcardU->get('goodNews');

                            if (!empty($goodNews))
                            {
                                $goodNews = $this
                                    ->renderer
                                    ->render($goodNews);
                            }
                            else
                            {
                                $goodNews = "";
                            }

                            $illustration = $postcardU->get('illustration', null, false);
                            if (!empty($illustration))
                            {
                                $illustration_u = $this
                                    ->client
                                    ->resolveLink($illustration);
                                $illustration_url = $illustration_u->getFile()
                                    ->getUrl();
                            }
                            else
                            {
                                $illustration_url = "";
                            }

                            $audioLink = $postcardU->get('audioLink', null, false);
                            if (!empty($audioLink))
                            {
                                $audioLink_u = $this
                                    ->client
                                    ->resolveLink($audioLink);

                                $audioLink_url = $audioLink_u->getFile()
                                    ->getUrl();
                            }
                            else
                            {
                                $audioLink_url = "";
                            }

                            $whatsGoingOnText = $postcardU->get('whatsGoingOnText');

                            if (!empty($whatsGoingOnText))
                            {
                                $whatsGoingOnText = $this
                                    ->renderer
                                    ->render($whatsGoingOnText);
                            }
                            else
                            {
                                $whatsGoingOnText = "";
                            }

                            $supportingYourChild = $postcardU->get('supportingYourChild');

                            if (!empty($supportingYourChild))
                            {
                                $supportingYourChild = $this
                                    ->renderer
                                    ->render($supportingYourChild);
                            }
                            else
                            {
                                $supportingYourChild = "";
                            }

                            $ideas = $postcardU->get('ideas', null, false);

                            $Ideaarray = [];

                            foreach ($ideas as $ikey => $iivalue)
                            {

                                $ivalue = $this
                                    ->client
                                    ->resolveLink($iivalue);

                                $ideaTitle = $ivalue->get('ideaTitle');
                                $idea = $ivalue->get('idea');
                                $renderIdea = $this
                                    ->renderer
                                    ->render($idea);

                                $Ideaarray[] = ['ideaTitle' => $ideaTitle, 'ideaDesc' => $renderIdea];
                            }

                            //echo '<pre>';print_r($Ideaarray);
                            $recentRelatedPosts = $postcardU->get('recentRelatedPosts', null, false);

                            foreach ($recentRelatedPosts as $rkey => $rvalue)
                            {
                                $resolvePost = $this
                                    ->client
                                    ->resolveLink($rvalue);

                                $resolvePostHead = $resolvePost->get('title');

                                $resolvePostHeadArr[] = ['resolvePostHead' => $resolvePostHead, 'post_id' => $resolvePost->getId()

                                ];
                            }

                            $usefulTools = $postcardU->get('usefulTools');
                            $Toolarray = [];

                            foreach ($usefulTools as $ukey => $uvalue)
                            {
                                $toolName = $uvalue->get('name');

                                $toolPreviewImage = $uvalue->get('toolIcon', null, false);
                                if (!empty($toolPreviewImage))
                                {
                                    $toolPreviewImage_u = $this
                                        ->client
                                        ->resolveLink($toolPreviewImage);

                                    $toolPreviewImage_url = $toolPreviewImage_u->getFile()
                                        ->getUrl();
                                }
                                else
                                {
                                    $toolPreviewImage_url = "";
                                }
                                $Toolarray[] = ['toolName' => $toolName, 'toolIcon' => $toolPreviewImage_url, 'id' => $uvalue->getId() ];
                            }

                            //contextAndIssue
                            //audiolink
                            

                            // $category=$postcardU->get('contentType');
                            
                        }
                        catch(Exception $e)
                        {
                            $category = "";
                        }
                    }
                    else
                    {
                        $category = "";
                    }

                    $dynamicContentColor = $this->colorByCategory($pcategory);
                    $logo_url = $this->logoByCategory($pcategory);

                    $site_url = url('/');
                    $logoimage = "<a target='_blank' href='$site_url'>" . '<img style="display:block; border:none;width: 320px;"  src="' . $logo_url . '">' . "</a>";

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
                    if (!empty($illustration_url))
                    {
                        $illuImage = '<img style="display:block; border:none;width:100%;"  src="' . 'https:' . $illustration_url . '">';

                    }
                    else
                    {
                        $illuImage = "";
                    }

                    //dd($illuImage);
                    

                    if (!empty($audioLink_url))
                    {
                        //$illuImage='"<img height="200" src="'.substr($illustration_url,2).'">';
                        $audioData = "Prefer to listen?" . '<a style="color: rgba(51,51,51,0.5);"  href="' . 'https:' . $audioLink_url . '">' . "Click for audio" . "</a>";
                    }
                    else
                    {
                        $audioData = "";
                    }

                    $name_data = "<div style='color:$dynamicContentColor;font-size:22px'>" . 'Hi' . ' ' . '*|FNAME|*,' . "</div>";

                    if (!empty($contextAndIssue))
                    {
                        $contextAndIssue = "<div style='padding:0;margin:0;color:$dynamicContentColor;font-size:22px;line-height:28px;'>" . $contextAndIssue . "</div>";
                    }
                    else
                    {
                        $contextAndIssue = "";
                    }
                    //echo $contextAndIssue;
                    //echo $name_data;
                    //exit;
                    if (!empty($goodNews))
                    {
                        $goodNews = "<div style='padding:0;margin:0;color:$dynamicContentColor;font-size:22px;line-height:28px;'>" . $goodNews . "</div>";
                    }
                    else
                    {
                        $goodNews = "";
                    }

                    if (!empty($whatsGoingOnText))
                    {
                        $whatsGoingOnText = $whatsGoingOnText;
                        $whatsGoingOnHeading = "<h3 style='padding:10px 0;margin:0;color:$dynamicContentColor;line-height:28px;'>- - - - WHAT'S GOING ON? - - - - </h3>";
                    }
                    else
                    {
                        $whatsGoingOnText = "";
                        $whatsGoingOnHeading = "";
                    }

                    if (!empty($supportingYourChild))
                    {
                        $supportingYourChild = $supportingYourChild;
                        $supportingYourChildHeading = "<h3 style='padding:10px 0;margin:0;color:$dynamicContentColor;line-height:24px;'>- - - - SUPPORTING YOUR CHILD - - - -</h3>";
                    }
                    else
                    {
                        $supportingYourChild = "";
                        $supportingYourChildHeading = "";
                    }

                    if (!empty($whatsComingUparray))
                    {

                        //$RELATED_post="<p>".  ."<p>";
                        $whatscomingUpHeading = "<h3 style='padding:20px 0 0;margin:0;color:$dynamicContentColor;line-height:24px;'>- - - - COMING UP - - - - </h3>";

                        $comingTitle = "";
                        foreach ($whatsComingUparray as $wtKey => $wtPost)
                        {

                            $comingTitle .= "<p>" . $wtPost['comingUpTitle'] . "</p>";

                        }
                    }
                    else
                    {
                        $comingTitle = "";
                        $whatscomingUpHeading = "";
                    }

                    if (!empty($resolvePostHeadArr))
                    {

                        //$RELATED_post="<p>".  ."<p>";
                        $RELATED_post_cont = "";
                        foreach ($resolvePostHeadArr as $resolvePostV)
                        {

                            $post_id = $resolvePostV['post_id'];

                            $url_ = url("details/$post_id");
                            $RELATED_post_cont .= "<p style='padding:0 0 5px;'>" . "<a style='color:#5c5f60' href='$url_?m=*|EMAIL|*&e=$encrypted' >" . $resolvePostV['resolvePostHead'] . "</a>" . "</p>";
                        }

                        $relatedPostHeading = "<h3 style='padding:10px 0 0;margin:0;color:$dynamicContentColor;line-height:24px;'>- - - - IN CASE YOU MISSED - - - - </h3>";
                    }
                    else
                    {
                        $relatedPostHeading = "";
                        $RELATED_post_cont = "";
                    }

                    // dd($RELATED_post_cont);
                    

                    if (!empty($Ideaarray))
                    {

                        //$RELATED_post="<p>".  ."<p>";
                        

                        $ideaDesc = "";
                        foreach ($Ideaarray as $ideaKey => $ideaPost)
                        {

                            $ideaDesc .= "<p style='font-family: Arial, Helvetica, sans-serif;padding:0;margin:0;line-height:24px;color:$dynamicContentColor'><a target='_blank' style='color:$dynamicContentColor' href='$detail_page_hyper_link_url?m=*|EMAIL|*&e=$encrypted'> <strong>" . ($ideaKey + 1) . '.' . ' ' . $ideaPost['ideaTitle'] . "</strong></a></p>";
                            //"<p style='padding:5px 0;margin:0;line-height:24px;font-family: Arial, Helvetica, sans-serif;font-size:14px;'>".  $ideaPost['ideaDesc']   ."</p>"  ;
                            
                        }
                    }
                    else
                    {
                        $ideaDesc = "";
                    }

                    if (!empty($Toolarray))
                    {

                        //$RELATED_post="<p>".  ."<p>";
                        $usefulToolsContent = '';
                        foreach ($Toolarray as $resolveToolarray)
                        {
                            // $resolveURL= substr($resolveToolarray['toolIcon'], 2);
                            $resolveIcon = $resolveToolarray['toolIcon'];
                            $tid = $resolveToolarray['id'];
                            $tool_detail_page_hyper_link_url = url("toolkitDetails/$tid");

                            $useful_tools_hyper_link_url = url("toolkit");

                            $resolveURL = 'https:' . $resolveIcon;
                            //$icon_image='<span><a href=""<img style="display:block; border:none;width:80px;" src="'.$resolveURL.'">'."<br/>";
                            $icon_image = '<span><a style="' . 'color:#373737;text-decoration:none' . '" href="' . $tool_detail_page_hyper_link_url . '" ><img style="display:block; border:none;width:80px;" src="' . $resolveURL . '">' . "<br/>";

                            $usefulToolsContent .= $icon_image . $resolveToolarray['toolName'] . '</a>' . '</span>';
                        }

                        $usefulToolsHeading = "<h3 style='padding:10px 0;margin:0;line-height:24px;color:$dynamicContentColor;'>- - - - <a style='color:$dynamicContentColor;text-decoration:none;' href='$useful_tools_hyper_link_url'>USEFUL TOOLS </a>- - - - </h3>";
                    }
                    else
                    {
                        $usefulToolsHeading = "";
                        $usefulToolsContent = "";
                    }

                    $dynamicArray = ['name' => $name_data, 'contentAndIssue' => $contextAndIssue, 'goodNews' => $goodNews, 'illustrationImage' => $illuImage, 'whatsGoingOnHeading' => $whatsGoingOnHeading, 'whatsGoingOnContent' => $whatsGoingOnText, 'supportingYourChildHeading' => $supportingYourChildHeading, 'supportingYourChildContent' => $supportingYourChild, 'whatscomingUpContent' => $comingTitle, 'whatscomingUpHeading' => $whatscomingUpHeading, 'relatedPostHeading' => $relatedPostHeading, 'relatedPostContent' => $RELATED_post_cont, 'ideasContent' => $ideaDesc, 'usefulToolsHeading' => $usefulToolsHeading, 'usefulToolsContent' => $usefulToolsContent, 'audioLink' => $audioData, 'logoimage' => $logoimage];

                    //echo '<pre>'; print_r($dynamicArray);
                    //exit;
                    //Mailchimp mailer
                    $MailChimp = Newsletter::getApi();

                    $listID = "d2ae77bf0e";
                    //original
                    //test list id
                    //$listID="caa284fd88";
                    

                    $all_grades = $this->allGradesInList($listID);

                    $segment_id = $all_grades[$grade];
                    $segment_id = $all_grades[$grade];

                    $template_id = 101993;
                    $fromName = "Kate, Postcards for Parents";
                    $replyTo = "hello@postcardsforparents.com";
                    $subject = $emailSubjectLine;
                    $defaultOptions = ['type' => 'regular', 'recipients' => ['list_id' => $listID, 'segment_opts' => ['saved_segment_id' => $segment_id, 'prebuilt_segment_id' => "$segment_id",

                    ]

                    ], 'settings' => ['subject_line' => $subject, 'from_name' => $fromName, 'reply_to' => $replyTo, 'template_id' => $template_id], ];

                    $response = $MailChimp->post('campaigns', $defaultOptions);

                    $campaign_id = $response['id'];

                    $url = "campaigns/$campaign_id/content";

                    $parameter = [

                    'template' => ['id' => $template_id, 'sections' => $dynamicArray]];

                    $compaignForTemplate = $MailChimp->put($url, $parameter);

                    $send[] = $MailChimp->post("campaigns/$campaign_id/actions/send");

                    $message['success'][$name] = "success";

                }
                else
                {
                    $message['fail'][$name] = "This postcard is not for todays date";
                }

            }
            else
            {

                $message['fail'][$name] = "This postcard is not for this month";

            }

        }
        return $message;

        //end foreach
        
    }

    public function grades_logic()
    {

        $Mainquery = new \Contentful\Delivery\Query();

        $querycat = $Mainquery->setContentType("grade");
        //->where("sys.publishedCounter[gte]","1");
        $entries_grade = $this
            ->client
            ->getEntries($querycat);
        $grade_arr_id_name = [];
        foreach ($entries_grade as $egrade)
        {
            if (!empty($egrade))
            {
                $grade_number = $egrade->get('grade');
                $grade_ID = $egrade->getID();
                $grade_title = $egrade->get('yourXGrader');
                $grade_arr_id[$grade_number] = $grade_ID;
                $grade_arr_id_name[$grade_number] = ['id' => $grade_ID, 'Gnumber' => $grade_number, 'grade_name' => $grade_title];
            }
        }

        return $grade_arr_id_name;

        //  $user = DB::table('form_submissions')->orderByDesc('id')->limit(1)->first();
        //  $all_grades=json_decode($user->all_grades);
        //  $userGrades=$all_grades;
        //  if(!empty($userGrades))
        //  {
        

        //     foreach($userGrades as $gradesu)
        //     {
        

        //       if($grade_arr_id[$gradesu]){
        //           $seached_id=$grade_arr_id_name[$gradesu]['id'];
        //           $grade_name_new=$grade_arr_id_name[$gradesu]['title'];
        

        //           $Mainquery1= new \Contentful\Delivery\Query();
        //            $Newquery1=$Mainquery1->setContentType("atThisAge")
        //            ->where("fields.grade.sys.id[in]",$seached_id)
        //            ->where("sys.publishedCounter[gte]","1");
        //            $entries_values = $this->client->getEntries($Newquery1);
        //            $c_total= $entries_values->count();
        //            $Mainquery2= new \Contentful\Delivery\Query();
        //            $Newquery2=$Mainquery2->setContentType("ideaEmail")
        //            ->where("fields.ideaForGrades.sys.id[in]",$seached_id)
        //            ->where("sys.publishedCounter[gte]","1");
        //            $entries_values_idea = $this->client->getEntries($Newquery2);
        

        //            $idea_total= $entries_values_idea->count();
        

        //            if($c_total > 0)
        //            {
        //             $entries_at=$entries_values[0];
        //              $atThisAge=$entries_at->get('atThisAge');
        //              $atThisAgeRender=$this->renderer->render($atThisAge);
        

        //            }else{
        //              $atThisAgeRender="";
        //            }
        //           if($idea_total>0){
        //             $total_ideas=[];
        //                foreach($entries_values_idea as $kidea=>$videa)
        //                {
        //                  $ideaTitle=$videa->get('ideaTitle');
        //                  $total_ideas[]=[
        //                      'title'=>$ideaTitle,
        

        //                 ];
        //                }
        //            }else{
        //              $total_ideas=[];
        //            }
        

        //            $new_entries[$gradesu]= [
        //                'grade'=>$gradesu,
        //                'grade_name'=>$grade_name_new,
        //                'atThisAge'=>$atThisAgeRender,
        //                'idea'=>$total_ideas
        //              ];
        

        //        }
        //     }
        //    }
        //    return $new_entries;
        

        
    }

    public function month_ids($month)
    {

        $querycat = $this
            ->query
            ->setContentType("month")

            ->where("fields.monthNumber", "$month");
        //->where("sys.publishedCounter[gte]","1");
        $entries_month = $this
            ->client
            ->getEntries($querycat);
        return $entries_month[0]->getID();

    }
  
    public function getWeeks($date)
      {
          $Date = explode("-",$date);
          $DateNo = $Date[2];
          $WeekNo = $DateNo / 7; // devide it with 7
          if(is_float($WeekNo) == true)
          {
             $WeekNo = ceil($WeekNo); //So answer will be 1
          } else {
             $WeekNo;
          }

          return $WeekNo;
      }

    public function newTestmailerCron()
    {
        // $Mainquery4= new \Contentful\Delivery\Query();
        // $query_lattest=$Mainquery4->setContentType("postcard")
        // ->orderBy('-sys.createdAt')
        // ->setLimit(3)
        // ->where("sys.publishedCounter[gte]","1");
        // $data_lattest = $this->client->getEntries($query_lattest);
        // $latt_arr=[];
        // foreach($data_lattest as $latK=>$latV){
        //    $latTitle=$latV->get('title');
        //    $lid=$latV->getID();
        //    $latt_arr[]=[
        //        'title'=>$latTitle,
        //        'lid'=>$lid
        //    ];
        // }
        // dd($latt_arr);exit;
        

        //original
        //test list id
        

        //      $url="lists/d2ae77bf0e/segments/259765/members";
        //      $tag = $MailChimp->get($url);
        //      dd($tag);
        //     $MailChimp = Newsletter::getApi();
        //     $listIDTest="caa284fd88";
        //     //$listID="d2ae77bf0e";
        //     $url="lists/$listIDTest/members?count=1000";
        //     $segments = $MailChimp->get($url);
        //           foreach($segments['members'] as $memval){
        //           if($memval['status']=='subscribed'){
        //             $email_address=  $memval['email_address'];
        //             $tags=$memval['tags'];
        //   $all_members[]=[
        //       'email'=>$email_address,
        //       'tag'=>$memval['tags']
        //   ];
        //           }
        

        // }
        //dd($all_members);
        // $all_grades=$this->allGradesInList($listID);
        //dd($all_grades);
        

        $testingBypass = true;
        return $this->NewMailerCron($testingBypass);
    }
//Code for midweek email.
	public function MidWeekEmail($testingBypass = NULL){
		//check if bypass is null
			$MailChimp = Newsletter::getApi();
			//get the list of subscriber
			$listID = "d2ae77bf0e";
			$url = "lists/$listID/members?count=1000";
			$segments = $MailChimp->get($url);
			if ($testingBypass)
			{
				$bypassEmail = "katejhowe@gmail.com";
				//$bypassEmail="kumar.saurabh@sourcesoftsolutions.com";
				foreach ($segments['members'] as $memval)
				{

					if ($memval['email_address'] == "$bypassEmail")
					{
						//if($memval['status']=='subscribed'){
						$email_address = $memval['email_address'];
						$tags = $memval['tags'];

						$all_members[] = [

						'email' => $email_address, 'tag' => $memval['tags'], 'fname' => $memval['merge_fields']['FNAME'], 'lname' => $memval['merge_fields']['LNAME'], ];
					}
				}
			}
			else
			{

				foreach ($segments['members'] as $memval)
				{

					if ($memval['status'] == 'subscribed')
					{
						$email_address = $memval['email_address'];
						$tags = $memval['tags'];

						$all_members[] = [

						'email' => $email_address, 'tag' => $memval['tags'], 'fname' => $memval['merge_fields']['FNAME'], 'lname' => $memval['merge_fields']['LNAME'], ];
					}

				}
			}
			$query = $this
                        ->query
                        ->setContentType("midweekEmail");
            $ent_value = $this
                    ->client
                    ->getEntries($query)[0];
                    
            $emailSubjectLine = $ent_value->topic;
           // echo '<pre>'; print_r($ent_value->introText->getContent()[0]->getContent()[0]->getValue()); echo '</pre>'; exit;
			foreach ($all_members as $user)
                    {
						
						$email = $user['email'];
						try
                            {
                                Mail::send('mailer.midweekemail', ["data" => $ent_value, 'fname' => $user['fname']], function ($message) use ($user, $emailSubjectLine)
                                {

                                    $message->to($user['email'])->subject($emailSubjectLine);
                                });
                                $mail_ret[] = ['email' => $email, 'message' => 'success'];

                            }
                            catch(\Exception $e)
                            {

                                $message_err = $e->getMessage();
                                $mail_ret[] = ['email' => $email, 'message' => 'fail', 'reason' => $message_err];

                            }
                          
				}
				
			 if (!empty($mail_ret))
				{
					$return['success'] = $mail_ret;
				}
				else
				{
					$return['fail'] = "User grade not allowed by mailer";
				}
		
			
		}
//code ends here
    public function NewMailerCron($testingBypass = NULL)
    {

        //automatic login email
        $string = "MAILER";
        $encrypted = \Illuminate\Support\Facades\Crypt::encrypt($string);

        //echo $decrypted_string = \Illuminate\Support\Facades\Crypt::decrypt($encrypted);
        //dd($encrypted);
        //Testing purpose Next month data checking
        if ($testingBypass)
        {
            $currentMonth = date('n', strtotime('+1 month'));
        }
        else
        {
            $currentMonth = date("n");
        }
		//echo $currentMonth;
        $month_id = $this->month_ids($currentMonth);
		//echo"-----------";
      	//echo $month_id;die;
        $Mainquery3 = new \Contentful\Delivery\Query();

        $year = date("Y");
        //$dt = Carbon::parse('2021-08-07');
        //$dt = Carbon::now();
        //$weekNumberInMonth = $dt->weekNumberInMonth;
		//$date = date("2020-11-28");
      	$date = date("Y-m-d");
      	$weekNumberInMonth = $this->getWeeks($date);
        //echo $weekNumberInMonth;die;
        if (empty(!$testingBypass))
        {
            $query = $Mainquery3->setContentType("emailWrapper")
            //->where("sys.id","$detail_id")
            // ->orderBy("fields.order",true)
            //->where("include", "0")
            //->where("skip", "1")
            //->setSkip(1)
            //->where("order", "fields.order")
            //->orderBy('-sys.createdAt')
            //->setLimit(10)
            

            
                ->where("fields.month.sys.id", $month_id);
            //->where("sys.publishedCounter[gte]","1");
            

            
        }
        else
        {
            $query = $Mainquery3->setContentType("emailWrapper")
                ->where("fields.orderInMonth", $weekNumberInMonth)->where("fields.month.sys.id", $month_id);
            //->where("sys.publishedCounter[gte]","1");
            
        }
		//dd($query);die;
        $ent_value = $this
            ->client
            ->getEntries($query);
        //dd($ent_value);die;
        $MailChimp = Newsletter::getApi();
        //$listIDTest="caa284fd88";
        $listID = "d2ae77bf0e";
        $url = "lists/$listID/members?count=1000";
        $segments = $MailChimp->get($url);
        //dd($segments);
        //die;
        //$testingBypass=false;
        if ($testingBypass)
        {
            $bypassEmail = "katejhowe@gmail.com";
            //$bypassEmail="kumar.saurabh@sourcesoftsolutions.com";
            foreach ($segments['members'] as $memval)
            {

                if ($memval['email_address'] == "$bypassEmail")
                {
                    //if($memval['status']=='subscribed'){
                    $email_address = $memval['email_address'];
                    $tags = $memval['tags'];

                    $all_members[] = [

                    'email' => $email_address, 'tag' => $memval['tags'], 'fname' => $memval['merge_fields']['FNAME'], 'lname' => $memval['merge_fields']['LNAME'], ];
                }
                //}
                

                
            }
        }
        else
        {

            foreach ($segments['members'] as $memval)
            {

                if ($memval['status'] == 'subscribed')
                {
                    $email_address = $memval['email_address'];
                    $tags = $memval['tags'];

                    $all_members[] = [

                    'email' => $email_address, 'tag' => $memval['tags'], 'fname' => $memval['merge_fields']['FNAME'], 'lname' => $memval['merge_fields']['LNAME'], ];
                }

            }
        }

        //dd($all_members);die;
        foreach ($ent_value as $key => $ent_value)
        {

            //$grade=$ent_value->get('grade',null, false);
            $sendToGrades = $ent_value->get('sendToGrades', null, false);

            $name = $ent_value->get('emailSequence');

            $whatsComingUp = $ent_value->get('whatsComingUp', null, false);

            $whatsComingUparray = [];

            if (!empty($whatsComingUp))
            {

                foreach ($whatsComingUp as $wkey => $wwvalue)
                {

                    $wvalue = $this
                        ->client
                        ->resolveLink($wwvalue);

                    $wTitle = $wvalue->get('title');
                    $introText = $wvalue->get('introText');
                    if (!empty($introText))
                    {
                        $renderintroText = $this
                            ->renderer
                            ->render($introText);
                    }
                    else
                    {
                        $renderintroText = "";
                    }

                    $whatsComingUparray[] = ['comingUpTitle' => $wTitle, 'comingUpDesc' => $renderintroText];
                }
            }
            else
            {
                $whatsComingUparray = [];
            }

            //   if(!empty($grade))
            //    {
            //      try {
            //     $tIvalueU=$this->client->resolveLink($grade);
            //     $grade=$tIvalueU->get('grade');
            

            //     }catch(Exception $e)
            //     {
            //      $grade="";
            //     }
            //    }else{
            //      $grade="";
            //    }
            

            $month = $ent_value->get('month', null, false);
            if (!empty($month))
            {

                try
                {

                    $monthU = $this
                        ->client
                        ->resolveLink($month);

                    $monthNumber = $monthU->get('monthNumber');

                }
                catch(Exception $e)
                {
                    $monthNumber = "";
                }

            }
            else
            {
                $monthNumber = "";
            }
			
          	if ($currentMonth == $monthNumber && !empty($sendToGrades))
            {
                $orderInMonth = $ent_value->get('orderInMonth', null, false);

                //$todays_date=date("d-M-Y", strtotime("tomorrow"));
                $givenSatDAte = date("d-M-Y", strtotime("$orderInMonth saturday $year-$currentMonth"));
                //$givenSatDAte=date("d-M-Y", strtotime("$orderInMonth tuesday $year-$currentMonth"));
                // echo  $grade;
                

                if ($testingBypass)
                {
                    $todays_date = $givenSatDAte;
                }
                else
                {
                    $todays_date = date("d-M-Y", strtotime("today"));
                  	//$todays_date = $givenSatDAte;
                }
				//echo $todays_date;
              	//echo"-----------";
              	//echo $givenSatDAte;
                //checking postcard date
                if ($todays_date == $givenSatDAte)
                {
                    $contentCategory = $ent_value->get('contentCategory', null, false);
                    if (!empty($contentCategory))
                    {
                        try
                        {
                            $contentCategoryU = $this
                                ->client
                                ->resolveLink($contentCategory);

                            $category = $contentCategoryU->get('contentType');
                        }
                        catch(Exception $e)
                        {
                            $category = "";
                        }
                    }
                    else
                    {
                        $category = "";
                    }

                    if (!empty($sendToGrades))
                    {
                        $TotalAllowedGrade = [];
                        foreach ($sendToGrades as $sendg)
                        {
                            try
                            {

                                $tIvalueU = $this
                                    ->client
                                    ->resolveLink($sendg);

                                $TotalAllowedGrade[] = $tIvalueU->get('grade');

                            }
                            catch(Exception $e)
                            {
                                $TotalAllowedGrade = [];
                            }

                        }

                    }
                    else
                    {
                        $TotalAllowedGrade = [];
                    }

                    $postcard = $ent_value->get('postcard', null, false);

                    if (!empty($postcard))
                    {

                        //$Ideaarray=[];
                        //echo '<pre>';print_r($Ideaarray);
                        $postcardU = "";
                        try
                        {
                            $postcardU = $this
                                ->client
                                ->resolveLink($postcard);

                            $entry_id = $postcardU->getId();

                            $detail_page_hyper_link_url = url("details/$entry_id");

                            $pcontentType = $postcardU->get('contentType', null, false);
                            if (!empty($pcontentType))
                            {
                                try
                                {
                                    $contentCategoryU = $this
                                        ->client
                                        ->resolveLink($pcontentType);

                                    $pcategory = $contentCategoryU->get('contentType');
                                }
                                catch(Exception $e)
                                {
                                    $pcategory = "";
                                }
                            }
                            else
                            {
                                $pcategory = "";
                            }

                            $emailSubjectLine = $postcardU->get('emailSubjectLine');

                            $contextAndIssue = $postcardU->get('contextAndIssue');

                            if (!empty($contextAndIssue))
                            {
                                $contextAndIssue = $this
                                    ->renderer
                                    ->render($contextAndIssue);
                            }
                            else
                            {
                                $contextAndIssue = "";
                            }

                            //    $goodNews=$postcardU->get('goodNews');
                            

                            //    if (!empty($goodNews)) {
                            //        $goodNews= $this->renderer->render($goodNews);
                            //    } else {
                            //        $goodNews="";
                            //    }
                            

                            $illustration = $postcardU->get('illustration', null, false);
                            if (!empty($illustration))
                            {
                                $illustration_u = $this
                                    ->client
                                    ->resolveLink($illustration);
                                $illustration_url = $illustration_u->getFile()
                                    ->getUrl();
                            }
                            else
                            {
                                $illustration_url = "";
                            }

                            $audioLink = $postcardU->get('audioLink', null, false);
                            if (!empty($audioLink))
                            {
                                $audioLink_u = $this
                                    ->client
                                    ->resolveLink($audioLink);

                                $audioLink_url = $audioLink_u->getFile()
                                    ->getUrl();
                            }
                            else
                            {
                                $audioLink_url = "";
                            }

                            $developmentCategory = $postcardU->get('contentType', null, false);

                            if (!empty($developmentCategory))
                            {
                                $developmentCategoryU = $this
                                    ->client
                                    ->resolveLink($developmentCategory);
                                $catID = $developmentCategoryU->getID();
                                $developmentCategory_name = $developmentCategoryU->get('contentType');

                            }
                            else
                            {
                                $developmentCategory_name = "";
                                $catID = "";

                            }

                            $whatsGoingOnText = $postcardU->get('whatsGoingOnText');

                            if (!empty($whatsGoingOnText))
                            {
                                $whatsGoingOnText = $this
                                    ->renderer
                                    ->render($whatsGoingOnText);
                            }
                            else
                            {
                                $whatsGoingOnText = "";
                            }

                            //echo '<pre>';print_r($Ideaarray);
                            $recentRelatedPosts = $postcardU->get('recentRelatedPosts', null, false);

                            foreach ($recentRelatedPosts as $rkey => $rvalue)
                            {
                                $resolvePost = $this
                                    ->client
                                    ->resolveLink($rvalue);

                                $resolvePostHead = $resolvePost->get('title');

                                $resolvePostHeadArr[] = ['resolvePostHead' => $resolvePostHead, 'post_id' => $resolvePost->getId()

                                ];
                            }

                            $usefulTools = $postcardU->get('usefulTools');
                            $Toolarray = [];

                            foreach ($usefulTools as $ukey => $uvalue)
                            {
                                $toolName = $uvalue->get('name');

                                $toolPreviewImage = $uvalue->get('toolIcon', null, false);
                                if (!empty($toolPreviewImage))
                                {
                                    $toolPreviewImage_u = $this
                                        ->client
                                        ->resolveLink($toolPreviewImage);

                                    $toolPreviewImage_url = $toolPreviewImage_u->getFile()
                                        ->getUrl();
                                }
                                else
                                {
                                    $toolPreviewImage_url = "";
                                }
                                $Toolarray[] = ['toolName' => $toolName, 'toolIcon' => $toolPreviewImage_url, 'id' => $uvalue->getId() ];
                            }

                            //contextAndIssue
                            //audiolink
                            

                            // $category=$postcardU->get('contentType');
                            
                        }
                        catch(Exception $e)
                        {
                            $category = "";
                        }
                    }
                    else
                    {
                        $category = "";
                    }

                    $dynamicContentColor = $this->colorByCategory($pcategory);
                    $dynamicBackgroundColor = $this->BackgroudcolorByCategory($pcategory);
                    $logo_url = $this->logoByCategory($pcategory);

                    $site_url = url('/');
                    $logoimage = "<a target='_blank' href='$site_url'>" . '<img style="display:block; border:none;width: 320px;"  src="' . $logo_url . '">' . "</a>";

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
                    if (!empty($illustration_url))
                    {
                        $illuImage = '<img style="display:block; border:none;width:100%;"  src="' . 'https:' . $illustration_url . '">';

                    }
                    else
                    {
                        $illuImage = "";
                    }

                    //dd($illuImage);
                    

                    if (!empty($audioLink_url))
                    {
                        //$illuImage='"<img height="200" src="'.substr($illustration_url,2).'">';
                        $audioData = "Prefer to listen?" . '<a style="color: rgba(51,51,51,0.5);"  href="' . 'https:' . $audioLink_url . '">' . "Click for audio" . "</a>";
                    }
                    else
                    {
                        $audioData = "";
                    }

                    $name_data = "<div style='color:$dynamicContentColor;font-size:22px'>" . 'Hi' . ' ' . '*|FNAME|*,' . "</div>";

                    if (!empty($contextAndIssue))
                    {
                        $contextAndIssue = "<div style='padding:0;margin:0;color:$dynamicContentColor;font-size:22px;line-height:28px;'>" . $contextAndIssue . "</div>";
                    }
                    else
                    {
                        $contextAndIssue = "";
                    }
                    //echo $contextAndIssue;
                    //echo $name_data;
                    //exit;
                    //    if (!empty($goodNews)) {
                    //        $goodNews="<div style='padding:0;margin:0;color:$dynamicContentColor;font-size:22px;line-height:28px;'>".$goodNews."</div>";
                    //    } else {
                    //        $goodNews="";
                    //    }
                    if (!empty($whatsGoingOnText))
                    {
                        $whatsGoingOnText = $whatsGoingOnText;
                        $whatsGoingOnHeading = "<h3 style='padding:10px 0;margin:0;color:$dynamicContentColor;line-height:28px;'>- - - - WHAT'S GOING ON? - - - - </h3>";
                    }
                    else
                    {
                        $whatsGoingOnText = "";
                        $whatsGoingOnHeading = "";
                    }

                    if (!empty($whatsComingUparray))
                    {

                        //$RELATED_post="<p>".  ."<p>";
                        $whatscomingUpHeading = "<h3 style='padding:20px 0 0;margin:0;color:$dynamicContentColor;line-height:24px;'>- - - - COMING UP - - - - </h3>";

                        $comingTitle = "";
                        foreach ($whatsComingUparray as $wtKey => $wtPost)
                        {

                            $comingTitle .= "<p>" . $wtPost['comingUpTitle'] . "</p>";

                        }
                    }
                    else
                    {
                        $comingTitle = "";
                        $whatscomingUpHeading = "";
                    }

                    if (!empty($resolvePostHeadArr))
                    {

                        //$RELATED_post="<p>".  ."<p>";
                        $RELATED_post_cont = "";
                        foreach ($resolvePostHeadArr as $resolvePostV)
                        {

                            $post_id = $resolvePostV['post_id'];

                            $url_ = url("details/$post_id");
                            $RELATED_post_cont .= "<p style='padding:0 0 5px;'>" . "<a style='color:#5c5f60' href='$url_?m=*|EMAIL|*&e=$encrypted' >" . $resolvePostV['resolvePostHead'] . "</a>" . "</p>";
                        }

                        $relatedPostHeading = "<h3 style='padding:10px 0 0;margin:0;color:$dynamicContentColor;line-height:24px;'>- - - - IN CASE YOU MISSED - - - - </h3>";
                    }
                    else
                    {
                        $relatedPostHeading = "";
                        $RELATED_post_cont = "";
                    }

                    // dd($RELATED_post_cont);
                    $supportingYourChild = $postcardU->get('supportingYourChild');

                    if (!empty($supportingYourChild))
                    {
                        $supportingYourChild = $this
                            ->renderer
                            ->render($supportingYourChild);
                    }
                    else
                    {
                        $supportingYourChild = "";
                    }

                    if (!empty($supportingYourChild))
                    {
                        $supportingYourChild = $supportingYourChild;
                        $supportingYourChildHeading = "<h3 style='padding:10px 0;margin:0;color:$dynamicContentColor;line-height:24px;'>- - - - SUPPORTING YOUR SELF - - - -</h3>";
                    }
                    else
                    {
                        $supportingYourChild = "";
                        $supportingYourChildHeading = "";
                    }

                    if (!empty($Toolarray))
                    {

                        //$RELATED_post="<p>".  ."<p>";
                        $usefulToolsContent = '';
                        foreach ($Toolarray as $resolveToolarray)
                        {
                            // $resolveURL= substr($resolveToolarray['toolIcon'], 2);
                            $resolveIcon = $resolveToolarray['toolIcon'];
                            $tid = $resolveToolarray['id'];
                            $tool_detail_page_hyper_link_url = url("toolkitDetails/$tid");

                            $useful_tools_hyper_link_url = url("toolkit");

                            $resolveURL = 'https:' . $resolveIcon;
                            //$icon_image='<span><a href=""<img style="display:block; border:none;width:80px;" src="'.$resolveURL.'">'."<br/>";
                            $icon_image = '<span><a style="' . 'color:#373737;text-decoration:none' . '" href="' . $tool_detail_page_hyper_link_url . '" ><img style="display:block; border:none;width:80px;" src="' . $resolveURL . '">' . "<br/>";

                            $usefulToolsContent .= $icon_image . $resolveToolarray['toolName'] . '</a>' . '</span>';
                        }

                        $usefulToolsHeading = "<h3 style='padding:10px 0;margin:0;line-height:24px;color:$dynamicContentColor;'>- - - - <a style='color:$dynamicContentColor;text-decoration:none;' href='$useful_tools_hyper_link_url'>USEFUL TOOLS </a>- - - - </h3>";
                    }
                    else
                    {
                        $usefulToolsHeading = "";
                        $usefulToolsContent = "";
                    }

                    $Mainquery4 = new \Contentful\Delivery\Query();
                    $query_lattest = $Mainquery4->setContentType("postcard")
                    //->orderBy('-sys.createdAt')
                    
                        ->orderBy('-sys.updatedAt')
                        ->setLimit(3);
                    //->where("sys.publishedCounter[gte]","1");
                    $data_lattest = $this
                        ->client
                        ->getEntries($query_lattest);
                    //dd($data_lattest);
                    $latt_arr = [];
                    foreach ($data_lattest as $latK => $latV)
                    {
                        $latTitle = $latV->get('title');
                        $lid = $latV->getID();
                        $detail_page = url("details/$lid");
                        $latt_arr[] = ['title' => $latTitle, 'lid' => $detail_page];

                    }

                    // return view('mailer.mailer_layout')
                    //   ->with('data',$dynamicArray);
                    //   exit;
                    if (!empty($TotalAllowedGrade))
                    {
                        sort($TotalAllowedGrade);
                    }

                    //dd($TotalAllowedGrade);
                    $get_all_grades_ideas = $this->grades_logic();

                    //dd($get_all_grades_ideas);
                    //exit;
                    // if($testingBypass)
                    // {
                    //     $testing_allowed_email="katejhowe@gmail.com";
                    //    $test= explode(',',$testing_allowed_email);
                    //     $users = DB::table('users')
                    //     ->join('form_submissions', 'users.id', '=', 'form_submissions.user_id')
                    //     ->select('form_submissions.selected_grades',
                    //      'users.email','users.name')
                    //     ->where('users.type','2')->where('active','1')
                    //     ->whereIn('users.email', $test)
                    //     ->get();
                    // }else{
                    

                    //     $users = DB::table('users')
                    //     ->join('form_submissions', 'users.id', '=', 'form_submissions.user_id')
                    //     ->select('form_submissions.selected_grades',
                    //      'users.email','users.name')
                    //     ->where('users.type','2')->where('active','1')
                    //     ->get();
                    // }
                    //dd($all_members);
                    //dd($users);
                    

                    foreach ($all_members as $user)
                    {

                        $users_selected_grades = $user['tag'];
                        //$users_selected_grades=json_decode($user->selected_grades);
                        //dd($users_selected_grades);
                        //$users_g=array_flip($users_selected_grades);
                        //dd($TotalAllowedGrade);
                        $userGrades = [];
                        foreach ($users_selected_grades as $ugk => $ugv)
                        {
                            if (Is_Numeric($ugv['name']))
                            {
                                if (in_array($ugv['name'], $TotalAllowedGrade))
                                {
                                    $userGrades[] = $ugv['name'];
                                }
                            }
                        }
                        if (!empty($userGrades))
                        {
                            sort($userGrades);
                        }

                        $sharingSnippet = $postcardU->get('sharingSnippet');
                        if (empty($sharingSnippet))
                        {
                            $sharingSnippet = "";
                        }

                        $facebookPostLink = $postcardU->get('facebookPostLink');
                        if (empty($facebookPostLink))
                        {
                            $facebookPostLink = "";
                        }
                        $instagramPostLink = $postcardU->get('instagramPostLink');

                        if (empty($instagramPostLink))
                        {
                            $instagramPostLink = "";
                        }

                        if ($catID == '7dO2Fb2ypfgUDFOsld7OqO')
                        {
                            $supportingyourself = 1;

                            $ideas = $postcardU->get('ideas', null, false);
                            $Ideaarray = [];
                            foreach ($ideas as $ikey => $iivalue)
                            {

                                $ivalue = $this
                                    ->client
                                    ->resolveLink($iivalue);

                                $ideaTitle = $ivalue->get('ideaTitle');
                                $idea = $ivalue->get('idea');
                                $renderIdea = $this
                                    ->renderer
                                    ->render($idea);

                                $Ideaarray[] = ['ideaTitle' => $ideaTitle, 'ideaDesc' => $renderIdea];
                            }

                            if (!empty($Ideaarray))
                            {

                                $ideaDesc = "";
                                foreach ($Ideaarray as $ideaKey => $ideaPost)
                                {

                                    $ideaDesc .= "<p style='font-family: Arial, Helvetica, sans-serif;padding:0;margin:0;line-height:24px;color:$dynamicContentColor'><a target='_blank' style='color:$dynamicContentColor' href='$detail_page_hyper_link_url?m=*|EMAIL|*&e=$encrypted'> <strong>" . ($ideaKey + 1) . '.' . ' ' . $ideaPost['ideaTitle'] . "</strong></a></p>";

                                }
                            }
                            else
                            {
                                $ideaDesc = "";
                            }

                            $showIdea = ['ideasContent' => $ideaDesc, ];

                        }
                        else
                        {

                            $ideaDesc = "";
                            $supportingyourself = 0;
                            if (!empty($userGrades))
                            {
                                $atThisAgeLinked = $postcardU->get('atThisAgeLinked');
                                $Atthisarray = [];
                                foreach ($atThisAgeLinked as $atThisAgekey => $atThisAgeValue)
                                {

                                    $grade = $atThisAgeValue->get('grade');

                                    foreach ($grade as $atGrade)
                                    {

                                        $this_grade = $atGrade->get('grade');

                                        if (in_array($this_grade, $userGrades))
                                        {
                                            $at_this_age = $atThisAgeValue->get('atThisAge');
                                            $render_at_this = $this
                                                ->renderer
                                                ->render($at_this_age);

                                            $Atthisarray[$this_grade][] = [

                                            'renderAtthis' => $render_at_this

                                            ];
                                        }

                                    }

                                }
                                $ideas = $postcardU->get('ideas');
                                $Ideaarray = [];
                                // dd($grade_arr_id);
                                foreach ($ideas as $ikey => $ivalue)
                                {

                                    $ideaForGrades = $ivalue->get('ideaForGrades');

                                    foreach ($ideaForGrades as $deaForg)
                                    {

                                        $this_grade = $deaForg->get('grade');
                                        $ideaTitle = $ivalue->get('ideaTitle');
                                        $idea = $ivalue->get('idea');
                                        $renderIdea = $this
                                            ->renderer
                                            ->render($idea);

                                        if (in_array($this_grade, $userGrades))
                                        {
                                            $Ideaarray[$this_grade][] = ['title' => $ideaTitle, 'ideaDesc' => $renderIdea];
                                        }

                                    }
                                }

                            }

                            $showIdea = ['Ideaarray' => @$Ideaarray, 'Atthisarray' => @$Atthisarray, ];

                        }

                        $sharingSnippet = $postcardU->get('sharingSnippet');
                        if (empty($sharingSnippet))
                        {
                            $sharingSnippet = "";
                        }

                        $facebookPostLink = $postcardU->get('facebookPostLink');
                        if (empty($facebookPostLink))
                        {
                            $facebookPostLink = "";
                        }
                        $instagramPostLink = $postcardU->get('instagramPostLink');

                        if (empty($instagramPostLink))
                        {
                            $instagramPostLink = "";
                        }

                        //$Ideaarray
                        //dd($userGrades);
                        if (!empty($userGrades) || !empty($supportingyourself))
                        {

                            $find1 = '*|FNAME|*';

                            $replace1 = ucfirst($user['fname']);
                            $replaced_name_data = str_replace($find1, $replace1, $name_data);

                            $email = $user['email'];

                            $dynamicArray = ['name' => $replaced_name_data, 'contentAndIssue' => $contextAndIssue,
                            //'goodNews'=>$goodNews,
                            'illustrationImage' => $illuImage, 'whatsGoingOnHeading' => $whatsGoingOnHeading, 'whatsGoingOnContent' => $whatsGoingOnText, 'supportingYourChildHeading' => $supportingYourChildHeading, 'supportingYourChildContent' => $supportingYourChild, 'whatscomingUpContent' => $comingTitle, 'whatscomingUpHeading' => $whatscomingUpHeading, 'relatedPostHeading' => $relatedPostHeading, 'relatedPostContent' => $RELATED_post_cont,

                            'usefulToolsHeading' => $usefulToolsHeading, 'usefulToolsContent' => $usefulToolsContent, 'audioLink' => $audioData, 'logoimage' => $logoimage, 'users_selected_grades' => $userGrades, 'dynamicContentColor' => $dynamicContentColor, 'dynamicBackgroundColor' => $dynamicBackgroundColor, 'detail_page_hyper_link_url' => $detail_page_hyper_link_url, 'encrypted' => $encrypted, 'email' => $email, 'lattest_arr' => $latt_arr, 'showIdea' => $showIdea, 'supportingyourself' => $supportingyourself, 'sharingSnippet' => $sharingSnippet, 'instagramPostLink' => $instagramPostLink, 'facebookPostLink' => $facebookPostLink

                            ];

                            //dd($dynamicArray);
                            //dd($supportingyourself);
                            //  return view('mailer.mailer_layout')
                            //         ->with('data',$dynamicArray)->with('extraIdeas',$get_all_grades_ideas);
                            //  exit;
                            

                            //dd($dynamicArray);die;
                            

                            try
                            {
                                Mail::send('mailer.mailer_layout', ["data" => $dynamicArray, 'extraIdeas' => $get_all_grades_ideas], function ($message) use ($user, $emailSubjectLine)
                                {

                                    $message->to($user['email'])->subject($emailSubjectLine);
                                });
                                $mail_ret[] = ['email' => $email, 'message' => 'success'];

                            }
                            catch(\Exception $e)
                            {

                                $message_err = $e->getMessage();
                                $mail_ret[] = ['email' => $email, 'message' => 'fail', 'reason' => $message_err];

                            }

                        }

                    }
                    if (!empty($mail_ret))
                    {
                        $return['success'] = $mail_ret;
                    }
                    else
                    {
                        $return['fail'] = "User grade not allowed by mailer";
                    }

                }
                else
                {
                    $return['fail'] = "This postcard is not for todays date";
                }

            }
            else
            {

                $return['fail'] = "This postcard is not for this month or grades not allowed";

            }

        }
        //dd($return);
        if (empty($return))
        {

            return $return['fail'] = "Email wrapper does not found";
        }
        else
        {
            return $return;
        }

        //end foreach
        
    }

}


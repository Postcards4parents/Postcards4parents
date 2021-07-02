<?php
namespace App\Helper;
use Illuminate\Support\Facades\Auth;
use App\User;
use Session;
use App\category;
use Illuminate\Support\Facades\DB;
use App\subcategory;
use Newsletter;

class AuthData
{
    
    public static function shout()
    {
        //return "AJAY  HJKLJ";
         //Session::put('user', Auth::user()->id);
        // session(['user1' => 'Ann']);
         //dd(Session::get('user'));
        
         //dd(Auth::user());

       return User::find(7);
      

    }
    public static function category()
    {
        $all=category::where('cat_id','=',0)->pluck('name','id');
        return $all;
    }
    public static function subcategory($cat_id)
    {
        $all=category::where('cat_id','>',1)->where('cat_id','=',$cat_id)->pluck('name','id');
        return $all;
    }
    
    public static function SendGetInTouchMail( $listID,$template_id, $segment_id,$email,$message)
    {
        // $segment_id=262121;
        // $template_id=101069;
       // $listID="d2ae77bf0e";

        $MailChimp = Newsletter::getApi();
        $fromName="Postcard";
        $replyTo="hello@postcardsforparents.com";
        $subject="Get In Touch Mail";
        

       

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
        
        $campaign_id=$response['id'];
        $url="campaigns/$campaign_id/content";
        
        $parameter=[

            'template'=>[
                'id'=>$template_id,
                'sections'=>[
                    'email'=>$email,
                    'message'=>$message

                ]
            ]
        ];

         $compaignForTemplate=$MailChimp->put($url,$parameter);
         if(!empty($compaignForTemplate['plain_text']))
         {
            $send=$MailChimp->post("campaigns/$campaign_id/actions/send");
            return true; 
        }else{

        return false;
         }


    }

    public static function SendSignupMail( $email,$fname,$lname,$grade)
    {
        // $listID=caa284fd88;
       
        // $segment_id=262305;
        //  $template_id=101185;
        // $listID="d2ae77bf0e";
        $MailChimp = Newsletter::getApi();
        Newsletter::subscribeOrUpdate($email, ['FNAME'=>$fname, 'LNAME'=>$lname], 'list3' , ['tags' => $grade]);
        //create new template
       //    $url="templates";
    //    $parameter=[
    //        'name'=>'Signup Template',
    //        'html'=>view('email_templates.signup')->render()
    //    ];

    //    $template = $MailChimp->post($url,$parameter);
       
      
    //    $subs= Newsletter::subscribeOrUpdate($email, ['FNAME'=>$fname, 'LNAME'=>$lname], 'list2' , ['tags' => ['new']]);
       
        
    //     $fromName="Postcard";
    //     $replyTo="hello@postcardsforparents.com";
    //     $subject="Signup Mail from Postcard";
        

       

    //     $defaultOptions = [
    //         'type' => 'regular',
    //         'recipients' => [
    //             'list_id' => $listID,
    //             'segment_opts'=>[
    //                 'saved_segment_id'=>$segment_id,

    //             ]
                
    //         ],
    //         'settings' => [
    //             'subject_line' =>$subject,
    //             'from_name' =>$fromName,
    //             'reply_to' =>$replyTo,
    //             'template_id'=>$template_id
    //         ],
    //     ];

        

    //     $response = $MailChimp->post('campaigns', $defaultOptions);
        
    //     $campaign_id=$response['id'];
    //     $send=$MailChimp->post("campaigns/$campaign_id/actions/send");
       
        
         

       
    //     if(!empty($send)){
    //         sleep(5);
    //         Newsletter::unsubscribe($email,'list2');
    //     }
        


    }

    public static function SendResetPasswordMail( $listID,$template_id, $segment_id,$email,$fname,$link1)
    {
        // $listID=caa284fd88; 
        // $segment_id=262305;
        //  $template_id=101185;
       // $listID="d2ae77bf0e";
       $MailChimp = Newsletter::getApi();
        //create new template
       //    $url="templates";
    //    $parameter=[
    //        'name'=>'Signup Template',
    //        'html'=>view('email_templates.signup')->render()
    //    ];

    //    $template = $MailChimp->post($url,$parameter);
       
      
       $subs= Newsletter::subscribeOrUpdate($email, ['FNAME'=>$fname], 'list2' , ['tags' => ['new']]);
       
        
        $fromName="Postcard";
        $replyTo="hello@postcardsforparents.com";
        $subject="Signup Mail from Postcard";
        

       

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
            sleep(5);
            Newsletter::unsubscribe($email,'list2');
        }

        
        


    }

    public static function SendProfileUpdateMail($email,$fname,$lname,$grade)
    {
        // $listID=caa284fd88; 
        // $segment_id=262305;
        //  $template_id=101185;
       // $listID="d2ae77bf0e";
       $MailChimp = Newsletter::getApi();
       
       
      
       
    
       $return=Newsletter::getMember($email,'list3');

        
        if ($return['status'] !='404') {
            foreach ($return['tags'] as $tag) {
                $old_tags[]=[
                'name'=>$tag['name'],
                'status' => 'inactive'
                ];
            }
        }
        $subscriber_hash=md5(strtolower($email));
       
        $tag_url="lists/d2ae77bf0e/members/$subscriber_hash/tags";
       if(!empty($old_tags)){
        
        
        $remove_tags=['tags'=>$old_tags];
        
        $remove=$MailChimp->post($tag_url,$remove_tags);
       }

       foreach ($grade as $gd) {
        $new_tags[]=[
        'name'=>$gd,
        'status' => 'active'
        ];
      }

        $add_tags=['tags'=>$new_tags];
        
        $add=$MailChimp->post($tag_url,$add_tags);

       
        Newsletter::subscribeOrUpdate($email, ['FNAME'=>$fname, 'LNAME'=>$lname], 'list3');
        
        





        
    //     $fromName="Postcard";
    //     $replyTo="hello@postcardsforparents.com";
    //     $subject="Profile Update Mail from Postcard";
        

       

    //     $defaultOptions = [
    //         'type' => 'regular',
    //         'recipients' => [
    //             'list_id' => $listID,
    //             'segment_opts'=>[
    //                 'saved_segment_id'=>$segment_id,

    //             ]
                
    //         ],
    //         'settings' => [
    //             'subject_line' =>$subject,
    //             'from_name' =>$fromName,
    //             'reply_to' =>$replyTo,
    //             'template_id'=>$template_id
    //         ],
    //     ];

        

    //     $response = $MailChimp->post('campaigns', $defaultOptions);
       
    //     $campaign_id=$response['id'];
    //     $send=$MailChimp->post("campaigns/$campaign_id/actions/send");
        
       
    //    Newsletter::subscribeOrUpdate($email, ['FNAME'=>$fname, 'LNAME'=>$lname], 'list3' , ['tags' => $grade]);

       
    //     if(!empty($send)){
    //         sleep(5);
    //         Newsletter::unsubscribe($email,'list2');
    //     }
        


    }


}
?>
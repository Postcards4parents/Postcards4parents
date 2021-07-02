<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post Card</title>
    
  <style type="text/css">
    h3{
      /*@editable*/font-family:Helvetica;
      text-transform:uppercase;
      font-size:14px;
      letter-spacing:2px;
    }
    p{
      margin:0;
      padding:0 0 15px;
    }
    .goingtxt p{
      padding-bottom:15px;
    }
    .toolstd span{
      display:inline-block;
      vertical-align:middle;
      margin:0 15px;
    }
  @media only screen and (max-width:480px){
    p{
      /*@editable*/font-size:24px !important;
      line-height:30px;
    }

} @media only screen and (max-width:480px){
    .paraP div,.paraP p{
      /*@editable*/font-size:30px !important;
      line-height:36px;
    }

} @media only screen and (max-width:480px){
    h3{
      /*@editable*/font-size:24px !important;
    }

}</style></head>
  <body style="padding:0;margin:0 15px;font-family: Arial, Helvetica, sans-serif;font-size:14px;color:#373737;">
    @php
    //dd($data['lattest_arr']);
     //echo '<pre>';print_r($extraIdeas);
     //echo '<pre>';print_r($data['users_selected_grades']);
     //exit;   
    @endphp
    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" style="padding:0 15px;">
      <tbody>
        <tr>
          <td align="left" valign="middle"><img src="https://gallery.mailchimp.com/0c1d7620b470a58d26b8ea100/images/33902026-3159-4db0-926c-1f7c8d749ca8.png" style="display:block; border:none;max-width:100%;" alt="33902026-3159-4db0-926c-1f7c8d749ca8.png">
          </td>
        </tr>
        <tr>
          <td align="left" valign="middle" style="padding:10px 0;font-family:Arial, Helvetica, sans-serif;color:rgba(51,51,51,0.5);font-size:14px;">Be sure to join us on <a href="https://www.instagram.com/postcardsforparents" target="_blank" style="color:rgba(51,51,51,0.5);">Instagram</a> and <a href="https://www.facebook.com/Postcards-for-Parents-820084901661452" target="_blank" style="color:rgba(51,51,51,0.5);">Facebook!</a>
        </td>
      </tr>
      <tr>
        <td align="left" valign="middle" style="padding:5px 0;font-size:14px;color:rgba(51,51,51,0.5);">
        <span >{!! $data['audioLink'] !!}</span>
        </td>
        
      </tr>
      <tr>
        <td align="right" style="padding:10px 0;"  valign="middle">
           {!! $data['logoimage'] !!}
        </td>
      </tr>
      <tr>
        <td align="left" valign="middle">
          <span class="paraP" style="font-family:Georgia, Times, 'Times New Roman', serif;">{!! $data['name'] !!}</span>
        <span class="paraP" style="font-family:Georgia, Times, 'Times New Roman', serif;">{!! $data['contentAndIssue'] !!}</span>
        
        </td>
      </tr>
      <tr>
        <td align="left"  valign="middle">
        {!! $data['illustrationImage'] !!}
        </td>
      </tr>
      <tr>
        <td align="left" valign="middle">
        <span mc:edit="whatsgoingonheading">{!! $data['whatsGoingOnHeading'] !!}</span>
          <div class="goingtxt" mc:edit="whatsgoingoncontent" style="padding:0;margin:0;line-height:24px;font-family:Arial, Helvetica, sans-serif;color:#5C5F60;font-size:15px;">
          {!! $data['whatsGoingOnContent'] !!}
          </div>
        </td>
      </tr>
      
      @if(!empty($data['sharingSnippet']))
      <tr>
        <td class="toolstd" align="left" valign="middle" style="background:{{$data['dynamicBackgroundColor']}};padding:20px;">
          <p style="padding:0;margin:0;color:{{$data['dynamicContentColor']}};font-size:14px;text-transform:none;">What's your experience?</p>
        <h3 style="margin:0;color:{{$data['dynamicContentColor']}};font-size:24px;padding:10px 0 15px 20px;text-transform:none;font-style: italic;font-family: Georgia, Times, 'Times New Roman', serif;font-weight:500;letter-spacing:0;">{{$data['sharingSnippet']}}</h3>
          <p style="padding:0;margin:0;color:{{$data['dynamicContentColor']}}">Ask a question or share a comment <span style="display:inline-block;vertical-align:top:margin:0 5px;"><a target="_blank" href="{{$data['facebookPostLink']}}" style="display:block;color:{{$data['dynamicContentColor']}};border:1px solid {{$data['dynamicContentColor']}};padding:5px 10px;text-decoration:none;">Facebook</a></span><span style="display:inline-block;vertical-align:top:margin:0 5px;"><a target="_blank" href="{{$data['instagramPostLink']}}" style="display:block;color:{{$data['dynamicContentColor']}};border:1px solid {{$data['dynamicContentColor']}};padding:5px 10px;text-decoration:none;">Instagram</a></span></p>
        </td>
      </tr>
      @endif

       @php 
       
       //dd($data['showIdea']);
       
       @endphp
     @if(!empty($data['supportingyourself']))
                <tr>
                  <td align="left" valign="middle">
                  <span mc:edit="supportingyourchildheading">{!! $data['supportingYourChildHeading'] !!}</span>
                    <div mc:edit="supportingyourchildcontent" style="padding:0;margin:0;line-height:24px;font-family:Arial, Helvetica, sans-serif;color:#5C5F60;font-size:14px;">
                    {!! $data['supportingYourChildContent'] !!}
                    </div>
                  </td>
                </tr>
                  <tr>
                  <td align="left" valign="middle">
                    <span mc:edit="ideascontent">
                      {!! $data['showIdea']['ideasContent'] !!}
                    </span>
                    
                  </td>
                </tr>
      @else


                  @foreach($data['users_selected_grades'] as $userSgrade)
                  @php
                  $extrav=$extraIdeas[$userSgrade];
                  

                  if(!empty($data['showIdea']['Atthisarray'])){
                  @$Atthisval= $data['showIdea']['Atthisarray'][$userSgrade];
                  }
                
                
                if(!empty($data['showIdea']['Ideaarray'])){
                  @$Ideaval=$data['showIdea']['Ideaarray'][$userSgrade];
                }
                
                //print_r($Atthisval);
                //dd($Ideaval);
                @endphp
                  
                  <tr>
                    <td align="left" valign="middle">
                    <span mc:edit="supportingyourchildheading">
                    <h3 style="padding:10px 0;margin:0;color:{{$data['dynamicContentColor']}};line-height:24px;">- - - - YOUR {{$extrav['grade_name'] }}: CONNECT & EMPOWER - - - -</h3>
                    </span>
                      <div mc:edit="supportingyourchildcontent" style="padding:0;margin:0;line-height:24px;font-family:Arial, Helvetica, sans-serif;color:#5C5F60;font-size:14px;">
                        @if(!empty($Atthisval)) 
                        @foreach($Atthisval as $AtthisvalKey=>$AtthisvalVal)
                        {!! $AtthisvalVal['renderAtthis'] !!}
                        @endforeach
                        @endif
                        
                      </div>
                    </td>
                  </tr> 
                
                  
                  @if(!empty($Ideaval))
                  <tr>
                    <td align="left" valign="middle">
                      <span mc:edit="ideascontent">
                        @foreach($Ideaval as $iikey=>$iival)
                        @php
                        $number= ($iikey+1); 
                        @endphp
                        <p style="font-family: Arial, Helvetica, sans-serif;line-height:24px;color:{{$data['dynamicContentColor']}}"><a target="_blank" style="color:{{$data['dynamicContentColor']}}" 
                        href="{{$data['detail_page_hyper_link_url']}}?m={{$data['email']}}&g={{$userSgrade}}&e={{$data['encrypted']}}"> 
                        <strong>{{$number}}. {{$iival['title']}}</strong></a>
                        </p>   
                        @endforeach
                      </span>
                      
                    </td>
                  </tr>
                
                  @endif
                @endforeach

   @endif             
    
    
   
      <tr>
        <td align="center" valign="middle">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tbody>
              <tr>
                <td mc:edit="usefultoolsheading" colspan="3">
                  {!! $data['usefulToolsHeading'] !!}
                </td>
              </tr>
              <tr>
                <td class="toolstd" mc:edit="usefultoolscontent">
                  {!! $data['usefulToolsContent'] !!}
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
      <tr>
        <td align="left" valign="middle">
        <span mc:edit="whatscomingupheading">{!! $data['whatscomingUpHeading'] !!}</span>
          
          <div mc:edit="whatscomingupcontent" style="padding:5px 0;margin:0;font-size:13px;font-family:Arial, Helvetica, sans-serif;">
            {!! $data['whatscomingUpContent'] !!}
            
          </div>
          
        </td>
      </tr>
      <tr>
        <td align="left" valign="middle">
          <span mc:edit="relatedpostheading">{!! $data['relatedPostHeading'] !!} </span>
          <div mc:edit="relatedpostcontent" style="padding:10px 0;margin:0;font-size:13px;font-family:Arial, Helvetica, sans-serif;">
            {!! $data['relatedPostContent'] !!}
          </div>
        </td>
      </tr>
      <tr>
        <td align="left" valign="middle">
        <span>
        <h3 style="padding:10px 0;margin:0;color:{{$data['dynamicContentColor']}};line-height:24px;">- - - - IN CASE YOU MISSED - - - -</h3>
        </span>
        @foreach($data['lattest_arr'] as $lkey=>$lval)
        @php
        $number= ($lkey+1); 
        @endphp
        <p style="font-family: Arial, Helvetica, sans-serif;line-height:24px;color:{{$data['dynamicContentColor']}}"><a target="_blank" style="color:{{$data['dynamicContentColor']}}" 
        href="{{$lval['lid']}}"> 
        <strong>{{$number}}. {{$lval['title']}}</strong></a>
        </p>   
        @endforeach
        </td>
      </tr>
      <tr>
        <td align="center" valign="middle" style="border-top:2px solid #ddd;border-bottom:2px solid #ddd;padding:10px 0;font-family:Arial, Helvetica, sans-serif;width:100%;">
          <a target="_blank" href="https://www.instagram.com/postcardsforparents"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-instagram-48.png" style="border:none;width:30px;" alt="color-instagram-48.png"></a>
          <a target="_blank" href="https://www.facebook.com/Postcards-for-Parents-820084901661452"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-facebook-48.png" style="border:none;width:30px;" alt="color-facebook-48.png"></a>
          <a target="_blank" href="https://www.youtube.com/channel/UCm5ySrWmzLmKteNtzHynDXA"><img src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-youtube-48.png" style="border:none;width:30px;" alt="color-youtube-48.png"></a>
        </td>
      </tr>
      <tr>
        <td align="center" valign="middle">
          <p style="padding:10px 0;margin:0;font-size:12px;font-family:Arial, Helvetica, sans-serif;">Copyright © 2019 Postcards for Parents, All rights reserved.
          </p>
          
        </td>
      </tr>
    </tbody>
  </table>
</body>
</html>

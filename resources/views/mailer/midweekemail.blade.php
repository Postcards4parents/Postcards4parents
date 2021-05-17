<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Postcards For Parents</title>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix" style="font-family: 'Libre Baskerville', serif; margin:0px; padding:0px;">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td>&nbsp;</td>
</tr>
  <tr>
    <td align="center" valign="middle">
      <table width="600px" border="0" cellspacing="0" cellpadding="0" style="padding:20px; border:1px solid #DBDBDB;">
        
        <tr>
          <td align="center" valign="middle"><img src="bg-border.png"></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        	<td style="color:#979797; font-size:14px;">Be sure to join us on <a href="https://www.instagram.com/postcardsforparents" target="_blank" style="color:rgba(51,51,51,0.5);">Instagram</a> and <a href="https://www.facebook.com/Postcards-for-Parents-820084901661452" target="_blank" style="color:rgba(51,51,51,0.5);">Facebook!</a>!</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        	<td><img src="{{ url('site/images/logo.png')}}" style="float:right;"></td>
        </tr>
        <tr><td>&nbsp;</td></tr>

        <tr>
          <td>
            <div style="margin:0px; padding:25px 0;">
              <p style="margin:0px; padding:10px 0; font-size:12px; color:#1c75bc; font-weight:500;">- - - STORIES IN PARENTING - - -</p>
              <p style="margin:0px; padding:5px 0px; font-size:18px; color:#1c75bc; line-height:24px;">Hi {{$fname}},</p>
              <p style="margin:0px; padding:0px; font-size:18px; color:#1c75bc; line-height:24px;">{{ $data->introText->getContent()[0]->getContent()[0]->getValue() }}</p>
            </div>
          </td>
        </tr>
		
        <tr><td>&nbsp;</td></tr>
		@foreach($data->midweekMedia as $media)
        <tr>
        	<td>
        		<p style="margin:0px; padding:0px; color:#e75a41;">{{ $media->midweekMediaTitle	}}</p>
        		@foreach($media->midweekMedia as $medias)
        		<p style="margin:0px; padding:10px 0 0; font-size:10px; color:#e75a41;"><a href="https:{{$medias->getFile()->getUrl()}}" target="_blank">(CLICK TO LISTEN)</a></p>
        		@endforeach
        	</td>
    	</tr>
		@endforeach

        <tr><td>&nbsp;</td></tr>
        <tr>
        	<td>
        		<img src="{{$data->authorClinicianExpert->getProfilePic()->getFile()->getUrl()}}" style="float:right;">
        		<img src="{{$data->authorClinicianExpert->getSignaturePic()->getFile()->getUrl()}}" style="float:right; margin-top:50px;">
        	</td>
        </tr>

        <tr><td>&nbsp;</td></tr>
        <p style="margin:0px; padding:0px; font-size:16px; color:#c1c1c1;">{{$data->prompt}}<a href="{{$data->promptLink}}" target="_blank">Share it here!</u></p>
        <tr>
          <td style="margin:0px; padding:0px;">
            <div style="background:#d8e2e5; width:100%; height:2px;"></div>
          </td>
        </tr>

        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        
        <tr>
          <td style="margin:0px; padding:0px;">
           
          </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
      </table>
    </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
</table>

</body>
</html>

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
          <td align="center" valign="middle"><img src="{{ url('site/images/bg-border.png')}}"></td>
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
              <p style="margin:0px; padding:5px 0px; font-size:18px; color:#1c75bc; line-height:24px;">{{ $entrys->emailText->getContent()[0]->getContent()[0]->getValue() }} {{$fname}}?</p>
            </div>
          </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
          <td>
          	<p style="margin:0px; padding:0px; color:#1c75bc;">{{ $entrys->emailText->getContent()[2]->getContent()[0]->getValue() }}</p>
          </td>
        </tr>
        <tr>
        <tr><td>&nbsp;</td></tr>
      <tr>
          <td style="text-align:center;">
            <img src="https:{{ $entrys->media[0]->getFile()->getUrl()}}" width="650px">
          </td>
        </tr>

        <tr>
          <td style="text-align:center;">
            <a style="text-align:center; margin:0px; padding:0px; border:0px;" href="{{url('/quiz')}}"><img src="{{asset('site/images/gotosurvey.jpg')}}"></a>
          </td>
        </tr>
        <tr><td>&nbsp;</td></tr>

        <tr>
          <td>
          	<p style="margin:0px; padding:0px; color:#1c75bc;">{{ $entrys->emailText->getContent()[5]->getContent()[0]->getValue() }}</p>
      
          </td>
        </tr>

        <tr><td>&nbsp;</td></tr>

        <tr><td>&nbsp;</td></tr>
		
        <tr>
          <td>
            <p style="margin:0px; padding:0px; color:#1c75bc; font-style:italic;">{{ $entrys->emailText->getContent()[6]->getContent()[0]->getValue() }}</p>
            <p style="margin:0px; padding:0px; color:#1c75bc; font-style:italic;">{{ $entrys->emailText->getContent()[7]->getContent()[0]->getValue() }}</p>
          </td>
        </tr>

        <tr><td>&nbsp;</td></tr>

        <tr><td>&nbsp;</td></tr>
      </table>
    </td>
  </tr>
  <tr><td>&nbsp;</td></tr>
  <tr><td>&nbsp;</td></tr>
</table>

</body>
</html>
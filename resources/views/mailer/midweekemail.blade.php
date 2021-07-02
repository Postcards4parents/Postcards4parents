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
        	<td style="color:#979797; font-size:14px;">Be sure to join us on <u>Instagram</u> and <u>Facebook</u>!</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
        	<td><img src="{{ url('site/images/logo.png')}}" style="float:right;"></td>
        </tr>
        <tr><td>&nbsp;</td></tr>

        <tr>
          <td>
            <div style="margin:0px; padding:25px 0; font-family: 'Poppins', serif;">
              <p style="margin:0px; padding:10px 0; font-size:12px; color:#1c75bc; font-weight:500;">STORIES IN PARENTING</p>
              <p style="margin:0px; padding:5px 0px; font-size:16px; color:#1c75bc; line-height:24px;">Hi {{$fname}},</p>
              <p style="margin:0px; padding:0px; font-size:16px; color:#1c75bc; line-height:24px;">{{ $data->introText->getContent()[0]->getContent()[0]->getValue() }}</p>
            </div>
          </td>
        </tr>

        <tr><td>&nbsp;</td></tr>

        <tr>
          <td>
            <p style="margin:0px; padding:0 50px; color:#3ca884;">---------</p>
          </td>
        </tr>

        <tr><td>&nbsp;</td></tr>

        <tr>
          <td style="padding:0 50px;">
            <p style="margin:0px; padding:5px 0px; color:#3ca884; font-size:12px; font-family: 'Poppins', serif;">{{ $data->stories[0]->minRead}} min read</p>
          </td>
        </tr>

        <tr>
        	<td style='margin:0px; padding:0 50px; line-height:24px; color:#3ca884; font-size:14px;'>
				@php
				/*$storytext = $data->stories[0]->storyText->getContent();
				foreach($storytext as $texts){
					$inner = $texts->getContent();
					foreach($inner as $inners){
						echo "<p style='margin:0px; padding:0px; line-height:24px; color:#3ca884;'>".$inners->getValue()."</p>";
					}
				}*/
				@endphp
        		{!! $render->render($data->stories[0]->storyText) !!}
        	</td>
    	  </tr>

        <tr><td>&nbsp;</td></tr>

        <tr>
        	<td style='margin:0px; padding:0 50px; line-height:24px; color:#3ca884; font-size:14px;'>
        		<p style="margin:0px; padding:0px; font-size:13px; color:#3ca884; font-family: 'Poppins', serif; font-weight:600;">UNRAVELLING THE ISSUE</p>
        		@php
				/*$storytext = $data->stories[0]->unravellingTheIssue->getContent();
				foreach($storytext as $texts){
					$inner = $texts->getContent();
					foreach($inner as $inners){
						echo "<p style='margin:0px; padding:0px; line-height:24px; color:#3ca884;'>".$inners->getValue()."</p>";
					}
				}*/
				@endphp
        		{!! $render->render($data->stories[0]->unravellingTheIssue) !!}
        	</td>
    	  </tr>

        <tr><td>&nbsp;</td></tr>

        <tr>
          <td style="font-size:20px; padding:0 50px; color:#a4a4a4; font-style:italic;">
				{!! $render->render($data->prompt) !!}
          </td>
        </tr>

        <tr><td>&nbsp;</td></tr>

        <tr>
        	<td>
            <div style="float:right; padding:0 50px;">
              <img src="https:{{$data->authorClinicianExpert->profilePic->getFile()->getUrl()}}" style="float:left;" width="120px">
            </div>

            <div style="float:right; color:#1c75bc; padding:0 50px;">
          		  <img src="https:{{$data->authorClinicianExpert->signaturePic->getFile()->getUrl()}}" style="float:right; margin-top:50px;" width="100px">
                <p style="color:#1c75bc;">{{ $data->authorClinicianExpert->name}}</p>
            </div>

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

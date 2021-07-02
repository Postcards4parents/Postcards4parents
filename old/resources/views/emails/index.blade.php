<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Postcards</title>
</head>

<body style="padding:0;margin:0;font-family: Arial, Helvetica, sans-serif;font-size:14px;color:#000;">
	<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="border:1px solid #ddd;">
  <tbody>
    <tr>
    <td align="center" style="padding:15px;"><img src="{{url('/site/images/logo.png')}}" style="display:block; border:none;"/></td>
    </tr>
	  
    <tr>
      <td style="font-family: Arial, Helvetica, sans-serif;font-size:17px;font-weight:600;padding:20px 15px 0;margin:0;color:#0f64e6;">
            @yield('content1')	
	  </td>
    </tr>
	  
    <tr>
      <td style="font-family: Arial, Helvetica, sans-serif;font-size:14px;padding:10px 15px 0;margin:0;color:#000;">
        @yield('content2')	
	  </td>
    </tr>
    <tr>
      <td style="font-family: Arial, Helvetica, sans-serif;font-size:14px;padding:10px 15px 0;margin:0;">If you need any help using the website please contact us.</td>
    </tr>
    <tr>
      <td style="font-family: Arial, Helvetica, sans-serif;font-size:14px;padding:10px 15px 20px;margin:0;line-height: 20px;">Have a great day!<br>
		  <span style="display:block;">Postcards Team</span>
</td>
    </tr>
  </tbody>
</table>

</body>
</html>
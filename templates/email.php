<?php $message .= '<html>
<head>
<meta charset="utf-8">
<title>Swipe Generated QR Code</title>
</head>

<body>

<table width="600" style="width:600px; margin:0 auto; background:#f4f4f4; border-radius:5px;">
<tr>
<td>
<table style="width:100%; border-bottom: 1px solid #e5e5e5;">
<tr><td style="height:15px;"></td><td></td></tr>
<tr><td>
<img src="https://swipepro.io/swipe_pro_plugin/logo-color.png" alt="logo" width="205" height="64">
</td>
    <td style="text-align: right;"><a href="https://swipepro.io" target="_blank" style="font:700 14px/50px Arial, Helvetica, sans-serif; color:#ffffff; text-decoration:none; text-transform:uppercase; display:inline-block; overflow:hidden; background:#f27b69; text-align:center; border-radius:40px; -moz-border-radius:40px; -webkit-border-radius:40px; width: 170px;">GO TO SWIPE</a></td>
</tr>
<tr><td style="height:15px;"></td><td></td></tr>
</table>
<table style="width:100%;"><tr><td style="height:30px;"></td></tr></table>
</td>
</tr>
<tr>
  <td>
  <table style="width:100%; text-align:center;"><tr><td style="font:700 20px Arial, Helvetica, sans-serif; color:#f27b69; text-transform:uppercase; padding:0 5% 0 5%;">
  '.$blog_name.'
  </td></tr>
  <tr>
        <td style="height:10px;"> </td>
      </tr>
    <tr>
      <td style="font:bold 18px Arial, Helvetica, sans-serif; color:#404040; text-transform:uppercase; padding:0 5% 0 5%;">HI '.$user->display_name.' </td>
    </tr>
     <tr>
        <td style="height:10px;"> </td>
      </tr>
    <tr>
      <td style="font:18px Arial, Helvetica, sans-serif; color:#404040; padding:0 5% 0 5%;">Scan the QR code using the mobile app </td>
    </tr>
     <tr>
        <td style="height:10px;"> </td>
      </tr>
    <tr>
      <td style="text-align:center;" align="center">
      <img src="'.$attachment.'">
      </td>
    </tr>
  </table>
  </td>
</tr>
<tr>
  <td>
  <table style="width:100%; text-align:center;"><tr><td style="font:16px Arial, Helvetica, sans-serif; color:#404040; padding:0 10px;">
  Scan this QR code with Swipe App.
  </td></tr>
  <tr>
        <td style="height:5px;"> </td>
      </tr>
    <tr>
      <td style="font:16px Arial, Helvetica, sans-serif; color:#404040; padding:0 10px;">This QR request is from website <a href="'.site_url().'" style="color:#f27b69; text-decoration:none;">'.site_url().'</a></td>
    </tr>
    <tr>
        <td style="height:10px;"> </td>
      </tr>
  </table>
  </td>
</tr>

<tr><td>

<table style="width:100%;">
<tr><td style="font:700 20px Arial, Helvetica, sans-serif; color:#f27b69; text-transform:uppercase; padding:0 5% 0 5%; text-align:center;">Download Apps</td></tr>
 <tr>
        <td style="height:20px;"> </td>
      </tr>
</table>

<table style="width:100%;">
<tr>
<td style="text-align:center;">
<a href="https://play.google.com/store/apps/details?id=tru.swipe.app" target="_blank"><img src="https://swipepro.io/swipe_pro_plugin/google.png" width=""></a>
</td>
    <td style="text-align:center;"><a href="https://itunes.apple.com/in/app/swipe-login/id1437771552?mt=8" target="_blank"><img src="https://swipepro.io/swipe_pro_plugin/apple.png" width=""></a></td>
</tr>
</table>

</td></tr>
<tr>
        <td style="height:20px;"> </td>
      </tr>
<tr>
  <td>
  <table style="width:100%; background:#af5372; border-radius: 0px 0px 5px 5px; -moz-border-radius: 0px 0px 5px 5px; -webkit-border-radius: 0px 0px 5px 5px;">
  <tr>
        <td style="height:20px;"> </td>
      </tr>
  <tr><td style="color:#fff; font:16px Arial, Helvetica, sans-serif; text-align:center;">
  © '.date("Y").', All rights reserved
  </td>
  </tr>
  
  
      <tr>
        <td style="height:20px;"> </td>
      </tr>
  </table></td>
</tr>
</table>

</body>
</html>';
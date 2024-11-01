<?php if ( ! defined( 'ABSPATH' ) ) exit;
$this->custom_css(); ?>
<div class="wrap setting_wrap swipeDocumentation">
<h1 class="title">
<img src="<?php echo SWIPE_PRO_PATH.'/images/doc.png';?>"/> 
<?php _e('Documentation','swipe'); ?>
</h1>
<div class="swipeDocWrap">
<div class="tab">
  <button class="tablinks" onclick="openSwipe(event, 'install_app')" id="defaultOpen"><?php _e('Step 1 - Install','swipe'); ?></button>
  <button class="tablinks" onclick="openSwipe(event, 'plugin_settings')"><?php _e('Step 2 - Signup','swipe'); ?></button>
  <button class="tablinks" onclick="openSwipe(event, 'generate_qr')"><?php _e('Step 3 - Add Website','swipe'); ?></button>
  <button class="tablinks" onclick="openSwipe(event, 'swipe_login')"><?php _e('Step 4 - Login','swipe'); ?></button>
</div>

<div id="install_app" class="tabcontent">
  <h3 class="innerHead"><?php _e('Install Swipe App','swipe'); ?></h3>
  <div class="swipeTwoColWrap">
  <div class="swipeTwoCol alignCenter rBorder">
  <h4><?php _e('Android Users','swipe'); ?></h4>
  <div>  <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=https://play.google.com/store/apps/details?id=tru.swipe.app&choe=UTF-8" /></div>
  <a href="https://play.google.com/store/apps/details?id=tru.swipe.app" target="_blank"><img src="<?php echo SWIPE_PRO_PATH.'/images/google.png';?>" width="130px;" /></a> 
  <div class="noteText"><?php _e("(Search on google play 'tru.swipe.app')",'swipe'); ?></div>

</div>
 <div class="swipeTwoCol alignCenter">
  <h4><?php _e('IOS Users','swipe'); ?></h4>
  <div> <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=https://itunes.apple.com/in/app/swipe-login/id1437771552?mt=8&choe=UTF-8" /></div>
  <a href="https://itunes.apple.com/in/app/swipe-login/id1437771552?mt=8" target="_blank"><img src="<?php echo SWIPE_PRO_PATH.'/images/apple.png';?>" width="130px;" /></a>
  
 <div class="noteText"><?php _e("(Search on app store 'swipe login')",'swipe'); ?></div>
  </div>
    </div>
</div>

<div id="plugin_settings" class="tabcontent">
   <h3 class="innerHead"><?php _e('Signup with Swipe app','swipe'); ?></h3>
    <h4 class="subhead"><?php _e('Create account with your swipe app and login into your app','swipe'); ?></h4>
   <div class="swipeTwoColWrap">
   <div class="swipeTwoCol alignCenter rBorder padr15">  
   <h4><?php _e('Signup','swipe'); ?></h4>
   <img src="<?php echo SWIPE_PRO_PATH.'/images/register.jpg';?>" class="imgresponsive" />    
   </div>
   
   <div class="swipeTwoCol alignCenter transBorderLft padl15">  
     <h4><?php _e('Login','swipe'); ?></h4>
   <img src="<?php echo SWIPE_PRO_PATH.'/images/login.jpg';?>" class="imgresponsive" />   
    </div> 
     </div>
</div>

<div id="generate_qr" class="tabcontent">
  <h3 class="innerHead"><?php _e('Add Website to Swipe App','swipe'); ?></h3>
  <h4 class="subhead"><?php _e('Click on "<strong>+ ADD NEW WESBITE</strong>" and Scan QR code with swipe app to add website','swipe'); ?></h4> 
   <div class="borderEle pad15 alignCenter maxwdImg">
   <img src="<?php echo SWIPE_PRO_PATH.'/images/add-website.png';?>" class="imgresponsive"/> 
   </div>
   
</div>

<div id="swipe_login" class="tabcontent">
  <h3 class="innerHead"><?php _e('Login with Swipe app','swipe'); ?></h3>
  <h4 class="subhead"><?php _e('Scan wordpress login wave with swipe app','swipe'); ?></h4> 
   <div class="alignCenter maxwdImg">
    <h4 class="lgText"><?php _e('Login with app','swipe'); ?></h4>
   <img src="<?php echo SWIPE_PRO_PATH.'/images/scan.png';?>" class="imgresponsive"/> 
   </div>
</div>
</div>

<script>
function openSwipe(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
</script>
</div>
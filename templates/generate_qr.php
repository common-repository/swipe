<?php if ( ! defined( 'ABSPATH' ) ) exit; 
$this->custom_css(); 
$args = array(
	        'role' => 'administrator',
			); 
$users = get_users( $args );
$get_user_data = $this->get_user_data();
if(isset($_POST['qr_generate_qr']) && wp_verify_nonce( $_POST['swipe_generate_nonce_field'], 'swipe_generate_action' )):
    $save = $this->save_data(intval($_POST['qr_users']));
endif;
?>
<div class="wrap qr_wrap">



<div class="swip-down">
	<h1> <img src="<?php echo SWIPE_PRO_PATH.'/images/down.png';?>"/> <?php _e('Download The Swipe App (Step 1)','swipe'); ?>
    </h1>
	<p><a href="admin.php?page=swipe_documentation"><?php _e('Need Help? See Documentation','swipe'); ?></a></p>
	<div class="andro twoColWrap">
		<div class="get-on twoCol rborder alignCeter">
			<h3><?php _e('Android','swipe'); ?></h3>
            <div>  <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=https://play.google.com/store/apps/details?id=tru.swipe.app&choe=UTF-8" /></div>
			<a href="https://play.google.com/store/apps/details?id=tru.swipe.app" target="_blank"><img src="<?php echo SWIPE_PRO_PATH.'/images/google.png';?>" width="100px;" /></a> 
            <div class="noteText"><?php _e("(Search on google play 'tru.swipe.app')",'swipe'); ?></div>
          
		</div>
		
		<div class="get-on twoCol alignCeter">
			<h3><?php _e('iOS','swipe'); ?></h3>
            <div>  <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=https://itunes.apple.com/in/app/swipe-login/id1437771552?mt=8&choe=UTF-8" /></div>
			<a href="https://itunes.apple.com/in/app/swipe-login/id1437771552?mt=8" target="_blank"><img src="<?php echo SWIPE_PRO_PATH.'/images/apple.png';?>" width="100px;" /></a>
            <div class="noteText"><?php _e("(Search on app store 'swipe login')",'swipe'); ?></div>
          
		</div>
		
	</div>
	
	<p class="description">
		<?php _e('Install swipe app in your phone.','swipe'); ?>
		</p>
	
</div>
<form method="post" action="">
<div class="swip-down swipe-2">
	<h1> <img src="<?php echo SWIPE_PRO_PATH.'/images/usr.png';?>"/> <?php _e('Generate a QR code for users (Step 2)','swipe'); ?> </h1>
	<?php wp_nonce_field( 'swipe_generate_action', 'swipe_generate_nonce_field' ); ?>
	
	<div class="andro">
	<div class="get-on">
		<p><?php _e('Select User','swipe'); ?></p>
		
		<select name="qr_users" id="qr_users">
	<?php if(!empty($users) && is_array($users)) {
	foreach($users as $user) { ?>
    <option value="<?php echo $user->ID;?>"><?php echo $user->user_login;?></option>
    <?php }} ?>
</select>
	</div>
	<p class="description"><?php _e('Select user to generate settings code','swipe'); ?></p>
	<p><input type="submit" name="qr_generate_qr" id="qr_generate_qr" class="blue-btn" value="Generate"></p>
	
	</div>
	
</div>

</form>
</div>
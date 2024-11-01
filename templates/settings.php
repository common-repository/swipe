<?php if ( ! defined( 'ABSPATH' ) ) exit; 
$this->custom_css();
global $wp_roles;
$roles = $wp_roles->get_names();
$swipe_setting_options = get_option('swipe_setting_options');
?>
<style>
.swipe_msg_error {
	color:#900;
}
</style>
<div class="wrap setting_wrap">
<h1 class="title"> <img src="<?php echo SWIPE_PRO_PATH.'/images/swipe.png';?>"/> <?php _e('Settings','swipe'); ?></h1>

<div class="page_clef_wrap">
	<div class="lSideCol">
    	<h3><?php _e('Disable Password','swipe'); ?> <span class="smText"><a href="https://swipepro.io/documentation/" target="_blank"><?php _e('Learn more about these settings','swipe'); ?></a></span></h3>
        
        <div class="clefRow">
        	<div class="text"><?php _e('Disable password for Swipe Users','swipe'); ?>
            
            </div>
            <div class="field"><input type="checkbox" class="swipe_check" value="1" name="swipe_disable_check" id="swipe_disable_check" <?php echo (isset($swipe_setting_options['swipe_disable_check']) && $swipe_setting_options['swipe_disable_check'] == 'true') ? 'checked="checked"' : ''; ?>/></div>
         <span id="swipe_msg_swipe_disable_check" class="swipe_msg"></span>
        </div>
        
        <div class="clefRow">
        	<div class="text"><?php _e('Disable passwords for all users with privileges greater than or equal to','swipe'); ?>
             
            </div>
            <div class="field">
            <select class="select swipe_select_userrole" id="swipe_select_userrole">
            <option value="" <?php echo (isset($swipe_setting_options['swipe_select_userrole']) && $swipe_setting_options['swipe_select_userrole'] == '') ? 'selected="selected"' : ''; ?>></option>
            <?php foreach($roles as $key => $role): ?>
            <option value="<?php echo $key; ?>" <?php echo (isset($swipe_setting_options['swipe_select_userrole']) && $swipe_setting_options['swipe_select_userrole'] == $key) ? 'selected="selected"' : ''; ?>><?php echo $role; ?></option>
             <?php endforeach; ?>
            </select>            
            </div>
           <span id="swipe_msg_swipe_select_userrole" class="swipe_msg"></span>
        </div>
        
        <div class="clefRow">
        	<div class="text">
			<?php _e('Disable passwords for all users and hide the password login form','swipe'); ?>
            
            </div>
            <div class="field"><input type="checkbox" class="swipe_check" value="1" name="swipe_hide_check" id="swipe_hide_check" <?php echo (isset($swipe_setting_options['swipe_hide_check']) && $swipe_setting_options['swipe_hide_check'] == 'true') ? 'checked="checked"' : ''; ?> /></div>
            <span id="swipe_msg_swipe_hide_check" class="swipe_msg"></span>
        </div>
        
        <h3><?php _e('Form Style','swipe'); ?></h3>
        
           <div class="clefRow">
        	<div class="text">
			<?php _e('Show Swipe wave as primary login option','swipe'); ?>
            
            </div>
            <div class="field"><input type="checkbox" class="swipe_check" value="1" name="swipe_show_check" id="swipe_show_check" <?php echo (isset($swipe_setting_options['swipe_show_check']) && $swipe_setting_options['swipe_show_check'] == 'true') ? 'checked="checked"' : ''; ?> /></div>
            <span id="swipe_msg_swipe_show_check" class="swipe_msg"></span>            
        </div>
        
    </div>
    
    <div class="rSideCol">
    	 <h4><?php _e('Preview of your login form','swipe'); ?></h4>
<div class="clefLoginForm" <?php echo (isset($swipe_setting_options['swipe_show_check']) && $swipe_setting_options['swipe_show_check'] == 'true') ? 'style="display:none"' : ''; ?>>
         	<form name="loginform" id="loginform" action="#" method="post">

		<label for="user_login"><?php _e('Username or Email Address','swipe'); ?></label>
		<input type="text" name="log" id="user_login" class="input" value="" size="20">

	
		<label for="user_pass"><?php _e('Password','swipe'); ?></label>
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20">
	
   
<div class="qr_login">
<p><strong><?php _e('- OR -','swipe'); ?></strong></p>

<div class="swipeBtnDv">
<a href="#!" class="swipeLoginButtonInn swipeLoginShowBtn">
<span class="swipeFormWave">
<svg class="barcode" width="20px" height="20px" x="0px" y="0px" viewBox="0 0 218 120" xmlns="http://www.w3.org/2000/svg" version="1.1" style="transform: translate(0,0)">
<rect x="0" y="0" width="218" height="120" style="fill:transparent;"></rect>
<g transform="translate(10, 10)" style="fill:#fff;">
<rect x="0" y="0" width="4" height="100" style="animation-duration: 1.2s;"></rect>
<rect x="6" y="0" width="6" height="100" style="animation-duration: 0.89s;"></rect>
<rect x="14" y="0" width="2" height="100" style="animation-duration: 0.78s;"></rect>
<rect x="22" y="0" width="2" height="100" style="animation-duration: 1.13s;"></rect>
<rect x="32" y="0" width="2" height="100" style="animation-duration: 0.8s;"></rect>
<rect x="36" y="0" width="4" height="100" style="animation-duration: 1.3s;"></rect>
<rect x="44" y="0" width="2" height="100" style="animation-duration: 1.31s;"></rect>
<rect x="50" y="0" width="4" height="100" style="animation-duration: 1.04s;"></rect>
<rect x="62" y="0" width="2" height="100" style="animation-duration: 1.03s;"></rect>
<rect x="66" y="0" width="4" height="100" style="animation-duration: 0.99s;"></rect>
<rect x="72" y="0" width="4" height="100" style="animation-duration: 1.17s;"></rect>
<rect x="80" y="0" width="4" height="100" style="animation-duration: 1.11s;"></rect>
<rect x="88" y="0" width="2" height="100" style="animation-duration: 0.78s;"></rect>
<rect x="98" y="0" width="2" height="100" style="animation-duration: 0.96s;"></rect>
<rect x="102" y="0" width="4" height="100" style="animation-duration: 0.81s;"></rect>
<rect x="110" y="0" width="2" height="100" style="animation-duration: 0.97s;"></rect>
<rect x="120" y="0" width="4" height="100" style="animation-duration: 1.32s;"></rect>
<rect x="126" y="0" width="2" height="100" style="animation-duration: 1.05s;"></rect>
<rect x="132" y="0" width="2" height="100" style="animation-duration: 1.29s;"></rect>
<rect x="136" y="0" width="4" height="100" style="animation-duration: 1.23s;"></rect>

</g></svg>
</span>

<span class="swipeLoginText">
<?php _e('Log in with your  phone','swipe'); ?>
</span>
</a> 
</div>
 
 </div>  
 <div class="clefLoginFooter">
	<div class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"> <?php _e('Remember Me','swipe'); ?></label></div>
	<div class="submitDv">
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="Log In">
	</div>
    </div>
</form>
</div>
         
 <div class="swipewaveBox" <?php echo (isset($swipe_setting_options['swipe_show_check']) && $swipe_setting_options['swipe_show_check'] == 'true') ? 'style="display:block"' : ''; ?>>
 <div class="waveBoxInner">
 	<svg class="barcode" width="200px" height="120px" x="0px" y="0px" viewBox="0 0 200 120" xmlns="http://www.w3.org/2000/svg" version="1.1" style="transform: translate(0,0)"><rect x="0" y="0" width="200" height="120" style="fill:#ffffff;"></rect><g transform="translate(10, 10)" style="fill:#09F;"><rect x="0" y="0" width="4" height="100" style="animation-duration: 1.21s;"></rect><rect x="6" y="0" width="2" height="100" style="animation-duration: 1.08s;"></rect><rect x="12" y="0" width="2" height="100" style="animation-duration: 1.16s;"></rect><rect x="22" y="0" width="2" height="100" style="animation-duration: 1.29s;"></rect><rect x="30" y="0" width="4" height="100" style="animation-duration: 1s;"></rect><rect x="36" y="0" width="6" height="100" style="animation-duration: 0.88s;"></rect><rect x="44" y="0" width="2" height="100" style="animation-duration: 1.28s;"></rect><rect x="52" y="0" width="8" height="100" style="animation-duration: 0.96s;"></rect><rect x="62" y="0" width="2" height="100" style="animation-duration: 1.18s;"></rect><rect x="66" y="0" width="2" height="100" style="animation-duration: 1.34s;"></rect><rect x="72" y="0" width="4" height="100" style="animation-duration: 1.01s;"></rect><rect x="78" y="0" width="2" height="100" style="animation-duration: 1.1s;"></rect><rect x="88" y="0" width="2" height="100" style="animation-duration: 1.17s;"></rect><rect x="98" y="0" width="4" height="100" style="animation-duration: 0.89s;"></rect><rect x="104" y="0" width="2" height="100" style="animation-duration: 0.98s;"></rect><rect x="110" y="0" width="4" height="100" style="animation-duration: 1.22s;"></rect><rect x="122" y="0" width="2" height="100" style="animation-duration: 1.09s;"></rect><rect x="126" y="0" width="2" height="100" style="animation-duration: 1.23s;"></rect><rect x="132" y="0" width="2" height="100" style="animation-duration: 0.83s;"></rect><rect x="142" y="0" width="2" height="100" style="animation-duration: 1.01s;"></rect><rect x="148" y="0" width="4" height="100" style="animation-duration: 0.99s;"></rect><rect x="154" y="0" width="4" height="100" style="animation-duration: 1.02s;"></rect><rect x="164" y="0" width="6" height="100" style="animation-duration: 1.14s;"></rect><rect x="172" y="0" width="2" height="100" style="animation-duration: 0.81s;"></rect><rect x="176" y="0" width="4" height="100" style="animation-duration: 0.98s;"></rect></g></svg>
   </div>
   
   <div class="waveFooterArea">
   		<p class="or"><strong><?php _e('- OR -','swipe'); ?></strong></p>
        
        <a href="#!" class="swipeLoginButtonInn swipeLoginShowBtn" id="swipe_show_wp">
<span class="swipeFormwpicon">
<img src="<?php echo SWIPE_PRO_PATH.'/images/wp-icon-24.png';?>"/>
</span>

<span class="swipeLoginText">
<?php _e('Log in with wordpress','swipe'); ?></span>
</a>

   </div> 
    
    
 </div>
         
         
    </div>
    
</div>

</div>


<script>
jQuery(document).ready(function(e) {
	jQuery('.swipe_check').click(function(e) {
		var msg_class = jQuery(this).attr('name');
        save_swipe_data(msg_class);
    });
	
	jQuery('.swipeLoginShowBtn').click(function(e) {
        jQuery('.swipewaveBox').show();
		jQuery('.clefLoginForm').hide();		
    });
	
	jQuery('#swipe_select_userrole').change(function(e) {
      save_swipe_data('swipe_select_userrole');  
    });
	
	jQuery('#swipe_show_wp').click(function(e) {
        jQuery('.swipewaveBox').hide();
		jQuery('.clefLoginForm').show();		
    });
	
});
function save_swipe_data(msgclass) {
	jQuery('.swipe_msg').html('');
	var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
	var swipe_disable_check = jQuery('#swipe_disable_check').prop('checked');
	var swipe_hide_check = jQuery('#swipe_hide_check').prop('checked');
	var swipe_show_check = jQuery('#swipe_show_check').prop('checked');
	var swipe_select_userrole = jQuery('#swipe_select_userrole option:selected').val();
	if(swipe_show_check == true) {
		jQuery('.clefLoginForm').hide();
		jQuery('.swipewaveBox').show();
	} else {
		jQuery('.swipewaveBox').hide();
		jQuery('.clefLoginForm').show();
	}
	// finally sending ajax save request :)
	var data = {
			'action': 'swipe_save_settings',
			'swipe_disable_check': swipe_disable_check,
			'swipe_hide_check': swipe_hide_check,
			'swipe_show_check': swipe_show_check,
			'swipe_select_userrole': swipe_select_userrole,
			'ajax_nonce': '<?php echo wp_create_nonce('swipe_login_secrete');?>'
		};

		jQuery.post(ajaxurl, data, function(response) {
			if(response == 1) {
				jQuery('#swipe_msg_'+msgclass).html('<p class="swipe_msg_success">Settings Saved.</p>');
			} else if(response == 2) {
				jQuery('#swipe_msg_'+msgclass).html('<p class="swipe_msg_error">Settings Not Saved.</p>');
			}
			setTimeout(function(){ jQuery('.swipe_msg').html(''); }, 3000);
			return false;
		});
	
}
</script>
<meta charset="UTF-8">
<?php if ( ! defined( 'ABSPATH' ) ) exit;
$swipe_setting_options = get_option('swipe_setting_options');
$this->custom_css();
if(isset($_GET['show_wp_login']) && $_GET['show_wp_login'] == '1') { ?>
<script>
var hide_form = false;
</script>
<p class="mainFormoTxt"><strong><?php _e('- OR -','swipe'); ?></strong></p>
 <div class="swipeBtnDv mainFormBtnDv">
<a href="<?php echo site_url('wp-login.php?show_swipe=1');?>" class="swipeLoginButtonMain swipeLoginButtonInn">
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
<?php } else { ?>
<script>
<?php if((isset($swipe_setting_options['swipe_show_check']) && $swipe_setting_options['swipe_show_check'] == 'true') || isset($_GET['show_swipe']) && $_GET['show_swipe'] == '1') { ?>
var hide_form = true;
<?php } else { ?>
var hide_form = false;
<?php } ?>
var _qrnonce = "<?php echo wp_create_nonce( 'swipe' ); ?>";
var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
var redirect_url = "<?php echo admin_url(); ?>";
var ip_address = "<?php echo $this->get_ip(); ?>";
var content = "<?php echo 'Login';?>";
</script>
<script src="<?php echo SWIPE_PRO_PATH . '/js/JsBarcode.all.js' ?>"></script>
<script src="<?php echo SWIPE_PRO_PATH . '/js/tests.js' ?>"></script>
<script src="<?php echo SWIPE_PRO_PATH . '/js/svgTest.js' ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo SWIPE_PRO_PATH . '/css/app-login.css' ?>">
<?php wp_enqueue_script( 'swipe', SWIPE_PRO_PATH . '/js/login_qr.js', array('jquery'), '1.0.0', true ); ?>   
<div class="qr_login frontSwipe">
<p><strong><?php _e('- OR -','swipe'); ?></strong></p>
<?php if((isset($swipe_setting_options['swipe_show_check']) && $swipe_setting_options['swipe_show_check'] == 'true') || isset($_GET['show_swipe']) && $_GET['show_swipe'] == '1') { ?>
<div><p> <?php _e('Scan Code with APP','swipe'); ?></p></div>
 <div id="qr_login"></div>
 <div class="swipeotxt"><strong><?php _e('- OR -','swipe'); ?></strong></div>
 <a href="<?php echo site_url('wp-login.php?show_wp_login=1');?>" class="swipeLoginButtonMain swipeLoginButtonInn">
 <span class="swipeFormwpicon">
<img src="<?php echo SWIPE_PRO_PATH.'/images/wp-icon-24.png';?>"/>
</span>
<span class="swipeLoginText">
 <?php _e('Log in with wordpress','swipe'); ?></span> </a>
 <script>
     doTests('qr_login');
</script>
 <?php } else { ?>
 <div class="swipeBtnDv">
<a href="<?php echo site_url('wp-login.php?show_swipe=1');?>" class="swipeLoginButtonMain swipeLoginButtonInn">
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
 <?php }  ?>
 </div> 
<?php } ?>
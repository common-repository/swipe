<?php 
/*
Plugin Name: Swipe
Plugin URI: http://wordpress.org/plugins/swipe/
Description: Wordpress login with swipe app
Author: swipepro
Version: 1.4
Author URI: https://profiles.wordpress.org/swipepro
*/
if ( ! defined( 'ABSPATH' ) ) exit;
define( 'SWIPE_PRO_FILE', __FILE__ );
define('SWIPE_PRO_PATH', plugins_url( '', __FILE__ ));
include('controller.php');
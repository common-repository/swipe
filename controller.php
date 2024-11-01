<?php if(!class_exists('swipe_controller')) {
	class swipe_controller {
		/*
		* Hooks and auto load functions
		*/
		public function __construct() {
		    add_action( 'login_form', array($this, 'login_form_swipe'));
			register_activation_hook(SWIPE_PRO_FILE, array($this, 'swipe_activation_process'));
		    add_action('admin_menu', array($this, 'swipe_menu'));
			add_action('wp_ajax_nopriv_swipe_check_app', array(&$this, 'swipe_check_app_callback'));
			add_action('wp_ajax_swipe_check_app', array(&$this, 'swipe_check_app_callback'));
			add_action('clear_auth_cookie', array($this,'users_reset_app'), 10);
			add_action('admin_init', array($this,'reset_after_login'));
			add_action('wp_ajax_nopriv_qr_verify', array(&$this, 'qr_verify_callback'));
			add_action('wp_ajax_nopriv_qr_logout', array(&$this, 'qr_logout_from_app'));
			add_action('wp_ajax_qr_logout', array(&$this, 'qr_logout_from_app'));
			add_action('wp_ajax_nopriv_swipe_logs', array(&$this, 'swipe_logs_response'));			
			add_action('wp_ajax_swipe_logs', array(&$this, 'swipe_logs_response'));
			add_action('wp_ajax_nopriv_swipe_check_logout', array(&$this, 'swipe_check_logout_callback'));
			add_action('wp_ajax_swipe_check_logout', array(&$this, 'swipe_check_logout_callback'));			
            add_action('admin_enqueue_scripts', array(&$this,'qr_logged_out_load_scripts'));
			add_action('wp_ajax_who_is', array(&$this, 'who_is_callback'));
			add_action('wp_ajax_nopriv_who_is', array(&$this, 'who_is_callback'));
			add_action('wp_ajax_swipe_save_settings', array(&$this, 'wp_ajax_swipe_save_settings'));
			add_action('admin_head', array(&$this, 'hide_profile_options'));
			add_action('admin_init', array(&$this,'swipe_activation_redirect') );
			add_action('wp_ajax_swipe_view_qr_users', array(&$this, 'swipe_view_qr_users_callback'));
			add_action('wp_ajax_swipe_view_app_users', array(&$this, 'swipe_view_app_users_callback'));	
		}		
		/*
		* Check Logout
		*/
		public function swipe_check_logout_callback() {
			 if(is_user_logged_in()) {
				$ip = sanitize_text_field($_POST['ip']);
				global $wpdb;
				$swipe = $wpdb->prefix.'swipe';
				$check_logout = $wpdb->get_row("select * from ".$swipe." where uid = '".get_current_user_id()."' and ip_address = '".$ip."' and is_logged_out = '1'");
				if($check_logout == 1) {
				  wp_logout();
				  echo '1';
				} else {
				  echo '0';	
				}
			 } else {
				  echo '1';
			 }
			die;
		}
		/*
		* Reset After Login
		*/
		public function reset_after_login() {
			if(is_user_logged_in()) {
				global $wpdb;
				$current_user_id = get_current_user_id();
				$qr_login = $wpdb->prefix.'swipe';			
				$update = $wpdb->update($qr_login, array('ustatus' => '0', 'is_logged_out' => '0'), array('uid' => $current_user_id));
			}
		}
		/*
		* Load Form Swipe
		*/
		public function login_form_swipe() {
			include('templates/login.php');
		}
		/*
		 * Swipe Activation
		*/
	    public function swipe_activation_process(){
		  global $wpdb;	
		  $swipe = $wpdb->prefix.'swipe';
		  $swipe_app_logs = $wpdb->prefix.'swipe_app_logs';	
		  $swipe_app_users = $wpdb->prefix.'swipe_app_users';
		  require_once(ABSPATH.'wp-admin/includes/upgrade.php');
				$sql = "CREATE TABLE IF NOT EXISTS `".$swipe."` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uid` varchar(255) DEFAULT NULL,
					  `ukey` varchar(255) DEFAULT NULL,
					  `ustatus` varchar(255) DEFAULT NULL,
					  `is_logged_out` varchar(255) DEFAULT NULL,
					  `ip_address` varchar(255) DEFAULT NULL,
					   PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
				  dbDelta($sql);
				  $sql1 = "CREATE TABLE IF NOT EXISTS `".$swipe_app_logs."` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uid` int(11) DEFAULT NULL,
					  `login_date` varchar(255) DEFAULT NULL,
					   PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
				  dbDelta($sql1);
				  $sql3 = "CREATE TABLE IF NOT EXISTS `".$swipe_app_users."` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `uid` int(11) DEFAULT NULL,
					  `name` varchar(255) DEFAULT NULL,
					  `email` varchar(255) DEFAULT NULL,					  
					  `mobile_model` varchar(255) DEFAULT NULL,
					  `blocked` int(11) DEFAULT NULL,
					  `register_date` timestamp DEFAULT CURRENT_TIMESTAMP,
					   PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
				  dbDelta($sql3);
			//redirect on activation QR Code
			add_option('swipe_do_activation_redirect', true);			  	  
	   }
	   /*
	   Redirect upon activation
	   */
	   public function swipe_activation_redirect($plugin) {
		   if (get_option('swipe_do_activation_redirect', false)) {
              delete_option('swipe_do_activation_redirect');
              wp_redirect(admin_url( 'admin.php?page=swipe_generate' ));
             exit;
          }
	   }
	   /*
		* Swipe Menus
	   */
	   public function swipe_menu() {		   
		 add_menu_page( 
			__( 'Swipe', 'swipe'),
			__( 'Swipe', 'swipe'),
			'manage_options',
			'swipe_settings',
			array($this,'swipe_callback'),
			SWIPE_PRO_PATH.'/images/ico.png'
             );	
		add_submenu_page( 'swipe_settings', __( 'Settings', 'swipe'), __( 'Settings', 'swipe'), 'manage_options', 'swipe_settings', array($this,'swipe_callback'),'');	 
	    add_submenu_page( 'swipe_settings', __( 'Generate QR', 'swipe'), __( 'Generate QR', 'swipe'), 'manage_options', 'swipe_generate', array($this,'swipe_generate'),'');
		add_submenu_page( 'swipe_settings', __( 'Swipe Users', 'swipe'), __( 'Swipe Users', 'swipe'), 'manage_options', 'swipe_qr_users', array($this,'swipe_qr_users_callback'),'');	 
		/*add_submenu_page( 'swipe_settings', __( 'Users', 'swipe'), __( 'Users', 'swipe'), 'manage_options', 'swipe_users', array($this,'swipe_users_callback'),'');*/
		add_submenu_page( 'swipe_settings', __( 'Documentation', 'swipe'), __( 'Documentation', 'swipe'), 'manage_options', 'swipe_documentation', array($this,'swipe_documentation'),'');
		}
	   /*
		* Swipe new
	   */
	   public function swipe_callback() {
		   if(is_admin() && current_user_can('manage_options')) {
			  include('templates/settings.php');   
		   }
	   }
	   /*
		* Swipe QR Generate page
	   */
	   public function swipe_generate() {
		   if(is_admin() && current_user_can('manage_options')) {
			  include('templates/generate_qr.php');   
		   }
	   }
	   /*
	   * Swipe QR Users
	   */
	   public function swipe_qr_users_callback() {
		   if(is_admin() && current_user_can('manage_options')) {
			  include('templates/swipe_users.php');   
		   }
	   }
	   /*
	    * Swipe Users
	   */
	   public function swipe_users_callback() {
		  if(is_admin() && current_user_can('manage_options')) {
			  include('templates/users.php');   
		   }
	   }
	    /*
	    * Swipe Blocked Users
	   */
	   public function swipe_documentation() {
		  if(is_admin() && current_user_can('manage_options')) {
			  include('templates/documentation.php');   
		   }
	   }	   
	   /*
		* Generate random number
	   */
	   public function random($length, $chars = ''){
		if (!$chars) {
			$chars = implode(range('a','z'));
			$chars .= implode(range('0','9'));
		}
		$shuffled = str_shuffle($chars);
		return substr($shuffled, 0, $length);
	  }
	  /*
		* Generate key
	  */
      public function generated_number(){
	       return $this->random(16).''.$this->random(16).''.$this->random(16).''.$this->random(16);
	  }
	  /*
	    * Login Check
	  */
	  public function swipe_check_app_callback() {
		  global $wpdb;
		  $swipe = $wpdb->prefix.'swipe';	
		  $nonce = sanitize_text_field($_POST['_nonce']);
		  $ip = sanitize_text_field($_POST['ip']);
		  if ( /*wp_verify_nonce( $nonce, 'swipe' ) &&*/ sanitize_text_field($_POST['login_check']) == 'app') { 
		     $get_user = $wpdb->get_row("select * from ".$swipe." where ip_address = '".$ip."' AND ustatus = '1' AND is_logged_out = '0'"  );
			 if($get_user) {
               wp_set_auth_cookie($get_user->uid);
			   echo '1';
			 }
		  }
		  die;
	  }
	  /*
	  Reset APP
	  */
	  public function users_reset_app() {
		 global $wpdb;
         $userinfo = wp_get_current_user();  
		 $swipe = $wpdb->prefix.'swipe';
		 $wpdb->update($swipe, array('ustatus' => '0', 'is_logged_out' => '0'), array('uid' => $userinfo->ID));
      }
	   /*
	     * Get User Data
	   */
	  public function get_user_data() {
		  global $wpdb;
		  $swipe = $wpdb->prefix.'swipe';	
		  $get_results = $wpdb->get_row("select * from ".$swipe."");
		  return $get_results;
	  }
	   /*
	     * Save Data
	   */
	  public function save_data($id) {
		  global $wpdb;
		  $swipe = $wpdb->prefix.'swipe';
		  $get_user = $wpdb->get_row("select * from ".$swipe." where uid = '".$id."'");
		  $key = $this->generated_number();
		  $ip = $this->get_ip();
		  if($get_user) {
			 //simply update and send email
			   $saveuser = $wpdb->update($swipe, array('ukey' => $key, 'ustatus' => '0', 'is_logged_out' => '0', 'ip_address' => $ip), array('uid' => $id));		 
		  } else {
			 //simply insert and send email 
			 $saveuser = $wpdb->insert($swipe, array('uid' => $id, 'ukey' => $key, 'ustatus' => '0', 'is_logged_out' => '0', 'ip_address' => $ip));		
		  }
		  if($saveuser) {
			  $this->send_email($id);
			  $this->redirect('?page=swipe_qr_users&msg=1&source=qr&id='.$id);
		  } else {
			  $this->redirect('?page=swipe_generate&msg=2');
		  }		  
	  }
	 /* Send QR email */ 
     public function send_email($id) {
		    global $wpdb;
		    $swipeTbl = $wpdb->prefix.'swipe';
		    $user = get_userdata($id);
			$admin_email = get_option('admin_email');
			$blog_name = get_bloginfo('name');
			$to = $user->user_email;
			$QrUser = $wpdb->get_row("select * from ".$swipeTbl." where uid= '".$id."'");			
			$qrQuery = 'verify='.admin_url('admin-ajax.php?action=qr_verify').'||un='.$user->display_name.'||uid='.$id.'||ip='.base64_encode($QrUser->ip_address).'||secrete='.$QrUser->ukey.'||title='.$blog_name;
			$attachment = "https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=".$qrQuery."&choe=UTF-8";
			$subject = "Swipe Generated QR Code";
			$message = '';			
			include('templates/email.php');
			// Always set content-type when sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			
			// More headers
			$headers .= 'From: '.$blog_name.' <no-reply@swipepro.io>' . "\r\n";	
			if($_SERVER['HTTP_HOST'] != 'localhost') {
			  mail($to,$subject,$message,$headers);
			}
    }
	   /*
	     * Get IP
	   */
	  public function get_ip() {
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];
		$_SERVER_ADDR  = $_SERVER['SERVER_ADDR'];
		return $_SERVER_ADDR;
	  }
	  /*
	    *redirect
	  */
	  public function redirect($url) {
		echo '<script>window.location.href="'.$url.'"</script>';
		die;
	  }
	  /*
	    Verify Login with app
	  */
	  public function qr_verify_callback() {
		    	global $wpdb;
				$swipe_app_users = $wpdb->prefix.'swipe_app_users';
				$swipe = $wpdb->prefix.'swipe';
				$swipe_app_logs = $wpdb->prefix.'swipe_app_logs';
			    $usecret = isset($_POST['secrete']) ? sanitize_text_field($_POST['secrete']) : '';
				$ip = isset($_POST['ip']) ? sanitize_text_field($_POST['ip']) : '';
				$email = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
				$phonemodel = isset($_POST['phone_model']) ? sanitize_text_field($_POST['phone_model']) : '';
				if($usecret == '') {
					echo json_encode(array('status' => 0, 'msg' => 'Secrete is empty.'));
					die;
				} else if($ip == '') {
					echo json_encode(array('status' => 0, 'msg' => 'IP is empty.'));
					die;
				} else if(base64_decode($ip) != $this->get_ip()) {
					echo json_encode(array('status' => 0, 'msg' => 'Login failed due to IP Conflict. Regenerate QR code and scan it again.'));
					die;
				}
				$swipe_user_exists = $wpdb->get_row('select * from '.$swipe_app_users.' where email = "'.$email.'" AND mobile_model = "'.$phonemodel.'"');
				if(!$swipe_user_exists) {
					echo json_encode(array('status' => 0, 'msg' => 'Unable to login, please contact administrator.'));
					die;
				}
				// check block and existance
				$swipe_user = $wpdb->get_row('select * from '.$swipe_app_users.' where email = "'.$email.'" AND mobile_model = "'.$phonemodel.'" AND blocked = 1');
				if($swipe_user) {
					echo json_encode(array('status' => 0, 'msg' => 'Login is blocked by site administrator.'));
					die;
				}
				$login_time = isset($_POST['login_time']) ? $_POST['login_time'] : '';
				$ip = base64_decode($ip);
				$get_data = $wpdb->get_row('select * from '.$swipe.' where ukey = "'.$usecret.'" AND ip_address = "'.$ip.'" AND ustatus = 0');
				if(count($get_data) == 1) {
						 $uid = $get_data->uid;
						 $wpdb->update($swipe, array('ustatus' => '1', 'is_logged_out' => '0'), array('uid' => $uid));
						 $wpdb->insert($swipe_app_logs, array('uid' => $uid, 'login_date' => $login_time));
						 echo json_encode(array('status' => 1, 'msg' => 'Login Verification Success!'));
						 die;
					} else {
						echo json_encode(array('status' => 0, 'msg' => 'Login Verification Failed!'));
					  die;
				}
			die;
		}
		/*
		  Swipe logs response
		*/
		public function swipe_logs_response() {
			    $usecret = isset($_POST['secrete']) ? sanitize_text_field($_POST['secrete']) : '';
				$ip = isset($_POST['ip']) ? sanitize_text_field($_POST['ip']) : '';
				if($usecret == '') {
					echo json_encode(array('status' => 0, 'msg' => 'Secrete is empty.'));
					die;
				} else if($ip == '') {
					echo json_encode(array('status' => 0, 'msg' => 'IP is empty.'));
					die;
				}
				global $wpdb;
				$swipe = $wpdb->prefix.'swipe';
				$swipe_app_logs = $wpdb->prefix.'swipe_app_logs';
				$ip = base64_decode($ip);
				$get_data = $wpdb->get_row('select * from '.$swipe.' where ukey = "'.$usecret.'" AND ip_address = "'.$ip.'"');
				 if(count($get_data) == 1) {
						 $uid = $get_data->uid;
			             $response = $wpdb->get_results('select * from '.$swipe_app_logs.' where uid = "'.$uid.'"', ARRAY_A);
						 echo json_encode(array('status' => 1, 'response' => $response));
						 die;
					} else {
						echo json_encode(array('status' => 0, 'response' => 'No logs found.'));
					  die;
				}
			die;
		}
		/*
		Logout from App
		*/
		public function qr_logout_from_app() {
			global $wpdb;
			$swipe = $wpdb->prefix.'swipe';	
			$swipe_app_logs = $wpdb->prefix.'swipe_app_logs';
			$swipe_app_users = $wpdb->prefix.'swipe_app_users';				
			$usecret = isset($_POST['secrete']) ? sanitize_text_field($_POST['secrete']) : '';
			$ip = isset($_POST['ip']) ? sanitize_text_field($_POST['ip']) : '';
			$email = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
			$phonemodel = isset($_POST['phone_model']) ? sanitize_text_field($_POST['phone_model']) : '';
			if($usecret == '') {
				echo json_encode(array('status' => 0, 'msg' => 'Secrete is empty.'));
				die;
			} else if($ip == '') {
				echo json_encode(array('status' => 0, 'msg' => 'IP is empty.'));
				die;
			} else if($email == '') {
				echo json_encode(array('status' => 0, 'msg' => 'Email is empty.'));
				die;
			} else if($phonemodel == '') {
				echo json_encode(array('status' => 0, 'msg' => 'Phone Model is empty.'));
				die;
			}
			
			$swipe_user_exists = $wpdb->get_row('select * from '.$swipe_app_users.' where email = "'.$email.'" AND mobile_model = "'.$phonemodel.'"');
			if(!$swipe_user_exists) {
				echo json_encode(array('status' => 0, 'msg' => 'Unable to logout, please contact administrator.'));
				die;
			}
			// check block and existance
			$swipe_user = $wpdb->get_row('select * from '.$swipe_app_users.' where email = "'.$email.'" AND mobile_model = "'.$phonemodel.'" AND blocked = 1');
			if($swipe_user) {
				echo json_encode(array('status' => 0, 'msg' => 'Logout is blocked by site administrator.'));
				die;
			}
			$ip = base64_decode($ip);
			$get_data = $wpdb->get_row('select * from '.$swipe.' where ukey = "'.$usecret.'" AND ip_address = "'.$ip.'"');
			if(count($get_data) == 1) {
			 $uid = $get_data->uid;	
			 $wpdb->update($swipe, array('ustatus' => '0', 'is_logged_out' => '1'), array('uid' => $uid));
			 $sessions = WP_Session_Tokens::get_instance( $uid );
			 $sessions->destroy_all();
			 wp_clear_auth_cookie();
			   echo json_encode(array('status' => 1, 'msg' => 'Logged out successfully.'));
			} else {
			   echo json_encode(array('status' => 0, 'msg' => 'Unable to logged out.'));	
			}
			die;
		}
		// who is
		public function who_is_callback() {
			global $wpdb;
			$swipe_app_users = $wpdb->prefix.'swipe_app_users';
		    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
			$email = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
			$uid = isset($_POST['uid']) ? intval($_POST['uid']) : ''; 
			$mobile_model = isset($_POST['mobile_model']) ? sanitize_text_field($_POST['mobile_model']) : '';
			    if($name == '') {
					echo json_encode(array('status' => 0, 'msg' => 'Name is empty.'));
					die;
				} else if($email == '') {
					echo json_encode(array('status' => 0, 'msg' => 'Email is empty.'));	
					die;			
				} else if($mobile_model == '') {
					echo json_encode(array('status' => 0, 'msg' => 'Mobile Model is empty.'));	
					die;				
				} else {
					// saving
					$check_already_exists = $wpdb->get_row("select * from ".$swipe_app_users." where email = '".$email."'");
					if(!$check_already_exists) {
						$insert = $wpdb->insert($swipe_app_users, array('uid' => $uid, 'name' => $name,'email' => $email, 'mobile_model' => $mobile_model, 'blocked' => '0'));
						if($insert) {
							echo json_encode(array('status' => 1, 'msg' => 'User saved successfully.'));
							die;					
						} else {
							echo json_encode(array('status' => 0, 'msg' => 'User not saved. Try Again.'));		
							die;					
						}
					} else {
						$update = $wpdb->update($swipe_app_users, array('uid' => $uid, 'name' => $name,'email' => $email, 'mobile_model' => $mobile_model), array('email' => $email));
						if($update) {
							echo json_encode(array('status' => 1, 'msg' => 'User updated successfully.'));
							die;					
						} else {
							echo json_encode(array('status' => 1, 'msg' => 'User not updated. Try Again.'));		
							die;					
						}
					}
				}				
		}
		/* custom css */
		public function custom_css() {
		    wp_enqueue_style( 'style-swipe', plugin_dir_url( __FILE__ ) .'css/swipe.css' );
		}
		/* Load Scripts */
		public function qr_logged_out_load_scripts() {
		  echo '<script>';
		  echo 'var ip_address = "'.$this->get_ip().'"; ';
		  echo 'var redirect_url = "'.admin_url().'"; ';		
		  echo '</script>';
	      wp_enqueue_script('app-logout', plugin_dir_url( __FILE__ ) .'js/logout.js');
        }
		/* Swipe Save Settings */
		public function wp_ajax_swipe_save_settings() {
			$options = array();
			if ( wp_verify_nonce( $_POST['ajax_nonce'], 'swipe_login_secrete' ) ){
				delete_option('swipe_setting_options');
				$save_swipe_settings = update_option('swipe_setting_options', $_POST);
				if($save_swipe_settings) {
					echo '1';
				} else {
					echo '0';
				}
             }
			die;

		}
		// disable password		
		public function hide_profile_options() {
			global $wpdb;
			$user = wp_get_current_user();
			$swipe = $wpdb->prefix.'swipe';
            $role = ( array ) $user->roles;
            $userrole = $role[0];
			$swipe_setting_options = get_option('swipe_setting_options');
			$current_page = basename($_SERVER['REQUEST_URI']);
			if($current_page == 'profile.php') {
			//case 1 - Disable passwords for all users and hide the password login form	
			if(($swipe_setting_options['swipe_hide_check']) && $swipe_setting_options['swipe_hide_check'] == 'true'){
					echo "<script>
						jQuery('document').ready(function(e) {
							jQuery('#your-profile #password').html('<th></td><td style=color:#fe3f3f>Password reset form is disabled by Swipe Administrator.</td>');
						});
						</script>";
		}
			//case 2 - Disable passwords for all users with privileges greater than or equal to
			else if(isset($swipe_setting_options['swipe_select_userrole']) && $swipe_setting_options['swipe_select_userrole'] != '')    {
				$saved_role = $swipe_setting_options['swipe_select_userrole'];
					if($saved_role == 'administrator') {
						if($userrole == $saved_role) {
							echo $this->disable_password();
						}
					} else if($saved_role == 'editor') {
						if(in_array($userrole, array('administrator', 'editor'))) {
							echo $this->disable_password();
						}
					} else if($saved_role == 'author') {
						if(in_array($userrole, array('administrator', 'editor', 'author'))) {
							echo $this->disable_password();
						}
					} else if($saved_role == 'contributor') {
						if(in_array($userrole, array('administrator', 'editor', 'author', 'contributor'))) {
							echo $this->disable_password();
						}
					} else if($saved_role == 'subscriber') {
							echo $this->disable_password();
					}
				
			}			
			// case 3 - Disable password for Swipe Users
			else if(isset($swipe_setting_options['swipe_disable_check']) && $swipe_setting_options['swipe_disable_check'] == 'true')              {
				$get_user = $wpdb->get_row("select * from ".$swipe." where uid = '".$user->ID."'");
				if($get_user) {
					echo $this->disable_password();
				}
				}
			}
		}
		/* diabale password */
		public function disable_password() {
			$disable_password = "<script>
					jQuery('document').ready(function(e) {
						jQuery('#your-profile #password td').html('<span style=color:#fe3f3f>Password is Disabled by Swipe Administrator.</span>');
					});
					</script>";
			return $disable_password;		
		}
		/*
		View Swipe QR users - qr
		*/
		public function swipe_view_qr_users_callback() {
			global $wpdb;
		    $swipe = $wpdb->prefix.'swipe';
			$uid = isset($_POST['uid']) ? intval($_POST['uid']) : '';
			if(!empty($uid)) {
				$data = $wpdb->get_row("select * from ".$swipe." where uid = '".$uid."'");
				$user = get_userdata($uid);
				$blog_name = get_bloginfo('name');		
				$qrQuery = 'verify='.admin_url('admin-ajax.php?action=qr_verify').'||un='.$user->display_name.'||uid='.$uid.'||ip='.base64_encode($data->ip_address).'||secrete='.$data->ukey.'||title='.$blog_name;
				$attachment = "https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=".$qrQuery."&choe=UTF-8";	
				echo json_encode(array('status' => '1', 'msg' => 'Success', 'user_name'=> $user->display_name, 'user_email' => $user->user_email, 'attachment' => $attachment));
			} else {
				echo json_encode(array('status' => '0', 'msg' => 'Invalid User ID.'));
			}
			die;
		}
		/*
		View QR app users
		*/		
		public function swipe_view_app_users_callback() {
			global $wpdb;
		    $swipe = $wpdb->prefix.'swipe_app_users';
			$id = isset($_POST['id']) ? intval($_POST['id']) : '';
			if(!empty($id)) {
				$data = $wpdb->get_row("select * from ".$swipe." where id = '".$id."'");	
				if($data) {
				  echo json_encode(array('status' => '1', 'msg' => 'Success', 'name'=> $data->name, 'email' => $data->email, 'mobile_model' => $data->mobile_model, 'register_date' => $data->register_date, 'block_url' => 'admin.php?page=swipe_qr_users&id='.$id.'&action=block', 'trash_url' => 'admin.php?page=swipe_qr_users&id='.$id.'&action=trash'));
				} else {
				  echo json_encode(array('status' => '0', 'msg' => 'No Records Found!'));	
				}
			} else {
				echo json_encode(array('status' => '0', 'msg' => 'Invalid User ID.'));
			}
			die;
		}
	}
	new swipe_controller;
} 
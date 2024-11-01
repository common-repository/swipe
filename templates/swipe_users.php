<?php if ( ! defined( 'ABSPATH' ) ) exit;
global $wpdb;
$this->custom_css();
$swipe_qr_users = $wpdb->prefix.'swipe';
$swipe_app_users = $wpdb->prefix.'swipe_app_users';
$swipeQrUsers = $wpdb->get_results("select * from ".$swipe_qr_users." order by id DESC"); 
$swipeBlockedUsers = $wpdb->get_results("select * from ".$swipe_app_users." where blocked='1' order by id DESC");
?>
<div class="wrap setting_wrap">
<h1 class="title"><img src="<?php echo SWIPE_PRO_PATH.'/images/users.png';?>"/><?php _e('Users','swipe'); ?> <a href="admin.php?page=swipe_generate" class="button button-primary"><?php _e('Generate QR','swipe'); ?></a>
</h1>
<p class="description"><?php _e('List of users using swipe app login for your website.','swipe'); ?></p>
<?php 
if(isset($_GET['action']) && !empty($_GET['action'])) {
	$id = (int) $_GET['id'];
	// trash process	
	if($_GET['action'] == 'swipe_user_trash') {
		echo 'Deleting please wait...';
		$trash = $wpdb->delete($swipe_qr_users, array('id' => $id));
		if($trash) {
		 $this->redirect('?page=swipe_qr_users&trash=1');
		} else {
		 $this->redirect('?page=swipe_qr_users&trash=2');
		}
	}
	// block	
	if($_GET['action'] == 'block') {
		echo 'Blocking please wait...';
		$block = $wpdb->update($swipe_app_users, array('blocked' => '1'), array('id' => $id));
		if($block) {
		 $this->redirect('?page=swipe_qr_users&blocked=1');
		} else {
		 $this->redirect('?page=swipe_qr_users&blocked=2');
		}
	} 
	 // trash process	
    if($_GET['action'] == 'trash') {
		echo 'Trashing please wait...';
		$trash = $wpdb->delete($swipe_app_users, array('id' => $id));
		if($trash) {
		 $this->redirect('?page=swipe_qr_users&trash=1');
		} else {
		 $this->redirect('?page=swipe_qr_users&trash=2');
		}
	}
	// unblock
	if($_GET['action'] == 'unblock') {
		echo 'Unblocking please wait...';
		$block = $wpdb->update($swipe_app_users, array('blocked' => '0'), array('id' => $id));
		if($block) {
		 $this->redirect('?page=swipe_qr_users&unblocked=1');
		} else {
		 $this->redirect('?page=swipe_qr_users&unblocked=2');
		}
	} 
}
?>

<div class="swipeUserTabWrap">

<ul class="swipeuserTab">
<li class="current" data-tab="swipe_tab1"><?php _e('Swipe Users ('.count($swipeQrUsers).')','swipe'); ?></li>
<li data-tab="swipe_tab2"><?php _e('Blocked Users ('.count($swipeBlockedUsers).')','swipe'); ?></li>
</ul>


<div class="swipeTabContent current" id="swipe_tab1">
<?php if(count($swipeQrUsers) == 0) { ?>
<div class="swipe_no_data">
	<?php _e('No QR users found.','swipe'); ?>
</div>    
<?php } else { ?>
<table class="wp-list-table widefat fixed middle_align">
    <thead>
      <tr>
        <th><strong><?php _e('Name','swipe'); ?></strong></th>       
        <th><strong><?php _e('Email','swipe'); ?></strong></th>
         <th><strong><?php _e('App Users','swipe'); ?></strong></th>
        <th><?php _e('','swipe'); ?></th>
      </tr>
    </thead>
    <tbody>
    <?php 
	if(isset($swipeQrUsers) && !empty($swipeQrUsers)) { 
	$count = 1;
	foreach($swipeQrUsers as $swipeQrUser) { 
	 $user = get_userdata($swipeQrUser->uid);
	 $swipeUsers = $wpdb->get_results("select * from ".$swipe_app_users." where blocked='0' AND uid = '".$swipeQrUser->uid."' order by id DESC"); 
	?>
      <tr>
        <td><?php echo $user->display_name;?> (<a href="user-edit.php?user_id=<?php echo $swipeQrUser->uid;?>"><?php echo '#'.$swipeQrUser->uid;?></a>)</td>
        <td><?php echo $user->user_email;?></td>
        <td>
        <?php if(count($swipeUsers) > 0) { ?>
        <ul class="swipeAppUserList">
           <?php foreach($swipeUsers as $swipeUser) {?>
        	<li><a href="#" data-id="<?php echo $swipeUser->id;?>" class="view_app_user"><?php echo $swipeUser->name;?></a></li>
            <?php } ?>
        </ul>
        <?php } else { ?>
        <span class="swipeAppUserListNone"><?php _e('No App users found.','swipe'); ?></span>
        <?php } ?>
        </td>
        <td>
        <a href="#" class="button button-primary view_qr_user_details" data-uid="<?php echo $swipeQrUser->uid;?>"><?php _e('View','swipe'); ?></a>      
        <a href="admin.php?page=swipe_qr_users&id=<?php echo $swipeQrUser->id;?>&action=swipe_user_trash" class="button" onclick="return confirm('Are you sure to delete this user?')"><?php _e('Delete','swipe'); ?></a></td>
      </tr>
      <?php } } ?>
    </tbody>
  </table>
<?php } ?>
</div>


<div class="swipeTabContent" id="swipe_tab2">
<?php if(count($swipeBlockedUsers) == 0) { ?>
<div class="swipe_no_data">
<?php _e('No blocked user found.','swipe'); ?>
</div>    
<?php } else { ?>
<table class="wp-list-table widefat fixed middle_align">
    <thead>
      <tr>
        <th><strong><?php _e('Name','swipe'); ?></strong></th>        
        <th><strong><?php _e('Email','swipe'); ?></strong></th>
        <th><strong><?php _e('Phone Model','swipe'); ?></strong></th>
        <th><?php _e('','swipe'); ?></th>
      </tr>
    </thead>
    <tbody>
    <?php if(isset($swipeBlockedUsers) && !empty($swipeBlockedUsers)) { 
	foreach($swipeBlockedUsers as $swipeBlockedUser) { 
	?>
      <tr>
        <td><?php echo $swipeBlockedUser->name;?></td>
        <td><?php echo $swipeBlockedUser->email;?></td>
        <td><?php echo $swipeBlockedUser->mobile_model;?></td>
        <td>
        <a href="admin.php?page=swipe_qr_users&id=<?php echo $swipeBlockedUser->id;?>&action=unblock" class="button button-primary" onclick="return confirm('Are you sure to unblock this user?')"><?php _e('Unblock','swipe'); ?></a>        
        <a href="admin.php?page=swipe_qr_users&id=<?php echo $swipeBlockedUser->id;?>&action=trash" class="button" onclick="return confirm('Are you sure to delete this user?')"><?php _e('Delete','swipe'); ?></a></td>
      </tr>
      <?php } } ?>
    </tbody>
  </table>
<?php } ?>
</div>

</div>

</div>


<div class="swipeqrPopWrap" style="display:none">
<div class="swipeqrPopWrapOverlay"></div>
	<div class="swipeqrPopTbl">
    	<div class="swipeqrPopCel">
        	<div class="swipeqrPopInner">
             <?php if(isset($_GET['source']) && $_GET['source'] == 'qr') { ?>
              <a href="admin.php?page=swipe_qr_users" class="closeSwipeqrPop">&times;</a>
              <?php } else { ?>
              <a href="javascript:void(0)" class="closeSwipeqrPop">&times;</a>
              <?php } ?>            	
                <div class="topSec">
                <h3>
                <span class="icon"><img src="<?php echo SWIPE_PRO_PATH.'/images/install.png';?>"></span>
                <span class="text"><?php _e('Scan the QR code using the mobile app','swipe'); ?></span>
                </h3>
                <label id="swipe_uid_uname"></label>
                </div>             
                <div class="qrCodeImg" id="swipe_qr_image"></div>
                
            </div>
        </div>
    </div>
</div>


<div class="swipeUserListPopWrap" style="display:none;">
<div class="swipeUserListPopWrapOverlay"></div>
	<div class="swipeUserListPopTbl">
    	<div class="swipeUserListPopCel">
        	<div class="swipeUserListPopInner">
            <a href="javascript:void(0)" class="closeSwipeUserListPop">&times;</a>
                <div class="topSec">
                <h3><span class="text"><?php _e('Swipe App Users','swipe'); ?></span></h3>               
                </div>
               <div class="swipeUserListPopLoad" style="display:none"><?php _e('Loading...','swipe'); ?></div>
               <div class="view_qr_app_user_details" style="display:none"> 
                   <div class="sUserDtGrp">
                   <div class="hText"><?php _e('Name','swipe'); ?></div>
                   <div class="subText get_swipe_user_name"></div>
                   </div>
                   <div class="sUserDtGrp">
                   <div class="hText"><?php _e('Email','swipe'); ?></div>
                   <div class="subText get_swipe_user_email"></div>
                   </div>
                   <div class="sUserDtGrp">
                   <div class="hText"><?php _e('Mobile Model','swipe'); ?></div>
                   <div class="subText get_swipe_user_mobile_model"></div>
                   </div>
                   <div class="sUserDtGrp">
                   <div class="hText"><?php _e('Register Date','swipe'); ?></div>
                   <div class="subText get_swipe_user_register_date"></div>
                   </div>
                   <div style="display:none" class="action_swipe_app_user"></div>
               </div>
                
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" >
   jQuery(document).ready(function() {
	 var swipe_ajax_url = "<?php echo admin_url('admin-ajax.php')?>";
	  // diaplay after redirect from qr
	 <?php if(isset($_GET['source']) && $_GET['source'] == 'qr') { ?>
	  var id = '<?php echo intval($_GET['id'])?>';
	  show_user_qr_block(swipe_ajax_url, id);
	 <?php } ?>
     jQuery('.view_qr_user_details').click(function(e) {
	   var id = jQuery(this).data('uid')
	   show_user_qr_block(swipe_ajax_url, id);	 
	 });
	 
	 // app user details
	 
	  jQuery('.view_app_user').click(function(e) {
		 jQuery('.swipeUserListPopWrap').show(); 
		 jQuery('.swipeUserListPopLoad').show();  
		 var swipe_id = jQuery(this).data('id');
          var data = {
			'action': 'swipe_view_app_users',
			'id': swipe_id
		};
		jQuery.post(swipe_ajax_url, data, function(response) {
			jQuery('.swipeUserListPopLoad').hide();
			 var myJSON = JSON.parse(response);
			 var status = myJSON.status;
			 jQuery('.view_qr_app_user_details').show();
			 if(status == '1') {
				jQuery('.get_swipe_user_name').html(myJSON.name);
				jQuery('.get_swipe_user_email').html(myJSON.email);
				jQuery('.get_swipe_user_mobile_model').html(myJSON.mobile_model);
				jQuery('.get_swipe_user_register_date').html(myJSON.register_date);
				var swipe_user_app_action_btns = '<a href="'+myJSON.block_url+'" class="button button-primary">Block</a> ';
				    swipe_user_app_action_btns += '<a href="'+myJSON.trash_url+'" class="button">Delete</a>';
				jQuery('.action_swipe_app_user').show().html(swipe_user_app_action_btns);
			 } else {
				jQuery('.view_qr_app_user_details').html(myJSON.msg);				
			 }
		});   
     });
	 
	 
	 // close popup
	  jQuery('.closeSwipeqrPop').click(function(e) {
		jQuery('.swipeqrPopWrap').hide();  
	  });
	  
	   jQuery('.closeSwipeUserListPop').click(function(e) {
		jQuery('.swipeUserListPopWrap').hide(); 
		jQuery('.view_qr_app_user_details').hide();
	  });	  
	});
	function show_user_qr_block(swipe_ajax_url, id) {		
		 jQuery('#swipe_uid_uname').html('Loading...');
		 jQuery('#swipe_qr_image').html('');
		 jQuery('.swipeqrPopWrap').show();  
		 var swipe_uid = id;
          var data = {
			'action': 'swipe_view_qr_users',
			'uid': swipe_uid
		};
		jQuery.post(swipe_ajax_url, data, function(response) {
			 var myJSON = JSON.parse(response);
			 var status = myJSON.status;
			 if(status == '1') {
				jQuery('#swipe_uid_uname').html('#'+swipe_uid+' '+myJSON.user_name+' '+'<span class="smText"> ('+myJSON.user_email+')</span>');
				jQuery('#swipe_qr_image').html('<img src="'+myJSON.attachment+'">');
			 } else {
				jQuery('#swipe_uid_uname').html(myJSON.msg); 
			 }
		});  
	}
	</script>
    
    <script>
	jQuery(document).ready(function(){
	
	jQuery('ul.swipeuserTab li').click(function(){
		var tab_id = jQuery(this).attr('data-tab');

		jQuery('ul.swipeuserTab li').removeClass('current');
		jQuery('.swipeTabContent').removeClass('current');

		jQuery(this).addClass('current');
		jQuery("#"+tab_id).addClass('current');
	});

});
</script>
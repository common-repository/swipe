jQuery(document).ready(function(e) {
	if(hide_form) {
		 jQuery('#loginform p').remove();
		 jQuery('#nav').remove();
	} else {
		jQuery('#show_login_form').remove();
	}
       setInterval(ajaxCall, 3000); 
	   
	jQuery(".barcode g rect").each(function () {

         jQuery(this).css("animation-duration",((Math.random() * (9 - 5) + 5)*.15).toString().substring(0,4) + "s");
    });
   
});
function ajaxCall() {
 var data = {
			'action': 'swipe_check_app',
			'_nonce': _qrnonce,
			'login_check': 'app', 
			'ip': ip_address, 
		};

		jQuery.post(ajaxurl, data, function(response) {
			if(response == '1') {
				window.location.href = redirect_url;
			}
		});  
}
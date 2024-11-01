jQuery(document).ready(function(e) {
       setInterval(ajaxLogoutCall, 3000); 	   
 });
function ajaxLogoutCall() {
 var data = {
			'action': 'swipe_check_logout',
			'ip': ip_address,
		};

		jQuery.post(ajaxurl, data, function(response) {
			if(response == '1') {
				window.location.href = redirect_url;
			}
		}); 
}

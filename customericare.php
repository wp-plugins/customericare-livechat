<?php
/*
Plugin Name: CustomerICare Livechat
Plugin URI: http://customericare.com/knowledgebase/live-chat-wordpress/
Description: Live chat software designed for Wordpress. Quickly add a chat box to your website and start chatting with visitors. It's so easy! 
Author: CustomerICare livechat
Author URI: http://customericare.com
Version: 1.2.4
*/
global $wp_version;


if (version_compare($wp_version, "2.5", "<"))
{
    exit("Requires WordPress 2.5 or newer");
}


if (is_admin())
{
	require_once(plugin_dir_path( __FILE__ ).'/assets/CicChatAdmin.class.php');
	CicChatAdmin::get_instance();
}
else
{
	require_once(plugin_dir_path( __FILE__ ).'/assets/CicChatPlugin.class.php');
	CicChatPlugin::get_instance();
}

function ao_script() {
?>
    <script type="text/javascript">
	jQuery(document).ready(function($){
		var ao_server_url = 'https://app.customericare.com'; 
		//var ao_server_url = 'http://app-local';
		var ao_div = [
			'<div style="position: fixed; top: 80px; width: 300px; background-color: #fff; z-index: 9999; left: 0; right: 0; margin: auto; padding: 20px; box-shadow: 1px 1px 1px grey;">',
			'<img src="<?=plugin_dir_url( __FILE__ )?>assets/img/logo.png" alt="customericare" />',
			'<p>Tell as please, what is the reason for deactivating plugin? :( </p>',
			'<textarea id="ao_survey_wp" style="width: 300px; height: 100px; font-size: 12px;"></textarea> <br/><br/>',
			'<div style="text-align: right;"><button id="cic-deactivate" class="button-secondary">Send informaction and Deactivate plugin</button></div>',
			'</div>'].join("");
	
		var ao_href='';
		var ao_email = "<?=get_option('cic-api-email')?>";
		
		
		$('#customericare-livechat').find('.deactivate a').click(function(e){
			ao_href =  $(this).attr('href');
			e.preventDefault();
			
			$('body').append(ao_div);
		});
		
		$(document).on('click', '#cic-deactivate', function() {
		
			var ao_text = $('#ao_survey_wp').val();
			
			if(ao_text.length != 0)
			{
				$.ajax({
					url: ao_server_url+'/ajax/survey-wp',
					type: "POST",
					dataType: 'JSONP',
					data: {text: ao_text, email: ao_email},
					success: function (data, status, error) {
						window.location.href=ao_href;
					}
				});
			}
			
		});
	});
		
    </script><?php
}

add_action( 'admin_footer', 'ao_script' );



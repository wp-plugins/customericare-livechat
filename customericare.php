<?php
/*
Plugin Name: CustomerICare Livechat
Plugin URI: http://customericare.com/knowledgebase/live-chat-wordpress/
Description: Live chat software designed for Wordpress. Quickly add a chat box to your website and start chatting with visitors. It's so easy! 
Author: CustomerICare livechat
Author URI: http://customericare.com
Version: 1.2.3
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


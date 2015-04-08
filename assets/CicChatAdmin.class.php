<?php

class CicChatAdmin
{

	private static $instance;
    private function __construct()
    {
    	add_action('init', array($this, 'init'));
    	add_action('admin_menu', array($this, 'admin_menu'));

		/*
		delete_option( 'cic-apikey' );
		delete_option( 'cic-api-email' );
		delete_option( 'cic-token' );
		*/
    	if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			//save apikey
			if(isset($_POST['cic-apikey']) && !empty($_POST['cic-apikey']) && isset($_POST['cic-api-email']) && !empty($_POST['cic-api-email']))
			{
				update_option('cic-apikey', $_POST['cic-apikey']);
                update_option('cic-api-email', $_POST['cic-api-email']);
			}
			
			if(isset($_POST['cic-token']))//can be null
			{
				update_option('cic-token', $_POST['cic-token']);
			}
		}
    }

    public static function get_instance()
    {
        if ( !isset( self::$instance ) )
        {
            $c = __CLASS__;
            self::$instance = new $c();
        }

        return self::$instance;
    }


    public function init()
    {
    	wp_enqueue_script('customericare', plugin_dir_url( __FILE__ ).'/js/cic.js', 'jquery', $this->plugin_version(), true);
		wp_enqueue_style('customericare', plugin_dir_url( __FILE__ ).'/css/cic.css', false, $this->plugin_version());
		

    }

	public function build_query()
	{
		$data = array();
		$p = '';
		$t = get_option('cic-token');
		
		if(!empty($t))
		{
			$data = array(
				'email' => get_option('cic-api-email'),
				'token' => get_option('cic-token'),
				'paylane' => 'one'
			);
			$p = 'login/token/?';
		}
		
		$q = http_build_query($data, '', '&');
		
		return 'https://app.customericare.com/'.$p.$q;
	}
	
    /**
     * make menu
     */
    public function admin_menu()
    {
    	add_menu_page('CustomerICare', 'CustomerICare', 'administrator', 'cic-admin-settings', array($this, 'admin_settings_page'), plugin_dir_url( __FILE__ ).'/img/favicon.png' );
		
		add_submenu_page(
			'cic-admin-settings',
			'Sign in to Live chat',
			'Sign in to Live chat',
			'administrator',
			'admin-redirect-to-app',
			array($this, 'admin_redirect_to_app')
		);

    }

    /**
     * render settings page
     */
    public function admin_settings_page()
    {
		$link = $this->build_query();
    	
    	require_once ('templates/CicSettingsPage.class.php');
    	$cicSettingsPageModel = new CicSettingsPage();
    	$cicSettingsPageModel->render( $link );
		
		echo "<script> jQuery('a[href=\"admin.php?page=admin-redirect-to-app\"]').attr('href', '".str_replace('&paylane=one', '', $link)."').attr('target', '_blank') </script>";
		echo "<script> jQuery('a[href=\"admin.php?page=cic-admin-settings\"]').parent('.wp-first-item').remove();  </script>";
		
    }


    /**
     * get plugin version
     */
    public function plugin_version()
    {
		if ( function_exists( 'get_plugin_data' ) ) {
			$plugin = get_plugin_data( plugin_dir_path( __FILE__ ).'../customericare.php', true, true );
		} else
		{
			if (!function_exists('get_plugins'))
			{
				require_once(ABSPATH.'wp-admin/includes/plugin.php');
			}
			$plugin_path 		= get_plugins('/'.plugin_basename(dirname(__FILE__).'/..'));
			$plugin['Version'] 	= $plugin_path['customericare.php']['Version'];
		}
		
    return $plugin['Version'];
    }

}
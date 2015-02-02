<?php

class CicChatAdmin
{

	private static $instance;
    private function __construct()
    {
    	add_action('init', array($this, 'init'));
    	add_action('admin_menu', array($this, 'admin_menu'));

    	if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			//save apikey
			if(isset($_POST['cic-apikey']) && !empty($_POST['cic-apikey']) && isset($_POST['cic-api-email']) && !empty($_POST['cic-api-email']))
			{
				update_option('cic-apikey', $_POST['cic-apikey']);
                update_option('cic-api-email', $_POST['cic-api-email']);
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

    /**
     * make menu
     */
    public function admin_menu()
    {
    	add_menu_page('CustomerICare', 'CustomerICare', 'administrator', 'cic-admin-settings', array($this, 'admin_settings_page'), plugin_dir_url( __FILE__ ).'/img/favicon.png' );
    }

    /**
     * render settings page
     */
    public function admin_settings_page()
    {
    	require_once ('templates/CicSettingsPage.class.php');
    	$cicSettingsPageModel = new CicSettingsPage();
    	$cicSettingsPageModel->render();
    }

    /**
     * get plugin version
     */
    public function plugin_version()
    {
    	$plugin = get_plugin_data( plugin_dir_path( __FILE__ ).'../customericare.php', true, true );
    return $plugin['Version'];
    }

}
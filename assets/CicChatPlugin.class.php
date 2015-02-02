<?php

class CicChatPlugin
{

	private static $instance;
    private function __construct()
    {
    	add_action('init', array($this, 'init'));
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

    	add_action ('wp_footer', array($this, 'render'));
    }

    public function render()
    {

    	$apikey = get_option('cic-apikey');
    	if(!empty($apikey))
    	{
			echo '<div class="ao_plugin"></div>';
			echo '<script type="text/javascript" async="true" src="https://app.customericare.com/api?key='.$apikey.'"></script>';
		}
    }

}

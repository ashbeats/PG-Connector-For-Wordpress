<?php
/*
Plugin Name: ProxyGoblin Connector for WPsBOX
Plugin URI: http://proxygb.com/
Description: Connector to allow ProxyGoblin to communicate with WPsBox
Version: 1.0.0
Author: Ash 
Author URI: http://proxygb.com/
*/


require_once("global.functions.php");
/* ------------------------------------------------------------------------*
* Stylesheets
* ------------------------------------------------------------------------*/	
	wp_enqueue_style('wpalb', WP_PLUGIN_URL . '/alb/css/style.css');
	wp_enqueue_style('wpalbu', WP_PLUGIN_URL . '/alb/css/uniform.css');

/* MODS */
	add_filter('pre_option_alb_proxy_list', 'get_proxies_hook');
    
	function get_proxies_hook($val='')
    {
        return get_proxies(); 
    }

    
    add_filter('pre_update_option_alb_proxy_list', 'set_proxies_hook');

    function set_proxies_hook($option='', $newvalue='', $oldvalue='')
    {
    	//update_option($option, $newvalue);
		
       set_proxies($option); 	   
	   return $newvalue;  	      
    }



/* ------------------------------------------------------------------------*
* Creating the admin menu
* ------------------------------------------------------------------------*/	
	

	if(is_admin())
	{
		add_action('admin_menu', 'pgmenu_create');
	}

	function pgmenu_create()
	{
		$page_title ="My Page Tie";
		$menu_title ="Menu Titlesss";
		$capability ="administrator";
		$menu_slug = "pg_setting";
		
		//add_object_page( $page_title, $menu_title, $capability, $menu_slug, $function = '', $icon_url = '');
		$icon = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__)) . "css/proxygoblin-icon.png";
		
		add_submenu_page( 'edit.php?post_type=auto_comments', 'PGoblin Connector for WPsBOX', ' <img src="' . $icon . '" align="absmiddle"> PG Connector', 'administrator', 'pg_setting', 'pg_setting' );
	}
	
 	function pg_setting(){
		require_once(dirname(__FILE__).'/interface.php');
	}




?>
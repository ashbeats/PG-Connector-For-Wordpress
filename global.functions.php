<?php 

function get_proxy_count($pg_activelist)
{
    $dir = WP_PLUGIN_DIR.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
	
    $proxy_path = $dir."configs/". $pg_activelist .".txt";
 
    $count = 0;
	
    if (file_exists($proxy_path))
    {
        $proxies = @file_get_contents($proxy_path);
        
        //validate & extract proxies
        preg_match_all('/\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}(:[\d]+)\b/', $proxies, $result, PREG_PATTERN_ORDER);
        $proxies_array = $result[0];
        
        if (is_array($proxies_array))
        {
           	return count($proxies_array);
        }
    }
	
	return $count;
}

/***
 * Load proxies from text file, instead of DB
 * @return
 */

function get_proxies()
{
    $dir = WP_PLUGIN_DIR.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
	
	$pg_activelist = get_option('pg_activelist','proxies.inc'); /* New Mod */
	
    $proxy_path = $dir."configs/". $pg_activelist .".txt";
 
    
    if (file_exists($proxy_path))
    {
        $proxies = @file_get_contents($proxy_path);
        
        //validate & extract proxies
        preg_match_all('/\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}(:[\d]+)\b/', $proxies, $result, PREG_PATTERN_ORDER);
        $proxies_array = $result[0];
        
        if (is_array($proxies_array))
        {
            $proxies_cleaned_verified = implode("\n", $proxies_array);			
            return ($proxies_cleaned_verified);
        }
    }
}


function set_proxies($proxies)
{
    $dir = WP_PLUGIN_DIR.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
    $proxy_path = $dir."configs/proxies.inc.txt"; // By default
   
    //validate & extract proxies
    preg_match_all('/\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}(:[\d]+)\b/', $proxies, $result, PREG_PATTERN_ORDER);
    $proxies_array = $result[0];
    
    if (is_array($proxies_array))
    {
        $proxies_cleaned_verified = implode("\n", $proxies_array);	
	
		do_log("Proxies",$proxy_path);
		
        file_put_contents($proxy_path, $proxies_cleaned_verified);
    }
}



/* ------------------------------------------------------------------------*
* Logging Function
* ------------------------------------------------------------------------*/	
function do_log($type,$data){
	
    global $wpdb;
	$response = $wpdb->get_var("show tables like 'wplb_log'");
	    
	if ($response == "wplb_log")
	{
	    $now = date("F j, Y, g:i a");
	    $data = mysql_escape_string($data);
	    //$query="INSERT INTO wplb_log (action,date,data) values('$type','$now','$data')";
	        
	    $wpdb->insert('wplb_log', array('action'=>$type, 'date'=>$now, 'data'=>$data));
	    
	}
	 		
}

?>
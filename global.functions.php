<?php 
/***
 * Load proxies from text file, instead of DB
 * @return
 */

function get_proxies()
{
    $dir = WP_PLUGIN_DIR.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
    $proxy_path = $dir."configs/proxies.inc.txt";
    
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
    $proxy_path = $dir."configs/proxies.inc.txt";

   
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
<?php 
require_once ('../../../wp-load.php');

if (get_magic_quotes_gpc())
{
    $_REQUEST = array_map('stripslashes', $_REQUEST);
    $_GET = array_map('stripslashes', $_GET);
    $_POST = array_map('stripslashes', $_POST);
}

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
ini_set("max_execution_time", 0);

if (isset($_POST['isTestMode']))
{
    $isTestMode = true;
} else
{
    $isTestMode = false;
}

$isAuthenticated = false;

if (isset($_POST['passcode']))
{
    // Validate
    $passcode = ($_POST['passcode']);
    
    if ($passcode == get_option('pg_passcode'))
    {
        $isAuthenticated = true;
        
    } else
    {
        $isAuthenticated = false;
    }
    
}else{
	echo "Unauthorized User";
    die();
}

if (!$isAuthenticated)
{
    echo "Invalid Credentials. Did you change your Passcode recently?";
    die();
} else
{
    echo "Connected Successfully. \r\n";
}

/* Query For ProxyGoblin to Test if Script is Working properly */
if ($isTestMode)
{


    $wpurl = get_bloginfo('wpurl');
    $version = get_bloginfo('version');
    echo "-----------------------------------------------------\r\n";
    echo "Url: $wpurl"."\r\n";
    echo "Wordpress Version: $version"."\r\n";
    echo "-----------------------------------------------------\r\n";
    
    die();
}


/* Process ProxyLists */

if (isset($_POST['proxies']))
{
    // Validate
    $_POST = array_map('stripslashes', $_POST);
    $raw_proxies = $_POST['proxies'];
    
    $new_proxies = json_decode($raw_proxies, true);
    
    if (is_array($new_proxies) == false && count($new_proxies) <= 0)
    {
        echo "No Proxies Received By WpsBox";
        die();
    }
    
    $dir = WP_PLUGIN_DIR.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
    $proxy_path = $dir."configs/proxies.inc.txt"; // By default
    $proxy_path_google = $dir."configs/proxies.google.inc.txt"; // By default
    
    $list_of_all_proxies = "";
    $list_of_google_proxies = "";
    
    foreach ($new_proxies as $entry)
    {
    		
        if ($entry["IP"] <> "" && preg_match('/\b(?:[0-9]{1,3}\.){3}[0-9]{1,3}:[\d]+\b/', $entry["IP"]))
        {
            $list_of_all_proxies .= $entry["IP"] ."\n"; // Add to main list
            
            if ($entry['Google'] == "Yes")
            {
                $list_of_google_proxies .= $entry["IP"]."\n"; // Add to Google Only list
            }
        }
    }
    
	
    if ($list_of_all_proxies <> "")
    {
    	
		update_option('alb_proxylist', $list_of_all_proxies);
    	file_put_contents($proxy_path, $list_of_all_proxies);		
		file_put_contents($proxy_path_google, $list_of_google_proxies);
		        
        do_log("Proxies", count($new_proxies)." Updated Via API");
        echo count($new_proxies)." Proxies Updated Via API";
    }
    
}
?>
<?php 
ini_set('error_reporting', E_ERROR);

require_once('../../../wp-load.php');

if (isset($_POST['value']) && $_POST['value'] <> "")
{
    $active_filename = trim($_POST['value']);    	
	
	if($active_filename <> "" && preg_match('/proxies(\.google)?\.inc/sm', $active_filename) )
	{
		 update_option("pg_activelist", $active_filename);		 
		 $pg_activelist_text =  ($active_filename == "proxies.google.inc")? "Only Google Friendly":"All Proxies" ;
		 $pg_activelist_text .= " (". get_proxy_count($active_filename) .")";
		 echo $pg_activelist_text;
		 die();
	}else{
		$output = "Invalid Filename $active_filename";
		header('HTTP/1.1 400 Bad Request');
		echo $output;
		die();
	}	

} 

$output = "Invalid Selection";
header('HTTP/1.1 400 Bad Request');
echo $output;
die();





?>

<?php 
ini_set('error_reporting', E_ERROR);

require_once('../../../wp-load.php');

if (isset($_POST['value']) && $_POST['value'] <> "")
{
    $passcode = trim($_POST['value']);    
	$passcode = preg_replace('/[^\w]/', '', $passcode);
	
	$passcode = (strlen($passcode)>=15) ? substr($passcode, 0, 14) : $passcode ;
	
	if($passcode <> "")
	{
		 update_option("pg_passcode", $passcode);
		 echo $passcode;
		 die();
	}	

} 

$output = "Invalid Passcode";
header('HTTP/1.1 400 Bad Request');
echo $output;
die();





?>

<?php
error_reporting(0);
$about = "MPJ v1.0";
/* MOLURA'S PROXY JUDGE FOR PROXY GOBLIN v1.X */

/* 
	UPLOAD THIS FILE TO YOUR SERVER 
	
	Stricter Proxy Test
*/

/*
Filters:

HTTP_FORWARDED:
HTTP_X_FORWARDED_FOR:
HTTP_CLIENT_IP:
HTTP_VIA:
HTTP_XROXY_CONNECTION:
HTTP_PROXY_CONNECTION: 
*/


if ( preg_match('/:312[4-8]$/sm', urldecode($_GET['proxy']) ) ) 
{
	// Aggressive Codeen Filter
	// Remove Ports 3124 to 3128
	die();	
}


if (!$_SERVER['HTTP_X_FORWARDED_FOR'] && !$_SERVER['HTTP_FORWARDED'] && !$_SERVER['HTTP_CLIENT_IP'] && !$_SERVER['HTTP_VIA'] && !$_SERVER['HTTP_XROXY_CONNECTION'] && !$_SERVER['HTTP_PROXY_CONNECTION'])
{
    header("X-Proxy-Judge-Verdict: Elite");
}
elseif (!$_SERVER['HTTP_X_FORWARDED_FOR'])
{
    header("X-Proxy-Judge-Verdict: Anonymous");
}
else
{
    header("X-Proxy-Judge-Verdict: Transparent");
}
;

header("X-Proxy-Judge-Defendant: ".urldecode($_GET['proxy']));


$proxy_wo_port = @preg_replace('/:.+$/m', '', urldecode($_GET['proxy']) );

if ($proxy_wo_port <> "")
{
	$hostname = @gethostbyaddr( $proxy_wo_port );
	$hostname = @preg_replace('/' . @preg_quote($proxy_wo_port . "."). '?/i', '', $hostname);
	
	header("X-Proxy-Judge-Hostname: ". $hostname);
}


header("X-About: ".$about);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

die ();
?>
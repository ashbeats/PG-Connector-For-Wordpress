<?php

ini_set('error_reporting', E_ERROR);

require_once('../../../wp-load.php');
/* Validate Connection */

$useragent = "ProxyGoblin";

$proxies = "";

$dir = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
$proxy_path = WP_PLUGIN_DIR.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__)) . "configs/";
$proxy_filename = "proxies.inc.txt";
$proxy_judgeurl = $dir . "judge/proxy-judge-wpsbox.php";



?>
<?php
ini_set('error_reporting', E_ERROR);
require_once('../../../wp-load.php');

if (isset($_GET['p']) && $_GET['p'] <> "")
{
    $dir = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
    $proxy_path = WP_PLUGIN_DIR.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__))."configs/";
    
    $isValidApi = false;
    $engine_url = $dir."molura-engine.php";
    $passcode = $_GET['p']; 
    	
    if ($passcode == "MyDefaultPass")
    {
        //No API Key wil be shown
        $engine_apikey_encoded = "You don't have an API Key yet. Create a new passcode to initialize";
    
    } else
    {
        // Proper API KEY
		   
		 $passcode = preg_replace('/[^\w]/', '', $passcode);
	
        $isValidApi = true;
        $engine_apikey = array('passcode'=>$passcode, 'engine_url'=>$engine_url);
        //$engine_apikey = array($passcode, $engine_url);
        $engine_apikey = json_encode($engine_apikey);
        $engine_apikey_encoded = base64_encode($engine_apikey);    
       // $engine_apikey_encoded = ($engine_apikey);    
    }
	
	
}

?>
<?php if ($isValidApi): ?>
	<strong style="color: rgb(255, 0, 0);">
	<textarea id="pg_api" cols="80"  rows="3" class="pre-wrap"><?php echo $engine_apikey_encoded; ?></textarea>
	</strong>
<?php else: ?>
<a href="#" class="edit_trigger invalid_api"><?php echo $engine_apikey_encoded; ?></a>	
<?php endif;  ?>
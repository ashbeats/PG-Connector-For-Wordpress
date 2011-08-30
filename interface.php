<?php

$dir = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
$proxy_path = WP_PLUGIN_DIR.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__)) . "configs/";
$path = WP_PLUGIN_DIR.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
require_once($path . "global.functions.php");

$isValidApi = false;

$proxy_filename = "proxies.inc.txt";
$proxy_judgeurl = $dir . "judge/proxy-judge-wpsbox.php";
$engine_url = $dir . "molura-engine.php";

$passcode = get_option('pg_passcode','MyDefaultPass');

$ajax_url = $dir . "ajax.gen.api.php";

$pg_activelist = get_option('pg_activelist','');

if($pg_activelist=='')
{
	update_option("pg_activelist", 'proxies.inc');
	$pg_activelist = "proxies.inc";
}

$pg_activelist_text = ($pg_activelist == "proxies.google.inc")? "Only Google Friendly":"All Proxies" ;
$pg_activelist_text .= " (". get_proxy_count($pg_activelist) .")";

if(intval(get_option('alb_proxy','0'))==0)
{
	echo '<div id="message" class="error"><p>» <b>Don\'t use Proxy List</b> is selected in WpsBox</p></div>';
	
}


//$change_api_msg = '<div id="message" class="updated"><p>API Key Updated. Please update your tasks if you are using the old API Key</p></div>';

?>

<script type="text/javascript" src="<?php echo $dir ?>js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="<?php echo $dir ?>js/jquery.form.js"></script>
<script type="text/javascript" src="<?php echo $dir ?>js/jquery.jeditable.js"></script>
<script type="text/javascript" src="<?php echo $dir ?>js/x.onload.js"></script>

<link href="<?php echo $dir ?>css/pg-style.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
$(document).ready(function(){
	
	
	
    $.get('<?php echo $ajax_url ?>', {
        p: "<?php echo $passcode; ?>"
    }, function(data){
        $('.api_display').html(data);
    });
	
    $('.pg_settings_edit').editable('<?php echo $dir ?>process.php', 
	{
    
        tooltip: 'Click to to change passcode...',
		indicator: '<img src="<?php echo $dir ?>css/indicator.gif">',
        submit: 'OK',        
        select: true,
        cancel: "Cancel",
        onblur: 'ignore',
        style: 'display: inline',
        cssclass: 'pg_inlineclass',
        event: "edit",
        onerror: function(settings, original, xhr)
		{
            alert(xhr.responseText);            
            original.reset();			
		},
		callback: function( sValue, y ) 
		{
			$('.api_display').html('<img src="<?php echo $dir ?>css/indicator.gif">');
			$.get('<?php echo $ajax_url ?>',  { p: sValue}, function(data){
                
                $('.api_display').html(data).find('#pg_api').select();             
            });
		}
    });	
	 
	
	$(".edit_trigger").bind("click", function() 
	{
		$('#passcode_div').trigger("edit");
	});
	
	$(".refresh_api").bind("click", function() 
	{
		$('.api_display').html('<img src="<?php echo $dir ?>css/indicator.gif">');
        $.get('<?php echo $ajax_url ?>', {
            p: $('.pg_settings_edit').text()
        }, function(data){
            $('.api_display').html(data).find('#pg_api').select();
			
        });
			
	});
    
	$("#pg_api").bind("click", function() 
	{
		$('#pg_api').select();	
	});
	
	/* Proxy List Active Options */
    $(".proxylist_select").editable("<?php echo $dir ?>ajax.form.lists.php", {
        indicator: '<img src="<?php echo $dir ?>css/indicator.gif">',
        data: "{'proxies.inc':'All Proxies (<?php echo get_proxy_count("proxies.inc"); ?>)','proxies.google.inc':'Only Google Friendly (<?php echo get_proxy_count("proxies.google.inc"); ?>)'}",
        type: "select",
        submit: "OK",
        //style: "inherit",
		event: "edit",
		cancel: "Cancel",
        onblur: 'ignore',
		style: 'display: inline',
        cssclass: 'pg_inlineclass'
		
    });
	
	$(".proxylist_select_edit_trigger").bind("click", function() 
	{
		$('#ProxyListsSelector').trigger("edit");
	});
	
 
	
 
});
</script>

<div class="item_custom_message"><p><a href="http://proxygb.com/?ref=wordpress"><img src="http://proxygb.com/images/proxygoblin-connecter.png" /></a></p>

<p><span style="color: #360; font-family: Verdana,Geneva,sans-serif; font-size: small;"><strong>The Connector is Active</strong></span></p>
<h2>Connection Information:</h2>
<div id="connection_info">

<h3>Active Proxy Source:</h3>
<i>This is the source WPsBox will use when running your campaigns</i>
<div id="message" class="updated highlight tips">
<b class="proxylist_select" id="ProxyListsSelector" style="display: inline"><? echo $pg_activelist_text; ?></b>
<a href="#" class="proxylist_select_edit_trigger">[Change/Modify]</a>
</div>




<h3>Secret Passcode: </h3>
<i>This is a passcode for your plugin task in Proxy Goblin (Max: 15 letters & numbers)</i>

<div  class="updated highlight tips">
<b id="passcode_div" class="pg_settings_edit"><?php 
echo (trim($passcode)=="" ? "Passcode Not Configured Yet." : $passcode);
?></b>

<a href="#" class="edit_trigger">[Change/Modify]</a>
</div>



<!-- Only API Key is Needed For ProxyGoblin. This will reduce the chances of errors and user mistakes -->

<h3>API Key: </h3>
<i>Copy & Paste this API key into your ProxyGoblin Task</i>
<div id="message" class="updated highlight api_display">
	<img src="<?php echo $dir ?>css/indicator.gif">
</div>
<a href="#" class="refresh_api">[Refresh]</a>


</div>
    

<p><a href="http://molura.zendesk.com/entries/20292311-wpsbox-proxy-goblin-approved" target="_blank">Tutorial &#187;</a> | <a href="http://molura.zendesk.com/" target="_blank">Support &#187;</a> </p>

<h2>What does this Connector do?</h2>
<p>ProxyGoblin's  Connector alters WPsBox to use  proxies from a text file. </p>
<p>Without this connector, you would have to manually copy &amp; paste proxies <br />
  to the settings window. But with this plugin, you can 
  automatically upload proxies<br />
using FTP to your WPsBox from within the Goblin.<br />
  <br />
  Proxy Goblin &amp; WPsBox - Complete Automation. :)</p>
<p>&nbsp;</p>

<h2><em>Notes:</em></h2>
<p>Current Version: <em>3.0</em></p>
<p><em>Hosted judge is deprecated.</em> Use "Auto-Select" in the Goblin</p>
</div>
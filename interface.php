<?php
$dir = WP_PLUGIN_URL.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
$proxy_path = WP_PLUGIN_DIR.'/'.str_replace(basename(__FILE__), "", plugin_basename(__FILE__)) . "configs/";
$proxy_filename = "proxies.inc.txt";
$proxy_judgeurl = $dir . "judge/proxy-judge-wpsbox.php";
?>
<link href="<?php echo $dir ?>css/pg-style.css" rel="stylesheet" type="text/css" />


<div class="item_custom_message"><p><a href="http://proxygb.com/?ref=wordpress"><img src="http://proxygb.com/images/proxygoblin-connecter.png" /></a></p>
<p><span style="color: #360; font-family: Verdana,Geneva,sans-serif; font-size: small;"><strong>The Connector is Active</strong></span></p>
<h2>Connection Information:</h2>
<div id="connection_info">

<h3>Path To Proxy List: </h3>
<div id="message" class="updated highlight">
<strong style="color: rgb(255, 0, 0);"><?php echo $proxy_path;  ?></strong> 
</div>
<p>This <strong>may not be the actual path</strong> for your FTP connection. It may be different, according to your FTP account's privileges. Always double check using an FTP client if you are unsure.</p>


<h3>Filename: </h3>
<div id="message" class="updated highlight">
<strong style="color: rgb(255, 0, 0);">proxies.inc</strong>
</div>

<h3>Proxy Judge URL: </h3>
<div id="message" class="updated highlight">
<strong style="color: rgb(255, 0, 0);"><?php echo $proxy_judgeurl; ?></strong>
</div>

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
</div>
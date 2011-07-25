<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set("max_execution_time", 0);
require_once ('core.php');

// Example usage: molura-engine.php?username=admin&password=


print_r($_POST);

if (isset($_POST['username']) && isset($_POST['password']))
{
    // Validate
    $username = ($_POST['username']);
    $password = ($_POST['password']);
    
    $creds = array();
    $creds['user_login'] = $username;
    $creds['user_password'] = $password;
    $creds['remember'] = true;
    $user = wp_signon($creds, false);
	
    if (is_wp_error($user))
    {
        echo $user->get_error_message();
    }else{
    	echo "Login Successful";
    }

    
}



?>
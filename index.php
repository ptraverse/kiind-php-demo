<?php

require_once('config.php');  
    
$urls = array(
	'/' => 			'welcome_controller',			//GET
	'/campaign' => 	'campaign_controller',			//GET
	'/login' => 	'login_controller',				//POST
	'/logout' => 	'login_controller', 			//GET
	'/([a-z]+)'	=> 	'static_pages_controller',		//GET
);
    
try 
{
	glue::stick($urls);
}
catch (Exception $e)
{
	header("HTTP/1.1 ".$e->getCode());
	echo '<h1>'.$e->getCode().'!</h1>';	
	
	if ($development_server==TRUE)
	{
		if (isset($e->xdebug_message))
		{
			echo '<table>'.$e->xdebug_message.'</table>';
		}
		echo '<hr>';
		echo '<pre>';
		var_dump($e);
		echo '</pre>';
	}
}


?>
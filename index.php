<?php

require_once('config.php');  
    
$urls = array(
	'/' => 						'WelcomeController',			//GET
	'/campaign' => 				'CampaignController',			//GET
	'/campaign/([a-z]+)' => 	'CampaignController',			//GET
	'/login' => 				'LoginController',				//POST
	'/logout' => 				'LoginController', 				//GET
	'/([a-z]+)'	=> 				'StaticPagesController',		//GET
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
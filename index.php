<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');  
    
$urls = array(
	'/' => 						'WelcomeController',			//GET
	'/r/(\d+)/(\d+)' =>			'RedirectController',			//GET
	'/campaign' => 				'CampaignController',			//GET
	'/campaign/([a-z]+)' => 	'CampaignController',			//GET
	'/link/([a-z]+)/(\d+)' =>	'LinkController',				//GET
	'/link/(\d+)' =>			'LinkController',				//GET
	'/link' =>					'LinkController',				//GET
	'/login' => 				'LoginController',				//POST
	'/logout' => 				'LoginController', 				//GET
	'/auth/redirect(.*)' =>		'AuthController',				//GET
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
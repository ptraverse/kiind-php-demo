<?php

require_once('config.php');  
    
$urls = array(
	'/' => 'welcome',					//GET
	'/login' => 'login', 				//POST
	'/logout' => 'login', 				//GET
	'/(.+)'	=> 'static_pages',			//GET
);
    
try 
{
	glue::stick($urls);
}
catch (Exception $e)
{
	if ($e->getCode()=='404')
	{
		header("HTTP/1.1 404 Not Found");
		echo '<h1>404!</h1>';
	}
	else 
	{
		header("HTTP/1.1 500 Internal Server Error");
		echo '<h1>500!</h1>';		
	}
	
	if ($development_server==TRUE)
	{
		if (isset($e->xdebug_message))
		{
			echo '<table>'.$e->xdebug_message.'</table>';
		}
		echo '<pre>';
		var_dump($e);
		echo '</pre>';
	}
}


?>
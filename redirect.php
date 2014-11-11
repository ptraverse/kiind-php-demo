<?php

require_once('config.php');

if (isset($_REQUEST['code']))
{
	//Exchange the auth code for an access token and a refresh token 
	$kas = new KiindApiService($session);
	$kas->getTokens($_REQUEST['code']);		
	if ($kas->checkSessionHasTokens()==TRUE)
	{
		if ($kas->checkSessionTokensExpiry()==TRUE)
		{
			//Success, Go Home to Index
			header("Location: "."/index.php");
		}
		else
		{
			throw new Exception('TODO - Refresh the tokens? We just got them!');
		}
	}
	else
	{
		throw new Exception('TODO - Get tokens? We just got them!');
	}
}
else 
{
	//Somehow got here without providing the right shit to Kiind
	echo "<h1>!</h1>";
	throw new Exception('TODO - Redirect Page Hit Without Code!');	
}
?>
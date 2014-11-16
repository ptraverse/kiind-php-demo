<?php

require_once('./config.php');

$kas = new KiindApiService($session);

if ($kas->checkTokens()==FALSE)
{
	if ($kas->checkSessionTokensExpiry()==FALSE)
	{
		echo "Getting Refresh of Tokens...<br>";
		$kas->getRefreshTokens();
		if ($kas->checkTokens()==TRUE)
		{
			echo "Got Refreshed Tokens!<br>";
		}
		else
		{
			echo "Refreshing Failed :( <br>";
		}
	}
	else
	{
		echo "<br>Didn't get Tokens :( <br><br>";
		echo '<a href="getKiindAuth.php">Get Them</a><br>';
	}
}

if ($kas->checkTokens()==TRUE)
{		
	//Prove it with an API call!
	var_dump($kas->apiCheckAuth());
	echo __FILE__.":".__LINE__."<br>";
	
	//Get list of All Brands possible
	$gift_cards = $kas->apiMarketplace();
	foreach ($gift_cards['marketplace_gifts'] as $k=>$v)
	{
		echo $v['id'].': '.$v['name'].'<br>';
	}
	
	$createCampaignParams = array(
		"message"=>"Thanks for all of the hard work on the API this week. Have lunch at Bliss on me.",
		"subject"=>"Thanks For the Hard Work",
		"contacts"=>array(
			array(
				"firstname"=>"Pippo",
				"lastname"=>"Traverse",
				"email"=>"philippe.traverse@gmail.com"
			)
		),
		"marketplace_gifts"=>array(
			array(
				"id"=>1, // "id"=>"1" will cause Response Code 400 Bad JSON Syntax
				"price_in_cents"=>2000	
			)
		),
		"expiry"=>"2015-01-01",
		"id"=>"FooBarGift12345",
		"quote"=>TRUE
	);
	
	$create_response = $kas->apiCreateCampaign($createCampaignParams);
	var_dump($create_response);	
	
}
else
{
	echo "Still Don't have the tokens!!! <br>";
}

?>
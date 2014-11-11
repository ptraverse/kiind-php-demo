<?php

require_once('./config.php');

echo '<h1>Index!</h1><br><i>Todo:</i> add Routing :)<br>';

$kas = new KiindApiService($session);
if ($kas->checkTokens()==TRUE)
{
	echo "<br>Got the Tokens!!<br>";
	
	//Prove it with an API call!	
	var_dump($kas->apiCheckAuth());
	
	//Prove it with another API call
	$gift_cards = $kas->apiMarketplace();
	foreach ($gift_cards['marketplace_gifts'] as $k=>$v)
	{
		echo $v['id'].': '.$v['name'].'<br>';
	}
	
	//Try Creating a Campaign!!
	echo "<marquee>FOOOOOOOooooobarrrrr</marquee>";
	
	$createCampaignParams = array(
		"message"=>"Testing from Apizzle",
		"subject"=>"You win",
		"contacts"=>array(
			array(
				"firstname"=>"Peter",
				"lastname"=>"Traverse",
				"email"=>'philippe.traverse@gmail.com'				
			),
			array(
				"firstname"=>"Petra",
				"lastname"=>"Traverse",
				"email"=>'philippe.traverse@gmail.com'
			),
			array(
					"firstname"=>"Prokofiev",
					"lastname"=>"Traverse",
					"email"=>'philippe.traverse@gmail.com'
			),
		),
		"marketplace_gifts"=>array(
			array(
				"id"=>'1',
			),
			array(
					"id"=>'356',
			),
			array(
					"id"=>'411',
			),
			array(
					"id"=>'217',
			),
			array(
					"id"=>'374',
			),
		),
		"expiry"=>"2015-01-01",
		"id"=>"12345",
		"quote"=>"TRUE"
	);
	
	$createCampaignParams = array(
		"message"=>"Thanks for all of the hard work on the API this week. Have lunch at Bliss on me.",
		"subject"=>"Thanks For the Hard Work",
		"contacts"=>array(
			array(
				"firstname"=>"P",
				"lastname"=>"Trav",
				"email"=>'philippe.traverse@gmail.com'
			)
		),
		"marketplace_gifts"=>array(
			array(
				"id"=>'27',
			)
		),
		"expiry"=>"2015-01-01",
		"id"=>"FooBarGift12345"
	);
	//TODO Finish this
	$create_response = $kas->apiCreateCampaign($createCampaignParams);
	var_dump($create_response);
} 
else 
{
	echo "<br>Didn't get Tokens :( <br>";
	echo '<a href="getKiindAuth.php">Get Them</a><br>';
}



?>
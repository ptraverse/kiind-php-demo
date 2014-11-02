<?php

//CLI Prototype: take input from user and support following actions:
/**1. User create marketing Campaign (ie. set owly longUrl) 
 * 2. User participate in Campaign (ie. get new owly shortUrl)
 * 3. Show campaign stats (ie. get all owly clickStats)
 * 4. User show link stats (ie. get single owly clickStats)
 */

$f = fopen( 'php://stdin', 'r' );
require_once('config.php');

echo "Please choose a mode:\n";
echo "\tU - Create new User\n";
echo "\tC - Create marketing campaign\n";
echo "\tP - Participate in marketing campaign\n";
echo "\tS - Show campaign stats\n";
echo "\tL - show Link stats\n";

$line = '';
while (!($line=="U"||$line=="C"||$line=="P"||$line=="S"||$line=="L"))
{
	echo "\n";
	$line = trim(fgets($f));
}
$mode = $line;

switch ($mode)
{
	case "U":
		echo "Creating new user ... \n";
		echo "\tEnter email: \n";
		$email = trim(fgets($f));	
		echo "\tEnter Password: \n";
		$password = trim(fgets($f));
		echo "\tEnter Password Again: \n";
		$password_confirm = trim(fgets($f));
		$user = new User($email,$password,$password_confirm);
		$exists = $em->getRepository('User')->findOneBy(array('email' => $email));
		var_dump($exists);
		if ($exists==FALSE)
		{
			$em->persist($user);
			$em->flush();			
			echo "\tNew User ID ".$user->id." Created! Your New Pin is: \n\t\t\t".$user->pin."\n\n";
		}
		else
		{
			echo "User With Email ".$exists->email." already exists! \n";
		}
		break;
	case "C":
		echo "Creating new campaign...\n";
		echo "\tEnter user id: ";
		$userId = trim(fgets($f));
		$user = User::find($userId);//TODO		
		echo "\tEnter Endpoint URL: ";
		$longUrl = trim(fgets($f));
		echo "\tEnter Campaign ShortName: ";
		$shortName = trim(fgets($f));		
		$campaign = new Campaign($longUrl, $shortName, $user->id);		
		echo "\n\nCreated New Campaign:\n";
		echo "\tNew User with id ".$user->id."\n";
		echo "\tCampaign Url: ".$campaign->longUrl."\n";
		echo "\tCampaign ShortName: ".$campaign->shortName."\n";
		echo "\n";
		break;
	case "P":
		echo "Participating!\n";
		echo "\tEnter email: ";
		$email = trim(fgets($f));
		echo "\tEnter Campaign Short Name or Existing Link: ";
		$entry = trim(fgets($f));		
		$shortName = "Shortname for ".$entry;
		$newLink = "NotYetImplemented CreateNewLink";
		echo "\n\nParticipating in Campaign:\n";
		echo "\tUser with email ".$email."\n";
		echo "\tCampaign ShortName: ".$shortName."\n";
		echo "\n\tThanks for participating! Your new Link is:\n\t\t".$newLink."\n";
		echo "\n";
		break;
	case "S":
		echo "ShowCampaigning!\n";
		break;
	case "L":
		echo "ShowLinking\n";
		break;
	default:
		echo "No Mode :( \n";exit;
		break;
}



//-----------------



?>
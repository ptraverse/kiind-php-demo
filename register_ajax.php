<?php

require_once('config.php');

$e = $_REQUEST['e'];
$p = $_REQUEST['p'];

try
{
	// Create the user
	$user = Sentry::createUser(array(
			'email'     => $e,
			'password'  => $p,
			'activated' => true,
	));

	// Find the group using the group id
	$userGroup = Sentry::findGroupById(2);

	// Assign the group to the user
	$user->addGroup($userGroup);
	
	$color = "green";
	$message = 'New User Added!<br><a href="/">Back Home</a>';
}
catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
{
	$error_array[] = 'Login field is required.';
}
catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
{
	$error_array[] = 'Password field is required.';
}
catch (Cartalyst\Sentry\Users\UserExistsException $e)
{
	$error_array[] = 'User with this login already exists.';
}
catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
{
	$error_array[] = 'Group was not found.';
}

//------------

if (count($error_array)>0)
{
	$error_string = implode('<br>',$error_array);
	$return_array = array(
		'error'=>$error_string
	);
}
else
{
	$return_array = array(
		'color'=>$color,
		'message'=>$message,
	);
}


$return_json = json_encode($return_array);
echo $return_json;

?>
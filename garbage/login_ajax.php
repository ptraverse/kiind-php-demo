<?php

require_once('config.php');

$e = $_REQUEST['e'];
$p = $_REQUEST['p'];

try
{
	// Login credentials
	$credentials = array(
			'email'    => $e,
			'password' => $p,
	);

	// Authenticate the user
	$user = Sentry::authenticate($credentials, false);
	
	$color = "green";
	$message = 'Logged In!<br><a href="/">Back Home</a>';
}
catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
{
	$error_array[] =  'Login field is required.';
}
catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
{
	$error_array[] =  'Password field is required.';
}
catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
{
	$error_array[] =  'Wrong password, try again.';
}
catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
{
	$error_array[] =  'User was not found.';
	$error_array[] =  '<a href="register.php">Register New User</a>';
}
catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
{
	$error_array[] = 'User is not activated.';
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

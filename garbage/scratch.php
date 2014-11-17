<?php

require_once('config.php');

try
{
	// Create the group
	$group = Sentry::createGroup(array(
			'name'        => 'User',
			'permissions' => array(
					'admin' => 0,
					'users' => 1,
			),
	));
}
catch (Cartalyst\Sentry\Groups\NameRequiredException $e)
{
	echo 'Name field is required';
}
catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
{
	echo 'Group already exists';
}

?>
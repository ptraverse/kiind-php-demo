<?php

require_once('./config.php');

if ( ! Sentry::check()) //Not Logged In
{
	echo "<h3>No User</h3>";
	echo '<a href="login.php">Log In</a> or <a href="register.php">Sign Up</a>';
}
else
{
	$user = Sentry::getUser();
	echo '<h3>Welcome, '.$user->email.'</h3>';
	echo '<br><br>';
	echo '<a href="createKiindGift.php">Create Kiind Gift</a>';
	echo '<br><br>';	
	echo '<a href="logout.php">Log Out</a>';
	echo '<br><br>';
}









?>
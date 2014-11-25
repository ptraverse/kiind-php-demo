<?php

class LoginController
{
	
	public function POST() //log IN
	{
		$e = $_REQUEST['email'];
		$p = $_REQUEST['password'];
	
		try
		{
			// Login credentials
			$credentials = array(
					'email'    => $e,
					'password' => $p,
			);
	
			// Authenticate the user
			$user = Sentry::authenticate($credentials, false);
		
			header("HTTP/1.1 302 Found");
			header("Location: /");
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
			
			throw new Exception($error_string,"500");
			
		}
		
	}
	
	
	
	public function GET() //log OUT
	{
		Sentry::logout();

		header("HTTP/1.1 302 Found");
		header("Location: /");
	}
	
}
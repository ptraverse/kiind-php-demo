<?php

class LoginController
{
	
	public function POST() //log IN
	{
		global $session;
		
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
			$session->getFlashBag()->add("danger","Login field is required");
			header("HTTP/1.1 401 User Not Found");
			header("Location: /");
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{			
			$session->getFlashBag()->add("danger","Password field is required");
			header("HTTP/1.1 401 Password Field Required");
			header("Location: /");
			
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{			
			$session->getFlashBag()->add("danger","Wrong password, try again");
			header("HTTP/1.1 401 Incorrect Password");
			header("Location: /");
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			$session->getFlashBag()->add("danger","User Not Found");
			header("HTTP/1.1 401 User Not Found");
			header("Location: /contact");
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
			$session->getFlashBag()->add("danger","User Not Activated Yet");
			header("HTTP/1.1 401 User Not Found");
			header("Location: /contact");
		}
	
		
	}
	
	
	
	public function GET() //log OUT
	{
		Sentry::logout();

		header("HTTP/1.1 302 Found");
		header("Location: /");
	}
	
}
<?php

class login_required_controller extends base_controller
{
	protected $user;
	
	public function __construct()
	{
		parent::__construct();
		if ( ! Sentry::check()) //Not Logged In
		{
			header("HTTP/1.1 401 Unauthorized");
			header("Location: /");
		}
		else
		{
			$user = Sentry::getUser();
			$this->user = $user;	
		}	
	}
	
	
}
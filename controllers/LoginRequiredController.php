<?php

class LoginRequiredController extends BaseController
{
	public $user;
	public $session;
	
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
			global $session;
			$this->session = $session;
		}	
	}
	
	
}
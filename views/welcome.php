<?php

class welcome 
{
	private $twig;
	
	public function __construct()
	{
		global $twig;
		$this->twig = $twig;
	}
	
	public function GET() 
	{		
		if ( ! Sentry::check()) //Not Logged In
		{
			echo $this->twig->render('welcome.html.twig');
		}
		else
		{
			$user = Sentry::getUser();
			echo $this->twig->render('home.html.twig',array('user'=>$user));
		}				
	}
}
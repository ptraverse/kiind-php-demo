<?php

class help
{
	private $twig;
	
	public function __construct()
	{
		global $twig;
		$this->twig = $twig;
	}
	
	public function GET() //log OUT
	{
		echo $this->twig->render('help.html.twig');
	}
	
}
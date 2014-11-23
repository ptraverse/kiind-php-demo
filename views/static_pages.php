<?php

class static_pages extends view_controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function GET($matches)
	{
		if (isset($matches[1]) && $matches[1]>'')
		{
			if ($matches[1]=='help')
			{
				$this->help();
			}
			elseif ($matches[1]=='')
			{
				//TODO - add more static pages here
			}
		}
		else
		{
			throw new Exception("No Static Page Specified","505");
		}
	}
	
	public function help()
	{		
		echo $this->twig->render('help.html.twig');
	}
}
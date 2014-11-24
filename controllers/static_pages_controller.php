<?php

class static_pages_controller extends base_controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function GET($matches)
	{
		if (isset($matches[1]))
		{
			if ($matches[1]=='help')
			{
				$this->help();
			}
			elseif ($matches[1]=='')
			{
				throw new Exception("Static Page Name Blank","400");
			}
			else
			{
				throw new Exception("Static Page '$matches[1]' Not Yet Implemented","404");
			}			
		}
		else
		{
			throw new Exception("Static Page Not Specified","400");
		}
	}
	
	public function help()
	{		
		echo $this->twig->render('help.html.twig');
	}
}
<?php

class StaticPagesController extends BaseController
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
				echo $this->twig->render('help.html.twig');
			}
			elseif ($matches[1]=='contact')
			{
				echo $this->twig->render('contact.html.twig');
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
}
<?php

class view_controller
{
	protected $twig;
	
	public function __construct()
	{
		global $twig;
		$this->twig = $twig;
	}
	
}
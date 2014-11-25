<?php

class BaseController
{
	protected $twig; 
	protected $em;
	
	public function __construct()
	{
		global $twig, $em;
		$this->twig = $twig;
		$this->em = $em;
	}
	
}
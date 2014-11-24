<?php

class base_controller
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
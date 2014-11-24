<?php

class campaign_controller extends base_controller
{
	
	public function GET()
	{	
		//TODO - Fancier querying to get most recent or whatever
		$campaigns = $this->em->getRepository('Campaign')->findAll();
		echo $this->twig->render("campaigns.html.twig",array("campaigns"=>$campaigns));		
	}
	
}
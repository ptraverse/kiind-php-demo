<?php

class campaign_controller extends login_required_controller
{
	
	public function GET()
	{			
		//TODO - Fancier querying to get most recent or whatever
		$campaigns = $this->em->getRepository('Campaign')->findAll();
		//TODO - Add User Email instead of ID 		
		echo $this->twig->render("campaigns.html.twig",array("user"=>$this->user,"campaigns"=>$campaigns));		
	}
	
}
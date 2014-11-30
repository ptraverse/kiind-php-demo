<?php

class RedirectController extends BaseController
{
	
	public function GET($matches)
	{ 
		if (!(isset($matches[1]) && isset($matches[2])))
		{
			throw new Exception("RedirectController without matches 1 and 2!","500");
		}
		else
		{
			//TODO Log To DB
			//Serve Page
			/*Need
			 * long_url for JS			 
			 * campaign prize price
			 * Later: Campaign Pic, PrizeName, current stats from API, check user
			 * MuchLater: Pyramid Structure? 
			 * Note - redirect_url in table is crufty but keepable (denormalized)
			 */			
			$campaign_id = $matches[1];
			$user_id = $matches[2];
			$q = $this->em->createQuery("
				SELECT					
					l.id,
					l.short_url,
					c.long_url,
					c.gift_amount
				FROM Link AS l
				JOIN Campaign AS c
					WITH l.campaign_id = c.id
				WHERE l.campaign_id = ".$campaign_id."
					AND l.user_id = ".$user_id." 
			");
			$r = $q->getResult();
			
			echo $this->twig->render("redirect.html.twig",array("r"=>$r[0]));
		}
	}
	
}
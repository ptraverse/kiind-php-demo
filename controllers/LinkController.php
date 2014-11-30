<?php

class LinkController extends LoginRequiredController
{
	
	public function GET($matches)
	{
		if (isset($matches[1]))
		{
			if ($matches[1]=="create")
			{
				if ($matches[2]>'')
				{
					$campaign_id = $matches[2];
					$user_id = $this->user->id;
					$campaign = $this->em->getRepository('Campaign')->find($campaign_id);
					$exists = $this->em->getRepository("Link")->findOneBy(array("user_id"=>$user_id,"campaign_id"=>$campaign_id));					
					if ($exists==FALSE)
					{					
						$link = new Link($campaign_id,$user_id);					
						$link->getNewShortlink();
						$this->em->persist($link);
						$this->em->flush();
						if ($campaign)
						{				
							echo $this->twig->render("link_create.html.twig",array("user"=>$this->user,"campaign"=>$campaign,"link"=>$link));
						}
						else 
						{	
							throw new Exception("Create Link: Campaign '$matches[2]' does not exist!",'500');
						}
					}
					else
					{
						throw new Exception("TODO Implement Link Already Exists Page","500");
					}
				}
				else 
				{
					throw new Exception("Create Link No Campaign Specified: '$matches[2]' !",'500');
				}				
			}
			else
			{
				var_dump($_SERVER);
				throw new Exception("Link Controller for GET '$matches[1]' Not Yet Implemented","404");
			}
		}
		else
		{
			//TODO - order by; WHERE user = this user
			$links_q = $this->em->createQuery("
				SELECT
					l.id,
					l.short_url,
					c.long_url,
					l.clicks AS link_clicks,
					c.clicks AS campaign_clicks,
					c.gift_amount
				FROM Link AS l
				JOIN Campaign AS c
					WITH l.campaign_id = c.id AND l.user_id = ".$this->user->id."					
			");
			$links = $links_q->getResult();
			
			echo $this->twig->render("link_list.html.twig",array("user"=>$this->user,"links"=>$links));			
		}
	}
	
}

?>
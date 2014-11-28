<?php

class CampaignController extends LoginRequiredController
{
	
	public function GET($matches)
	{		
		$kas = new KiindApiService($this->session);
		if (isset($matches[1]))
		{
			if ($matches[1]=="create")
			{						
				//Get list of All Gift Cards
				$gift_cards = $kas->apiMarketplaceAllGifts();								
				echo $this->twig->render("campaign_create.html.twig",array("user"=>$this->user,"gift_cards"=>$gift_cards));				
			}			
			else
			{
				throw new Exception("Campaign Controller for GET '$matches[1]' Not Yet Implemented","404");
			}
		}
		else
		{
			//TODO - order by
			$campaigns = $this->em->getRepository('Campaign')->findAll();
			//Replace Gift ID with Gift Card Name			
			$gift_cards = $kas->apiMarketplaceAllGifts();
			foreach ($campaigns as $c)
			{				
				$c->gift_card_name = $gift_cards[$c->gift_id];
			}
			//TODO - Add Link to "My Link" or Link to Create Link
			echo $this->twig->render("campaign_list.html.twig",array("user"=>$this->user,"campaigns"=>$campaigns));
		}		
	}	

	public function POST($matches)
	{
		if (isset($matches[1]))
		{
			if ($matches[1]=="create")
			{
				$c_long_url = mysql_real_escape_string($_REQUEST['long_url']);
				$c_short_name = mysql_real_escape_string($_REQUEST['short_name']);
				$gift_id = $_REQUEST['gift_id'];
				$gift_amount = $_REQUEST['gift_amount'];
				$clicks = $_REQUEST['clicks'];
				$c = new Campaign($c_long_url,$c_short_name,$this->user->id,$gift_id,$gift_amount,$clicks);
				$exists = $this->em->getRepository('Campaign')->findOneBy(array('long_url'=>$c_long_url,'short_name'=>$c_short_name));
				if ($exists==FALSE)
				{
					$this->em->persist($c);
					$this->em->flush();
					header("HTTP/1.1 200 OK");
					header("HTTP/1.1 302 OK");
					//TODO - Get this to work!
// 					$this->session->getFlashBag()->add('message', 'Campaign Created');
					header("Location: /campaign");
				}
				else
				{
					throw new Exception("Campaign Already Exists","500");
				}
			}
			else
			{
				throw new Exception("Campaign Controller for POST '$matches[1]' Not Yet Implemented","404");
			}
		}
		else
		{
			throw new Exception("Campaign Controller for POST /campaign Not Yet Implemented","404");			
		}
	}
	
}
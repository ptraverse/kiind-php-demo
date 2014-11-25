<?php

class CampaignController extends LoginRequiredController
{
	
	public function GET($matches)
	{			
		if (isset($matches[1]))
		{
			if ($matches[1]=="create")
			{
				echo $this->twig->render("campaign_create.html.twig",array("user"=>$this->user));
			}			
			else
			{
				throw new Exception("Campaign Controller for GET '$matches[1]' Not Yet Implemented","404");
			}
		}
		else
		{
			//TODO - Fancier querying to get most recent or whatever
			$campaigns = $this->em->getRepository('Campaign')->findAll();
			//TODO - Add User Email instead of ID
			echo $this->twig->render("campaign_list.html.twig",array("user"=>$this->user,"campaigns"=>$campaigns));
		}		
	}	

	public function POST($matches)
	{
		if (isset($matches[1]))
		{
			if ($matches[1]=="create")
			{
				//TODO Validate with javascript before submitting
				$c_long_url = mysql_real_escape_string($_REQUEST['long_url']);
				$c_short_name = mysql_real_escape_string($_REQUEST['short_name']);
				$c = new Campaign($c_long_url,$c_short_name,$this->user->id);
				$exists = $this->em->getRepository('Campaign')->findOneBy(array('long_url'=>$c_long_url,'short_name'=>$c_short_name));
				if ($exists==FALSE)
				{
					$this->em->persist($c);
					$this->em->flush();
					header("HTTP/1.1 200 OK");
					header("HTTP/1.1 302 OK");
					$this->session->getFlashBag()->add('notice', 'Campaign Created');
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
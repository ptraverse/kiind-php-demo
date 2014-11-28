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
					$campaign = $this->em->getRepository('Campaign')->find($matches[2]);
					$link = new Link($campaign->id,$this->user->id);
					$link->getNewShortlink();
					if ($campaign)
					{				
						echo $this->twig->render("link_create.html.twig",array("user"=>$this->user,"campaign"=>$campaign,"link"=>$link));
					}
					else 
					{	
						throw new Exception("Create Link: Campaign '$matches[2]' not found!",'500');
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
			var_dump($_SERVER);
			throw new Exception("Link Controller for GET wihtout params '$matches[1]' Not Yet Implemented","404");			
		}
	}
	
}

?>
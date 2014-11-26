<?php

class CampaignController extends LoginRequiredController
{
	
	public function GET($matches)
	{			
		if (isset($matches[1]))
		{
			if ($matches[1]=="create")
			{
				//Get List of Available Gift Cards from Kiind
				$kas = new KiindApiService($this->session);				
				if ($kas->checkTokens()==FALSE)
				{
					if ($kas->checkSessionTokensExpiry()==FALSE)
					{
						echo "Getting Refresh of Tokens...<br>";
						$kas->getRefreshTokens();
						if ($kas->checkTokens()==TRUE)
						{
							echo "Got Refreshed Tokens!<br>";
						}
						else
						{
							echo "Refreshing Failed :( <br>";
						}
					}
					else
					{
						echo "<br>Need Tokens to Continue :( <br><br>";
						echo '<a href="getKiindAuth.php">Get Them</a><br>';
					}
				}
				//not Else since we may have just refreshed tokens
				if ($kas->checkTokens()==TRUE)
				{										
					//Get list of All Gift Cards
					$marketplace_params = array(
						'limit' => 1000
					);
					$gift_cards_resp = $kas->apiMarketplace($marketplace_params);
					foreach ($gift_cards_resp['marketplace_gifts'] as $k=>$v)
					{
						$gift_cards[] = array('id'=>$v['id'],'name'=>$v['name']);
					}
								
					echo $this->twig->render("campaign_create.html.twig",array("user"=>$this->user,"gift_cards"=>$gift_cards));
				}
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
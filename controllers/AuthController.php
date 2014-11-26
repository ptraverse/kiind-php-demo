<?php

class AuthController extends LoginRequiredController
{
	
	public function GET()
	{
		if (isset($_REQUEST['code']))
		{
			//Exchange the auth code for an access token and a refresh token
			$kas = new KiindApiService($this->session);
			$kas->getTokens($_REQUEST['code']);
			if ($kas->checkSessionHasTokens()==TRUE)
			{
				if ($kas->checkSessionTokensExpiry()==TRUE)
				{
					//Success, Go Home to Index
					header("Location: "."/");
				}
				else
				{
					throw new Exception('TODO - Refresh the tokens? We just got them!','500');
				}
			}
			else
			{
				throw new Exception('TODO - Get tokens? We just got them!','500');
			}
		}
		else
		{
			//Somehow got here without providing the right shit to Kiind
			throw new Exception('TODO - Redirect Page Hit Without Code!','500');
		}
	}
	
}
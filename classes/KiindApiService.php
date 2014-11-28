<?php

use Guzzle\Http\Client;

class KiindApiService
{
	
	private $api_url, $authorize_endpoint, $client_id, $client_secret, $token_endpoint, $redirect_uri, $guzzle;
	public $session; 
	
	public function __construct($session,$authorizing=FALSE)
	{
		$this->api_url = KIIND_BASE_URL;
		$this->authorize_endpoint = KIIND_BASE_URL."oauth/userlogin"; 
		$this->client_id = KIIND_CLIENT_ID;
		$this->client_secret = KIIND_CLIENT_SECRET;
		$this->token_endpoint = KIIND_BASE_URL."oauth/token";
		$this->redirect_uri = KIIND_REDIRECT_URI;
		$this->guzzle = new Guzzle\Http\Client();
		
		if (isset($session))
		{
			$this->session = $session;
		}
		
		if ($authorizing==FALSE) //prevent infinite looping
		{
			if ($this->checkTokens()==FALSE)
			{
				if ($this->checkSessionTokensExpiry()==FALSE)
				{
					try 
					{
						$this->getRefreshTokens();
					}
					catch (Guzzle\Http\Exception\ClientErrorResponseException $e) //CROCK!!
					{
						$this->getAuthRedirect();
					}
					
					if ($this->checkTokens()==FALSE) //Didnt get refresh tokens?!
					{
						throw new Exception('Couldnt Get Kiind Tokens!','500');
					}
				}
				else
				{
					$this->getAuthRedirect();
				}
			}
		}
		
	}			
	
	public function checkTokens()
	{
		return ($this->checkSessionHasTokens() && $this->checkSessionTokensExpiry() );
	}
	
	public function checkSessionHasTokens()
	{
		if (!isset($this->session))
		{
			return FALSE;
		}
		elseif ($this->session->has('tokens/kiind/access_token')==FALSE)
		{
			return FALSE;
		}
		elseif ($this->session->has('tokens/kiind/refresh_token')==FALSE)
		{
			return FALSE;
		}		
		else 
		{
			return TRUE;
		}
	}
	
	public function checkSessionTokensExpiry()
	{		
		if ($this->session)
		{
			if ($this->session->has('tokens/kiind/expires'))
			{
				if ($this->session->get('tokens/kiind/expires') > date("Y-m-d H:i:s"))
				{
					return TRUE;
				}
				else 
				{
					return FALSE;
				}
			}
			else
			{
				return TRUE;
			}	
		}
		else
		{
			return TRUE;
		}	
	}
	
	public function getRefreshTokens()
	{
		$token_endpoint = $this->token_endpoint;
		$token_array = array(
				"grant_type" => "refresh_token", 	//must always be "refresh_token"
				"refresh_token" => $this->session->get('tokens/kiind/refresh_token'),
				"client_id" => KIIND_CLIENT_ID,
				"client_secret" => KIIND_CLIENT_SECRET
		);
		
		$request = $this->guzzle->createRequest('POST', $token_endpoint);
		$query = $request->getQuery();
		foreach ($token_array as $k=>$v)
		{
			$query->set($k, $v);
		}
		$res = $this->guzzle->send($request);
		$tokens = $res->json();
		
		$this->session->set('tokens/kiind/access_token', $tokens['access_token']);
		$this->session->set('tokens/kiind/refresh_token', $tokens['refresh_token']);
		$this->session->set('tokens/kiind/expires_in', $tokens['expires_in']);
		$this->session->set('tokens/kiind/acquired', date('Y-m-d H:i:s'));
		$this->session->set('tokens/kiind/expires', date('Y-m-d H:i:s',(time()+(int)($tokens['expires_in']/1000))));
		
		return $this->session->has('tokens/kiind/access_token');
	}
	
	public function getAuthRedirect()
	{
		$authEndpoint = $this->authorize_endpoint.'?';
		$authArray = array(
				"client_id" => $this->client_id,
				"response_type" => "code", 	// Should always be "code"
				"scope" => "GIFT", 			//TODO: Change this to a constant in /private folder
				"redirect_uri" => $this->redirect_uri,
		);
		$authLocation = $authEndpoint.http_build_query($authArray);		
		header("HTTP/1.1 302 Found");
		header("Location: ".$authLocation);
		exit;
	}	
	
	//send POST to authorization server and return response
	//TODO - handle whatever happens when the access token expires and we need to use refresh token
	public function getTokens($authorization_code)
	{
		$token_endpoint = $this->token_endpoint;
		$token_array = array(
				"grant_type" => "authorization_code", 	//must always be "authorization_code"
				"code" => $_REQUEST['code'],
				"client_id" => KIIND_CLIENT_ID,
				"client_secret" => KIIND_CLIENT_SECRET,
				"scope" => "GIFT",
				"redirect_uri" => KIIND_REDIRECT_URI
		);
		
		$request = $this->guzzle->createRequest('POST', $token_endpoint);
		$query = $request->getQuery();
		foreach ($token_array as $k=>$v)
		{
			$query->set($k, $v);
		}
		$res = $this->guzzle->send($request);
		$tokens = $res->json();

		$this->session->set('tokens/kiind/access_token', $tokens['access_token']);
		$this->session->set('tokens/kiind/refresh_token', $tokens['refresh_token']);
		$this->session->set('tokens/kiind/expires_in', $tokens['expires_in']);
		$this->session->set('tokens/kiind/acquired', date('Y-m-d H:i:s'));
		$this->session->set('tokens/kiind/expires', date('Y-m-d H:i:s',(time()+(int)($tokens['expires_in']/1000))));
		
		return $this->session->has('tokens/kiind/access_token');
	}
	
	
	public function apiCheckAuth()
	{
		$papi_url = $this->api_url."/papi/v1/";
		$request = $this->guzzle->createRequest('GET', $papi_url);
		$query = $request->getQuery();
		$query->set('access_token', $this->session->get('tokens/kiind/access_token'));
		try 
		{
			$res = $this->guzzle->send($request);
		}
		catch (Exception $e)
		{
			global $debug;
			$debug->addDebug($request,array('Guzzle CHECKAUTH Request'));
		}
		$response = $res->json();		
		return (bool)($response['info']['name']=='Credentials are valid');
	}
	
	/**
	 * 
	 * @param $params
	 * 	vendor Long Optional
	 * 	region Long Optional
	 * 	category Long Optional
	 * 	max_price_in_cents Integer Optional
	 * 	min_price_in_cents Integer Optional
	 * 	limit Integer Optional Default 20
	 * 	offset Integer Optional Default 0
	 * 	long_format Boolean Optional Default False
	 * @return Array (of Available Gifts)
	 */
	public function apiMarketplace($params = array())
	{
		$papi_url = $this->api_url."papi/v1/marketplace";
		$request = $this->guzzle->createRequest('GET', $papi_url);
		$query = $request->getQuery();
		$query->set('access_token', $this->session->get('tokens/kiind/access_token'));
		foreach ($params as $k=>$v)
		{
			$query->set($k, $v);
		}
		$res = $this->guzzle->send($request);
		$response = $res->json();
		return $response;
	}
	
	//Shortcut to get the 1000 first Marketplace Gift Cards, Id and Name only
	public function apiMarketplaceAllGifts()
	{
		//Get list of All Gift Cards
		$marketplace_params = array(
			'limit' => 1000
		);
		$gift_cards_resp = $this->apiMarketplace($marketplace_params);
		foreach ($gift_cards_resp['marketplace_gifts'] as $k=>$v)
		{
			$gift_cards[$v['id']] = $v['name'];
		}
		return $gift_cards;
	}
	
	public function apiMarketplaceId($id)
	{
		throw new Exception('Not Yet Implemented!');
	}
	
	public function apiMarketplaceRegions()
	{
		throw new Exception('Not Yet Implemented!');
	}
	
	public function apiMarketplaceVendors()
	{
		throw new Exception('Not Yet Implemented!');
	}
	
	public function apiMarketplaceCategories()
	{
		throw new Exception('Not Yet Implemented!');
	}
	
	public function apiListCampaigns()
	{
		$papi_url = $this->api_url."papi/v1/campaign";
		$headers = array(
			'Accept'=>'application/json',
			'Authorization'=>'Bearer '.$this->session->get('tokens/kiind/access_token'),
		);
		$request = $this->guzzle->get($papi_url,$headers);
				
		try
		{
			$res = $this->guzzle->send($request);
			$response = $res->json();
			return $response;
		}
		catch (	Exception $e )
		{
			global $debug;
			$debug->addDebug($e,array('Guzzle EXCEPTION'));
			$curl_string = 'curl -k -X POST ';
			foreach ($headers as $k=>$v)
			{
				$curl_string .= '-H "'.$k.': '.$v.'" ';
			}
			$curl_string .= ' '.$papi_url.' ';
			$debug->addDebug($curl_string,array('Curl String'));
			return "Exception from Kiind. Check Debug Log.";
		}
	}
	
	/**
	 * 
	 * @param unknown $params
	 * 	message
	 * 	subject
	 * 	contacts (list)
	 * 		firstname
	 * 		lastname
	 * 		email
	 * 	marketplace_gifts (list)
	 * 		id
	 * 		prince_in_cents Optional
	 * 	expiry (YYYY-MM-DD)
	 * 	id
	 * 	quote Optional
	 * @return unknown
	 */
	public function apiCreateCampaign($params)
	{
		if (is_array($params))
		{
			$json_params = json_encode($params);
		}
		else
		{
			$json_params = $params;
		}
		$headers = array(
			'Accept'=>'application/json',
			'Content-Type'=>'application/json',			
			'Authorization'=>'Bearer '.$this->session->get('tokens/kiind/access_token'),
		);
		$papi_url = $this->api_url."papi/v1/campaign";
		$request = $this->guzzle->post($papi_url,$headers,$json_params);				
		
		try 
		{
			$res = $this->guzzle->send($request);
			$response = $res->json();
			return $response;
		}
		catch (	Exception $e )
		{						
			global $debug;
			$debug->addDebug($e,array('Guzzle EXCEPTION'));
			$curl_string = 'curl -k -X POST ';
			foreach ($headers as $k=>$v)
			{
				$curl_string .= '-H "'.$k.': '.$v.'" ';
			}
			$curl_string .= '-d '."'".$json_params."'".' '.$papi_url.' ';
			$debug->addDebug($curl_string,array('Curl String'));
			return "Exception from Kiind. Check Debug Log.";				
		}
		
	}
	
	public function apiCampaignUuid()
	{
		throw new Exception('Not Yet Implemented!');
	}
	
	public function apiCampaignId()
	{
		throw new Exception('Not Yet Implemented!');
	}
	
}
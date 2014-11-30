<?php

class GooglApiService
{
	
	private $client,$service;
	public $url;
	
	public function __construct()
	{
		$this->client = new Google_Client();
		$this->client->setApplicationName(GOOGL_APPLICATION_NAME);
		$this->client->setDeveloperKey(GOOGL_API_KEY);
		
		$this->service = new Google_Service_Urlshortener($this->client);
		
		$this->url = new Google_Service_Urlshortener_Url();
	}
	
	public function urlShorten($longUrl)
	{
		$this->url->longUrl = $longUrl;
		$shortUrl = $this->service->url->insert($this->url);
		if ($shortUrl['id']=='')
		{
			throw new Exception("Googl URL Shortening Service Puked","500");
		}
		return $shortUrl['id'];
	}
	
}
<?php

class OwlyService
{
	private $apiKey,$baseUrl,$client;
	
	public function __construct()
	{
		$this->apiKey = OWLY_API_KEY;
		$this->baseUrl = OWLY_BASE_URL;
		$this->client = new GuzzleHttp\Client();
	}
	
	public function urlShorten($longUrl)
	{
		$request = $this->client->createRequest('GET', $this->baseUrl.'url/shorten');
		$query = $request->getQuery();
		$query->set('apiKey', $this->apiKey);
		$query->set('longUrl', $longUrl);
		$res = $this->client->send($request);
		return $res;		
	}
	
	public function urlExpand($shortUrl)
	{
		$request = $this->client->createRequest('GET', $this->baseUrl.'url/expand');
		$query = $request->getQuery();
		$query->set('apiKey', $this->apiKey);
		$query->set('shortUrl', $shortUrl);
		$res = $this->client->send($request);
		return $res;	
	}
	
	public function urlInfo($shortUrl)
	{
		$request = $this->client->createRequest('GET', $this->baseUrl.'url/info');
		$query = $request->getQuery();
		$query->set('apiKey', $this->apiKey);
		$query->set('shortUrl', $shortUrl);
		$res = $this->client->send($request);
		return $res;	
	}
	
	public function urlClickStats($shortUrl,$fromDate='',$toDate='')
	{
		$request = $this->client->createRequest('GET', $this->baseUrl.'url/clickStats');
		$query = $request->getQuery();
		$query->set('apiKey', $this->apiKey);
		$query->set('shortUrl', $shortUrl);
		if ($fromDate!='')
		{
			$query->set('from', $fromDate);
		}
		if ($toDate!='')
		{
			$query->set('to', $toDate);
		}
		$res = $this->client->send($request);
		return $res();
	}
	
	public function photoUpload($filename,$fileData)
	{
		throw new Exception('Not yet implemented');
	}
	
	public function docUpload($filename,$fileData)
	{
		throw new Exception('Not yet implemented');
	}
	
}
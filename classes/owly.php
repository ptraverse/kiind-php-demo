<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

class owly
{
	private $api_key,$base_url,$client;
	
	public function __construct()
	{
		$this->api_key = OWLY_API_KEY;
		$this->base_url = OWLY_BASE_URL;
		$this->client = new GuzzleHttp\Client();
	}
	
	public function url_shorten($longUrl)
	{
		echo "notImplementedYet\n";
	}
	
	public function url_expand($shortUrl)
	{
		echo "notImplementedYet\n";		
	}
	
	public function url_info($shortUrl)
	{
		echo "notImplementedYet\n";
	}
	
	public function url_clickStats($shortUrl,$from_date='',$to_date='')
	{
		echo "notImplementedYet\n";
	}
	
	public function photo_upload($filename,$file_data)
	{
		echo "notImplementedYet\n";
	}
	
	public function doc_upload($filename,$file_data)
	{
		echo "notImplementedYet\n";
	}
	
}
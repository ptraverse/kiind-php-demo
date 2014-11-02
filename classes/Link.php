<?php

class Link
{
	
	private $id;
	
	private $hash;
	
	private $shortUrl;
	
	private $longUrl;
	
	private $userId;
	
	private $campaignId;
	
	public function __construct($campaignId,$userId)
	{
		$this->campaignId = $campaignId;
		$this->userId = $userId;
	}
	
	public function __get($property)
	{
		if (property_exists($this, $property))
		{
			return $this->$property;
		}
		else
		{
			throw new Exception("Property ".$property." is an invalid property.");
		}
	}
	
	public function __set($property, $value)
	{
		if (property_exists($this, $property))
		{
			if ((isset($value)) && (!is_null($value)))
			{
				$this->$property = $value;
			}
		}
		else
		{
			throw new Exception("Property ".$property." is an invalid property.");
		}
	}
	
}

?>
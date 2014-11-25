<?php

class Link
{
	
	private $id;
	
	private $hash;
	
	private $short_url;
	
	private $long_url;
	
	private $user;
	
	private $campaign;
	
	public function __construct($campaign_id,$user_id)
	{
		$this->$campaign = $campaign_id;
		$this->$campaign = $user_id;
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
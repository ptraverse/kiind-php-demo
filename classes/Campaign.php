<?php

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Campaign
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	public $id;
	/** @ORM\Column(length=1024) */
	public $longUrl;
	/** @ORM\Column(length=24) */
	public $shortName;
	/** @ORM\Column(type="integer") */
	public $user;
	
	public function __construct($longUrl,$shortName,$userId)
	{
		$this->longUrl = $longUrl;
		$this->shortName = $shortName;
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
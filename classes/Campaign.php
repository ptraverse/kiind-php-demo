<?php

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
	private $id;
	/** @ORM\Column(length=1024) */
	private $longUrl;
	/** @ORM\Column(length=24) */
	private $shortName;
	/** 
	 * @ORM\ManyToOne(targetEntity="User")
	 * TODO - Finish This Relationship
	 */
	private $user;
	
	public function __construct($longUrl,$shortName,$userId)
	{
		$this->id = '1'; //TODO
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
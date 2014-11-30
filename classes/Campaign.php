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
	public $long_url;
	/** @ORM\Column(length=24) */
	public $short_name;
	/** @ORM\Column(type="integer") */
	public $user_id;
	/** @ORM\Column(type="integer") */
	public $gift_id;
	/** @ORM\Column(type="float") */
	public $gift_amount;
	/** @ORM\Column(type="integer") */
	public $clicks;
	
	public $gift_card_name;
	
	public function __construct($long_url,$short_name,$user_id,$gift_id,$gift_amount,$clicks)
	{
		$this->long_url = $long_url;
		$this->short_name = $short_name;
		$this->user_id = $user_id;
		$this->gift_id = $gift_id;
		$this->gift_amount = $gift_amount;
		$this->clicks = $clicks;
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
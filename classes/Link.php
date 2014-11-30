<?php

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class Link
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	public $id;
	
	/** @ORM\Column(length=1024) */
	public $short_url;
	
	/** @ORM\Column(length=1024) */
	public $redirect_url;
	
	/** @ORM\Column(type="integer") */
	public $user_id;
	
	/** @ORM\Column(type="integer") */
	public $campaign_id;
	
	/** @ORM\Column(type="integer", nullable=true) */
	public $clicks;
	
	/** @ORM\Column(type="datetime") */
	public $date_created;
	
	/** @ORM\Column(type="datetime", nullable=true) */
	public $date_updated;
	
	public function __construct($campaign_id,$user_id)
	{
		$this->campaign_id = $campaign_id;
		$this->user_id = $user_id;		
		$this->redirect_url = 'http://'.$_SERVER['HTTP_HOST'].'/r/'.$this->campaign_id.'/'.$this->user_id; //cruft?			
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
	
	public function getNewShortlink()
	{
		$gas = new GooglApiService();
		$short_url = $gas->urlShorten($this->redirect_url);
		$this->short_url = $short_url;
		$this->date_created = new DateTime();
		return $this->short_url;
	}
	
}

?>
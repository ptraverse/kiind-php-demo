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
	public $user;
	
	/** @ORM\Column(type="integer") */
	public $campaign;
	
	public function __construct($campaign_id,$user_id)
	{
		$this->campaign = $campaign_id;
		$this->user = $user_id;		
		$this->redirect_url = 'http://'.$_SERVER['HTTP_HOST'].'/r/'.$this->campaign.'/'.$this->user; //cruft
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
		$oas = new OwlyApiService();
		$res = $oas->urlShorten($this->redirect_url);
		$res_array = $res->json();
		$this->short_url = $res_array['results']['shortUrl'];
		return $res_array['shortUrl'];
	}
	
}

?>
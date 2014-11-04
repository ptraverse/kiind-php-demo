<?php

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class User
{
	/** 
	 * @ORM\Id 
	 * @ORM\Column(type="integer") 
	 * @ORM\GeneratedValue  
	*/
	private $id;
	/** @ORM\Column(length=140) */
	private $email;
	/** @ORM\Column(length=140) */
	private $password;
	/** @ORM\Column(length=4) */
	private $pin;
	
	public function __construct($email,$password,$password_confirm)
	{
		if ($password!==$password_confirm)
		{
			throw new Exception('NewUserPasswordConfirmationException');
		}
		else 
		{
			$this->id = '1';//TODO change this with DB ORM
			$this->email = $email;
			$this->password = $password;
			$digits = 4;
			$this->pin = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);	
		}
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
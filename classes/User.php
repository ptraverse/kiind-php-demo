<?php

use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
	/** 
	 * @ORM\Id 
	 * @ORM\Column(type="integer") 
	 * @ORM\GeneratedValue  
	*/
	private $id;
	
	/** @ORM\Column(length=255) */
	private $email;
	
	/** @ORM\Column(length=255) */
	private $password;
	
	/** @ORM\Column(type="text") */
	private $permissions;
	
	/** @ORM\Column(type="boolean") */
	private $activated;
	
	/** @ORM\Column(length=255) */
	private $activation_code;
	
	/** @ORM\Column(length=255) */
	private $activated_at;
	
	/** @ORM\Column(length=255) */
	private $last_login;
	
	/** @ORM\Column(length=255) */
	private $persist_code;
	
	/** @ORM\Column(length=255) */
	private $reset_password_code;
	
	/** @ORM\Column(length=255) */
	private $first_name;
	
	/** @ORM\Column(length=255) */
	private $last_name;
	
	/** @ORM\Column(type="datetime") */
	private $created_at;
	
	/** @ORM\Column(type="datetime") */
	private $updated_at;
	
	/** @ORM\Column(length=4) */
	private $pin;

	/** @ORM\Column(type="boolean") */
	private $kiind_enabled;
	
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
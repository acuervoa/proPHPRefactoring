<?php

namespace App;

use App\GoldAffiliation;
use App\NullAffiliation;
use App\SilverAffiliation;

class Customer 
{
	const GOLD = 'gold';
	const SILVER = 'silver';

	protected $type;
	protected $affiliation;

	public $is_gold = false;
	public $is_silver = false;

	protected $first_name;
	protected $last_name;
	protected $customer_address;
	protected $customer_city;
	protected $customer_country;
	

	public function __construct() 
	{
		$this->affiliation = new NullAffiliation();	
	}

	public function isGold()
	{
		return $this->affiliation->getType() == self::GOLD;
	}

	public function makeGold()
	{
		$this->affiliation = new GoldAffiliation();
	}

	public function isSilver(){
		return $this->affiliation->getType() == self::SILVER;
	}

	public function makeSilver()
	{
		$this->affiliation = new SilverAffiliation();
	}

	public function setName($customer)
	{
		list($this->first_name, $this->last_name) = explode(' ', $customer);
	}

	public function __toString(){
		return $this->first_name . ' ' . $this->last_name;
	}

	public function getAffiliation()
	{
		return $this->affiliation;
	}

}
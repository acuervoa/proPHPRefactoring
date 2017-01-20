<?php

namespace App;

class Customer 
{
	public $is_gold = false;
	public $is_silver = false;

	protected $first_name;
	protected $last_name;
	protected $customer_address;
	protected $customer_city;
	protected $customer_country;
	
	public function isGold()
	{
		return $this->is_gold;
	}

	public function makeGold()
	{
		$this->is_gold = true;
	}

	public function isSilver(){
		return $this->is_silver;
	}

	public function makeSilver()
	{
		$this->is_silver = true;
	}

	public function setName($customer)
	{
		list($this->first_name, $this->last_name) = explode(' ', $customer);
	}

	public function __toString(){
		return $this->first_name . ' ' . $this->last_name;
	}

}
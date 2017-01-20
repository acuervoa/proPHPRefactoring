<?php

namespace App;

use App\Customer;

/**
 * Class description.
 *
 * @author	Andrés Cuervo Adame (kuerbo@gmail.com)
 */
class Order
{

	const DISCOUNT_THRESHOLD = 500;
	public $items = array();
	protected $customer;
	protected $shipping_address;

	public function __construct() 
	{
		$this->customer = new Customer();
	}

	public function setItem($code, $price, $description, $quantity)
	{
		$this->items[] = array('code' => $code,
								'price' => $price,
								'description' => $description,
								'quantity' => $quantity
								);
	}

	public function setItems($items)
	{
		$this->items = $items;
	}

	public function listItems()
	{
		return $this->items;
	}
	
	public function getCustomer()
	{
		return $this->customer;
	}


	public function setShippingAddress($address)
	{
		$this->shipping_address = $address;
	}

	public function getShippingAddress()
	{
		return $this->shipping_address;
	}

	private function applyDiscountOverThreshold($total, $discount = 1)
	{
		if($total > self::DISCOUNT_THRESHOLD) {
			$total = $this->applyDiscount($total, $discount);
		}
		return $total;	
	}

	private function applyDiscount($total, $discount){
		return $total * $discount;
	}

	public function getTotal()
	{
		$total = 0;
		foreach ($this->items as $item) 
		{
			$currency = '';

			//we check for the item to be valid
			if(isset($item['price']) && isset($item['quantity']))
			{
				// we detect currency if indicated
				$price = explode(' ', $item['price']);
				if(isset($price[1])){
					$currency = $price[1];
				}
				$price = $price[0];
				$total += $price  * $item['quantity'];
			}
		}

		// if the customer is gold we apply 40% discount and ...
		if($this->customer->isGold()) {
			$threshold_discount = 0.8;
			$total = $this->applyDiscount($total, 0.6);
		}

		//if the customer is silver we apply 20% discount and ...
		else if($this->customer->isSilver()) {
			$threshold_discount = 0.9;
			$total = $this->applyDiscount($total, 0.8);
		} 
		else {
			$threshold_discount = 0.9;
		}
		$total = $this->applyDiscountOverThreshold($total, $threshold_discount);
		if($currency){
			return 	round($total, 2) . ' ' . $currency;
		}else return round($total, 2);
	}


	
}
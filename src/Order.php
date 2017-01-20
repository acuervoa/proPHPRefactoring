<?php
namespace App;
/**
 * Class description.
 *
 * @author	Andrés Cuervo Adame (kuerbo@gmail.com)
 */
class Order
{

	public $gold_customer = false;
	public $silver_customer = false;

	public $items = array();

	protected $first_name;
	protected $last_name;
	protected $customer_address;
	protected $customer_city;
	protected $customer_country;
	protected $shipping_address;

	
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

	public function setCustomer($customer)
	{
		list($this->first_name, $this->last_name) = explode(' ', $customer);
	}

	public function getCustomer()
	{
		return $this->first_name . ' ' . $this->last_name;
	}

	public function setShippingAddress($address)
	{
		$this->shipping_address = $address;
	}

	public function getShippingAddress()
	{
		return $this->shipping_address;
	}

	public function isGoldCustomer()
	{
		return $this->gold_customer;
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
		if($this->gold_customer) {
			$total = $total * 0.6;
			$total = $this->applyDiscountOverThreshold($total, 0.8);
		}

		//if the customer is silver we apply 20% discount and ...
		else if($this->silver_customer) {
			$total = $total * 0.8;
	
			$total = $this->applyDiscountOverThreshold($total, 0.9);
		} 
		else {
			
			$total = $this->applyDiscountOverThreshold($total, 0.9);
		}

		if($currency){
			return 	round($total, 2) . ' ' . $currency;
		}else return round($total, 2);
	}

	private function ifAmountIsOver500WeApplyFurther20Discount($total)
	{
		if($total > 500) {
				$total = $total * 0.8;
		}
		return $total;
	}

	private function ifAmountIsOver500WeApplyFurther10Discount($total)
	{
		if($total > 500) {
				$total = $total * 0.9;
		}
		return $total;
	}

	private function applyDiscountOverThreshold($total, $discount = 1)
	{
		$threshold = 500;

		if($total > $threshold) {
			$total = $total * $discount;
		}

		return $total;	
	}
}
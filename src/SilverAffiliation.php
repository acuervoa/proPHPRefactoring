<?php 

namespace App;

class SilverAffiliation extends Affiliation
{
	public function getType()
	{
		return Customer::SILVER;
	}

	public function calculateDiscount($order, $total)
	{
		$this->threshold_discount = 0.9;
		$total = $order->applyDiscount($total, 0.8);
		return $order->applyDiscountOverThreshold($total, $this->threshold_discount);
	}
}
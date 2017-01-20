<?php 

namespace App;

class GoldAffiliation extends Affiliation
{
	public function getType()
	{
		return Customer::GOLD;
	}

	public function calculateDiscount($order, $total)
	{
		$this->threshold_discount = 0.8;
		$total = $order->applyDiscount($total, 0.6);
		return $order->applyDiscountOverThreshold($total, $this->threshold_discount);
	}
}


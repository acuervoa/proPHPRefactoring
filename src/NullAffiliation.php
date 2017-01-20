<?php 

namespace App;

class NullAffiliation extends Affiliation
{
	public function getType()
	{
		return null;
	}

	public function calculateDiscount($order, $total)
	{
		$this->threshold_discount = 0.9;
		return $order->applyDiscountOverThreshold($total, $this->threshold_discount);
	}
}
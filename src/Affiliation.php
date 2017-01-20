<?php 

namespace App;

abstract class Affiliation 
{
	protected $threshold_discount;

	abstract public function getType();
	abstract public function calculateDiscount($order, $total);
}






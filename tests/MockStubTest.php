<?php 

class Order
{
	public function addItem(Item $item) {
		$this->items[] = $item;
	}

	public function getTotal()
	{
		$total=0;
		foreach($this->items as $item)
		{
			$total += $item->getTotal(true);
		}
		return $total;
	}
}

class Item
{
	public $quantity;
	public $price;

	public function getTotal()
	{
		return $quantity*$price;
	}
}

class Order2Test extends PHPUnit_Framework_TestCase
{
	public function testGetTotal()
	{
		$item = $this->createMock('Item', array('getTotal'));

		$item->expects($this->once())
			->method('getTotal')
			->with($this->equalTo(true))
			->will($this->returnValue(10));

		$order = new Order();
		$order->addItem($item);
		$this->assertEquals(10, $order->getTotal());

	}
}
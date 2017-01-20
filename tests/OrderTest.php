<?php


use App\Order;
use PHPUnit\Framework\TestCase;


class OrderTest extends TestCase
{

	/**
	 * Initialise classes to test against.
	 *
	 * @author	Andrés Cuervo Adame (kuerbo@gmail.com)
	 * @return	void
	 */
	public function setUp()
	{
		parent::setUp();
		
		$this->order = new Order();
	}

	public function testGetTotal()
	{
		$items = array(
			'34tr45' => array(
								'price' => 10,
								'description' => 'A very good CD by Jane Doe.',
								'quantity' => 2
							),
			'34tr89' => array(
								'price' => 70,
								'description' => 'Super compilation',
								'quantity' => 1
							)

			);
		$this->order->setItems($items);
		$this->assertEquals((20 + 70), $this->order->getTotal());
	}

	public function testGetTotalAfterRemovingItem()
	{
		$items = array(
			'34tr45' => array(
								'price'=> '9.99 EUR',
								'description' => 'A very good CD by Jane Doe.',
								'quantity' => 2
							),
			't667t4' => array(
								'price' => '69.99 EUR',
								'description' => 'Super Compilation.',
								'quantity' => 1
							),
			'jhk987' => array(
								'price' => '49.99 EUR',
								'description' => 'Foo singers. Rare edition',
								'quantity' => 3
							),
		);

		$this->order->setItems($items);
		unset($this->order->items['jhk987']);

		$this->assertEquals((9.99 * 2 + 69.99) . ' EUR', $this->order->getTotal());
	}

	public function testListItems()
	{
		$this->assertEquals(array(), $this->order->listItems());

		$items = array(
			'34tr45' => array(
								'price' => 10,
								'description' => 'A very good CD by Jane Doe.',
								'quantity' => 2
							),
			'34tr89' => array(
								'price' => 70,
								'description' => 'Super compilation',
								'quantity' => 1
							)

			);
		$this->order->setItems($items);
		$this->assertEquals($items, $this->order->listItems());
	}

	public function testGetCustomer()
	{
		$this->order->setCustomer('Jean Pistel');
		$this->assertEquals('Jean Pistel', $this->order->getCustomer());
	}

	public function testShippingAddress()
	{
		$this->order->setShippingAddress('84 Doe Street, London');
		$this->assertEquals('84 Doe Street, London', $this->order->getShippingAddress());
	}

	public function testDiscountForGoldSilverCustomer()
	{
		$this->assertFalse($this->order->isGoldCustomer());

		$items = array(
			'34tr45' => array(
								'price'=> 9.99,
								'description' => 'A very good CD by Jane Doe.',
								'quantity' => 2
							),
			'34tr89' => array(
								'price' => 69.99,
								'description' => 'Super Compilation.',
								'quantity' => 1
							)
			);
		$this->order->setItems($items);
		$this->assertEquals(19.98 + 69.99, $this->order->getTotal());
		$this->order->silver_customer = true;
		$this->assertEquals(71.98, $this->order->getTotal());
		$this->order->gold_customer = true;
		$this->assertEquals(53.98, $this->order->getTotal());
	}


	public function testDiscountOverOrderTotal()
	{
		$items = array(
			'34tr45' => array(
								'price'=> 300,
								'description' => 'A very good CD by Jane Doe.',
								'quantity' => 1
							),
			'34tr89' => array(
								'price' => 270,
								'description' => 'Super Compilation.',
								'quantity' => 1
							)
			);
		$this->order->setItems($items);
		$this->assertEquals(570 * 0.9, $this->order->getTotal());
	}
}
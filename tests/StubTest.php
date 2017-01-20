<?php 

class StubTest extends PHPUnit_Framework_TestCase {
	
	public function testStub()
	{
		// Create a stub for the Foo class
		$stub = $this->createMock('Foo', array('bar'));

		//Configure the stub
		$stub->
			expects($this->any())->
			method('bar')->
			will($this->returnValue('something'));

		// Test calling $stub->doSomething() will now return 'something'
		$this->assertEquals('something', $stub->bar());
	}	
}

class Foo {
	public function bar()
	{
		//do something
	}
}
<?php

use Nerd\Form\Tests\Field;



class SelectTest extends \Nerd\Form\Tests\FieldTestCase
{
	protected $field = 'select';

	// Override
	public function testFieldRendersAttributes()
	{
		$field = $this->ref->newInstance();
		$field->id = 'myid';
		$field->style('mystyle');

		$expected = ' id="myid" style="mystyle"';
		$this->assertSame($expected, $field->attributes(true));
	}
}
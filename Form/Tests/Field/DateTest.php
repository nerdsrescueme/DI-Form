<?php

use Nerd\Form\Tests\Field;



class DateTest extends \Nerd\Form\Tests\FieldTestCase
{
	protected $field = 'date';

	public function testSpecialDateOption()
	{
		$field = $this->ref->newInstance();
		$field->value('03/29/2009');

		$this->assertSame('2009-03-29', $field->value, '->option(\'value\', ...) does not convert date to proper format');
	}
}
<?php

use Nerd\Form\Tests\Field;



class DateTimeTest extends \Nerd\Form\Tests\FieldTestCase
{
	protected $field = 'datetime';

	public function testSpecialDateOption()
	{
		$field = $this->ref->newInstance();
		$field->value('03/29/2009 12:01');

		$this->assertSame('2009-03-29T12:01:00+02:00', $field->value, '->option(\'value\', ...) does not convert date to proper format');
	}
}
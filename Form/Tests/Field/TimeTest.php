<?php

use Nerd\Form\Tests\Field;



class TimeTest extends \Nerd\Form\Tests\FieldTestCase
{
	protected $field = 'time';

	public function testSpecialDateOption()
	{
		$field = $this->ref->newInstance();
		$field->value('12:01');

		$this->assertSame('12:01:00', $field->value, '->option(\'value\', ...) does not convert date to proper format');
	}
}
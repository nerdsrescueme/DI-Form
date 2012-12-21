<?php

use Nerd\Form\Tests\Field;



class CheckboxTest extends \Nerd\Form\Tests\FieldTestCase
{
	protected $field = 'checkbox';

	public function testLabelTextRendering()
	{
		$field = $this->ref->newInstance();
		$field->label('text');
		$expected = '<input type="checkbox"> text';

		$this->assertContains($expected, $field->render(), '->render() does not render proper label placement');
	}
}
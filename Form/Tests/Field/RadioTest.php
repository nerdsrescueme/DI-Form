<?php

use Nerd\Form\Tests\Field;



class RadioTest extends \Nerd\Form\Tests\FieldTestCase
{
	protected $field = 'radio';

	public function testLabelTextRendering()
	{
		$field = $this->ref->newInstance();
		$field->label('text');
		$expected = '<input type="radio"> text';

		$this->assertContains($expected, $field->render(), '->render() does not render proper label placement');
	}
}
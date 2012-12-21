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

	public function testRendersOptions()
	{
		$options = ['1' => 'Item', '2' => 'Item'];
		$field = $this->ref->newInstance();
		$field->option('options', $options);

		$this->assertContains('<option value="1">Item</option>', $field->render(), '->render() does not create proper option tags');
		$this->assertContains('<option value="2">Item</option>', $field->render(), '->render() does not create proper option tags');
	}

	public function testRendersSelected()
	{
		$options = ['1' => 'Item', '2' => 'Item'];
		$field = $this->ref->newInstance();
		$field->option('options', $options);
		$field->option('selected', '1');

		$this->assertContains('<option value="1" selected>Item</option>', $field->render(), '->render() does not create selected option tag');
	}

	public function testRendersOptgroup()
	{
		$options = ['group' => ['1' => 'Item', '2' => 'Item']];
		$field = $this->ref->newInstance();
		$field->option('options', $options);
		$expected = '<optgroup label="group"><option value="1">Item';

		$this->assertContains($expected, $field->render(), '->render() does not create proper optgroup tags');
	}

	public function testRendersOptgroupSelected()
	{
		$options = ['group' => ['1' => 'Item', '2' => 'Item']];
		$field = $this->ref->newInstance();
		$field->option('options', $options);
		$field->selected('1');
		$expected = '<optgroup label="group"><option value="1" selected>Item';

		$this->assertContains($expected, $field->render(), '->render() does not create proper optgroup tags');
	}
}
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

	public function testFieldRendersMultiple()
	{
		$field = $this->ref->newInstance();
		$field->multiple = true;

		$expected = ' multiple';
		$this->assertContains($expected, $field->attributes(true), '->render() does not render a multiple select tag');
	}

	public function testFieldMultipleRendersMultiSelected()
	{
		$options = ['1' => 'Item', '2' => 'Item', '3' => 'Item'];
		$field = $this->ref->newInstance();
		$field->multiple = true;
		$field->option('options', $options);
		$field->option('selected', [1, 2]);

		$this->assertContains('<option value="1" selected', $field->render(), '->render() does not select multiple options');
		$this->assertContains('<option value="2" selected', $field->render(), '->render() does not select multiple options');
		$this->assertContains('<option value="3">', $field->render(), '->render() marks options that are not selected as selected');
	}

	public function testFieldMultipleRendersMultiOptgroupSelected()
	{
		$options = ['1' => 'Item', '2' => 'Item', '3' => ['4' => 'Subitem']];
		$field = $this->ref->newInstance();
		$field->multiple = true;
		$field->option('options', $options);
		$field->option('selected', [1, 4]);

		$this->assertContains('<option value="4" selected', $field->render(), '->render() does not select multiple options within optgroup');
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
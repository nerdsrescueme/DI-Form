<?php

namespace Nerd\Form\Tests;

abstract class FieldTestCase extends \PHPUnit_Framework_TestCase
{
	protected $field;
    protected $ref;
	protected $ins;
	protected $str;

    public function setUp()
    {
        $this->ref = new \ReflectionClass('\\Nerd\\Form\\Field\\'.ucfirst($this->field));
		$this->ins = $this->ref->newInstance();
		$this->str = (string) $this->ins;
    }

    public function testFieldInNerdFormFieldNamespace()
    {
        $this->assertEquals($this->ref->getNamespaceName(), 'Nerd\\Form\\Field');
    }

	public function testFieldIsInstantiable()
	{
		$this->assertTrue($this->ref->isInstantiable());
	}

	public function testFieldExtendsField()
	{
		$parent = $this->ref;
		$found  = false;

		while ($parent = $parent->getParentClass()) {
			if ($parent->getName() == 'Nerd\\Form\\Field') {
				$found = true;
			}
		}

		$this->assertTrue($found);
	}

	public function testFieldClassFunctionsProperly()
	{
		$field = $this->ref->newInstance();
		$field->class = 'class';
		$this->assertSame($field, $field->class('class-1'));
		$this->assertSame($field, $field->option('class', 'class-2'));
		$this->assertSame('class class-1 class-2', $field->class);
	}

	public function testFieldRendersAttributes()
	{
		$field = $this->ref->newInstance();
		$field->id = 'myid';
		$field->style('mystyle');

		$this->assertContains('type="'.$field->type.'"', $field->render(), '->render does not render attributes properly');
		$this->assertContains('id="myid"', $field->render(), '->render does not render attributes properly');
		$this->assertContains('style="mystyle"', $field->render(), '->render does not render attributes properly');
	}

	public function testFieldRendersDataAttributes()
	{
		$field = $this->ref->newInstance();
		$field->data('test', 'test');

		$this->assertContains('data-test="test"', $field->render(), '->render() does not render data attributes');
	}

	public function testFieldReturnsEmptyIfRemoved()
	{
		$field = $this->ref->newInstance();
		$field->remove();

		$this->assertEmpty($field->render(), '->render() returns a value when field has been removed');
	}

	public function testFieldCanApplyLabelAndNullify()
	{
		$field = $this->ref->newInstance();
		$field->label('My Label');

		$this->assertNotNull($field->label(), '->label() is unable to create a label');
	}

	public function testFieldCanApplyLabelWithAttributes()
	{
		$field = $this->ref->newInstance();
		$field->label('My Label', ['for' => 'field']);

		$this->assertCount(1, $field->label->allOptions(), '->label() does not pass through label options');
	}

	public function testFieldAttributesReturnsArray()
	{
		$field = $this->ref->newInstance();

		$this->assertTrue(is_array($field->attributes(false)), '->attributes(false) does not return the options array');
	}

	public function testFieldCanSetBooleanAttributes()
	{
		$field = $this->ref->newInstance();
		$field->readonly(true);

		$this->assertContains(' readonly', $field->attributes(true), '->attributes(true) does not render boolean attributes properly');
		$this->assertNotContains('readonly="readonly"', $field->attributes(true), '->attributes(true) does not render boolean attributes properly');
		$this->assertNotContains('readonly="true"', $field->attributes(true), '->attributes(true) renders boolean attributes as normal ones');
	}

	public function testFieldWrappable()
	{
		if ($this->ref->getShortName() == 'Hidden') {
			return;
		}

		$field = $this->ref->newInstance();
		$field->wrap('<start>', '</end>');
		$field->wrapField('<startfield>', '</endfield>');

		$this->assertContains('<start>', $field->render(), '->render() does not produced proper wrapped output');
		$this->assertContains('</end>', $field->render(), '->render() does not produced proper wrapped output');
		$this->assertContains('<startfield>', $field->render(), '->render() does not produced proper wrapped output');
		$this->assertContains('</endfield>', $field->render(), '->render() does not produced proper wrapped output');
	}

	public function testFieldSetText()
	{
		$field = $this->ref->newInstance();

		// Only run for fields with text() methods
		if (!method_exists($field, 'text')) {
			return;
		}

		$this->assertSame($field, $field->text('text'), '->text() is not chainable');
		$this->assertSame('text', $field->text, '->text() does not set text property properly');
	}
}

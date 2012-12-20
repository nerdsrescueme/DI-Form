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

		$expected = ' type="'.$field->type.'" id="myid" style="mystyle"';
		$this->assertSame($expected, $field->attributes(true));
	}
}

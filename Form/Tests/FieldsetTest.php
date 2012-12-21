<?php

namespace Nerd\Form\Tests;

class FieldsetTest extends TestCase
{
    public function testConstruction()
    {
        $fieldset = new \Nerd\Form\Fieldset;
        $this->assertTrue(is_object($fieldset));
    }

    public function testConstructionCreatesFieldsCollection()
    {
        $fieldset = new \Nerd\Form\Fieldset;
        $this->assertInstanceOf('\\Nerd\\Form\\Design\\Collection', $fieldset->fields, '->__construct() does not create a Collection instance');
    }

    /**
     * @depends testConstructionCreatesFieldsCollection
     */
    public function testConstructionWithField()
    {
        $field1 = new \Nerd\Form\Field\Text;
        $field2 = new \Nerd\Form\Field\Password;
        $fieldset = new \Nerd\Form\Fieldset($field1, $field2);

        $this->assertCount(2, $fieldset->fields, '->__construct() did not assign two given fields to the collection');
    }

    public function testAddingFields()
    {
        $fieldset = new \Nerd\Form\Fieldset;
        $field = new \Nerd\Form\Field\Checkbox;
        $result = $fieldset->addField($field);

        $this->assertSame($field, $result, '->addField() does not return the proper Field instance');
        $this->assertCount(1, $fieldset->fields, '->addField() did not assign the new field to the collection');
    
        $fieldset->addField(new \Nerd\Form\Field\Checkbox);

        $this->assertCount(2, $fieldset->fields, '->addField() did not assign the second new field to the collection');
    }

    public function testRender()
    {
        $field = new \Nerd\Form\Field\Text;
        $fieldset = new \Nerd\Form\Fieldset;
        $fieldset->addField($field);

        $expected = '<fieldset>'.$field->render().'</fieldset>';
        $this->assertSame($fieldset->render(), $expected, '->render() did not produce the desired output');
        $this->assertSame((string) $fieldset, $expected, '->__toString() did not produce the desired output');
    }

    /**
     * @depends testRender
     */
    public function testRenderWithMultipleFields()
    {
        $field1 = new \Nerd\Form\Field\Text;
        $field2 = new \Nerd\Form\Field\Text;
        $fieldset = new \Nerd\Form\Fieldset($field1, $field2);

        $expected = '<fieldset>'.$field1->render().$field2->render().'</fieldset>';
        $this->assertSame($fieldset->render(), $expected, '->render() did not produce the desired output');
    }

    /**
     * @depends testRender
     */
    public function testRenderWithAttributes()
    {
        $fieldset = new \Nerd\Form\Fieldset;
        $fieldset->id = 'fieldset';
        $fieldset->style('background:red');

        $expected = '<fieldset id="fieldset" style="background:red"></fieldset>';
        $this->assertSame($fieldset->render(), $expected, '->render() did not produce the desired output with attributes');
    }

    public function testCanSetMultiOptions()
    {
        $options = ['id' => 'fieldset', 'style' => 'background:red'];
        $fieldset = new \Nerd\Form\Fieldset;
        $fieldset->options($options);

        $this->assertTrue(is_array($fieldset->allOptions()), '->__construct() does properly set options');
        $this->assertCount(2, $fieldset->allOptions(), '->__construct() does not properly set options');
    }

    /**
     * @depends testCanSetMultiOptions
     * @depends testRenderWithAttributes
     */
    public function testRenderWithMultisetAttributes()
    {
        $fieldset = new \Nerd\Form\Fieldset;
        $options = ['id' => 'fieldset', 'style' => 'background:red'];
        $fieldset->options($options);

        $expected = '<fieldset id="fieldset" style="background:red"></fieldset>';
        $this->assertSame($fieldset->render(), $expected, '->render() did not produce the desired output with attributes');
    }

    /**
     * @depends testRenderWithAttributes
     */
    public function testRenderWithDataAttributes()
    {
        $fieldset = new \Nerd\Form\Fieldset;
        $fieldset->data('index', 2);
        $fieldset->data('my-field', 'x');

        $expected = '<fieldset data-index="2" data-my-field="x"></fieldset>';
        $this->assertSame($fieldset->render(), $expected, '->render() did not produce the desired output with data-attributes');
    }

    public function testLegend()
    {
        $fieldset = new \Nerd\Form\Fieldset;
        $result = $fieldset->legend('Legend');

        $this->assertSame($fieldset, $result, '->legend() is not chainable');
        $this->assertInstanceOf('\\Nerd\\Form\\Legend', $fieldset->legend, '->legend() did not create a new Legend object');
    }

    /**
     * @depends testLegend
     */
    public function testCanAccessLegend()
    {
        $fieldset = new \Nerd\Form\Fieldset;
        $fieldset->legend('Legend');

        $this->assertTrue(is_string($fieldset->legend->render()), '->legend is not accessible');
    }

    /**
     * @depends testRender
     * @depends testCanAccessLegend
     */
    public function testRenderWithLegend()
    {
        $field = new \Nerd\Form\Field\Text;
        $fieldset = new \Nerd\Form\Fieldset;
        $fieldset->legend('Legend Text');
        $fieldset->addField($field);

        $expected = '<fieldset>'.$fieldset->legend->render().$field->render().'</fieldset>';
        $this->assertSame($expected, $fieldset->render(), '->render() did not produce the desired output');
    }

    public function testRemoved()
    {
        $fieldset = new \Nerd\Form\Fieldset;
        $fieldset->remove();

        $this->assertEmpty($fieldset->render(), '->remove() does not stop output from being rendered');
    }
}
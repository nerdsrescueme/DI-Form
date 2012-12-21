<?php

namespace Nerd\Form\Tests;

class GroupTest extends TestCase
{
    public function testConstruction()
    {
        $group = new \Nerd\Form\Group;
        $this->assertTrue(is_object($group));
    }

    public function testConstructionCreatesFieldsCollection()
    {
        $group = new \Nerd\Form\Group;
        $this->assertInstanceOf('\\Nerd\\Form\\Design\\Collection', $group->fields, '->__construct() does not create a Collection instance');
    }

    /**
     * @depends testConstructionCreatesFieldsCollection
     */
    public function testConstructionWithField()
    {
        $field1 = new \Nerd\Form\Field\Text;
        $field2 = new \Nerd\Form\Field\Password;
        $group = new \Nerd\Form\Group($field1, $field2);

        $this->assertCount(2, $group->fields, '->__construct() did not assign two given fields to the collection');
    }

    public function testAddingFields()
    {
        $group = new \Nerd\Form\Group;
        $field = new \Nerd\Form\Field\Checkbox;
        $result = $group->addField($field);

        $this->assertSame($field, $result, '->addField() does not return the proper Field instance');
        $this->assertCount(1, $group->fields, '->addField() did not assign the new field to the collection');
    
        $group->addField(new \Nerd\Form\Field\Checkbox);

        $this->assertCount(2, $group->fields, '->addField() did not assign the second new field to the collection');
    }

    public function testRender()
    {
        $field = new \Nerd\Form\Field\Text;
        $group = new \Nerd\Form\Group;
        $group->addField($field);

        $expected = '<div>'.$field->render().'</div>';
        $this->assertSame($group->render(), $expected, '->render() did not produce the desired output');
        $this->assertSame((string) $group, $expected, '->__toString() did not produce the desired output');
    }

    /**
     * @depends testRender
     */
    public function testRenderWithMultipleFields()
    {
        $field1 = new \Nerd\Form\Field\Text;
        $field2 = new \Nerd\Form\Field\Text;
        $group = new \Nerd\Form\Group($field1, $field2);

        $expected = '<div>'.$field1->render().$field2->render().'</div>';
        $this->assertSame($group->render(), $expected, '->render() did not produce the desired output');
    }

    /**
     * @depends testRender
     */
    public function testRenderWithAttributes()
    {
        $group = new \Nerd\Form\Group;
        $group->id = 'Group';
        $group->style('background:red');

        $expected = '<div id="Group" style="background:red"></div>';
        $this->assertSame($group->render(), $expected, '->render() did not produce the desired output with attributes');
    }

    public function testCanSetMultiOptions()
    {
        $options = ['id' => 'Group', 'style' => 'background:red'];
        $group = new \Nerd\Form\Group;
        $group->options($options);

        $this->assertTrue(is_array($group->allOptions()), '->__construct() does properly set options');
        $this->assertCount(2, $group->allOptions(), '->__construct() does not properly set options');
    }

    /**
     * @depends testCanSetMultiOptions
     * @depends testRenderWithAttributes
     */
    public function testRenderWithMultisetAttributes()
    {
        $group = new \Nerd\Form\Group;
        $options = ['id' => 'Group', 'style' => 'background:red'];
        $group->options($options);

        $expected = '<div id="Group" style="background:red"></div>';
        $this->assertSame($group->render(), $expected, '->render() did not produce the desired output with attributes');
    }

    /**
     * @depends testRenderWithAttributes
     */
    public function testRenderWithDataAttributes()
    {
        $group = new \Nerd\Form\Group;
        $group->data('index', 2);
        $group->data('my-field', 'x');

        $expected = '<div data-index="2" data-my-field="x"></div>';
        $this->assertSame($group->render(), $expected, '->render() did not produce the desired output with data-attributes');
    }

    public function testElementSetOnConstruct()
    {
        $group = new \Nerd\Form\Group('p');
        $this->assertSame($group->element, 'p', '->__construct() does not set the element property');
    }

    public function testRenderWithElement()
    {
        $group = new \Nerd\Form\Group('p');
        $expected = '<p></p>';

        $this->assertSame($group->render(), $expected, '->render() does not properly produce a non-default element');
    }

    public function testRenderWithWrap()
    {
        $group = new \Nerd\Form\Group('p');
        $group->wrap('<div>', '</div>');
        $expected = '<div><p></p></div>';

        $this->assertSame($group->render(), $expected, '->render() does not properly produce wrapped output');

        $group->wrap(false);
        $expected = '<p></p>';

        $this->assertSame($group->render(), $expected, '->wrap(false) does not clear wrap output from ->render()');
    }

    public function testLabel()
    {
        $group = new \Nerd\Form\Group;
        $result = $group->label('Label');

        $this->assertSame($group, $result, '->label() is not chainable');
        $this->assertInstanceOf('\\Nerd\\Form\\Label', $group->label, '->label() did not create a new Label object');
    }

    /**
     * @depends testLabel
     */
    public function testCanAccessLabel()
    {
        $group = new \Nerd\Form\Group;
        $group->label('Label');

        $this->assertTrue(is_string($group->label->render()), '->label is not accessible');
    }

    /**
     * @depends testRender
     * @depends testCanAccessLabel
     */
    public function testRenderWithLabel()
    {
        $field = new \Nerd\Form\Field\Text;
        $group = new \Nerd\Form\Group;
        $group->label('Label Text');
        $group->addField($field);
        $group->wrap('<div>', '</div>');

        $expected = '<div>'.$group->label->render().'<div>'.$field->render().'</div></div>';
        $this->assertSame($expected, $group->render(), '->render() did not produce the desired output');
    }

    public function testRemoved()
    {
        $group = new \Nerd\Form\Group;
        $group->remove();

        $this->assertEmpty($group->render(), '->remove() does not stop output from being rendered');
    }
}
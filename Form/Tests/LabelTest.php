<?php

namespace Nerd\Form\Tests;

class LabelTest extends TestCase
{
    public function testConstruction()
    {
        $label = new \Nerd\Form\Label('LabelText');
        $this->assertTrue(is_object($label));
    }

    public function testConstructionWithText()
    {
        $label = new \Nerd\Form\Label('LabelText');

        $this->assertSame('LabelText', $label->text(), '->__construct does not pass label text');
    }

    public function testConstructionWithAttributes()
    {
        $options = ['rel' => 'label'];
        $label = new \Nerd\Form\Label('LabelText', $options);

        $this->assertCount(1, $label->allOptions(), '->__construct() does not pass provided attributes');
    }

    public function testConstructionWithField()
    {
        $field = new \Nerd\Form\Field\Text(['id' => 'test']);
        $label = new \Nerd\Form\Label('LabelText', [], $field);

        $this->assertSame($field, $label->field, '->__construct() does not pass provided parent field');
        $this->assertCount(1, $label->allOptions(), '->__construct() did not automatically set for when given field has id');
    }

    public function testLabelSetText()
    {
        $label = new \Nerd\Form\Label('toReset');
        $label->text('LabelText');

        $this->assertSame('LabelText', $label->text(), '->__construct does not pass label text');
    }

    public function testRemoved()
    {
        $label = new \Nerd\Form\Label('LabelText');
        $label->remove();

        $this->assertEmpty($label->render(), '->remove() does not stop output from being rendered');
    }

    public function testSimpleRender()
    {
        $label = new \Nerd\Form\Label('LabelText');
        $expected = '<label>LabelText</label>';
        $this->assertSame($label->render(), $expected, '->render() does not produce desired output');
    }

    public function testRenderWithAttributes()
    {
        $label = new \Nerd\Form\Label('LabelText');
        $label->options(['rel' => 'label']);
        $expected = '<label rel="label">LabelText</label>';

        $this->assertSame($label->render(), $expected, '->render() does not produce desired output');
    }

    public function testRenderWithAutoForAttribute()
    {
        $field = new \Nerd\Form\Field\Text(['id' => 'field']);
        $label = new \Nerd\Form\Label('LabelText', [], $field);
        $expected = '<label for="field">LabelText</label>';

        $this->assertSame($label->render(), $expected, '->render() does not produce desired output');
    }
}
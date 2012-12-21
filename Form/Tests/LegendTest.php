<?php

namespace Nerd\Form\Tests;

class LegendTest extends TestCase
{
    public function testConstruction()
    {
        $legend = new \Nerd\Form\Legend('LegendText');
        $this->assertTrue(is_object($legend));
    }

    public function testConstructionWithText()
    {
        $legend = new \Nerd\Form\Legend('LegendText');

        $this->assertSame('LegendText', $legend->text(), '->__construct does not pass label text');
    }

    public function testConstructionWithAttributes()
    {
        $options = ['rel' => 'label'];
        $legend = new \Nerd\Form\Legend('LegendText', $options);

        $this->assertCount(1, $legend->allOptions(), '->__construct() does not pass provided attributes');
    }

    public function testConstructionWithFieldset()
    {
        $fieldset = new \Nerd\Form\Fieldset;
        $legend = new \Nerd\Form\Legend('LegendText', [], $fieldset);

        $this->assertSame($fieldset, $legend->fieldset, '->__construct() does not pass provided parent Fieldset');
    }

    public function testLabelSetText()
    {
        $legend = new \Nerd\Form\Legend('toReset');
        $legend->text('LegendText');

        $this->assertSame('LegendText', $legend->text(), '->__construct does not pass label text');
    }

    public function testRemoved()
    {
        $legend = new \Nerd\Form\Legend('LegendText');
        $legend->remove();

        $this->assertEmpty($legend->render(), '->remove() does not stop output from being rendered');
    }

    public function testSimpleRender()
    {
        $legend = new \Nerd\Form\Legend('LegendText');
        $expected = '<legend>LegendText</legend>';
        $this->assertSame($legend->render(), $expected, '->render() does not produce desired output');
    }

    public function testRenderWithAttributes()
    {
        $legend = new \Nerd\Form\Legend('LegendText');
        $legend->options(['rel' => 'label']);
        $expected = '<legend rel="label">LegendText</legend>';

        $this->assertSame($legend->render(), $expected, '->render() does not produce desired output');
    }
}
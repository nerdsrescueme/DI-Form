<?php

namespace Nerd\Form\Tests;

class FormTest extends TestCase
{
    public function setUp()
    {
        $this->setUpReflection('\\Nerd\\Form\\Form');
    }

    public function testFormInNerdNamespace()
    {
       $this->assertEquals($this->ref->getNamespaceName(), 'Nerd\\Form');
    }

    public function testRenderSimpleForm()
    {
    	$form = new \Nerd\Form\Form;
    	$form->field('text');

    	$expected = '<form><input type="text"></form>';
    	$result   = (string) $form;

    	$this->assertSame($result, $expected, 'A simple form could not be rendered');
    }
}

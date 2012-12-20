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
    	$result   = $form->render();

    	$this->assertSame($result, $expected, 'A simple form could not be rendered');
    }

    public function testRenderFormAttributes()
    {
    	$form = new \Nerd\Form\Form;
    	$form->action('#');
    	$form->method = 'post';

    	$expected = '<form action="#" method="post"></form>';
    	$result   = $form->render();

    	$this->assertSame($result, $expected, 'Form does not propely render attributes');
    }

    public function testFieldsInheritFormWrappers()
    {
    	$form = new \Nerd\Form\Form;
    	$form->wrap('<p>', '</p>');
    	$form->field('text');

    	$expected = '<form><p><input type="text"></p></form>';
    	$result   = $form->render();

    	$this->assertSame($result, $expected, 'Fields do not inherit form wrap');

    	$form = new \Nerd\Form\Form;
    	$form->wrapFields('<div>', '</div>');
    	$form->field('text');

    	$expected = '<form><div><input type="text"></div></form>';
    	$result   = $form->render();

    	$this->assertSame($result, $expected, 'Fields do not inherit form field wrap');
    }

    public function testFindByType()
    {
    	$form = new \Nerd\Form\Form;
    	$form->field('checkbox');
    	$form->field('checkbox');
    	$form->field('text');
    	$form->field('checkbox');
    	$form->field('text');

    	$checkboxes = $form->findByType('checkbox');
    	$this->assertCount(3, $checkboxes, '->findByType() did not find all instances of checkbox');

    	foreach ($checkboxes as $checkbox) {
    		$this->assertInstanceOf('\\Nerd\\Form\\Field\\Checkbox', $checkbox);
    	}

    	$texts = $form->findByType('text');
    	$this->assertCount(2, $texts, '->findByType() did not find all instances of text');

    	foreach ($texts as $text) {
    		$this->assertInstanceOf('\\Nerd\\Form\\Field\\Text', $text);
    	}
    }
}

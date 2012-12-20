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
}

<?php

namespace Nerd\Form\Tests;

class FormTest extends TestCase
{
    public function setUp()
    {
        $this->setUpReflection('\\Nerd\\Form\\Form');
    }

    public function testConstructWithOptions()
    {
        $options = ['action' => '#', 'method' => 'post'];
        $form = new \Nerd\Form\Form($options);

        $this->assertCount(2, $form->allOptions(), '->__construct() does not set options');
    }

    public function testWrappers()
    {
        $form = new \Nerd\Form\Form;
        $form->wrap('<div>', '</div>');
        $form->wrapField('<div>', '</div>');

        $this->assertTrue($form->hasWrap(), '->wrap() does not set wrappers');
        $this->assertTrue($form->hasFieldWrap(), '->wrapField() does not set wrappers');
    }

    public function testAddField()
    {
        $form = new \Nerd\Form\Form;
        $form->addField('text');
        $this->assertCount(1, $form->fields, '->addField() did not insert a new field');
    }

    public function testAddFieldWithNamespace()
    {
        $form = new \Nerd\Form\Form;
        $form->addField('\\Nerd\\Form\\Field\\Number');
        $this->assertCount(1, $form->fields, '->addField() did not insert a new field with namespace');
    }

    public function testAddFieldWithAttributes()
    {
        $form = new \Nerd\Form\Form;
        $field = $form->addField('text', ['id' => 'field']);
        $this->assertCount(2, $field->allOptions(), '->addField() did not inject attributes into a new Field');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddFieldChokesOnUnknownType()
    {
        $form = new \Nerd\Form\Form;
        $field = $form->addField('fail');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAddFieldWithNamespaceChokesOnUnfound()
    {
        $form = new \Nerd\Form\Form;
        $form->addField('\\This\\Should\\Fail');
    }

    public function testFieldsInheritFormWrappers()
    {
        $form = new \Nerd\Form\Form;
        $form->wrap('<p>', '</p>');
        $form->addField('text');

        $expected = '<form><p><input type="text"></p></form>';
        $result   = $form->render();

        $this->assertSame($result, $expected, 'Fields do not inherit form wrap');

        $form = new \Nerd\Form\Form;
        $form->wrapField('<div>', '</div>');
        $form->addField('text');

        $expected = '<form><div><input type="text"></div></form>';
        $result   = $form->render();

        $this->assertSame($result, $expected, 'Fields do not inherit form field wrap');
    }

    public function testRenderSimpleForm()
    {
    	$form = new \Nerd\Form\Form;
    	$form->addField('text');

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

    public function testFindByType()
    {
    	$form = new \Nerd\Form\Form;
    	$form->addField('checkbox');
    	$form->addField('checkbox');
    	$form->addField('text');
    	$form->addField('checkbox');
    	$form->addField('text');

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

    public function testFindByTypeRecursively()
    {
        $form = new \Nerd\Form\Form;
        $form->addField('checkbox');
        $form->addField('text');

        $group = $form->addGroup();
        $group->addField(new \Nerd\Form\Field\Checkbox);
        $group->addField(new \Nerd\Form\Field\Checkbox);
        $group->addField(new \Nerd\Form\Field\Text);

        $checkboxes = $form->findByType('checkbox');
        $this->assertCount(3, $checkboxes, '->findByType() did not find all instances of checkbox');

        $texts = $form->findByType('text');
        $this->assertCount(2, $texts, '->findByType() did not find all instances of text');
    }

    public function testFindByAttribute()
    {
        $form = new \Nerd\Form\Form;
        $form->addField('checkbox', ['rel' => 'test']);
        $form->addField('checkbox');
        $form->addField('text', ['rel' => 'test']);
        $form->addField('checkbox');
        $form->addField('text', ['rel' => 'test']);

        $rels = $form->findByattribute('rel', 'test');
        $this->assertCount(3, $rels, '->findByAttribute() did not find all instances of [rel=test]');
    }

    public function testFindByAttributeRecursively()
    {
        $form = new \Nerd\Form\Form;
        $form->addField('checkbox', ['rel' => 'test']);
        $form->addField('text');

        $group = $form->addGroup();
        $group->addField(new \Nerd\Form\Field\Checkbox);
        $group->addField(new \Nerd\Form\Field\Checkbox);
        $group->addField(new \Nerd\Form\Field\Text(['rel' => 'test']));

        $rels = $form->findByattribute('rel', 'test');
        $this->assertCount(2, $rels, '->findByAttribute() did not find all instances of [rel=test]');
    }

    public function testAddFieldsetReturnsFieldset()
    {
        $form = new \Nerd\Form\Form;
        $fieldset = $form->addFieldset();

        $this->assertInstanceOf('\\Nerd\\Form\\Fieldset', $fieldset, '->addFieldset() does not return an instance of Fieldset');
    }

    public function testAddFieldsetWithConstructorFields()
    {
        $form = new \Nerd\Form\Form;
        $field = new \Nerd\Form\Field\Date;
        $fieldset = $form->addFieldset($field);

        $this->assertCount(1, $fieldset->fields, '->addFieldset() does not pass fields into new Fieldset instance');
    }

    public function testFindByTypeRecursivelyWithFieldset()
    {
        $form = new \Nerd\Form\Form;
        $form->addField('checkbox');
        $form->addField('tel');

        $fieldset = $form->addFieldset();
        $fieldset->addField(new \Nerd\Form\Field\Radio);
        $fieldset->addField(new \Nerd\Form\Field\Select);
        $fieldset->addField(new \Nerd\Form\Field\Tel);

        $tel = $form->findByType('tel');
        $this->assertCount(2, $tel, '->findByType() did not find all instances of Tel when nested in Fieldset');
    }

    public function testFindByAttributeRecursivelyWithFieldset()
    {
        $form = new \Nerd\Form\Form;
        $form->addField('checkbox');
        $form->addField('tel');

        $fieldset = $form->addFieldset();
        $fieldset->addField(new \Nerd\Form\Field\Radio);
        $fieldset->addField(new \Nerd\Form\Field\Select(['rel' => 'test']));
        $fieldset->addField(new \Nerd\Form\Field\Tel(['rel' => 'test']));

        $rels = $form->findByattribute('rel', 'test');
        $this->assertCount(2, $rels, '->findByAttribute() did not find all instances of [rel=test] when nested in Fieldset');
    }

    public function testAddGroupReturnsGroup()
    {
        $form = new \Nerd\Form\Form;
        $group = $form->addGroup();

        $this->assertInstanceOf('\\Nerd\\Form\\Group', $group, '->addGroup() does not return an instance of Group');
    }

    public function testAddGroupInheritsWrappers()
    {
        $form = new \Nerd\Form\Form;
        $form->wrap('<div>', '</div>');
        $form->wrapField('<div>', '</div>');

        $group = $form->addGroup();

        $this->assertTrue($group->hasWrap(), '->addGroup() does not inject it\'s wrappers');
        $this->assertTrue($group->hasFieldWrap(), '->addGroup() does not inject it\'s wrappers');
    }

    public function testAddGroupWithConstructorFields()
    {
        $form = new \Nerd\Form\Form;
        $field = new \Nerd\Form\Field\DateTime;
        $group = $form->addGroup($field);

        $this->assertCount(1, $group->fields, '->addGroup() does not pass fields into new Group instance');
    }

    public function testFindByTypeRecursivelyWithGroup()
    {
        $form = new \Nerd\Form\Form;
        $form->addField('checkbox');
        $form->addField('tel');

        $group = $form->addGroup();
        $group->addField(new \Nerd\Form\Field\Radio);
        $group->addField(new \Nerd\Form\Field\Select);
        $group->addField(new \Nerd\Form\Field\Tel);

        $tel = $form->findByType('tel');
        $this->assertCount(2, $tel, '->findByType() did not find all instances of Tel when nested in Group');
    }

    public function testFindByAttributeRecursivelyWithGroup()
    {
        $form = new \Nerd\Form\Form;
        $form->addField('checkbox', ['rel' => 'test']);
        $form->addField('tel');

        $group = $form->addGroup();
        $group->addField(new \Nerd\Form\Field\Radio(['rel' => 'test']));
        $group->addField(new \Nerd\Form\Field\Select);
        $group->addField(new \Nerd\Form\Field\Tel);

        $rels = $form->findByattribute('rel', 'test');
        $this->assertCount(2, $rels, '->findByAttribute() did not find all instances of [rel=test] when nested in Fieldset');
    }
}

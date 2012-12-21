<?php

namespace Nerd\Form;

/**
 * Form Class
 *
 * Object oriented form builder class. This class is the gateway to Nerd's form
 * building capabilities. In essence, it creates an enumerable and renderable instance
 * of a form built with various HTML classes.
 */
class Form
{
	// Traits
	use Design\Attributable
	  , Design\Wrappable
	  , Design\Renderable;

	/**
	 * @var Collection
	 */
	public $fields;

	/**
	 * Constructor
	 *
	 * @param array $options Attr/value pairs
	 * @return Form
	 */
	public function __construct(array $options = [])
	{
		$this->fields = new Design\Collection();

		foreach ($options as $key => $value)
		{
			$this->option($key, $value);
		}
	}

	/**
	 * Locate form elements by class name of field
	 *
	 *     $form->findByType('hidden');
	 *     $form->findByType('date');
	 *
	 * @param string $type Field type
	 * @return mixed Field or array of fields
	 */
	public function findByType($type)
	{
		$fields = $this->fields->findAllRecursively(
			function($field) use ($type) {
				$class = explode('\\', get_class($field));
				return !$field->removed and end($class) === ucfirst($type);
			},
			function($field) {
				if ($field instanceof Container) {
					return $field->fields->toArray();
				}
			}
		);

		return count($fields) === 1 ? $fields[0] : $fields;
	}

	/**
	 * Locate form elements by one of its attributes
	 *
	 *     $form->findByAttribute('value', 1);
	 *     $form->findByAttribute('max', 3);
	 *
	 * @param string Attribute name
	 * @return mixed Field or array of Field objects
	 */
	public function findByAttribute($attribute, $value)
	{
		$fields = $this->fields->findAllRecursively(
			function($field) use ($attribute, $value) {
				return !$field->removed and isset($field->{$attribute}) and $field->{$attribute} === $value;
			},
			function($field) {
				if ($field instanceof Container) {
					return $field->fields->toArray();
				}
			}
		);

		return count($fields) === 1 ? $fields[0] : $fields;
	}

	/**
	 * Add a new field to the form
	 *
	 * This will add a field to the form of the given type. Types are defined within
	 * the Nerd library, but will be searched for in the current application if none
	 * is found. The field can be appended or prepended to the form, or simply created
	 * and not added to the form.
	 *
	 *     $form->field('hidden', ['value' => 1]); // Append a hidden field
	 *     $form->field('text', ['class' => 'small'], true); // Prepend a text field
	 *
	 *     $field = $form->field('text', [], null); // Only create an element
	 *
	 * @param    string          Type of field to add
	 * @param    array           Field options
	 * @param    boolean|null
	 */
	public function addField($type, array $options = [], $prepend = false)
	{
		if (strpos($type, '\\') === false) {
			$type = '\\Nerd\\Form\\Field\\'.ucfirst($type);
		}

		if (!class_exists($type)) {
			throw new \InvalidArgumentException("Form field type [$type] does not exist.");
		}

		$field = new $type($options);

		$this->hasWrap()      and $field->wrap($this->wrap[0], $this->wrap[1]);
		$this->hasFieldWrap() and $field->wrapField($this->fieldWrap[0], $this->fieldWrap[1]);
		$prepend !== null     and $this->fields->add($field, $prepend);

		return $field;
	}

	/**
	 * Add a fieldset to the form
	 *
	 * Create a fieldset container within the form. A fieldset object is built to be
	 * recursable by the form renderer, allowing for maximum form building flexibility.
	 * This method optionally takes fields as arguments, adding them to the fieldset
	 * upon creation
	 *
	 * @return    Nerd\Form\Fieldset
	 */
	public function addFieldset()
	{
		$fields   = func_get_args();
		$fieldset = new Fieldset();

		foreach($fields as $field) {
			$fieldset->addField($field);
		}

		$this->fields->add($fieldset);

		return $fieldset;
	}

	/**
	 * Add a fieldset to the form
	 *
	 * Create a fieldset container within the form. A group object is built to be
	 * recursable by the form renderer.
	 *
	 * @return    Nerd\Form\Group
	 */
	public function addGroup()
	{
		$fields = func_get_args();
		$group  = new Group();

		if ($this->hasWrap()) {
			$group->wrap($this->wrap[0], $this->wrap[1]);
		}

		if ($this->hasFieldWrap()) {
			$group->wrapField($this->fieldWrap[0], $this->fieldWrap[1]);
		}

		foreach($fields as $field) {
			$group->addField($field);
		}

		$this->fields->add($group);

		return $group;
	}

	/**
	 * Render this form to HTML markup
	 *
	 * @return    string          Rendered form
	 */
	public function render()
	{
		$out = "<form{$this->attributes(true)}>";

		$this->fields->each(function($field) use (&$out) {
			$out .= (string) $field->render();
		});

		return $out . '</form>';
	}
}
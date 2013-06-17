<?php

namespace Nerd\Form\Design;

/**
 * Attributable trait
 *
 * This trait identifies a class as able to include HTML attributes. Essentially, it
 * provides common functionality to any class that deals with outputting HTML tags.
 *
 * @package    Nerd
 * @subpackage Core
 */
trait Attributable
{
	/**
	 * Options that exist on this class.
	 *
	 * They are not considered attributes until they have been rendered since they
	 * have been not run through the attribute allowed method.
	 *
	 * @var array
	 */
	protected $options = [];

	/**
	 * Class attribute data
	 *
	 * The class attribute is treated differently than all other attributes. This is
	 * so we can provide the ability to add/remove class values without the need to
	 * reset the class on each change.
	 *
	 * @var array
	 */
	protected $classes = [];

	/**
	 * Set/get an option/attribute
	 *
	 * Simply sets or gets an option or attribute depending on whether or not a value
	 * is passed. If setting the class attribute special handling is invoked.
	 *
	 * @param    string             Option or attribute name
	 * @param    mixed|null         Option or attribute value or none
	 * @return   mixed              If getting an option/attribute
	 * @return   chainable          If setting an option/attribute
	 */
	public function option($option, $value = null)
	{
		if ($value === null) {
			if ($option === 'class') {
				return implode(' ', $this->classes);
			}

			return isset($this->options[$option]) ? $this->options[$option] : null;
		}

		if ($option === 'class') {
			$new = explode(' ', trim($value));
			$this->classes = array_merge($this->classes, $new);
		} else {
			$this->options[$option] = $value;
		}

		return $this;
	}

	/**
	 * Set multiple options at once
	 *
	 * @see Nerd\Attributable::option()
	 *
	 * @param    array          Array of option or attribute key/pairs.
	 * @return   chainable
	 */
	public function options(array $options)
	{
		foreach($options as $key => $value) {
			$this->option($key, $value);
		}

		return $this;
	}

	/**
	 * Get all given options
	 *
	 * @return array
	 */
	public function allOptions()
	{
		$class = $this->option('class');

		return !empty($class) ? $this->options + ['class' => $class] : $this->options;
	}

	/**
	 * Render attributes
	 *
	 * This methods allows you to render the object's attributes as a string or an
	 * array. It bypasses all data-* attributes allowing HTML 5 rendering.
	 *
	 * @param    boolean          Render attributes as a string?
	 * @return   string|array
	 */
	public function attributes($asString = false)
	{
		$attributes = $this->options;
		$attributes['class'] = $this->option('class');

		// Add in data-* attributes
		foreach($this->options as $key => $value) {
			if (strpos($key, 'data-') !== false) {
				$attributes[$key] = $value;
			}
		}

		if (!$asString) {
			return $attributes;
		}

		$out = '';

		foreach($attributes as $attribute => $value) {
			if (empty($value) or is_array($value)) {
				if ($value === 0) {
					$out .= " $attribute=\"0\"";
				}
				continue;
			}

			if (is_bool($value) and $value === true) {
				$out .= " $attribute";
			} else {
				$out .= " $attribute=\"$value\"";
			}
		}

		return (empty($out)?'':' ').trim($out);
	}

	/**
	 * Set an HTML data-* attribute
	 *
	 * @param    string          Data attribute name minus "data-"
	 * @param    mixed           Value of the data attribute
	 * @return   chainable
	 */
	public function data($data, $value = null)
	{
		$this->option("data-{$data}", $value);
		return $this;
	}

	/**
	 * Magic setter
	 *
	 * Allows you to set object attributes as methods.
	 * 
	 * @param    string          Option/attribute name
	 * @param    mixed           Option/attribute value
	 * @return   chainable
	 */
	public function __call($method, array $params)
	{
		$this->option($method, array_shift($params));
		return $this;
	}

	/**
	 * Magic getter
	 *
	 * Returns the value set for a given option/attribute
	 *
	 * @param    string          Option/attribute name
	 * @return   mixed           Option/attribute value
	 */
	public function __get($property)
	{
		return $this->option($property);

	}

	/**
	 * Magic setter
	 *
	 * Sets the value for a given option/attribute
	 *
	 * @param    string          Option/attribute name
	 * @param    string          Option/attribute value
	 * @return   void
	 */
	public function __set($property, $value)
	{
		$this->option($property, $value);
	}

	/**
	 * Magic exists
	 *
	 * Checks if a value has been set for a given option/attribute
	 *
	 * @param    string          Option/attribute name
	 * @return   boolean
	 */
	public function __isset($property)
	{
		return array_key_exists($property, $this->options);
	}
}

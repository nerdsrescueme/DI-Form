<?php

namespace Nerd\Form;

/**
 * Abstract Container Class
 *
 * Used to create HTML form container objects. These objects allow for fields to
 * exist within "containing" form elements, be searched and rendered recursively
 * on-demand.
 */
abstract class Container extends Field
{
    public $fields;
    protected $element;

    public function __construct()
    {
        $args = func_get_args();

        if (isset($args[0]) and is_string($args[0])) {
            $this->element(array_shift($args));
        }

        $this->fields = new Design\Collection($args);
    }

    public function element($element)
    {
        $this->element = $element;
    }

    public function addField(Field $field, array $options = [])
    {
        $this->fields->add($field);

        return $field;
    }
}

<?php

namespace Nerd\Form\Field;

/**
 * Abstract input field
 *
 * Provides basic functionality for form input elements.
 */
abstract class Input extends \Nerd\Form\Field
{
    /**
     * Class Constructor overload
     *
     * Perform basic instantiation, but automatically assign the type attribute to
     * the name of the extended form class.
     *
     * @param array $options Field options/attributes
     * @return Input
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $class = explode('\\', get_called_class());
        $class = strtolower(end($class));

        $this->option('type', $class);
    }

    public function render()
    {
        if ($this->removed) {
            return '';
        }

        $start = $end = $fieldStart = $fieldEnd = '';

        if ($this->hasWrap()) {
            list($start, $end) = $this->wrap;
        }

        if ($this->hasFieldWrap()) {
            list($fieldStart, $fieldEnd) = $this->fieldWrap;
        }

        return $start
             . (isset($this->label) ? $this->label : '')
             . $fieldStart
             . "<input{$this->attributes(true)}>"
             . $fieldEnd
             . $end;
    }
}

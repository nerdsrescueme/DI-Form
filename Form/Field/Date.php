<?php

namespace Nerd\Form\Field;

/**
 * Date input field
 *
 * Form date fields automatically convert dates to the format required by the
 * HTML5 date field specification.
 */
class Date extends Input
{
    /**
     * Overload option method
     *
     * Extends the value property allowing for automatic conversion of date
     * formats to yyyy-mm-dd
     *
     * @param string $option Option/Attribute to set
     * @param string $value Value to set to this option
     */
    public function option($option, $value = null)
    {
        if ($option == 'value' and $value !== null) {
            // TODO: Accomodate DateTime objects
            $this->options['value'] = date('Y-m-d', strtotime($value));
            return $this;
        }

        return parent::option($option, $value);
    }
}

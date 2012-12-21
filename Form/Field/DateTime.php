<?php

namespace Nerd\Form\Field;

/**
 * DateTime input field
 *
 * Datetime fields automatically convert dates into the format required by the
 * HTML5 Datetime field specification.
 */
class DateTime extends Input
{
    /**
     * Overload option method
     *
     * Extends the value property allowing for automatic conversion of date
     * formats to yyyy-mm-ddThh:mm:ss+00:00
     *
     * @param string $option Option/Attribute to set
     * @param string $value Value to set to this option
     */
    public function option($option, $value = null)
    {
        if ($option == 'value' and $value !== null) {
            // TODO: Accomodate DateTime objects
            $this->options['value'] = date('c', strtotime($value));
            return $this;
        }

        return parent::option($option, $value);
    }
}

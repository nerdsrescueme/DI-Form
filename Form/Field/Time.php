<?php

namespace Nerd\Form\Field;

/**
 * Form Time Field Class
 *
 * Form time fields automatically convert dates into the format required by the
 * HTML Time field specification: hh:mm:ss
 */
class Time extends Input
{
    /**
     * Overload
     *
     * Extends the value property allowing for automatic conversion of time
     *
     * @param string $option Option/Attribute to set
     * @param string $value Value to set to this option
     */
    public function option($option, $value = null)
    {
        if ($option == 'value' and $value !== null) {
            // TODO: Accomodate DateTime objects
            $this->options['value'] = date('h:i:s', strtotime($value));
            return $this;
        }

        return parent::option($option, $value);
    }
}

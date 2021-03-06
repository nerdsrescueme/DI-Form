<?php

namespace Nerd\Form\Field;

/**
 * Form Select Field Class
 *
 * Unlike most other form elements, the select object inherits directly from the
 * abstract Field class. This element has many special characteristics that make it
 * difficult to wrap up with other form elements, so it's treated differently.
 */
class Select extends \Nerd\Form\Field
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if ($this->removed) {
            return '';
        }

        $start = $end = $startField = $endField = '';

        if ($this->hasWrap()) {
            list($start, $end) = $this->wrap;
        }

        if ($this->hasFieldWrap()) {
            list($startField, $endField) = $this->fieldWrap;
        }

        $options  = (array) $this->option('options');
        $optstr   = '';
        $selected = $this->option('selected');

        // Convert selected values to string
        if (is_array($selected)) {
            $selected = array_map('strval', $selected);
        } else {
            $selected = (string) $selected;
        }

        // Need to kill options temporarily...
        unset($this->options['selected']);

        foreach ($options as $opt => $label) {
            // Support for optgroups.
            if (is_array($label)) {
                $optstr .= "<optgroup label=\"$opt\">";

                foreach ($label as $opt2 => $label2) {
                    $label2 = trim($label2, "'");

                    if (is_array($selected)) {
                        if (in_array(strval($opt2), $selected)) {
                            $optstr .= "<option value=\"$opt2\" selected>$label2</option>";
                        } else {
                            $optstr .= "<option value=\"$opt2\">$label2</option>";
                        }
                    } else {
                        if (strval($opt2) === $selected) {
                            $optstr .= "<option value=\"$opt2\" selected>$label2</option>";
                        } else {
                            $optstr .= "<option value=\"$opt2\">$label2</option>";
                        }
                    }
                }

                $optstr .= '</optgroup>';
                continue;
            }

            $label = trim($label, "'");

            if (is_array($selected)) {
                if (in_array($opt, $selected)) {
                    $optstr .= "<option value=\"$opt\" selected>$label</option>";
                } else {
                    $optstr .= "<option value=\"$opt\">$label</option>";
                }
            } else {
                if (strval($opt) === $selected) {
                    $optstr .= "<option value=\"$opt\" selected>$label</option>";
                } else {
                    $optstr .= "<option value=\"$opt\">$label</option>";
                }
            }
        }

        $return = $start
             . (isset($this->label) ? $this->label : '')
             . $startField
             . "<select{$this->attributes(true)}>{$optstr}</select>"
             . $endField
             . $end;

        // Put selected values back...
        $this->options['selected'] = $selected;

        return $return;
    }
}

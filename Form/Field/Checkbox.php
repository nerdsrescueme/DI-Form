<?php

namespace Nerd\Form\Field;

/**
 * Checkbox input field
 *
 * Checkboxes are rendered differently than other input elements. The checkbox
 * is rendered *inside* of the label element to support clickable labels.
 */
class Checkbox extends Input
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

        $checkbox = "<input{$this->attributes(true)}>";

        return $start.$startField
             . (isset($this->label) ? "{$checkbox} {$this->label->text}" : $checkbox)
             . $endField.$end;
    }
}

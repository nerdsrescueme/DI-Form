<?php

namespace Nerd\Form\Field;

/**
 * Radio input field(s)
 *
 * Radios are rendered differently than other input elements. The radio
 * is rendered *inside* of the label element to support clickable labels.
 */
class Radio extends Input
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

        $radio = "<input {$this->attributes(true)}>";

        if (isset($this->label)) {
            $this->label->text = "{$radio}{$this->label->text}";
        }

        return $start.$startField
             . (isset($this->label) ? $this->label : $radio)
             . $endField.$end;
    }
}

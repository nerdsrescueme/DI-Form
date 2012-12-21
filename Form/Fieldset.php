<?php

namespace Nerd\Form;

/**
 * Fieldset container
 *
 * Creates a recursable fieldset container object.
 */
class Fieldset extends Container
{
    public $element = 'fieldset';
    public $legend;

    public function legend($legend, array $options = [])
    {
        $this->legend = new Legend($legend, $options, $this);

        return $this;
    }

    public function render()
    {
        if ($this->removed) {
            return '';
        }

        $out = "<{$this->element}{$this->attributes(true)}>";

        if (isset($this->legend) and $this->legend !== null) {
            $out .= (string) $this->legend->render();
        }

        $this->fields->each(function($field) use (&$out) {
            $out .= (string) $field->render();
        });

        return $out . "</{$this->element}>";
    }
}

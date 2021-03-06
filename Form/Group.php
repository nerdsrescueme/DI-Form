<?php

namespace Nerd\Form;

/**
 * HTML Group Class
 *
 * Creates a recursable group container object. this object is meant to bundle
 * several field objects into one container. This is useful for checkbox and radio
 * groups.
 *
 * This will automatically strip wrappers from the object, as to not create an
 * overly complex html object that needs a ton of rendering magic.
 */
class Group extends Container
{
    public $element = 'div';

    public function addField(Field $field, array $options = [])
    {
        $field->wrap(false)->wrapField(false);
        $this->fields->add($field);

        return $field;
    }

    public function render()
    {
        if ($this->removed) {
            return '';
        }

        $start = $end = null;

        if ($this->hasWrap()) {
            list($start, $end) = $this->wrap;
        }

        $out  = $start;
        $out .= ($this->label ?: '');
        $out .= "<{$this->element}{$this->attributes(true)}>";

        $this->fields->each(function($field) use (&$out) {
            $out .= (string) $field->render();
        });

        $out .= "</{$this->element}>";
        $out .= $end;

        return $out;
    }
}

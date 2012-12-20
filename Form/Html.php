<?php

namespace Nerd\Form;

/**
 * HTML Container Class
 *
 * Creates a recursable HTML container object.
 *
 * @package    Nerd
 * @subpackage Form
 */
class Html extends Container
{
    protected $element;

    public function __construct()
    {
        $fields        = func_get_args();
        $this->element = array_shift($fields);
        $this->fields  = new Design\Collection($fields);
    }

    public function render()
    {
        $out  = ($this->label ?: '');
        $out .= "<{$this->element}{$this->attributes(true)}>";

        $this->fields->each(function($field) use (&$out) {
            $out .= (string) $field->render().' '; // space is important for visuals?
        });

        return $out . "</{$this->element}>";
    }
}

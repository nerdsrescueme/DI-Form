<?php

namespace Nerd\Form;

/**
 * Label Class
 *
 * Creates a label element for a field
 */
class Label
{
    // Traits
    use Design\Attributable
      , Design\Renderable;

    public $text;
    public $field;
    public $removed = false;

    public function __construct($text, array $options = [], Field $field = null)
    {
        foreach ($options as $key => $value) {
            $this->option($key, $value);
        }

        $this->field = $field;
        $this->text  = trim($text);

        if ($field !== null and $id = $this->field->option('id')) {
            $this->option('for', $id);
        }
    }

    public function text($text = null)
    {
        if ($text === null) {
            return $this->text;
        }

        $this->text = $text;
        return $this;
    }

    public function remove()
    {
        $this->removed = true;

        return $this;
    }

    public function render()
    {
        if ($this->removed) {
            return '';
        }

        return "<label{$this->attributes(true)}>{$this->text}</label>";
    }
}

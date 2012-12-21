<?php

namespace Nerd\Form;

/**
 * Legend Class
 *
 * Creates a legend fieldset form element
 *
 * @package    Nerd
 * @subpackage  Form
 */
class Legend
{
    // Traits
    use Design\Attributable
      , Design\Renderable;

    public $text;
    public $fieldset;
    public $removed = false;

    public function __construct($text, array $options = [], Fieldset $fieldset = null)
    {
        foreach ($options as $key => $value) {
            $this->option($key, $value);
        }

        $this->fieldset = $fieldset;
        $this->text  = trim($text);
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

        return "<legend{$this->attributes(true)}>{$this->text}</legend>";
    }
}

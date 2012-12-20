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
    private $field;

    public function __construct($text, array $options = [], Fieldset $field = null)
    {
        foreach ($options as $key => $value) {
            $this->option($key, $value);
        }

        $this->field = $field;
        $this->text  = trim($text);
    }

    public function render()
    {
        return "<legend{$this->attributes(true)}>{$this->text}</legend>";
    }
}

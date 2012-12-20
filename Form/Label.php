<?php

namespace Nerd\Form;

/**
 * Label Class
 *
 * Creates a label form element for a field
 *
 * @package    Nerd
 * @subpackage Form
 */
class Label
{
    // Traits
    use Design\Attributable;

    private static $localAttributes = ['form'];

    public $text;
    private $field;

    public function __construct($text, array $options = [], Field $field = null)
    {
        foreach ($options as $key => $value) {
            $this->option($key, $value);
        }

        $this->field = $field;
        $this->text  = trim($text);
    }

    public function render()
    {
        if (isset($this->field) and $id = $this->field->option('id')) {
            $this->option('for', $id);
        }

        return "<label{$this->attributes(true)}>{$this->text}</label>";
    }
}

<?php

namespace Nerd\Form;

/**
 * Abstract Field Class
 *
 * Base class for form fields. This provides common functionality for all form
 * elements. Form field types *must* extend this class in order to be rendered by
 * the various rendering classes.
 */
abstract class Field
{
    // Traits
    use Design\Attributable
      , Design\Wrappable
      , Design\Renderable;

    public $label;
    public $removed = false;

    public function __construct(array $options = [])
    {
        foreach ($options as $key => $value) {
            $this->option($key, $value);
        }
    }

    public function label($text = null, array $options = [])
    {
        if ($text === null) {
            return $this->label;
        }

        $this->label = new Label($text, $options, $this);

        return $this;
    }

    public function remove()
    {
        $this->removed = true;

        return $this;
    }

    abstract public function render();
}

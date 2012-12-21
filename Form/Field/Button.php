<?php

namespace Nerd\Form\Field;

/**
 * Button field
 *
 * Form buttons are treated like input elements with a text property used to
 * render the button text instead of using the value attribute.
 */
class Button extends Input
{
    /**
     * @var string
     */
    public $text;

    /**
     * Add text to this button
     *
     * @param string $text
     * @return Button
     */
    public function text($text)
    {
        $this->text = trim($text);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        if ($this->removed) {
            return '';
        }

        $start = $end = $fieldStart = $fieldEnd = '';

        if ($this->hasWrap()) {
            list($start, $end) = $this->wrap;
        }

        if ($this->hasFieldWrap()) {
            list($fieldStart, $fieldEnd) = $this->fieldWrap;
        }

        return "$start$fieldStart<button{$this->attributes(true)}>{$this->text}</button>$fieldEnd$end";
    }
}

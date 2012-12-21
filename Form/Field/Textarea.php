<?php

namespace Nerd\Form\Field;

/**
 * Texearea input field
 */
class Textarea extends Input
{
    /**
     * @var string
     */
    public $text;

    /**
     * Add text
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

        return $start
             . (isset($this->label) ? $this->label : '')
             . $fieldStart
             . "<textarea{$this->attributes(true)}>{$this->text}</textarea>"
             . $fieldEnd
             . $end;
    }
}

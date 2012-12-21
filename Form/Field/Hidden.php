<?php

namespace Nerd\Form\Field;

/**
 * Hidden input field
 */
class Hidden extends Input
{
	/**
	 * Hidden fields may not have wrappers
	 *
	 * @return boolean Always false
	 */
    public function hasWrap()
    {
        return false;
    }

    /**
	 * Hidden fields may not have wrappers
	 *
	 * @return boolean Always false
	 */
    public function hasFieldWrap()
    {
        return false;
    }
}

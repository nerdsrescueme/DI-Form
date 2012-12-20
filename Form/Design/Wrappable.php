<?php

namespace Nerd\Form\Design;

trait Wrappable
{
	protected $wrap;
	protected $fieldWrap;

	public function wrap($false)
	{
		if ($false === false) {
			$this->wrap = null;
		} else {
			$this->wrap = func_get_args();
		}

		return $this;
	}

	public function wrapFields($false)
	{
		if ($false === false) {
			$this->fieldWrap = null;
		} else {
			$this->fieldWrap = func_get_args();
		}

		return $this;
	}

	public function hasWrap()
	{
		return is_array($this->wrap);
	}

	public function hasFieldWrap()
	{
		return is_array($this->fieldWrap);
	}
}
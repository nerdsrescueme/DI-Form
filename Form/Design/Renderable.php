<?php

namespace Nerd\Form\Design;

/**
 * Renderable trait
 *
 * This trait identifies a class as renderable, allowing for easy determination and
 * solid understanding of the existance of the render() method. Additionally, any
 * object that includes the Renderable trait will automatically have an object to
 * string magic method attached.
 *
 * @package    Nerd
 * @subpackage Core
 */
trait Renderable
{
	/**
	 * Evaluate and render the contents of this instance
	 *
	 * @return   string          The evaluated and rendered contents
	 */
	abstract public function render();

	/**
	 * Define a common object to string call
	 *
	 * @return   string          The evaluated and rendered contents
	 */
	public function  __toString()
	{
		return (string) $this->render();
	}
}
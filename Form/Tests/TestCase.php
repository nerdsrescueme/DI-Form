<?php

namespace Nerd\Form\Tests;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Hold an reflection of the class of which we are testing
     *
     * @var \ReflectionClass
     */
    protected $ref;

    /**
     * Default fixture property
     *
     * @var mixed
     */
    protected $fixture;

    /**
     * Hold an instance of the class of which we are testing
     *
     * @var object
     */
    protected $ins;


    protected function setUpReflection($class)
    {
        $this->ref = new \ReflectionClass($class);
    }

    protected function setUpInstance($instance)
    {
        $this->ins = $instance;
    }

    // Test for type

    public function assertArray($item, $message = null)
    {
        $this->assertTrue(\is_array($item), $message);
    }

    public function assertString($item, $message = null)
    {
        $this->assertTrue(\is_string($item), $message);
    }

    public function assertBoolean($item, $message = null)
    {
        $this->assertTrue(\is_bool($item), $message);
    }

    public function assertObject($item, $message = null)
    {
        $this->assertTrue(\is_object($item), $message);
    }

    public function assertInteger($item, $message = null)
    {
        $this->assertTrue(\is_int($item), $message);
    }

    public function assertFloat($item, $message = null)
    {
        $this->assertTrue(\is_float($item), $message);
    }

    // Test not type

    public function assertNotArray($item, $message = null)
    {
        $this->assertFalse(\is_array($item), $message);
    }

    public function assertNotString($item, $message = null)
    {
        $this->assertFalse(\is_string($item), $message);
    }

    public function assertNotBoolean($item, $message = null)
    {
        $this->assertFalse(\is_bool($item), $message);
    }

    public function assertNotObject($item, $message = null)
    {
        $this->assertFalse(\is_object($item), $message);
    }

    public function assertNotInteger($item, $message = null)
    {
        $this->assertFalse(\is_int($item), $message);
    }

    public function assertNotFloat($item, $message = null)
    {
        $this->assertFalse(\is_float($item), $message);
    }
}
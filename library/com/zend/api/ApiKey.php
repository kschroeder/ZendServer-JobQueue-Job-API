<?php

namespace com\zend\api;

class ApiKey
{
	private $name;
	private $value;
	
	public function __construct($name, $value)
	{
		$this->name = $name;
		$this->value = $value;
	}
	/**
     * @return the $name
     */
    public function getName ()
    {
        return $this->name;
    }

	/**
     * @return the $value
     */
    public function getValue ()
    {
        return $this->value;
    }

	/**
     * @param field_type $name
     */
    public function setName ($name)
    {
        $this->name = $name;
    }

	/**
     * @param field_type $value
     */
    public function setValue ($value)
    {
        $this->value = $value;
    }

}
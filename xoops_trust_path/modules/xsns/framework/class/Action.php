<?php

class XsnsAction
{
	var $db;
	var $context;
	
	function __construct(&$context)
	{
		$this->db =& Database::getInstance();
		$this->context =& $context;
	}
	
	function dispatch()
	{
	}
}


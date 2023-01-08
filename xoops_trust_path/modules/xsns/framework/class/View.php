<?php

class XsnsView
{
    var $tpl;
    var $context;
    var $args;

    function __construct(&$context, $args)
    {
        global $xoopsTpl;
        $this->tpl =& $xoopsTpl;
        $this->context =& $context;
        $this->args = $args;
    }

    function dispatch()
    {
    }

}

<?php

if(!defined('XOOPS_TRUST_PATH')){
	die('set XOOPS_TRUST_PATH into mainfile.php');
}

$mydirpath = dirname(__FILE__, 2);
$mydirname = basename($mydirpath);

require $mydirpath.'/mytrustdirname.php';
require_once XOOPS_TRUST_PATH.'/modules/'.$mytrustdirname.'/'.basename(__FILE__);

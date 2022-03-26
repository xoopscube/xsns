<?php

define('XSNS_TRUST_PATH', dirname(__FILE__));

// Module path
define('XSNS_BASE_DIR', XOOPS_ROOT_PATH . '/modules/' . $mydirname);

// Module URL
define('XSNS_BASE_URL', XOOPS_URL . '/modules/' . $mydirname);

// Stylesheet URL
const XSNS_CSS_URL = XSNS_BASE_URL . '/css.php?f=';

// JavaScript URL
const XSNS_JS_URL = XSNS_BASE_URL . '/js.php?f=';

// Framework directory
const XSNS_FRAMEWORK_DIR = XSNS_TRUST_PATH . '/framework';
const XSNS_FRAMEWORK_CLASS_DIR = XSNS_FRAMEWORK_DIR . '/class';

// Path of user-defined class files
const XSNS_USERLIB_DIR = XSNS_TRUST_PATH . '/userlib';
const XSNS_USERLIB_CLASS_DIR = XSNS_USERLIB_DIR . '/class';

// Argument name for page switching
const XSNS_PAGE_ARG = 'p';

// Argument name for switching Action and View
const XSNS_ACTION_ARG = 'act';

// Action file directory
const XSNS_ACTION_DIR = XSNS_TRUST_PATH . '/act/';

// Default Action name
const XSNS_DEFAULT_ACTION = 'default';

// Default Action file
const XSNS_DEFAULT_ACTION_FILE = XSNS_ACTION_DIR . XSNS_DEFAULT_ACTION . 'Action.php';

// Directory with View files
const XSNS_VIEW_DIR = XSNS_TRUST_PATH . '/act/';

// Default View name
const XSNS_DEFAULT_VIEW = 'default';

// Default View file
const XSNS_DEFAULT_VIEW_FILE = XSNS_VIEW_DIR . XSNS_DEFAULT_VIEW . 'View.php';

const XSNS_REQUEST_POST = 1;
const XSNS_REQUEST_GET = 2;
const XSNS_REQUEST_SESSION = 3;

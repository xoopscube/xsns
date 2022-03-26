<?php

$constpref = '_MB_'.strtoupper($mydirname) ;

if(!defined($constpref.'_LOADED')){

define($constpref.'_LOADED', 1);

define($constpref.'_YEAR', '/');
define($constpref.'_MONTH', '/');
define($constpref.'_DAY', '');

define($constpref.'_INDEX_INFO_MSG_0', 'Review %d request(s) to join a group. ');
define($constpref.'_INDEX_INFO_MSG_1', 'Review %d request(s) to change a group manager. ');
define($constpref.'_INDEX_INFO_MSG_2', 'Review %d request(s) to manage a group. ');
define($constpref.'_INDEX_INFO_MSG_3', 'Review %d pending friend request.');
define($constpref.'_INDEX_INFO_MSG_4', '%d friend request was canceled.');

}

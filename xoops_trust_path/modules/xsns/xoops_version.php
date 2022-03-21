<?php

if (file_exists(dirname(__FILE__) . '/language/' . @$xoopsConfig['language'] . '/modinfo.php')) {
    require dirname(__FILE__) . '/language/' . @$xoopsConfig['language'] . '/modinfo.php';
}

$constpref = '_MI_' . strtoupper($mydirname);

$modversion['name'] = $mydirname;
$modversion['version'] = 2.30;
$modversion['detailed_version'] = '2.30.0';
$modversion['description'] = constant($constpref . '_MODULE_DESC');
$modversion['credits'] = 'BraTech (https://www.bratech.co.jp/), XOOPS X(ten) Distibution ( https://github.com/XoopsX ), @gigamaster (XCL7)';
$modversion['author'] = 'A. Aikawa, XOOPS X developers';
$modversion['help'] = '';
$modversion['license'] = 'GPL';
$modversion['official'] = 0;
$modversion['image'] = file_exists($mydirpath . '/module_icon.png') ? 'module_icon.png' : 'module_icon.php';
$modversion['dirname'] = $mydirname;
$modversion['trust_dirname'] = $mytrustdirname;

// Database things
$modversion['sqlfile'] = false;
$modversion['tables'] = [];

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = $mydirname . '_global_search';

// Menu
$modversion['hasMain'] = 1;

// Submenu
if (isset($_SESSION['xoopsUserId'])) {
    $modversion['sub'][1]['name'] = constant($constpref . '_MENU_MYPAGE');
    $modversion['sub'][1]['url'] = '?p=mypage';
}

// Templates
$modversion['templates'] = [];

// Blocks
$modversion['blocks'][1] = [
    'file' => 'blocks.php',
    'name' => constant($constpref . '_BLOCK_RECENT_TOPIC'),
    'description' => '',
    'show_func' => 'b_xsns_recent_topic_show',
    'edit_func' => 'b_xsns_recent_topic_edit',
    'options' => $mydirname . '|5|',
    'template' => '',
    'can_clone' => true,
];

$modversion['blocks'][] = [
    'file' => 'blocks.php',
    'name' => constant($constpref . '_BLOCK_INFORMATION'),
    'description' => '',
    'show_func' => 'b_xsns_information_show',
    'edit_func' => 'b_xsns_information_edit',
    'options' => $mydirname,
    'template' => '',
    'can_clone' => true,
];

// Comments
$modversion['hasComments'] = 0;

// Configs
$modversion['config'][1] = [
    'name' => 'file_upload_path',
    'title' => $constpref . '_FPATH',
    'description' => $constpref . '_FPATHDSC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => XOOPS_TRUST_PATH . '/uploads/' . $mydirname,
];
$modversion['config'][] = [
    'name' => 'file_upload_size',
    'title' => $constpref . '_FSIZE',
    'description' => $constpref . '_FSIZEDSC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => '10000000',
];
$modversion['config'][] = [
    'name' => 'image_width',
    'title' => $constpref . '_IMGW',
    'description' => $constpref . '_IMGWDSC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => '2000',
];
$modversion['config'][] = [
    'name' => 'image_height',
    'title' => $constpref . '_IMGH',
    'description' => $constpref . '_IMGHDSC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => '2000',
];
$modversion['config'][] = [
    'name' => 'file_upload_mime',
    'title' => $constpref . '_FMIME',
    'description' => $constpref . '_FMIMEDSC',
    'formtype' => 'textarea',
    'valuetype' => 'text',
    'default' => 'text/plain|application/msword|application/vnd.ms-excel|application/vnd.ms-powerpoint|application/pdf',
];
$modversion['config'][] = [
    'name' => 'image_form_limit',
    'title' => $constpref . '_ILIMIT',
    'description' => $constpref . '_ILIMITDSC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => '3',
];
$modversion['config'][] = [
    'name' => 'file_form_limit',
    'title' => $constpref . '_FLIMIT',
    'description' => $constpref . '_FLIMITDSC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => '3',
];

$modversion['config'][] = [
    'name' => 'mypage_use',
    'title' => $constpref . '_MYPAGE',
    'description' => $constpref . '_MYPAGEDSC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 0,
];

$modversion['config'][] = [
    'name' => 'show_mypage_for_guest',
    'title' => $constpref . '_MYPAGEG',
    'description' => $constpref . '_MYPAGEGDSC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1,
];

$modversion['config'][] = [
    'name' => 'use_footprint',
    'title' => $constpref . '_FOOT',
    'description' => $constpref . '_FOOTDSC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1,
];
$modversion['config'][] = [
    'name' => 'blog_module_name',
    'title' => $constpref . '_BLOG',
    'description' => $constpref . '_BLOGDSC',
    'formtype' => 'select',
    'valuetype' => 'int',
    'default' => 0,
    'options' => [
        constant($constpref . '_BLOG0') => 0,
        constant($constpref . '_BLOG1') => 1,
        constant($constpref . '_BLOG2') => 2,
        constant($constpref . '_BLOG3') => 3,
        constant($constpref . '_BLOG4') => 4,
        constant($constpref . '_BLOG5') => 5
    ]
];
$modversion['config'][] = [
    'name' => 'blog_module_dir',
    'title' => $constpref . '_BLOGDIR',
    'description' => $constpref . '_BLOGDIRDSC',
    'formtype' => 'text',
    'valuetype' => 'text',
    'default' => '',
];
$modversion['config'][] = [
    'name' => 'pop_level_max',
    'title' => $constpref . '_POPMAX',
    'description' => $constpref . '_POPMAXDSC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => '100',
];
$modversion['config'][] = [
    'name' => 'freq_level_max',
    'title' => $constpref . '_FREQMAX',
    'description' => $constpref . '_FREQMAXDSC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => '100',
];
$modversion['config'][] = [
    'name' => 'show_breadcrumbs',
    'title' => $constpref . '_XBC',
    'description' => $constpref . '_XBCDSC',
    'formtype' => 'yesno',
    'valuetype' => 'int',
    'default' => 1,
];

// Notification
$modversion['hasNotification'] = 1;
$modversion['notification'] = [
    'lookup_file' => 'notification.inc.php',
    'lookup_func' => $mydirname . '_notify_iteminfo',

    'category' => [
        [
            'name' => 'topic',
            'title' => constant($constpref . '_COMMU_NOTIFY'),
            'description' => constant($constpref . '_COMMU_NOTIFY_DSC'),
            'subscribe_from' => 'index.php',
            'item_name' => 'cid'
        ],
    ],

    'event' => [
        [
            'name' => 'create',
            'category' => 'topic',
            'title' => constant($constpref . '_TOPIC_CREATE_NOTIFY'),
            'caption' => constant($constpref . '_TOPIC_CREATE_NOTIFY_CAP'),
            'description' => constant($constpref . '_TOPIC_CREATE_NOTIFY_DSC'),
            'mail_template' => 'topic_create_notify',
            'mail_subject' => constant($constpref . '_TOPIC_CREATE_NOTIFY_SBJ'),
        ],
        [
            'name' => 'post',
            'category' => 'topic',
            'title' => constant($constpref . '_TOPIC_POST_NOTIFY'),
            'caption' => constant($constpref . '_TOPIC_POST_NOTIFY_CAP'),
            'description' => constant($constpref . '_TOPIC_POST_NOTIFY_DSC'),
            'mail_template' => 'topic_post_notify',
            'mail_subject' => constant($constpref . '_TOPIC_POST_NOTIFY_SBJ'),
        ],
    ],
];

// onInstall, onUpdate, onUninstall
$modversion['onInstall'] = 'admin/oninstall.php';
$modversion['onUpdate'] = 'admin/onupdate.php';
$modversion['onUninstall'] = 'admin/onuninstall.php';

// keep block's options
if (!defined('XOOPS_CUBE_LEGACY') && substr(XOOPS_VERSION, 6, 3) < 2.1 && !empty($_POST['fct']) && !empty($_POST['op']) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname']) {
    include dirname(__FILE__) . '/include/x20_keepblockoptions.inc.php';
}

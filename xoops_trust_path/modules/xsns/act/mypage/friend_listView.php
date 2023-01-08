<?php

class Xsns_Friend_list_View extends Xsns_Mypage_View
{

    function dispatch()
    {
        require XSNS_FRAMEWORK_DIR . '/global.php';
        require_once XOOPS_ROOT_PATH . '/header.php';

        $xoopsOption['template_main'] = $mydirname . '_mypage_friend_list.html';

        $this->assignCommonVars();
        $this->assignStyleSheet('mypage.css');

        $this->context->assignAttributes();

        require_once XOOPS_ROOT_PATH . '/footer.php';
    }

}

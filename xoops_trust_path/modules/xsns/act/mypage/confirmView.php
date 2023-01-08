<?php

class Xsns_Confirm_View extends Xsns_Mypage_View
{

    function dispatch()
    {
        require XSNS_FRAMEWORK_DIR . '/global.php';
        require_once XOOPS_ROOT_PATH . '/header.php';

        $xoopsOption['template_main'] = $mydirname . '_mypage_confirm.html';

        $this->assignCommonVars();
        $this->assignStyleSheet('confirm.css');

        $this->context->assignAttributes();

        require_once XOOPS_ROOT_PATH . '/footer.php';
    }

}

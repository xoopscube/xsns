<?php
// $Id: edituser.php,v 1.5 2006/05/01 02:37:26 onokazu Exp $
// TODO XCL7 profile

class Xsns_Profile_edit_exec_Action extends Xsns_Mypage_Action
{

    function dispatch()
    {
        require XSNS_FRAMEWORK_DIR . '/global.php';
        require_once XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/user.php';
        $ts =& XsnsTextSanitizer::sGetInstance();

        if ($this->isGuest() || !$this->validateToken('edituser')) {
            redirect_header(XSNS_URL_MYPAGE, 3, _US_NOEDITRIGHT);
        }
        $config_handler =& xoops_gethandler('config');
        if (defined('XOOPS_CUBE_LEGACY')) {
            $xoopsConfigUser =& $config_handler->getConfigsByDirname('user');
            $user_config =& $xoopsConfigUser;
        } else {
            $xoopsConfigUser =& $config_handler->getConfigsByCat(XOOPS_CONF_USER);
            $user_config =& $xoopsConfig;
        }
        if (!is_array($xoopsConfigUser)) {
            redirect_header(XSNS_URL_MYPAGE, 3, _US_NOEDITRIGHT);
        }

        $uid = 0;
        if (!empty($_POST['uid'])) {
            $uid = intval($_POST['uid']);
        }
        if (empty($uid) || $xoopsUser->getVar('uid') != $uid) {
            redirect_header(XSNS_URL_MYPAGE, 3, _US_NOEDITRIGHT);
        }
        $errors = array();
        if ($xoopsConfigUser['allow_chgmail'] == 1) {
            $email = '';
            if (!empty($_POST['email'])) {
                $email = $ts->stripSlashesGPC(trim($_POST['email']));
            }
            if ($email == '' || !checkEmail($email)) {
                $errors[] = _US_INVALIDMAIL;
            }
        }
        $password = '';
        if (!empty($_POST['password'])) {
            $password = $ts->stripSlashesGPC(trim($_POST['password']));
        }
        if ($password != '') {
            if (strlen($password) < $xoopsConfigUser['minpass']) {
                $errors[] = sprintf(_US_PWDTOOSHORT, $xoopsConfigUser['minpass']);
            }
            $vpass = '';
            if (!empty($_POST['vpass'])) {
                $vpass = $ts->stripSlashesGPC(trim($_POST['vpass']));
            }
            if ($password != $vpass) {
                $errors[] = _US_PASSNOTSAME;
            }
        }
        if (count($errors) > 0) {
            redirect_header(XSNS_URL_MYPAGE, 3, _US_NOEDITRIGHT);
        } else {
            $member_handler =& xoops_gethandler('member');
            $edituser =& $member_handler->getUser($uid);
            if (!is_object($edituser)) {
                redirect_header(XSNS_URL_MYPAGE, 3, _US_NOEDITRIGHT);
            }

            $vars = array(
                'name' => $_POST['name'] ?? '',
                'url' => isset($_POST['url']) ? formatURL($_POST['url']) : '',
                'user_icq' => $_POST['user_icq'] ?? '',
                'user_from' => $_POST['user_from'] ?? '',
                'user_viewemail' => !empty($_POST['user_viewemail']) ? 1 : 0,
                'user_aim' => $_POST['user_aim'] ?? '',
                'user_yim' => $_POST['user_yim'] ?? '',
                'user_msnm' => $_POST['user_msnm'] ?? '',
                'attachsig' => !empty($_POST['attachsig']) ? 1 : 0,
                'timezone_offset' => $_POST['timezone_offset'] ?? 0.0,
                'user_occ' => $_POST['user_occ'] ?? '',
                'user_intrest' => $_POST['user_intrest'] ?? '',
                'user_sig' => isset($_POST['user_sig']) ? xoops_substr($_POST['user_sig'], 0, 255) : '',
                'uorder' => $_POST['uorder'] ?? 0,
                'umode' => $_POST['umode'] ?? 0,
                'notify_method' => $_POST['notify_method'] ?? 1,
                'notify_mode' => $_POST['notify_mode'] ?? 0,
                'bio' => isset($_POST['bio']) ? xoops_substr($_POST['bio'], 0, 255) : '',
                'user_mailok' => !empty($_POST['user_mailok']) ? 1 : 0,
            );

            if ($xoopsConfigUser['allow_chgmail'] == 1) {
                $vars['email'] = $email;
            }
            if (!empty($password)) {
                $vars['pass'] = md5($password);
            }

            $edituser->setVars($vars);

            if (!empty($user_config['usercookie'])) {
                if (!empty($_POST['usercookie'])) {
                    setcookie($user_config['usercookie'], $xoopsUser->getVar('uname'), time() + 31536000);
                } else {
                    setcookie($user_config['usercookie']);
                }
            }

            if (!$member_handler->insertUser($edituser)) {
                redirect_header(XSNS_URL_MYPAGE, 3, _US_NOEDITRIGHT);
            } else {
                redirect_header(XSNS_URL_MYPAGE, 2, _US_PROFUPDATED);
            }
        }
    }

}

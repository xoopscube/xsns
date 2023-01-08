<?php
// Based on edituser.php,v 1.5 2006/05/01 02:37:26 onokazu Exp $
// TODO XCL7 profile

class Xsns_Profile_avatar_sel_exec_Action extends Xsns_Mypage_Action
{

    function dispatch()
    {
        if ($this->isGuest()) {
            redirect_header(XOOPS_URL, 2, _NOPERM);
        }

        require XSNS_FRAMEWORK_DIR . '/global.php';
        require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        require_once XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/user.php';

        //if (!$this->validateToken('choose') || !is_object($xoopsUser) || !isset($_POST['avatar_id']) || !is_array($_POST['avatar_id']) || count($_POST['avatar_id'])>1) {
        if (!$this->validateToken('choose') || !is_object($xoopsUser) || !isset($_POST['avatar_id']) || count($_POST['avatar_id']) > 1) { //naao
            redirect_header(XSNS_URL_MYPAGE_PROFILE, 3, _US_NOEDITRIGHT);
        }

        // Check is K-TAI?
        if (defined('HYP_K_TAI_RENDER') && HYP_K_TAI_RENDER) {
            $avatar_id = $_POST['avatar_id'];
        } else {
            global $xoopsTpl;
            if ($xoopsTpl->_tpl_vars['wizmobile_ismobile']) {
                $avatar_id = $_POST['avatar_id'];
            } else {
                foreach ($_POST['avatar_id'] as $id => $value) {
                    $avatar_id = $id;
                    break;
                }
            }
        }

        $avt_handler =& xoops_gethandler('avatar');
        if ($avatar_id > 0) {
            $criteria = new CriteriaCompo(new Criteria('a.avatar_id', $avatar_id));
            $criteria->add(new Criteria('a.avatar_type', 'S'));
            $avatars =& $avt_handler->getObjects($criteria);
            if (!is_array($avatars) || !is_object($avatars[0])) {
                redirect_header(XSNS_URL_MYPAGE_PROFILE, 3, _US_NOEDITRIGHT);
            }
            $user_avatar_object =& $avatars[0];
            $user_avatar = $avatars[0]->getVar('avatar_file');
        } else {
            $user_avatar_object = false;
            $user_avatar = XOOPS_UPLOAD_PATH . '/no_avatar.gif'; // @gigamaster default avatar
        }
        $user_avatarpath = str_replace("\\", "/", realpath(XOOPS_UPLOAD_PATH . '/' . $user_avatar));

        if (0 === strpos($user_avatarpath, XOOPS_UPLOAD_PATH) && is_file($user_avatarpath)) {
            $oldavatar = $xoopsUser->getVar('user_avatar');
            $xoopsUser->setVar('user_avatar', $user_avatar);
            $member_handler =& xoops_gethandler('member');
            if (!$member_handler->insertUser($xoopsUser)) {
                require_once XOOPS_ROOT_PATH . '/header.php';
                echo $xoopsUser->getHtmlErrors();
                require_once XOOPS_ROOT_PATH . '/footer.php';
            }
            if ($oldavatar && $oldavatar != 'blank.gif' && preg_match("/^cavt/", strtolower($oldavatar))) {
                (method_exists('MyTextSanitizer', 'sGetInstance') and $ts =& MyTextSanitizer::sGetInstance()) || $ts =& MyTextSanitizer::getInstance();
                $criteria = new CriteriaCompo(new Criteria('avatar_file', $ts->addSlashes($oldavatar)));
                $criteria->add(new Criteria('avatar_type', 'C'));
                $avatars =& $avt_handler->getObjects($criteria);
                if (is_object($avatars[0])) {
                    $avt_handler->delete($avatars[0]);
                }
                $oldavatar_path = str_replace("\\", "/", realpath(XOOPS_UPLOAD_PATH . '/' . $oldavatar));
                if (0 === strpos($oldavatar_path, XOOPS_UPLOAD_PATH) && is_file($oldavatar_path)) {
                    unlink($oldavatar_path);
                }
            }
            if (is_object($user_avatar_object)) {
                $avt_handler->addUser($user_avatar_object->getVar('avatar_id'), $xoopsUser->getVar('uid'));
            }
        }
        redirect_header(XSNS_URL_MYPAGE_PROFILE, 2, _US_PROFUPDATED);
    }

}

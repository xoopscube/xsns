<?php

class Xsns_Leave_exec_Action extends Xsns_Member_Action
{

    function dispatch()
    {
        global $xoopsUser, $xoopsUserIsAdmin;

        if ($this->isGuest() || !$this->validateToken('MEMBER_EDIT')) {
            redirect_header(XOOPS_URL, 2, _NOPERM);
        }
        $own_uid = $xoopsUser->getVar('uid');

        $cid = $this->getIntRequest('cid');
        $uid = $this->getIntRequest('uid');
        if (!$cid || !$uid || $uid == $own_uid) {
            redirect_header(XOOPS_URL, 2, _NOPERM);
        }

        // Get the community
        $perm = XSNS_AUTH_XOOPS_ADMIN | XSNS_AUTH_ADMIN;
        $commu_handler =& XsnsCommunityHandler::getInstance();
        $community =& $commu_handler->get($cid);
        if (!is_object($community) || !$community->checkAuthority($perm)) {
            redirect_header(XOOPS_URL, 2, _NOPERM);
        }

        // Get community members
        $c_member_handler =& XsnsMemberHandler::getInstance();
        $c_member =& $c_member_handler->getOne($cid, $uid);
        if (!is_object($c_member)) {
            redirect_header(XOOPS_URL, 2, _NOPERM);
        }
        $c_member_info =& $c_member->getInfo();

        // Forced withdrawal of community members
        if ($c_member_handler->delete($c_member)) {

            // Delete existing request
            $confirm_handler =& XsnsConfirmHandler::getInstance();
            $criteria = new CriteriaCompo(new Criteria('c_commu_id', $cid));
            $criteria->add(new Criteria('uid_from', $own_uid));
            $criteria->add(new Criteria('uid_to', $uid));
            $criteria->add(new Criteria('mode', '(1,2)', 'IN'));    // Change admin or set manager
            $confirm_handler->deleteObjects($criteria);

            // Special process site administrators
            if ($xoopsUserIsAdmin) {
                // If site admin, get the role of administrator
                if ($uid == $community->getVar('uid_admin')) {
                    $community->setVar('uid_admin', $own_uid);
                } // If role is sub-admin manager, no sub-admin
                elseif ($uid == $community->getVar('uid_sub_admin')) {
                    $community->setVar('uid_sub_admin', 0);
                }
                $commu_handler->insert($community);
            }

            redirect_header(XSNS_URL_COMMU . '?cid=' . $cid, 2, sprintf(_MD_XSNS_MEMBER_LEAVE_OK, $c_member_info['name']));
        }
        redirect_header(XSNS_URL_COMMU, 2, _MD_XSNS_MEMBER_LEAVE_NG);
    }

}

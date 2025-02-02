<?php

class Xsns_Sub_admin_exec_Action extends Xsns_Member_Action
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
        $message = $this->getTextRequest('message');

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

        if ($xoopsUserIsAdmin && $own_uid != $community->getVar('uid_admin')) {
            redirect_header(XOOPS_URL, 2, _NOPERM);
        }

        // Get community members
        $c_member_handler =& XsnsMemberHandler::getInstance();
        $c_member =& $c_member_handler->getOne($cid, $uid);
        if (!is_object($c_member)) {
            redirect_header(XOOPS_URL, 2, _NOPERM);
        }
        $c_member_info =& $c_member->getInfo();

        // Delete existing request (to prevent duplication)
        $confirm_handler =& XsnsConfirmHandler::getInstance();
        $criteria = new CriteriaCompo(new Criteria('c_commu_id', $cid));
        $criteria->add(new Criteria('uid_from', $own_uid));
        $criteria->add(new Criteria('uid_to', $uid));
        $criteria->add(new Criteria('mode', '(1,2)', 'IN'));    // Change admin or set manager
        $confirm_handler->deleteObjects($criteria);

        // Send new request
        $confirm =& $confirm_handler->create();
        $confirm->setVars(array(
            'c_commu_id' => $cid,
            'uid_from' => $own_uid,
            'uid_to' => $uid,
            'mode' => 2,    // add manager
            'r_datetime' => date('Y-m-d H:i:s'),
            'message' => $message,
        ));

        if ($confirm_handler->insert($confirm)) {
            redirect_header(XSNS_URL_COMMU . '?cid=' . $cid, 2,
                sprintf(_MD_XSNS_MEMBER_SUB_ADMIN_OK, $c_member_info['name']));
        }
        redirect_header(XSNS_URL_COMMU, 2, _MD_XSNS_MEMBER_SUB_ADMIN_NG);
    }

}

<?php

class Xsns_Edit_Action extends Xsns_Member_Action
{

    function dispatch()
    {
        global $xoopsUser, $xoopsUserIsAdmin;

        if ($this->isGuest()) {
            redirect_header(XOOPS_URL, 2, _NOPERM);
        }

        $limit = 10;
        $start = $this->getIntRequest('s', XSNS_REQUEST_GET);
        if (!isset($start) || $start < 0) {
            $start = 0;
        }

        $cid = $this->getIntRequest('cid', XSNS_REQUEST_GET);
        if (!$cid) {
            redirect_header(XOOPS_URL, 2, _NOPERM);
        }

        // Get the community
        $perm = XSNS_AUTH_XOOPS_ADMIN | XSNS_AUTH_ADMIN;
        $commu_handler =& XsnsCommunityHandler::getInstance();
        $community =& $commu_handler->get($cid);
        if (!is_object($community) || !$community->checkAuthority($perm)) {
            redirect_header(XOOPS_URL, 2, _NOPERM);
        }

        $commu_vars = array('id' => $cid, 'name' => $community->getVar('name'));

        // Get a list of community members
        $c_member_obj_list =& $community->getMemberObjects($limit, $start);
        $pager = $this->getPageSelector(XSNS_URL_MEMBER . "&" . XSNS_ACTION_ARG . "=edit&cid=" . $cid,
            $start, $limit, count($c_member_obj_list), $community->getMemberCount());

        // Management
        $menu_list = array(
            0 => array(    // member
                0 => _MD_XSNS_MEMBER_LEAVE,
                1 => _MD_XSNS_MEMBER_SET_ADMIN,
                2 => _MD_XSNS_MEMBER_SET_SUB_ADMIN,
            ),
            1 => array(    // admin
                0 => _MD_XSNS_MEMBER_LEAVE,
                1 => _MD_XSNS_MEMBER_SET_ADMIN,
            ),
            2 => array(    // Members awaiting approval
                0 => _MD_XSNS_MEMBER_LEAVE,
            ),
        );

        $own_uid = $xoopsUser->getVar('uid');
        $uid_admin = $community->getVar('uid_admin');
        $uid_sub_admin = $community->getVar('uid_sub_admin');
        $is_commu_admin = ($own_uid == $uid_admin) ? true : false;

        $c_member_list = array();

        foreach ($c_member_obj_list as $c_member_obj) {
            $mid = $c_member_obj->getVar('uid');

            $c_member_list[$mid] =& $c_member_obj->getInfo();
            $c_member_list[$mid]['form_edit'] = $this->getFormHeader('post', 'member', 'request', false, array('cid' => $cid, 'uid' => $mid));

            // When the member is himself (administrator) → Nothing is displayed
            if ($mid == $own_uid) {
                $c_member_list[$mid]['is_editable'] = false;
            } else {
                // If site admin but not a community administrator → Show only [Unsubscribe]
                if ($xoopsUserIsAdmin && !$is_commu_admin) {
                    $menu = $menu_list[2];
                } // When the member is a manager/moderator → Display items other than [Nominate as sub-administrator]
                elseif ($mid == $uid_sub_admin) {
                    $menu = $menu_list[1];
                } // When the member is a user → Display all items
                else {
                    $menu = $menu_list[0];
                }

                $c_member_list[$mid]['is_editable'] = true;
                $c_member_list[$mid]['sel_edit'] = XsnsUtils::getSelectBoxHtml('mode', $menu);
            }
        }

        $this->context->setAttribute('commu', $commu_vars);
        $this->context->setAttribute('member_list', $c_member_list);
        $this->context->setAttribute('pager', $pager);
    }


}

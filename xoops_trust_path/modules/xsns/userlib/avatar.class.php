<?php
// Based on avatar.php,v 1.1 2007/05/15 02:34:38 minahito Exp $

require_once XOOPS_ROOT_PATH . '/kernel/avatar.php';


class XsnsAvatar extends XoopsAvatar
{

    function __construct()
    {
        $this->XoopsAvatar();
    }

}


class XsnsAvatarHandler extends XoopsAvatarHandler
{

    function XsnsAvatarHandler()
    {
        $this->db =& Database::getInstance();
    }


    public static function &getInstance()
    {
        static $instance = NULL;
        if (is_null($instance)) {
            $instance = new XsnsAvatarHandler();
        }
        return $instance;
    }


    function &getList($avatar_type = null, $avatar_display = null)
    {
        $criteria = new CriteriaCompo();
        if (isset($avatar_type)) {
            $avatar_type = ($avatar_type == 'C') ? 'C' : 'S';
            $criteria->add(new Criteria('avatar_type', $avatar_type));
        }
        if (isset($avatar_display)) {
            $criteria->add(new Criteria('avatar_display', intval($avatar_display)));
        }
        $avatars =& $this->getObjects($criteria, true);
        $ret = array();
        $ret[] = array(
            'id' => 0,
            'name' => _NONE,
            'file' => 'blank.gif',
        );
        if (is_array($avatars)) {
            foreach ($avatars as $id => $obj) {
                $ret[] = array(
                    'id' => $id,
                    'name' => $obj->getVar('avatar_name'),
                    'file' => $obj->getVar('avatar_file'),
                );
            }
        }
        return $ret;
    }

}

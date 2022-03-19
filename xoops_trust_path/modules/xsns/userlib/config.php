<?php


// ���Х�����ɽ��������
define('XSNS_AVATAR_MAX_WIDTH',	75);
define('XSNS_AVATAR_MAX_HEIGHT', 75);


// �������ե������ɤ߹����ѥ�����ץ�
define('XSNS_IMAGE_URL', XSNS_BASE_URL.'/image.php');
define('XSNS_FILE_URL',  XSNS_BASE_URL.'/file.php');


// ����ͥ���Υ��������
define('XSNS_IMAGE_SIZE_S', 1);
define('XSNS_IMAGE_SIZE_M', 2);
define('XSNS_IMAGE_SIZE_L', 3);


// ���ߥ�˥ƥ��˴ؤ��븢��
define('XSNS_AUTH_XOOPS_ADMIN',	32);	// XOOPS������
define('XSNS_AUTH_ADMIN',		16);	// ���ߥ�˥ƥ�������
define('XSNS_AUTH_SUB_ADMIN',	 8);	// ���ߥ�˥ƥ���������
define('XSNS_AUTH_MEMBER',		 4);	// ���ߥ�˥ƥ����С�
define('XSNS_AUTH_NON_MEMBER',	 2);	// �󥳥ߥ�˥ƥ����С�
define('XSNS_AUTH_GUEST',		 1);	// ������


// �ڡ���URL���
define('XSNS_URL_COMMU',	XSNS_BASE_URL.'/');
define('XSNS_URL_ADMIN',	XSNS_BASE_URL.'/admin/index.php');
define('XSNS_URL_TOPIC',	XSNS_BASE_URL.'/?'.XSNS_PAGE_ARG.'=topic');
define('XSNS_URL_MEMBER',	XSNS_BASE_URL.'/?'.XSNS_PAGE_ARG.'=member');
define('XSNS_URL_FILE',		XSNS_BASE_URL.'/?'.XSNS_PAGE_ARG.'=file');

define('XSNS_URL_MYPAGE',			XSNS_BASE_URL.'/?'.XSNS_PAGE_ARG.'=mypage');
define('XSNS_URL_MYPAGE_FRIEND',	XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=friend_list');
define('XSNS_URL_MYPAGE_CONFIRM',	XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=confirm');
define('XSNS_URL_MYPAGE_NEWS',		XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=news');
define('XSNS_URL_MYPAGE_FOOTPRINT',	XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=footprint');
define('XSNS_URL_MYPAGE_INTRO',		XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=intro_list');
define('XSNS_URL_MYPAGE_CONFIG',	XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=config');
define('XSNS_URL_MYPAGE_PROFILE',	XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=profile');
define('XSNS_URL_MYPAGE_COMMU',		XSNS_URL_MYPAGE.'&'.XSNS_ACTION_ARG.'=commu_list');


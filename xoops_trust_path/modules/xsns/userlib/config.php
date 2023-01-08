<?php


// Avatar display size
const XSNS_AVATAR_MAX_WIDTH = 80;
const XSNS_AVATAR_MAX_HEIGHT = 80;


// Script for reading images and files
const XSNS_IMAGE_URL = XSNS_BASE_URL . '/image.php';
const XSNS_FILE_URL = XSNS_BASE_URL . '/file.php';


// Thumbnail size constant
const XSNS_IMAGE_SIZE_S = 1;
const XSNS_IMAGE_SIZE_M = 2;
const XSNS_IMAGE_SIZE_L = 3;


// Community authority
const XSNS_AUTH_XOOPS_ADMIN = 32;  // Administrator
const XSNS_AUTH_ADMIN = 16;       // Community admin
const XSNS_AUTH_SUB_ADMIN = 8;   // Community Manager
const XSNS_AUTH_MEMBER = 4;     // Community members
const XSNS_AUTH_NON_MEMBER = 2;// Non-community members
const XSNS_AUTH_GUEST = 1;    // Guests


// Page URL constant
const XSNS_URL_COMMU = XSNS_BASE_URL . '/';
const XSNS_URL_ADMIN = XSNS_BASE_URL . '/admin/index.php';
const XSNS_URL_TOPIC = XSNS_BASE_URL . '/?' . XSNS_PAGE_ARG . '=topic';
const XSNS_URL_MEMBER = XSNS_BASE_URL . '/?' . XSNS_PAGE_ARG . '=member';
const XSNS_URL_FILE = XSNS_BASE_URL . '/?' . XSNS_PAGE_ARG . '=file';

const XSNS_URL_MYPAGE = XSNS_BASE_URL . '/?' . XSNS_PAGE_ARG . '=mypage';
const XSNS_URL_MYPAGE_FRIEND = XSNS_URL_MYPAGE . '&' . XSNS_ACTION_ARG . '=friend_list';
const XSNS_URL_MYPAGE_CONFIRM = XSNS_URL_MYPAGE . '&' . XSNS_ACTION_ARG . '=confirm';
const XSNS_URL_MYPAGE_NEWS = XSNS_URL_MYPAGE . '&' . XSNS_ACTION_ARG . '=news';
const XSNS_URL_MYPAGE_FOOTPRINT = XSNS_URL_MYPAGE . '&' . XSNS_ACTION_ARG . '=footprint';
const XSNS_URL_MYPAGE_INTRO = XSNS_URL_MYPAGE . '&' . XSNS_ACTION_ARG . '=intro_list';
const XSNS_URL_MYPAGE_CONFIG = XSNS_URL_MYPAGE . '&' . XSNS_ACTION_ARG . '=config';
const XSNS_URL_MYPAGE_PROFILE = XSNS_URL_MYPAGE . '&' . XSNS_ACTION_ARG . '=profile';
const XSNS_URL_MYPAGE_COMMU = XSNS_URL_MYPAGE . '&' . XSNS_ACTION_ARG . '=commu_list';


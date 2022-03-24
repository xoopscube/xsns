<?php

define('XSNS_TRUST_PATH', dirname(__FILE__));

// ���W���[���̃p�X
define('XSNS_BASE_DIR', XOOPS_ROOT_PATH . '/modules/' . $mydirname);

// ���W���[����URL
define('XSNS_BASE_URL', XOOPS_URL . '/modules/' . $mydirname);

// �X�^�C���V�[�g��URL
const XSNS_CSS_URL = XSNS_BASE_URL . '/css.php?f=';

// JavaScript��URL
const XSNS_JS_URL = XSNS_BASE_URL . '/js.php?f=';

// �t���[�����[�N�̃f�B���N�g��
const XSNS_FRAMEWORK_DIR = XSNS_TRUST_PATH . '/framework';
const XSNS_FRAMEWORK_CLASS_DIR = XSNS_FRAMEWORK_DIR . '/class';

// ���[�U�[��`�̃N���X�t�@�C���̃p�X
const XSNS_USERLIB_DIR = XSNS_TRUST_PATH . '/userlib';
const XSNS_USERLIB_CLASS_DIR = XSNS_USERLIB_DIR . '/class';

// �y�[�W�؂�ւ��p�̈�����
const XSNS_PAGE_ARG = 'p';

// Action, View �؂�ւ��p�̈�����
const XSNS_ACTION_ARG = 'act';

// Action �t�@�C���̃f�B���N�g��
const XSNS_ACTION_DIR = XSNS_TRUST_PATH . '/act/';

// �f�t�H���g�� Action ��
const XSNS_DEFAULT_ACTION = 'default';

// �f�t�H���g�� Action �t�@�C��
const XSNS_DEFAULT_ACTION_FILE = XSNS_ACTION_DIR . XSNS_DEFAULT_ACTION . 'Action.php';

// View �t�@�C��������f�B���N�g��
const XSNS_VIEW_DIR = XSNS_TRUST_PATH . '/act/';

// �f�t�H���g�� View ��
const XSNS_DEFAULT_VIEW = 'default';

// �f�t�H���g�� View �t�@�C��
const XSNS_DEFAULT_VIEW_FILE = XSNS_VIEW_DIR . XSNS_DEFAULT_VIEW . 'View.php';

const XSNS_REQUEST_POST = 1;
const XSNS_REQUEST_GET = 2;
const XSNS_REQUEST_SESSION = 3;

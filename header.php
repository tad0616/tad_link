<?php
require_once dirname(dirname(__DIR__)) . '/mainfile.php';
include_once 'preloads/autoloader.php';
require_once __DIR__ . '/function.php';

//判斷是否對該模組有管理權限
if (!isset($_SESSION['tad_link_adm'])) {
    $_SESSION['tad_link_adm'] = ($xoopsUser) ? $xoopsUser->isAdmin() : false;
}

$interface_menu[_MD_TADLINK_HOME] = 'index.php';
$interface_icon[_MD_TADLINK_HOME] = 'fa-link';

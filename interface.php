<?php
//判斷是否對該模組有管理權限
if (!isset($tad_link_adm)) {
    $tad_link_adm = isset($xoopsUser) && \is_object($xoopsUser) ? $xoopsUser->isAdmin() : false;
}

$interface_menu[_MD_TADLINK_HOME] = 'index.php';
$interface_icon[_MD_TADLINK_HOME] = 'fa-link';

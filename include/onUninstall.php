<?php

use XoopsModules\Tad_link\Utility;

function xoops_module_uninstall_tad_link(&$module)
{
    global $xoopsDB;
    $date = date("Ymd");

    rename(XOOPS_ROOT_PATH . "/uploads/tad_link", XOOPS_ROOT_PATH . "/uploads/tad_link_bak_{$date}");

    return true;
}


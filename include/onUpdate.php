<?php

use XoopsModules\Tad_link\Utility;

function xoops_module_update_tad_link(&$module, $old_version)
{
    global $xoopsDB;

    //if(!Utility::chk_chk1()) Utility::go_update1();
    Utility::chk_tad_link_block();

    return true;
}


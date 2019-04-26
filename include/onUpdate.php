<?php

use XoopsModules\Tad_link\Update;

function xoops_module_update_tad_link(&$module, $old_version)
{
    global $xoopsDB;

    Update::chk_tad_link_block();

    return true;
}

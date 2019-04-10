<?php

use XoopsModules\Tad_link\Utility;

include dirname(__DIR__) . '/preloads/autoloader.php';

function xoops_module_install_tad_link(&$module)
{
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_link");
    Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_link/thumbs");

    return true;
}




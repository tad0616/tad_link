<?php

use XoopsModules\Tadtools\Utility;

if (!class_exists('XoopsModules\Tadtools\Utility')) {
    require XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';
}

function xoops_module_install_tad_link(&$module)
{
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_link');
    Utility::mk_dir(XOOPS_ROOT_PATH . '/uploads/tad_link/thumbs');

    return true;
}

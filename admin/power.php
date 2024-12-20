<?php
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
$GLOBALS['xoopsOption']['template_main'] = 'tad_link_admin.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';

require_once XOOPS_ROOT_PATH . '/Frameworks/art/functions.php';
require_once XOOPS_ROOT_PATH . '/Frameworks/art/functions.admin.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

/*-----------function區--------------*/
$module_id = $xoopsModule->mid();

//抓取所有資料夾

$sql = 'SELECT `cate_sn`, `cate_title` FROM `' . $xoopsDB->prefix('tad_link_cate') . '`';
$result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

while (list($cate_sn, $cate_title) = $xoopsDB->fetchRow($result)) {
    $item_list[$cate_sn] = $cate_title;
}
if (empty($item_list)) {
    redirect_header('main.php', 3, "請先建立分類，始能設定權限");
}
$perm_desc = '';

$formi = new \XoopsGroupPermForm('', $module_id, 'tad_link_post', $perm_desc, null, false);
foreach ($item_list as $item_id => $item_name) {
    $formi->addItem($item_id, $item_name);
}

$permission_content = $formi->render();
$xoopsTpl->assign('permission_content', $permission_content);

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', 'tad_link_power');
require_once __DIR__ . '/footer.php';

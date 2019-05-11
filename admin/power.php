<?php
/*-----------引入檔案區--------------*/
$GLOBALS['xoopsOption']['template_main'] = 'tad_link_adm_power.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';

require_once XOOPS_ROOT_PATH . '/Frameworks/art/functions.php';
require_once XOOPS_ROOT_PATH . '/Frameworks/art/functions.admin.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

/*-----------function區--------------*/
$module_id = $xoopsModule->getVar('mid');

//抓取所有資料夾

$sql = 'SELECT cate_sn,cate_title FROM ' . $xoopsDB->prefix('tad_link_cate');
$result = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);
while (list($cate_sn, $cate_title) = $xoopsDB->fetchRow($result)) {
    $item_list[$cate_sn] = $cate_title;
}

$perm_desc = '';

$formi = new \XoopsGroupPermForm('', $module_id, 'tad_link_post', $perm_desc);
foreach ($item_list as $item_id => $item_name) {
    $formi->addItem($item_id, $item_name);
}

$permission_content = $formi->render();
$xoopsTpl->assign('permission_content', $permission_content);

/*-----------秀出結果區--------------*/
require_once __DIR__ . '/footer.php';

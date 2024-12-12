<?php
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
require dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
// 關閉除錯訊息
header('HTTP/1.1 200 OK');
$xoopsLogger->activated = false;
$cate_sn = (int) $_POST['cate_sn'];
$cate_sort = (int) $_POST['sort'];
$sql = 'UPDATE `' . $xoopsDB->prefix('tad_link_cate') . '` SET `cate_sort`=? WHERE `cate_sn`=?';
Utility::query($sql, 'ii', [$cate_sort, $cate_sn]) or die(_TAD_SORT_FAIL . ' (' . date('Y-m-d H:i:s') . ')');

echo _TAD_SORTED . "(" . date("Y-m-d H:i:s") . ")";

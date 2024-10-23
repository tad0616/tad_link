<?php
use XoopsModules\Tadtools\Utility;
/*-----------引入檔案區--------------*/
require dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
$of_cate_sn = (int) (str_replace('node-_', '', $_POST['of_cate_sn']));
$cate_sn = (int) (str_replace('node-_', '', $_POST['cate_sn']));
error_reporting(0);
$xoopsLogger->activated = false;
if ($of_cate_sn == $cate_sn) {
    die(_MA_TREETABLE_MOVE_ERROR1 . '(' . date('Y-m-d H:i:s') . ')');
} elseif (chk_cate_path($cate_sn, $of_cate_sn)) {
    die(_MA_TREETABLE_MOVE_ERROR2 . '(' . date('Y-m-d H:i:s') . ')');
}

$sql = 'UPDATE `' . $xoopsDB->prefix('tad_link_cate') . '` SET `of_cate_sn`=? WHERE `cate_sn`=?';
Utility::query($sql, 'ii', [$of_cate_sn, $cate_sn]) or die('Reset Fail! (' . date('Y-m-d H:i:s') . ')');

echo _MA_TREETABLE_MOVE_OK . ' (' . date('Y-m-d H:i:s') . ')';

//檢查目的地編號是否在其子目錄下
function chk_cate_path($cate_sn, $to_cate_sn)
{
    global $xoopsDB;
    //抓出子目錄的編號
    $sql = 'SELECT `cate_sn` FROM `' . $xoopsDB->prefix('tad_link_cate') . '` WHERE `of_cate_sn`=?';
    $result = Utility::query($sql, 'i', [$cate_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

    while (list($sub_cate_sn) = $xoopsDB->fetchRow($result)) {
        if (chk_cate_path($sub_cate_sn, $to_cate_sn)) {
            return true;
        }
        if ($sub_cate_sn == $to_cate_sn) {
            return true;
        }
    }

    return false;
}

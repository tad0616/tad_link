<?php
/*-----------引入檔案區--------------*/
include "../../../include/cp_header.php";

$of_cate_sn = (int) (str_replace("node-_", "", $_POST['of_cate_sn']));
$cate_sn    = (int) (str_replace("node-_", "", $_POST['cate_sn']));

if ($of_cate_sn == $cate_sn) {
    die(_MA_TREETABLE_MOVE_ERROR1 . "(" . date("Y-m-d H:i:s") . ")");
} elseif (chk_cate_path($cate_sn, $of_cate_sn)) {
    die(_MA_TREETABLE_MOVE_ERROR2 . "(" . date("Y-m-d H:i:s") . ")");
}

$sql = "update " . $xoopsDB->prefix("tad_link_cate") . " set `of_cate_sn`='{$of_cate_sn}' where `cate_sn`='{$cate_sn}'";
$xoopsDB->queryF($sql) or die("Reset Fail! (" . date("Y-m-d H:i:s") . ")");

echo _MA_TREETABLE_MOVE_OK . " (" . date("Y-m-d H:i:s") . ")";

//檢查目的地編號是否在其子目錄下
function chk_cate_path($cate_sn, $to_cate_sn)
{
    global $xoopsDB;
    //抓出子目錄的編號
    $sql    = "select cate_sn from " . $xoopsDB->prefix("tad_link_cate") . " where of_cate_sn='{$cate_sn}'";
    $result = $xoopsDB->query($sql) or web_error($sql);
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

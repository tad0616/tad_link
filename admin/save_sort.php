<?php
/*-----------引入檔案區--------------*/
include "../../../include/cp_header.php";

$cate_sn   = (int)$_POST['cate_sn'];
$cate_sort = (int)$_POST['sort'];
$sql       = "update " . $xoopsDB->prefix("tad_link_cate") . " set `cate_sort`='{$cate_sort}' where cate_sn='{$cate_sn}'";
$xoopsDB->queryF($sql) or die("Save Sort Fail! (" . date("Y-m-d H:i:s") . ")");

echo "Save Sort OK! (" . date("Y-m-d H:i:s") . ") ";

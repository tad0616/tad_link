<?php
use Xmf\Request;
use XoopsModules\Tadtools\Utility;
require_once __DIR__ . '/header.php';
// 關閉除錯訊息
$xoopsLogger->activated = false;
$updateRecordsArray = Request::getVar('tr', [], null, 'array', 4);

$sort = 1;
foreach ($updateRecordsArray as $link_sn) {
    $link_sn = (int) $link_sn;
    $sql = 'UPDATE `' . $xoopsDB->prefix('tad_link') . '` SET `link_sort`=? WHERE `link_sn`=?';
    Utility::query($sql, 'ii', [$sort, $link_sn]) or die(_TAD_SORT_FAIL . ' (' . date('Y-m-d H:i:s') . ')');

    $sort++;
}

echo _TAD_SORTED . "(" . date("Y-m-d H:i:s") . ")";

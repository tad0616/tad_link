<?php
include_once 'header.php';
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op = system_CleanVars($_REQUEST, 'op', '', 'string');
$link_sn = system_CleanVars($_REQUEST, 'link_sn', 0, 'int');

$all = get_tad_link($link_sn);
foreach ($all as $k => $v) {
    $$k = $v;
}

add_tad_link_counter($link_sn);

$cate = get_tad_link_cate_all();

if ('hide' === $op) {
    $main = mk_content($link_sn, $xoopsModuleConfig['show_mode'], $link_title, $link_url, $cate_sn, $cate[$cate_sn]['cate_title'], $link_desc, $link_counter);
} elseif ('show' === $op) {
    $main = mk_big_content($link_sn, $xoopsModuleConfig['show_mode'], $link_title, $link_url, $cate_sn, $cate[$cate_sn]['cate_title'], $link_desc, $link_counter);
} elseif ('light' === $op) {
    $width = empty($xoopsModuleConfig['pic_width']) ? 400 : $xoopsModuleConfig['pic_width'];
    $width_div = $width + 250;

    $main = "<table style='width:{$width_div}px;'>";
    $main .= mk_big_content($link_sn, 'light', $link_title, $link_url, $cate_sn, $cate[$cate_sn]['cate_title'], $link_desc, $link_counter);
    $main .= '</table>';
}
die($main);

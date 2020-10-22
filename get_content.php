<?php
use Xmf\Request;
require_once __DIR__ . '/header.php';

$op = Request::getString('op');
$link_sn = Request::getInt('link_sn');

$all = get_tad_link($link_sn);
foreach ($all as $k => $v) {
    $$k = $v;
}

$myts = MyTextSanitizer::getInstance();
$link_url = $myts->htmlSpecialChars($link_url);
$link_title = $myts->htmlSpecialChars($link_title);
$cate_title = $myts->htmlSpecialChars($cate_title);
$link_desc = $myts->displayTarea($link_desc, 0, 0, 0, 0, 1);

add_tad_link_counter($link_sn);

$cate = get_tad_link_cate_all();
$cate_title = $myts->htmlSpecialChars($cate[$cate_sn]['cate_title']);

if ('hide' === $op) {
    $main = mk_content($link_sn, $xoopsModuleConfig['show_mode'], $link_title, $link_url, $cate_sn, $cate_title, $link_desc, $link_counter);
} elseif ('show' === $op) {
    $main = mk_big_content($link_sn, $xoopsModuleConfig['show_mode'], $link_title, $link_url, $cate_sn, $cate_title, $link_desc, $link_counter);
} elseif ('light' === $op) {
    $width = empty($xoopsModuleConfig['pic_width']) ? 400 : $xoopsModuleConfig['pic_width'];
    $width_div = $width + 250;

    $main = "<table style='width:{$width_div}px;'>";
    $main .= mk_big_content($link_sn, 'light', $link_title, $link_url, $cate_sn, $cate_title, $link_desc, $link_counter);
    $main .= '</table>';
}
die($main);

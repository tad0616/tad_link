<?php
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_link\Tools;
xoops_loadLanguage('main', 'tadtools');
define('_TADLINK_PIC_URL', XOOPS_URL . '/uploads/tad_link');
define('_TADLINK_PIC_PATH', XOOPS_ROOT_PATH . '/uploads/tad_link');
define('_TADLINK_THUMB_PIC_URL', XOOPS_URL . '/uploads/tad_link/thumbs');
define('_TADLINK_THUMB_PIC_PATH', XOOPS_ROOT_PATH . '/uploads/tad_link/thumbs');
if (!isset($tad_link_adm)) {
    $tad_link_adm = isset($xoopsUser) && \is_object($xoopsUser) ? $xoopsUser->isAdmin() : false;
}
//取得所有tad_link_cate分類選單的選項（模式 = edit or show,目前分類編號,目前分類的所屬編號）
function get_tad_link_cate_options($page = '', $mode = 'edit', $default_cate_sn = '0', $default_of_cate_sn = '0', $unselect_level = '', $start_search_sn = '0', $level = 0)
{
    global $xoopsDB, $tad_link_adm;

    $post_cate_arr = Utility::get_gperm_cate_arr('tad_link_post', 'tad_link');

    $count = Tools::tad_link_cate_count();

    $sql = 'SELECT `cate_sn`, `cate_title` FROM `' . $xoopsDB->prefix('tad_link_cate') . '` WHERE `of_cate_sn`=? ORDER BY `cate_sort`';
    $result = Utility::query($sql, 'i', [$start_search_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

    $prefix = str_repeat('&nbsp;&nbsp;', $level);
    $level++;

    $unselect = explode(',', $unselect_level);

    $main = '';
    while (list($cate_sn, $cate_title) = $xoopsDB->fetchRow($result)) {
        // $tad_link_post = $modulepermHandler->getGroupIds("tad_link_post", $cate_sn, $mod_id);
        if (!$tad_link_adm and is_array($post_cate_arr) and !in_array($cate_sn, $post_cate_arr)) {
            continue;
        }

        if ('edit' === $mode) {
            $selected = ($cate_sn == $default_of_cate_sn) ? 'selected=selected' : '';
            $selected .= ($cate_sn == $default_cate_sn) ? 'disabled=disabled' : '';
            $selected .= (in_array($level, $unselect)) ? 'disabled=disabled' : '';
        } else {
            if (is_array($default_cate_sn)) {
                $selected = in_array($cate_sn, $default_cate_sn) ? 'selected=selected' : '';
            } else {
                $selected = ($cate_sn == $default_cate_sn) ? 'selected=selected' : '';
            }
            $selected .= (in_array($level, $unselect)) ? 'disabled=disabled' : '';
        }
        if ('none' === $page or empty($count[$cate_sn])) {
            $counter = '';
        } else {
            $w = ('admin' === $page) ? _MA_TADLINK_CATE_COUNT : _MD_TADLINK_CATE_COUNT;
            $counter = ' (' . sprintf($w, $count[$cate_sn]) . ') ';
        }
        $main .= "<option value=$cate_sn $selected>{$prefix}{$cate_title}{$counter}</option>";
        $main .= get_tad_link_cate_options($page, $mode, $default_cate_sn, $default_of_cate_sn, $unselect_level, $cate_sn, $level);
    }

    return $main;
}

//自動取得tad_link_cate的最新排序
function tad_link_cate_max_sort($of_cate_sn = '0')
{
    global $xoopsDB;
    $sql = 'SELECT MAX(`cate_sort`) FROM `' . $xoopsDB->prefix('tad_link_cate') . '` WHERE `of_cate_sn`=?';
    $result = Utility::query($sql, 'i', [$of_cate_sn]) or Utility::web_error($sql, __FILE__, __LINE__);

    list($sort) = $xoopsDB->fetchRow($result);

    return ++$sort;
}

//刪除tad_link某筆資料資料
function delete_tad_link($link_sn = '')
{
    global $xoopsDB, $now_uid, $tad_link_adm;

    $and_uid = $tad_link_adm ? '' : "AND uid = ?";
    $sql = 'DELETE FROM ' . $xoopsDB->prefix('tad_link') . " WHERE link_sn = ? {$and_uid}";
    $params = [$link_sn];

    if (!empty($and_uid)) {
        $params[] = $now_uid;
    }

    Utility::query($sql, str_repeat('i', count($params)), $params) or Utility::web_error($sql, __FILE__, __LINE__);

}

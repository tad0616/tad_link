<?php

namespace XoopsModules\Tad_link;

use XoopsModules\Tadtools\Utility;

/*
Update Class Definition

You may not change or alter any portion of this comment or credits of
supporting developers from this source code or any supporting source code
which is considered copyrighted (c) material of the original comment or credit
authors.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @license      http://www.fsf.org/copyleft/gpl.html GNU public license
 * @copyright    https://xoops.org 2001-2017 &copy; XOOPS Project
 * @author       Mamba <mambax7@gmail.com>
 */

/**
 * Class Update
 */
class Update
{
    // 移除訪客的發布權限設定
    public static function remove_guest_power()
    {
        global $xoopsDB;
        $sql = 'DELETE FROM `' . $xoopsDB->prefix('group_permission') . "`
        WHERE `gperm_name` = 'tad_link_post' AND  `gperm_groupid` = 3";
        $xoopsDB->query($sql);

    }

    //刪除錯誤的重複欄位及樣板檔
    public static function chk_tad_link_block()
    {
        global $xoopsDB;
        //die(var_export($xoopsConfig));
        include XOOPS_ROOT_PATH . '/modules/tad_link/xoops_version.php';

        //先找出該有的區塊以及對應樣板
        foreach ($modversion['blocks'] as $i => $block) {
            $show_func = $block['show_func'];
            $tpl_file_arr[$show_func] = $block['template'];
            $tpl_desc_arr[$show_func] = $block['description'];
        }

        //找出目前所有的樣板檔
        $sql = 'SELECT bid,name,visible,show_func,template FROM `' . $xoopsDB->prefix('newblocks') . "`
        WHERE `dirname` = 'tad_link' ORDER BY `func_num`";
        $result = $xoopsDB->query($sql);
        while (list($bid, $name, $visible, $show_func, $template) = $xoopsDB->fetchRow($result)) {
            //假如現有的區塊和樣板對不上就刪掉
            if ($template != $tpl_file_arr[$show_func]) {
                $sql = 'delete from ' . $xoopsDB->prefix('newblocks') . " where bid='{$bid}'";
                $xoopsDB->queryF($sql);

                //連同樣板以及樣板實體檔案也要刪掉
                $sql = 'delete from ' . $xoopsDB->prefix('tplfile') . ' as a
                left join ' . $xoopsDB->prefix('tplsource') . "  as b on a.tpl_id=b.tpl_id
                where a.tpl_refid='$bid' and a.tpl_module='tad_link' and a.tpl_type='block'";
                $xoopsDB->queryF($sql);
            } else {
                $sql = 'update ' . $xoopsDB->prefix('tplfile') . "
                set tpl_file='{$template}' , tpl_desc='{$tpl_desc_arr[$show_func]}'
                where tpl_refid='{$bid}'";
                $xoopsDB->queryF($sql);
            }
        }
    }

    //新增檔案欄位
    public static function chk_chk1()
    {
        global $xoopsDB;
        $sql = 'SELECT count(`cate_bg`) FROM ' . $xoopsDB->prefix('tad_link_cate');
        $result = $xoopsDB->query($sql);
        if (empty($result)) {
            return true;
        }

        return false;
    }

    public static function go_update1()
    {
        global $xoopsDB;
        $sql = 'ALTER TABLE ' . $xoopsDB->prefix('tad_link_cate') . "
        ADD `cate_bg` varchar(255) NOT NULL COMMENT '背景色',
        ADD `cate_color` varchar(255) NOT NULL COMMENT '文字顏色'
        ";
        $xoopsDB->queryF($sql) or redirect_header(XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin', 30, $xoopsDB->error());

        $sql = 'select cate_sn from ' . $xoopsDB->prefix('tad_link_cate') . " order by of_cate_sn,cate_sort";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while (list($cate_sn) = $xoopsDB->fetchRow($result)) {
            $color = self::cate_sn2color($cate_sn);

            $sql2 = 'update ' . $xoopsDB->prefix('tad_link_cate') . " set `cate_bg`='$color', `cate_color`='rgb(0,0,0)' where `cate_sn` = '{$cate_sn}' ";
            $xoopsDB->queryF($sql2) or die($sql2);
        }
    }

    //自動取得顏色
    private static function cate_sn2color($cate_sn = '')
    {
        $R = $G = $B = 255;
        $m = ceil($cate_sn / 6);
        $n = $cate_sn % 6;
        $degree = (int) ($cate_sn) * 3 * $m;

        if (0 == $n) {
            $R -= $degree;
        } elseif (1 == $n) {
            $G -= $degree;
        } elseif (2 == $n) {
            $B -= $degree;
        } elseif (3 == $n) {
            $R -= $degree;
            $G -= $degree;
        } elseif (4 == $n) {
            $R -= $degree;
            $B -= $degree;
        } elseif (5 == $n) {
            $G -= $degree;
            $B -= $degree;
        } elseif (6 == $n) {
            $R -= $degree;
            $G -= $degree;
            $B -= $degree;
        }

        return "rgb({$R},{$G},{$B})";
    }
}

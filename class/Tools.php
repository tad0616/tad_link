<?php

namespace XoopsModules\Tad_link;

use XoopsModules\Tadtools\Utility;

class Tools
{

//分類底下的連結數
    public static function tad_link_cate_count()
    {
        $all = [];
        global $xoopsDB;
        $sql = 'SELECT `cate_sn`, COUNT(*) FROM `' . $xoopsDB->prefix('tad_link') . '` GROUP BY `cate_sn`';
        $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        while (list($cate_sn, $count) = $xoopsDB->fetchRow($result)) {
            $all[$cate_sn] = (int) ($count);
        }

        return $all;
    }

//取得所有類別標題
    public static function block_link_cate($selected = '')
    {
        global $xoopsDB;
        $counter = self::tad_link_cate_count();

        if (!empty($selected)) {
            $sc = explode(',', $selected);
        }

        $js = '<script>
        function bbv(){
        i=0;
        var arr = new Array();';

        $sql = 'SELECT `cate_sn`,`cate_title` FROM `' . $xoopsDB->prefix('tad_link_cate') . '` ORDER BY `of_cate_sn`,`cate_sort`';
        $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $option = '';
        while (list($cate_sn, $cate_title) = $xoopsDB->fetchRow($result)) {
            $cate_counter = isset($counter[$cate_sn]) ? '(' . $counter[$cate_sn] . ')' : '';
            $js .= "if(document.getElementById('c{$cate_sn}').checked){
                arr[i] = document.getElementById('c{$cate_sn}').value;
                i++;
            }";
            $ckecked = (in_array($cate_sn, $sc)) ? 'checked' : '';
            $option .= "
            <span style='white-space:nowrap;'>
                <input type='checkbox' id='c{$cate_sn}' value='{$cate_sn}' class='bbv' onChange=bbv() $ckecked><label for='c{$cate_sn}'>$cate_title {$cate_counter}</label>
            </span> ";
        }

        $js .= "document.getElementById('bb').value=arr.join(',');
        }
        </script>";

        $main['js'] = $js;
        $main['form'] = $option;

        return $main;
    }

}

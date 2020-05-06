<?php
use XoopsModules\Tadtools\Utility;
//區塊主函式 (好站推薦快速連結(tad_link_all))
function tad_link_all($options)
{
    global $xoopsDB, $xoTheme;
    $xoTheme->addStylesheet('modules/tadtools/css/vertical_menu.css');
    $i = 0;
    $block = [];
    $and_cate = empty($options[1]) ? '' : "where cate_sn in({$options[1]})";
    //今天日期
    $today = date('Y-m-d');
    $sql = 'select * from ' . $xoopsDB->prefix('tad_link_cate') . " $and_cate order by of_cate_sn,cate_sort";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        //以下會產生這些變數： $cate_sn , $of_cate_sn , $cate_title , $cate_sort
        foreach ($all as $k => $v) {
            $$k = $v;
        }
        $color = cate_sn2color($cate_sn);

        $link_js = (1 == $options[0]) ? "window.open(this.value,'_blank');" : "location.href='" . XOOPS_URL . "/modules/tad_link/index.php?link_sn='+this.value";

        $sql2 = 'select * from ' . $xoopsDB->prefix('tad_link') . " where `cate_sn` = '{$cate_sn}' and `enable`='1' and (`unable_date`='0000-00-00' or `unable_date` >='$today') order by link_sort";
        $result2 = $xoopsDB->query($sql2) or Utility::web_error($sql2);
        $total = $xoopsDB->getRowsNum($result2);
        if (empty($total)) {
            continue;
        }

        $block['data'][$i]['link_js'] = $link_js;
        $block['data'][$i]['color'] = $color;
        $block['data'][$i]['cate_title'] = $cate_title;
        $block['data'][$i]['cate_sn'] = $cate_sn;
        $j = 0;
        while (false !== ($all2 = $xoopsDB->fetchArray($result2))) {
            //以下會產生這些變數： $link_sn , $cate_sn , $link_title , $link_url , $link_desc , $link_sort , $link_counter , $unable_date , $uid , $post_date , $enable
            foreach ($all2 as $k => $v) {
                $$k = $v;
            }
            $val = (1 == $options[0]) ? $link_url : $link_sn;
            if (empty($val)) {
                $val = '#';
            }
            $block['data'][$i]['item'][$j]['link_title'] = $link_title;
            $block['data'][$i]['item'][$j]['val'] = $val;
            $j++;
        }
        $i++;
    }
    $block['display_type'] = $options[2];
    $block['show_title'] = $options[3];
    // die(var_export($block));
    return $block;
}

//區塊編輯函式
function tad_link_all_edit($options)
{
    require_once XOOPS_ROOT_PATH . '/modules/tad_link/function_block.php';
    $chked0_0 = ('1' == $options[0]) ? 'checked' : '';
    $chked0_1 = ('0' == $options[0]) ? 'checked' : '';
    $chked3_0 = ('1' == $options[0]) ? 'checked' : '';
    $chked3_1 = ('0' == $options[0]) ? 'checked' : '';
    $opt2_dropdown = ('list' !== $options[2]) ? 'checked' : '';
    $opt2_list = ('list' === $options[2]) ? 'checked' : '';

    $menu = block_link_cate($options[1]);

    $form = "{$menu['js']}
    <ol class='my-form'>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_TADLINK_ALL_EDIT_BITEM0 . "</lable>
            <div class='my-content'>
                <input type='radio' $chked0_0 name='options[0]' value='1'>" . _YES . "
                <input type='radio' $chked0_1 name='options[0]' value='0'>" . _NO . "
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_TAD_CATE_MENU . "</lable>
            <div class='my-content'>
                {$menu['form']}
                <input type='hidden' name='options[1]' id='bb' value='{$options[1]}'>
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_TADLINK_LIST_TYPE . "</lable>
            <div class='my-content'>
                <input type='radio' $opt2_dropdown name='options[2]' value='dropdown'>" . _MB_TADLINK_TADLINK_DROPDOWN . "
                <input type='radio' $opt2_list name='options[2]' value='list'>" . _MB_TADLINK_TADLINK_LIST . "
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_SHOW_TITLE . "</lable>
            <div class='my-content'>
                <input type='radio' $chked3_0 name='options[3]' value='1'>" . _YES . "
                <input type='radio' $chked3_1 name='options[3]' value='0'>" . _NO . '
            </div>
        </li>
    </ol>';

    return $form;
}

if (!function_exists('cate_sn2color')) {
    //自動取得顏色
    function cate_sn2color($cate_sn = '')
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

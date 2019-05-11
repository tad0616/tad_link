<?php
use XoopsModules\Tadtools\Utility;
//區塊主函式 (最新好站連結(tad_link_show))
function tad_link_show($options)
{
    global $xoopsDB;
    if (empty($options[0])) {
        $options[0] = 10;
    }

    if ('new' === $options[4]) {
        $order = 'order by post_date desc';
    } elseif ('rand' === $options[4]) {
        $order = 'order by rand()';
    } else {
        $order = 'order by link_sort';
    }

    $and_cate = empty($options[6]) ? '' : "and cate_sn in({$options[6]})";
    //今天日期
    $today = date('Y-m-d');
    $sql = 'select * from ' . $xoopsDB->prefix('tad_link') . " where `enable`='1' and (`unable_date`='0000-00-00' or `unable_date` >='$today') $and_cate $order limit 0,{$options[0]}";

    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $block = [];
    $i = 0;
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        //以下會產生這些變數： $link_sn , $cate_sn , $link_title , $link_url , $link_desc , $link_sort , $link_counter , $unable_date , $uid , $post_date , $enable
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $val = ($options[5]) ? $link_url : $link_sn;
        $link_go = ($options[5]) ? $link_url : '' . XOOPS_URL . "/modules/tad_link/index.php?link_sn={$link_sn}";

        $height = 10;
        $thumb = get_show_block_pic($link_sn);
        $pic = ($options[1]) ? "<a href='{$link_go}' target='_blank' title='$link_title'><img src='$thumb' alt='{$link_url}' class='img-responsive img-fluid'></a>" : '';
        $height += ($options[1]) ? 100 : 5;

        $title = ($options[2]) ? "<a href='{$link_go}' target='_blank' title='$link_title'>$link_title</a>" : '';

        $height += ($options[2]) ? 30 : 0;

        $url = ($options[3]) ? "<a href='{$link_go}' target='_blank' title='$link_title'>$link_url</a>" : '';

        $height += ($options[3]) ? 25 : 0;

        $block['links'][$i]['height'] = $height;
        $block['links'][$i]['pic'] = $pic;
        $block['links'][$i]['url'] = $url;
        $block['links'][$i]['title'] = $title;
        $i++;
    }
    $block['height'] = $options[7];
    $block['col'] = $options[8];
    $block['cate_sn'] = $options[6];

    return $block;
}

//區塊編輯函式
function tad_link_show_edit($options)
{
    require_once XOOPS_ROOT_PATH . '/modules/tad_link/function_block.php';

    $chked1_1 = ('1' == $options[1]) ? 'checked' : '';
    $chked1_0 = ('0' == $options[1]) ? 'checked' : '';
    $chked2_1 = ('1' == $options[2]) ? 'checked' : '';
    $chked2_0 = ('0' == $options[2]) ? 'checked' : '';
    $chked3_1 = ('1' == $options[3]) ? 'checked' : '';
    $chked3_0 = ('0' == $options[3]) ? 'checked' : '';
    $chked4_1 = ('new' === $options[4]) ? 'checked' : '';
    $chked4_0 = ('rand' === $options[4]) ? 'checked' : '';
    $chked4_2 = ('sort' === $options[4]) ? 'checked' : '';
    $chked5_1 = ('1' == $options[5]) ? 'checked' : '';
    $chked5_0 = ('0' == $options[5]) ? 'checked' : '';
    $s12 = ('12' == $options[8]) ? 'selected' : '';
    $s6 = ('6' == $options[8]) ? 'selected' : '';
    $s4 = ('4' == $options[8]) ? 'selected' : '';
    $s3 = ('3' == $options[8]) ? 'selected' : '';
    $s2 = ('2' == $options[8]) ? 'selected' : '';
    $s1 = ('1' == $options[8]) ? 'selected' : '';
    $sno = ('0' == $options[8]) ? 'selected' : '';

    $menu = block_link_cate($options[6]);

    $form = "{$menu['js']}
    <ol class='my-form'>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_SHOW_EDIT_BITEM0 . "</lable>
            <div class='my-content'>
                <input type='text' name='options[0]' class='my-input' value='{$options[0]}' size=3>
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_SHOW_EDIT_BITEM1 . "</lable>
            <div class='my-content'>
                <input type='radio' name='options[1]' value='1' $chked1_1>" . _YES . "
                <input type='radio' name='options[1]' value='0' $chked1_0>" . _NO . "
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_SHOW_EDIT_BITEM2 . "</lable>
            <div class='my-content'>
                <input type='radio' name='options[2]' value='1' $chked2_1>" . _YES . "
                <input type='radio' name='options[2]' value='0' $chked2_0>" . _NO . "
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_SHOW_EDIT_BITEM3 . "</lable>
            <div class='my-content'>
                <input type='radio' name='options[3]' value='1' $chked3_1>" . _YES . "
                <input type='radio' name='options[3]' value='0' $chked3_0>" . _NO . "
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_SHOW_EDIT_BITEM3 . "</lable>
            <div class='my-content'>
                <input type='radio' name='options[4]' value='new' $chked4_1>" . _MB_TADLINK_SHOW_EDIT_BITEM4 . "
                <input type='radio' name='options[4]' value='rand' $chked4_0>" . _MB_TADLINK_SHOW_EDIT_BITEM5 . "
                <input type='radio' name='options[4]' value='sort' $chked4_2>" . _MB_TADLINK_SHOW_EDIT_BITEM7 . "
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_SHOW_EDIT_BITEM6 . "</lable>
            <div class='my-content'>
                <input type='radio' name='options[5]' value='1' $chked5_1>" . _YES . "
                <input type='radio' name='options[5]' value='0' $chked5_0>" . _NO . "
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_TAD_CATE_MENU . "</lable>
            <div class='my-content'>
                {$menu['form']}
                <input type='hidden' name='options[6]' id='bb' value='{$options[6]}'>
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_SHOW_HEIGHT . "</lable>
            <div class='my-content'>
                <input type='text' name='options[7]' class='my-input' value='{$options[7]}' size=4> px
            </div>
        </li>
        <li class='my-row'>
            <lable class='my-label'>" . _MB_TADLINK_BOOTSTRAP_COL . "</lable>
            <div class='my-content'>
                <select name='options[8]' class='my-input' value='{$options[8]}'>
                    <option value='0' $sno>" . _MB_TADLINK_NO_BOOTSTRAP_COL . "</option>
                    <option value='12' $s12>1</option>
                    <option value='6' $s6>2</option>
                    <option value='4' $s4>3</option>
                    <option value='3' $s3>4</option>
                    <option value='2' $s2>6</option>
                    <option value='1' $s1>12</option>
                </select>
            </div>
        </li>
    </ol>";

    return $form;
}

if (!function_exists('get_show_block_pic')) {
    //顯示圖片
    function get_show_block_pic($link_sn)
    {
        $pic = XOOPS_URL . "/uploads/tad_link/{$link_sn}.jpg";
        $pic_path = XOOPS_ROOT_PATH . "/uploads/tad_link/{$link_sn}.jpg";
        $empty = XOOPS_URL . '/modules/tad_link/images/pic_thumb.png';

        if (file_exists($pic_path)) {
            return $pic;
        }

        return $empty;
    }
}

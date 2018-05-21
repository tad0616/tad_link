<?php
//區塊主函式 (最新好站連結(tad_link_show))
function tad_link_show($options)
{
    global $xoopsDB;
    if (empty($options[0])) {
        $options[0] = 10;
    }

    if ($options[4] == 'new') {
        $order = "order by post_date desc";
    } elseif ($options[4] == 'rand') {
        $order = "order by rand()";
    } else {
        $order = "order by link_sort";
    }

    $and_cate = empty($options[6]) ? "" : "and cate_sn in({$options[6]})";
    //今天日期
    $today = date("Y-m-d");
    $sql   = "select * from " . $xoopsDB->prefix("tad_link") . " where `enable`='1' and (`unable_date`='0000-00-00' or `unable_date` >='$today') $and_cate $order limit 0,{$options[0]}";

    $result = $xoopsDB->query($sql) or web_error($sql);

    $block = array();
    $i     = 0;
    while ($all = $xoopsDB->fetchArray($result)) {
        //以下會產生這些變數： $link_sn , $cate_sn , $link_title , $link_url , $link_desc , $link_sort , $link_counter , $unable_date , $uid , $post_date , $enable
        foreach ($all as $k => $v) {
            $$k = $v;
        }

        $val     = ($options[5]) ? $link_url : $link_sn;
        $link_go = ($options[5]) ? $link_url : "" . XOOPS_URL . "/modules/tad_link/index.php?link_sn={$link_sn}";

        $height = 10;
        $thumb  = get_show_block_pic($link_sn);
        $pic    = ($options[1]) ? "<a href='{$link_go}' target='_blank' title='$link_title'><img src='$thumb' alt='{$link_url}' class='img-responsive'></a>" : "";
        $height += ($options[1]) ? 100 : 5;

        $title = ($options[2]) ? "<a href='{$link_go}' target='_blank' title='$link_title'>$link_title</a>" : "";

        $height += ($options[2]) ? 30 : 0;

        $url = ($options[3]) ? "<a href='{$link_go}' target='_blank' title='$link_title'>$link_url</a>" : "";

        $height += ($options[3]) ? 25 : 0;

        $block['links'][$i]['height'] = $height;
        $block['links'][$i]['pic']    = $pic;
        $block['links'][$i]['url']    = $url;
        $block['links'][$i]['title']  = $title;
        $i++;
    }
    $block['height']  = $options[7];
    $block['col']     = $options[8];
    $block['cate_sn'] = $options[6];

    return $block;
}

//區塊編輯函式
function tad_link_show_edit($options)
{

    include_once XOOPS_ROOT_PATH . "/modules/tad_link/function_block.php";

    $chked1_1 = ($options[1] == "1") ? "checked" : "";
    $chked1_0 = ($options[1] == "0") ? "checked" : "";
    $chked2_1 = ($options[2] == "1") ? "checked" : "";
    $chked2_0 = ($options[2] == "0") ? "checked" : "";
    $chked3_1 = ($options[3] == "1") ? "checked" : "";
    $chked3_0 = ($options[3] == "0") ? "checked" : "";
    $chked4_1 = ($options[4] == "new") ? "checked" : "";
    $chked4_0 = ($options[4] == "rand") ? "checked" : "";
    $chked4_2 = ($options[4] == "sort") ? "checked" : "";
    $chked5_1 = ($options[5] == "1") ? "checked" : "";
    $chked5_0 = ($options[5] == "0") ? "checked" : "";
    $s12      = ($options[8] == "12") ? "selected" : "";
    $s6       = ($options[8] == "6") ? "selected" : "";
    $s4       = ($options[8] == "4") ? "selected" : "";
    $s3       = ($options[8] == "3") ? "selected" : "";
    $s2       = ($options[8] == "2") ? "selected" : "";
    $s1       = ($options[8] == "1") ? "selected" : "";
    $sno      = ($options[8] == "0") ? "selected" : "";

    $menu = block_link_cate($options[6]);

    $form = "{$menu['js']}
  " . _MB_TADLINK_SHOW_EDIT_BITEM0 . "
  <INPUT type='text' name='options[0]' value='{$options[0]}'><br>

  " . _MB_TADLINK_SHOW_EDIT_BITEM1 . "
  <INPUT type='radio' name='options[1]' value='1' $chked1_1>" . _YES . "
  <INPUT type='radio' name='options[1]' value='0' $chked1_0>" . _NO . "<br>
  " . _MB_TADLINK_SHOW_EDIT_BITEM2 . "
  <INPUT type='radio' name='options[2]' value='1' $chked2_1>" . _YES . "
  <INPUT type='radio' name='options[2]' value='0' $chked2_0>" . _NO . "<br>
  " . _MB_TADLINK_SHOW_EDIT_BITEM3 . "
  <INPUT type='radio' name='options[3]' value='1' $chked3_1>" . _YES . "
  <INPUT type='radio' name='options[3]' value='0' $chked3_0>" . _NO . "<br>
  " . _MB_TADLINK_SHOW_SORT . "
  <INPUT type='radio' name='options[4]' value='new' $chked4_1>" . _MB_TADLINK_SHOW_EDIT_BITEM4 . "
  <INPUT type='radio' name='options[4]' value='rand' $chked4_0>" . _MB_TADLINK_SHOW_EDIT_BITEM5 . "
  <INPUT type='radio' name='options[4]' value='sort' $chked4_2>" . _MB_TADLINK_SHOW_EDIT_BITEM7 . "<br>

  " . _MB_TADLINK_SHOW_EDIT_BITEM6 . "
  <INPUT type='radio' name='options[5]' value='1' $chked5_1>" . _YES . "
  <INPUT type='radio' name='options[5]' value='0' $chked5_0>" . _NO . "<br>

  " . _MB_TADLINK_TAD_CATE_MENU . "
  {$menu['form']}
  <INPUT type='hidden' name='options[6]' id='bb' value='{$options[6]}'><br>
  " . _MB_TADLINK_SHOW_HEIGHT . "
  <INPUT type='text' name='options[7]' value='{$options[7]}' size=4> px<br>

  " . _MB_TADLINK_BOOTSTRAP_COL . "
  <select name='options[8]' value='{$options[8]}'>
    <option value='0' $sno>" . _MB_TADLINK_NO_BOOTSTRAP_COL . "</option>
    <option value='12' $s12>1</option>
    <option value='6' $s6>2</option>
    <option value='4' $s4>3</option>
    <option value='3' $s3>4</option>
    <option value='2' $s2>6</option>
    <option value='1' $s1>12</option>
  </select><br>
  ";

    return $form;
}

if (!function_exists('get_show_block_pic')) {
    //顯示圖片
    function get_show_block_pic($link_sn)
    {

        $pic      = XOOPS_URL . "/uploads/tad_link/{$link_sn}.jpg";
        $pic_path = XOOPS_ROOT_PATH . "/uploads/tad_link/{$link_sn}.jpg";
        $empty    = XOOPS_URL . "/modules/tad_link/images/pic_thumb.png";

        if (file_exists($pic_path)) {
            return $pic;
        } else {
            return $empty;
        }
    }
}

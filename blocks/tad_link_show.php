<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2011-11-14
// $Id:$
// ------------------------------------------------------------------------- //

//區塊主函式 (最新好站連結(tad_link_show))
function tad_link_show($options){
  global $xoopsDB;
  if(empty($options[0]))$options[0]=10;

  if($options[4]=='new'){
    $order="order by post_date desc";
  }elseif($options[4]=='rand'){
    $order="order by rand()";
  }else{
    $order="order by link_sort";
  }

  $and_cate=empty($options[6])?"":"and cate_sn in({$options[6]})";
  $sql = "select * from ".$xoopsDB->prefix("tad_link")." where enable='1' $and_cate $order limit 0,{$options[0]}";

  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());


  $block="";
  $i=0;
  while($all=$xoopsDB->fetchArray($result)){
    //以下會產生這些變數： $link_sn , $cate_sn , $link_title , $link_url , $link_desc , $link_sort , $link_counter , $unable_date , $uid , $post_date , $enable
    foreach($all as $k=>$v){
      $$k=$v;
    }

    $val=($options[5])?$link_url:$link_sn;
    $link_js=($options[5])?"window.open('{$link_url}','_blank');":"location.href='".XOOPS_URL."/modules/tad_link/index.php?link_sn={$link_sn}'";

    $height=10;
    $thumb=get_show_block_pic($link_sn);
    $pic=($options[1])?"<img src='$thumb' onClick=\"{$link_js}\" style='cursor:pointer;margin:4px auto;width:120px;'>":"";
    $height+=($options[1])?100:5;

    $title=($options[2])?"<div style='cursor:pointer;font-size:11px;color:#0066CC;' onClick=\"{$link_js}\">$link_title</div>":"";

    $height+=($options[2])?30:0;

    $url=($options[3])?"<div style='cursor:pointer;font-size:11px;color:#006600;' onClick=\"{$link_js}\">$link_url</div>":"";

    $height+=($options[3])?25:0;

    $block['links'][$i]['height']=$height;
    $block['links'][$i]['pic']=$pic;
    $block['links'][$i]['url']=$url;
    $block['links'][$i]['title']=$title;
    $i++;
  }

  return $block;
}



//區塊編輯函式
function tad_link_show_edit($options){

  include_once XOOPS_ROOT_PATH."/modules/tad_link/function_block.php";

  $chked1_1=($options[1]=="1")?"checked":"";
  $chked1_0=($options[1]=="0")?"checked":"";
  $chked2_1=($options[2]=="1")?"checked":"";
  $chked2_0=($options[2]=="0")?"checked":"";
  $chked3_1=($options[3]=="1")?"checked":"";
  $chked3_0=($options[3]=="0")?"checked":"";
  $chked4_1=($options[4]=="new")?"checked":"";
  $chked4_0=($options[4]=="rand")?"checked":"";
  $chked4_2=($options[4]=="sort")?"checked":"";
  $chked5_1=($options[5]=="1")?"checked":"";
  $chked5_0=($options[5]=="0")?"checked":"";

  $menu=block_link_cate($options[6]);

  $form="{$menu['js']}
  "._MB_TADLINK_SHOW_EDIT_BITEM0."
  <INPUT type='text' name='options[0]' value='{$options[0]}'><br>

  "._MB_TADLINK_SHOW_EDIT_BITEM1."
  <INPUT type='radio' name='options[1]' value='1' $chked1_1>"._YES."
  <INPUT type='radio' name='options[1]' value='0' $chked1_0>"._NO."<br>
  "._MB_TADLINK_SHOW_EDIT_BITEM2."
  <INPUT type='radio' name='options[2]' value='1' $chked2_1>"._YES."
  <INPUT type='radio' name='options[2]' value='0' $chked2_0>"._NO."<br>
  "._MB_TADLINK_SHOW_EDIT_BITEM3."
  <INPUT type='radio' name='options[3]' value='1' $chked3_1>"._YES."
  <INPUT type='radio' name='options[3]' value='0' $chked3_0>"._NO."<br>

  <INPUT type='radio' name='options[4]' value='new' $chked4_1>"._MB_TADLINK_SHOW_EDIT_BITEM4."
  <INPUT type='radio' name='options[4]' value='rand' $chked4_0>"._MB_TADLINK_SHOW_EDIT_BITEM5."<br>
  <INPUT type='radio' name='options[4]' value='sort' $chked4_2>"._MB_TADLINK_SHOW_EDIT_BITEM7."<br>

  "._MB_TADLINK_SHOW_EDIT_BITEM6."
  <INPUT type='radio' name='options[5]' value='1' $chked5_1>"._YES."
  <INPUT type='radio' name='options[5]' value='0' $chked5_0>"._NO."<br>

  "._MB_TADLINK_TAD_CATE_MENU."
  {$menu['form']}
  <INPUT type='hidden' name='options[6]' id='bb' value='{$options[2]}'>
  ";
  return $form;
}

if(!function_exists('get_show_block_pic')){
  //顯示圖片
  function get_show_block_pic($link_sn){

    $pic=XOOPS_URL."/uploads/tad_link/thumbs/{$link_sn}.jpg";
    $pic_path=XOOPS_ROOT_PATH."/uploads/tad_link/thumbs/{$link_sn}.jpg";
    $empty=XOOPS_URL."/modules/tad_link/images/pic_thumb.png";

    if(file_exists($pic_path)){
      return $pic;
    }else{
      return $empty;
    }
  }
}
?>
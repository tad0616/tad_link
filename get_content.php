<?php
include_once "header.php";
$link_sn=(empty($_REQUEST['link_sn']))?"":intval($_REQUEST['link_sn']);
$op=(empty($_POST['op']))?"":$_POST['op'];

$all=get_tad_link($link_sn);
foreach($all as $k=>$v){
  $$k=$v;
}

add_tad_link_counter($link_sn);

$cate=get_tad_link_cate_all();
	
if($op=='hide'){
  $main=mk_content($link_sn,$xoopsModuleConfig['show_mode'],$link_title,$link_url,$cate_sn,$cate[$cate_sn]['cate_title'],$link_desc,$link_counter);
}elseif($op=='show'){
  $main=mk_big_content($link_sn,$xoopsModuleConfig['show_mode'],$link_title,$link_url,$cate_sn,$cate[$cate_sn]['cate_title'],$link_desc,$link_counter);
}elseif($op=='light'){

  $width=empty($xoopsModuleConfig['pic_width'])?400:$xoopsModuleConfig['pic_width'];
  $width_div=$width+250;
  
  $main="<table style='width:{$width_div}px;'>";
  $main.=mk_big_content($link_sn,'light',$link_title,$link_url,$cate_sn,$cate[$cate_sn]['cate_title'],$link_desc,$link_counter);
  $main.="</table>";
}
die($main);

?>

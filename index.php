<?php
/*-----------引入檔案區--------------*/
include "header.php";
$xoopsOption['template_main'] = "tad_link_index_tpl.html";
include_once XOOPS_ROOT_PATH."/header.php";


/*-----------function區--------------*/


//列出所有tad_link資料
function list_tad_link($show_cate_sn='',$mode=''){
  global $xoopsDB,$xoopsModule,$xoopsModuleConfig,$xoopsTpl,$isAdmin;

  $show_num=empty($xoopsModuleConfig['show_num'])?10:$xoopsModuleConfig['show_num'];
  $cate=get_tad_link_cate_all();

  $and_cate=empty($show_cate_sn)?"order by post_date desc":"and cate_sn='$show_cate_sn' order by link_sort";

  //今天日期
  $today=date("Y-m-d");
  $sql = "select * from ".$xoopsDB->prefix("tad_link")." where enable='1' and (unable_date='0000-00-00' or unable_date >='$today')  $and_cate";

  if($mode!='batch'){
    //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    $PageBar=getPageBar($sql,$show_num,10);
    $bar=$PageBar['bar'];
    $sql=$PageBar['sql'];
    $total=$PageBar['total'];
  }

  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());


  $all_content="";
  $i=0;
  while($all=$xoopsDB->fetchArray($result)){
    //以下會產生這些變數： $link_sn , $cate_sn , $link_title , $link_url , $link_desc , $link_sort , $link_counter , $unable_date , $uid , $post_date , $enable
    foreach($all as $k=>$v){
      $$k=$v;
    }
    //避免截掉半個中文字
    //$link_desc=nl2br(xoops_substr(strip_tags($link_desc), 0, 90));
    $thumb=get_show_pic($link_sn);
    $pic=get_show_pic($link_sn,'big');

    $all_content[$i]['link_sn']=$link_sn;
    $all_content[$i]['pic']=$pic;
    $all_content[$i]['thumb']=$thumb;
    $all_content[$i]['cate_sn']=$cate_sn;
    $all_content[$i]['cate_title']=empty($cate_sn)?"":$cate[$cate_sn]['cate_title'];
    $all_content[$i]['link_title']=$link_title;
    $all_content[$i]['link_url']=$link_url;
    $all_content[$i]['link_desc']=$link_desc;
    $all_content[$i]['link_counter']=$link_counter;
    $i++;
  }


  if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
   redirect_header("index.php",3, _MA_NEED_TADTOOLS);
  }
  include_once TADTOOLS_PATH."/formValidator.php";
  $formValidator= new formValidator("#myForm",true);
  $formValidator_code=$formValidator->render();


  $xoopsTpl->assign('formValidator_code',$formValidator_code);
  $xoopsTpl->assign('get_tad_link_cate_options',get_tad_link_cate_options('','show',$show_cate_sn));
  $xoopsTpl->assign('all_content',$all_content);
  $xoopsTpl->assign('bar',$bar);
  $xoopsTpl->assign('isAdmin',$isAdmin);

  $xoopsTpl->assign("next_op","insert_tad_link");
  $xoopsTpl->assign("pic","images/pic_thumb.png");
  $xoopsTpl->assign('show_cate_sn',$show_cate_sn);

  $xoopsTpl->assign("count",++$i);
}



//以流水號秀出某筆tad_link資料內容
function show_one_tad_link($link_sn=""){
  global $xoopsDB,$xoopsModule,$xoopsModuleConfig,$xoopsTpl,$isAdmin;

  $push_url=$facebook_comments='';
  $push_url=push_url($xoopsModuleConfig['use_social_tools']);
  $facebook_comments=facebook_comments($xoopsModuleConfig['facebook_comments_width'],'tad_link','index.php','link_sn',$link_sn);


  $width=empty($xoopsModuleConfig['pic_width'])?400:$xoopsModuleConfig['pic_width'];
  $width_div=$width+10;

  if(empty($link_title) and empty($link_url)){
    $all=get_tad_link($link_sn);
    foreach($all as $k=>$v){
      $$k=$v;
    }
    $cate=get_tad_link_cate_all();
    $cate_title=$cate[$cate_sn]['cate_title'];
  }

  $link_desc=nl2br($link_desc);


  $pic=get_show_pic($link_sn,'big');


  $xoopsTpl->assign('link_url',$link_url);
  $xoopsTpl->assign('link_title',$link_title);
  $xoopsTpl->assign('cate_title',$cate_title);
  $xoopsTpl->assign('isAdmin',$isAdmin);
  $xoopsTpl->assign('pic',$pic);
  $xoopsTpl->assign('link_desc',$link_desc);
  $xoopsTpl->assign('link_sn',$link_sn);
  $xoopsTpl->assign('cate_sn',$cate_sn);
  $xoopsTpl->assign('link_counter',$link_counter);
  $xoopsTpl->assign("facebook_comments",$facebook_comments);
  $xoopsTpl->assign("push_url",$push_url);
  $xoopsTpl->assign("op","show_one_tad_link");

  //計數器欄位值 +1
  //add_tad_link_counter($link_sn);

}


//新增資料到tad_link_cate中
function new_tad_link_cate($of_cate_sn='',$cate_title=''){
  global $xoopsDB,$xoopsUser,$isAdmin;
  if(!$isAdmin)return;

  $myts =& MyTextSanitizer::getInstance();
  $cate_title=$myts->addSlashes($cate_title);
  $cate_sort=tad_link_cate_max_sort($of_cate_sn);

  $sql = "insert into ".$xoopsDB->prefix("tad_link_cate")."
  (`of_cate_sn` , `cate_title` , `cate_sort`)
  values('{$of_cate_sn}' , '{$cate_title}' , '{$cate_sort}')";
  $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  //取得最後新增資料的流水編號
  $cate_sn=$xoopsDB->getInsertId();
  return $cate_sn;
}



//新增資料到tad_link中
function insert_tad_link(){
  global $xoopsDB,$xoopsUser,$isAdmin;
  if(!$isAdmin)return;

  if(!empty($_POST['new_cate'])){
    $cate_sn=new_tad_link_cate($_POST['cate_sn'],$_POST['new_cate']);
  }else{
    $cate_sn=intval($_POST['cate_sn']);
  }

  //取得使用者編號
  $uid=($xoopsUser)?$xoopsUser->getVar('uid'):"";

  $myts =& MyTextSanitizer::getInstance();
  $_POST['link_title']=$myts->addSlashes($_POST['link_title']);
  $_POST['link_url']=$myts->addSlashes($_POST['link_url']);
  $_POST['link_desc']=$myts->addSlashes($_POST['link_desc']);

  $link_sort=tad_link_max_sort();

  //$now=date("Y-m-d H:i:s",xoops_getUserTimestamp(time()));

  $sql = "insert into ".$xoopsDB->prefix("tad_link")."
  (`cate_sn` , `link_title` , `link_url` , `link_desc` , `link_sort` , `link_counter` , `unable_date` , `uid` , `post_date` , `enable`)
  values('{$cate_sn}' , '{$_POST['link_title']}' , '{$_POST['link_url']}' , '{$_POST['link_desc']}' , '{$link_sort}' , 0 , '{$_POST['unable_date']}' , '{$uid}' , now() , '{$_POST['enable']}')";
  $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  //取得最後新增資料的流水編號
  $link_sn=$xoopsDB->getInsertId();

  get_pic($link_sn);
  return $link_sn;
}


//自動取得tad_link的最新排序
function tad_link_max_sort(){
  global $xoopsDB;
  $sql = "select max(`link_sort`) from ".$xoopsDB->prefix("tad_link");
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
  list($sort)=$xoopsDB->fetchRow($result);
  return ++$sort;
}


//更新tad_link某一筆資料
function update_tad_link($link_sn=""){
  global $xoopsDB,$xoopsUser,$isAdmin;
  if(!$isAdmin)return;

  //取得使用者編號
  $uid=($xoopsUser)?$xoopsUser->getVar('uid'):"";

  $myts =& MyTextSanitizer::getInstance();
  $_POST['link_title']=$myts->addSlashes($_POST['link_title']);
  $_POST['link_url']=$myts->addSlashes($_POST['link_url']);
  $_POST['link_desc']=$myts->addSlashes($_POST['link_desc']);

  //$link_sort=tad_link_max_sort();

  //$now=date("Y-m-d H:i:s",xoops_getUserTimestamp(time()));

  $sql = "update ".$xoopsDB->prefix("tad_link")." set
   `cate_sn` = '{$_POST['cate_sn']}' ,
   `link_title` = '{$_POST['link_title']}' ,
   `link_url` = '{$_POST['link_url']}' ,
   `link_desc` = '{$_POST['link_desc']}' ,
   `unable_date` = '{$_POST['unable_date']}' ,
   `uid` = '{$uid}' ,
   `post_date` =now()
  where link_sn='$link_sn'";

  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  get_pic($link_sn);

  return $link_sn;
}


//刪除tad_link某筆資料資料
function delete_tad_link($link_sn=""){
  global $xoopsDB,$isAdmin;
  if(!$isAdmin)return;
  $sql = "delete from ".$xoopsDB->prefix("tad_link")." where link_sn='$link_sn'";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}

//批次刪除tad_link某筆資料資料
function delete_all_link($all_sn=""){
  global $xoopsDB,$isAdmin;
  if(!$isAdmin)return;
  $sql = "delete from ".$xoopsDB->prefix("tad_link")." where link_sn in($all_sn)";
  $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}

function go_url($link_sn){
  add_tad_link_counter($link_sn);
  $data=get_tad_link($link_sn);
  header("location:{$data['link_url']}");
  exit;
}

//編輯表單
function tad_link_form($link_sn="",$mode=""){
  global $xoopsTpl,$isAdmin;

  $data=array();
  $next_op="insert_tad_link";
  $pic="images/pic_thumb.png";

  if(!empty($link_sn)){
    $data=get_tad_link($link_sn);
    $next_op="update_tad_link";
    $pic=get_show_pic($link_sn);
  }

  if($data['unable_date']=="0000-00-00")$data['unable_date']="";

  $xoopsTpl->assign('get_tad_link_cate_options',get_tad_link_cate_options('','show',$data['cate_sn']));
  $xoopsTpl->assign("op","tad_link_form");
  $xoopsTpl->assign("next_op",$next_op);
  $xoopsTpl->assign("pic",$pic);
  $xoopsTpl->assign("link_sn",$data['link_sn']);
  $xoopsTpl->assign("link_title",$data['link_title']);
  $xoopsTpl->assign("link_url",$data['link_url']);
  $xoopsTpl->assign("link_desc",$data['link_desc']);
  $xoopsTpl->assign("unable_date",$data['unable_date']);
  $xoopsTpl->assign("mode",$mode);
}

/*-----------執行動作判斷區----------*/
$op=(empty($_REQUEST['op']))?"":$_REQUEST['op'];
$mode=(empty($_REQUEST['mode']))?"":$_REQUEST['mode'];
$all_sn=(empty($_REQUEST['all_sn']))?"":$_REQUEST['all_sn'];
$cate_sn=(empty($_REQUEST['cate_sn']))?"":intval($_REQUEST['cate_sn']);
$link_sn=(empty($_REQUEST['link_sn']))?"":intval($_REQUEST['link_sn']);

$xoopsTpl->assign( "toolbar" , toolbar_bootstrap($interface_menu)) ;
$xoopsTpl->assign( "bootstrap" , get_bootstrap()) ;
$xoopsTpl->assign( "jquery" , get_jquery(true)) ;
$xoopsTpl->assign("isAdmin",$isAdmin);


switch($op){

  //新增資料
  case "insert_tad_link":
  $link_sn=insert_tad_link();
  header("location: {$_SERVER['PHP_SELF']}?op=$mode&cate_sn=$cate_sn");
  break;

  //更新資料
  case "update_tad_link":
  update_tad_link($link_sn);
  header("location: {$_SERVER['PHP_SELF']}?op=$mode&cate_sn=$cate_sn");
  break;

  //重新抓圖
  case "get_pic":
  get_pic($link_sn);
  header("location: {$_SERVER['PHP_SELF']}");
  break;

  //刪除資料
  case "delete_tad_link":
  delete_tad_link($link_sn);
  header("location: {$_SERVER['PHP_SELF']}?op=$mode&cate_sn=$cate_sn");
  break;

  //批次刪除資料
  case "delete_all_link":
  delete_all_link($all_sn);
  header("location: {$_SERVER['PHP_SELF']}?op=$mode&cate_sn=$cate_sn");
  break;

  case "go":
  go_url($link_sn);
  break;

  case "tad_link_form":
  tad_link_form($link_sn,$mode);
  break;

  case "batch":
  list_tad_link($cate_sn,'batch');
  $xoopsTpl->assign("op","batch");
  break;


  //預設動作
  default:
  if(empty($link_sn)){
    list_tad_link($cate_sn);
  }else{
    show_one_tad_link($link_sn);
  }
  break;

}

/*-----------秀出結果區--------------*/
include_once XOOPS_ROOT_PATH.'/footer.php';
?>
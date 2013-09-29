<?php
//  ------------------------------------------------------------------------ //
// 本模組由 tad 製作
// 製作日期：2011-11-14
// $Id:$
// ------------------------------------------------------------------------- //

/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_link_adm_main.html";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/
//tad_link_cate編輯表單
function tad_link_cate_form($cate_sn=""){
	global $xoopsDB,$xoopsUser,$xoopsTpl;

	//抓取預設值
	if(!empty($cate_sn)){
		$DBV=get_tad_link_cate($cate_sn);
	}else{
		$DBV=array();
	}

	//預設值設定


	//設定「cate_sn」欄位預設值
	$cate_sn=(!isset($DBV['cate_sn']))?"":$DBV['cate_sn'];

	//設定「of_cate_sn」欄位預設值
	$of_cate_sn=(!isset($DBV['of_cate_sn']))?"":$DBV['of_cate_sn'];

	//設定「cate_title」欄位預設值
	$cate_title=(!isset($DBV['cate_title']))?"":$DBV['cate_title'];

	//設定「cate_sort」欄位預設值
	$cate_sort=(!isset($DBV['cate_sort']))?tad_link_cate_max_sort():$DBV['cate_sort'];

	$op=(empty($cate_sn))?"insert_tad_link_cate":"update_tad_link_cate";
	//$op="replace_tad_link_cate";

	if(!file_exists(TADTOOLS_PATH."/formValidator.php")){
   redirect_header("index.php",3, _MA_NEED_TADTOOLS);
  }
  include_once TADTOOLS_PATH."/formValidator.php";
  $formValidator= new formValidator("#myForm",true);
  $formValidator_code=$formValidator->render();


	$xoopsTpl->assign('op','tad_link_cate_form');
	$xoopsTpl->assign('next_op',$op);
	$xoopsTpl->assign('cate_sn',$cate_sn);
	$xoopsTpl->assign('cate_sort',$cate_sort);
	$xoopsTpl->assign('cate_title',$cate_title);
	$xoopsTpl->assign('get_tad_link_cate_options',get_tad_link_cate_options('none','edit',$cate_sn,$of_cate_sn));
	$xoopsTpl->assign('formValidator_code',$formValidator_code);
}


//新增資料到tad_link_cate中
function insert_tad_link_cate(){
	global $xoopsDB,$xoopsUser;

	$myts =& MyTextSanitizer::getInstance();
	$_POST['cate_title']=$myts->addSlashes($_POST['cate_title']);


	$sql = "insert into ".$xoopsDB->prefix("tad_link_cate")."
	(`of_cate_sn` , `cate_title` , `cate_sort`)
	values('{$_POST['of_cate_sn']}' , '{$_POST['cate_title']}' , '{$_POST['cate_sort']}')";
	$xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

	//取得最後新增資料的流水編號
	$cate_sn=$xoopsDB->getInsertId();
	return $cate_sn;
}


//更新tad_link_cate某一筆資料
function update_tad_link_cate($cate_sn=""){
	global $xoopsDB,$xoopsUser;


	$myts =& MyTextSanitizer::getInstance();
	$_POST['cate_title']=$myts->addSlashes($_POST['cate_title']);


	$sql = "update ".$xoopsDB->prefix("tad_link_cate")." set
	 `of_cate_sn` = '{$_POST['of_cate_sn']}' ,
	 `cate_title` = '{$_POST['cate_title']}' ,
	 `cate_sort` = '{$_POST['cate_sort']}'
	where cate_sn='$cate_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	return $cate_sn;
}

//取得tad_link_cate無窮分類列表
function list_tad_link_cate_loop($show_function=1,$of_cate_sn=0,$i=0,$level=0){
	global $xoopsDB,$xoopsModule,$xoopsTpl;

	$sql = "select * from ".$xoopsDB->prefix("tad_link_cate")." where `of_cate_sn` = '{$of_cate_sn}' order by cate_sort";
	//echo "<p>$sql</p>";
  $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());

  $count=tad_link_cate_count();
  $level++;
	$data="";
	$i=0;
	while($all=$xoopsDB->fetchArray($result)){
	  //以下會產生這些變數： $cate_sn , $of_cate_sn , $cate_title , $cate_sort
    foreach($all as $k=>$v){
      $$k=$v;
    }

		$data[$i]['cate_sn']=$cate_sn;
		$data[$i]['cate_title']=$cate_title;
		$data[$i]['cate_sort']=$cate_sort;
		$data[$i]['level']=$level;
		$off=$level-1;
		$data[$i]['offset']=($level==0)?"":"offset{$off}";
		$data[$i]['count']=empty($cate_sn) or empty($count[$cate_sn])?"":sprintf(_MA_TADLINK_CATE_COUNT , $count[$cate_sn]);

    //echo "<p>\$data[$i]['$cate_sn']={$cate_title} offset{$off}</p>";
		$i++;

		$new_data=list_tad_link_cate_loop($show_function,$cate_sn,$i,$level);
		if(!empty($new_data['data'])){
      $data=array_merge($data,$new_data['data']);
      $i=$new_data['i'];
    }
	}


	if($of_cate_sn!='0'){
    //echo "<p>return \$data[$i]['$cate_sn']={$cate_title}</p>";
    $all['data']=$data;
    $all['i']=$i;
		return $all;
	}else{
    //echo "<p>assign \$data[$i]['$cate_sn']={$cate_title}</p>";
		$xoopsTpl->assign('data' , $data);
    $xoopsTpl->assign('jquery' , get_jquery(true));
	}
}



//以流水號取得某筆tad_link_cate資料
function get_tad_link_cate($cate_sn=""){
	global $xoopsDB;
	if(empty($cate_sn))return;
	$sql = "select * from ".$xoopsDB->prefix("tad_link_cate")." where cate_sn='$cate_sn'";
	$result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	$data=$xoopsDB->fetchArray($result);
	return $data;
}

//刪除tad_link_cate某筆資料資料
function delete_tad_link_cate($cate_sn=""){
	global $xoopsDB;
	//先刪除底下所有連結
	$sql = "delete from ".$xoopsDB->prefix("tad_link")." where cate_sn='$cate_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
	
	
	$sql = "delete from ".$xoopsDB->prefix("tad_link_cate")." where cate_sn='$cate_sn'";
	$xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'],3, mysql_error());
}



/*-----------執行動作判斷區----------*/
$op = (!isset($_REQUEST['op']))? "":$_REQUEST['op'];
$cate_sn=(empty($_REQUEST['cate_sn']))?"":intval($_REQUEST['cate_sn']);
$link_sn=(empty($_REQUEST['link_sn']))?"":intval($_REQUEST['link_sn']);

switch($op){
	/*---判斷動作請貼在下方---*/
  //替換資料
  case "replace_tad_link_cate":
  replace_tad_link_cate();
  header("location: {$_SERVER['PHP_SELF']}");
  break;

  //新增資料
  case "insert_tad_link_cate":
  $cate_sn=insert_tad_link_cate();
  header("location: {$_SERVER['PHP_SELF']}");
  break;

  //更新資料
  case "update_tad_link_cate":
  update_tad_link_cate($cate_sn);
  header("location: {$_SERVER['PHP_SELF']}");
  break;
  //輸入表格
  case "tad_link_cate_form":
  $main=tad_link_cate_form($cate_sn);
  break;

  //刪除資料
  case "delete_tad_link_cate":
  delete_tad_link_cate($cate_sn);
  header("location: {$_SERVER['PHP_SELF']}");
  break;

  //預設動作
  default:
  list_tad_link_cate_loop();
  break;


	/*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
include_once 'footer.php';

?>
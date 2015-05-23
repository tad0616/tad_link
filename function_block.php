<?php

//取得所有類別標題
if(!function_exists("block_link_cate")){
  function block_link_cate($selected=""){
  	global $xoopsDB;

  	if(!empty($selected)){
  		$sc=explode(",",$selected);
  	}

  	$js="<script>
  	function bbv(){
  	  i=0;
  	  var arr = new Array();";

  	$sql = "select cate_sn,cate_title from ".$xoopsDB->prefix("tad_link_cate")." order by of_cate_sn,cate_sort";
  	$result = $xoopsDB->query($sql);
  	$option="";
  	while(list($cate_sn,$cate_title)=$xoopsDB->fetchRow($result)){

  	  $js.="if(document.getElementById('c{$cate_sn}').checked){
  	   arr[i] = document.getElementById('c{$cate_sn}').value;
  		 i++;
  		}";
  	  $ckecked=(in_array($cate_sn,$sc))?"checked":"";
  		$option.="<span style='white-space:nowrap;'><input type='checkbox' id='c{$cate_sn}' value='{$cate_sn}' class='bbv' onChange=bbv() $ckecked><label for='c{$cate_sn}'>$cate_title</label></span> ";
  	}

  	$js.="document.getElementById('bb').value=arr.join(',');
  	}
  	</script>";

  	$main['js']=$js;
  	$main['form']=$option;
  	return $main;
  }
}


?>

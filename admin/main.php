<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_link_adm_main.html";
include_once "header.php";
include_once "../function.php";

/*-----------function區--------------*/
//tad_link_cate編輯表單
function tad_link_cate_form($cate_sn = "")
{
    global $xoopsDB, $xoopsUser, $xoopsTpl;

    //抓取預設值
    if (!empty($cate_sn)) {
        $DBV = get_tad_link_cate($cate_sn);
    } else {
        $DBV = array();
    }

    //預設值設定

    //設定「cate_sn」欄位預設值
    $cate_sn = (!isset($DBV['cate_sn'])) ? "" : $DBV['cate_sn'];

    //設定「of_cate_sn」欄位預設值
    $of_cate_sn = (!isset($DBV['of_cate_sn'])) ? "" : $DBV['of_cate_sn'];

    //設定「cate_title」欄位預設值
    $cate_title = (!isset($DBV['cate_title'])) ? "" : $DBV['cate_title'];

    //設定「cate_sort」欄位預設值
    $cate_sort = (!isset($DBV['cate_sort'])) ? tad_link_cate_max_sort() : $DBV['cate_sort'];

    $op = (empty($cate_sn)) ? "insert_tad_link_cate" : "update_tad_link_cate";
    //$op="replace_tad_link_cate";

    if (!file_exists(TADTOOLS_PATH . "/formValidator.php")) {
        redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
    }
    include_once TADTOOLS_PATH . "/formValidator.php";
    $formValidator      = new formValidator("#myForm", true);
    $formValidator_code = $formValidator->render();

    $xoopsTpl->assign('op', 'tad_link_cate_form');
    $xoopsTpl->assign('next_op', $op);
    $xoopsTpl->assign('cate_sn', $cate_sn);
    $xoopsTpl->assign('cate_sort', $cate_sort);
    $xoopsTpl->assign('cate_title', $cate_title);
    $xoopsTpl->assign('get_tad_link_cate_options', get_tad_link_cate_options('none', 'edit', $cate_sn, $of_cate_sn));
    $xoopsTpl->assign('formValidator_code', $formValidator_code);
}

//新增資料到tad_link_cate中
function insert_tad_link_cate()
{
    global $xoopsDB, $xoopsUser;

    $myts                = &MyTextSanitizer::getInstance();
    $_POST['cate_title'] = $myts->addSlashes($_POST['cate_title']);

    $sql = "insert into " . $xoopsDB->prefix("tad_link_cate") . "
    (`of_cate_sn` , `cate_title` , `cate_sort`)
    values('{$_POST['of_cate_sn']}' , '{$_POST['cate_title']}' , '{$_POST['cate_sort']}')";
    $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

    //取得最後新增資料的流水編號
    $cate_sn = $xoopsDB->getInsertId();

    return $cate_sn;
}

//更新tad_link_cate某一筆資料
function update_tad_link_cate($cate_sn = "")
{
    global $xoopsDB, $xoopsUser;

    $myts                = &MyTextSanitizer::getInstance();
    $_POST['cate_title'] = $myts->addSlashes($_POST['cate_title']);

    $sql = "update " . $xoopsDB->prefix("tad_link_cate") . " set
     `of_cate_sn` = '{$_POST['of_cate_sn']}' ,
     `cate_title` = '{$_POST['cate_title']}' ,
     `cate_sort` = '{$_POST['cate_sort']}'
    where cate_sn='$cate_sn'";
    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

    return $cate_sn;
}

//取得tad_link_cate無窮分類列表
function list_tad_link_cate($show_cate_sn = 0)
{
    global $xoopsTpl, $xoopsDB;
    $path     = get_tad_link_cate_path($show_cate_sn);
    $path_arr = array_keys($path);
    $sql      = "select cate_sn,of_cate_sn,cate_title from " . $xoopsDB->prefix("tad_link_cate") . " order by cate_sort";
    $result   = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

    $count  = tad_link_cate_count();
    $data[] = "{ id:0, pId:0, name:'All', url:'index.php', target:'_self', open:true}";
    while (list($cate_sn, $of_cate_sn, $cate_title) = $xoopsDB->fetchRow($result)) {
        $font_style      = $show_cate_sn == $cate_sn ? ", font:{'background-color':'yellow', 'color':'black'}" : '';
        $open            = in_array($cate_sn, $path_arr) ? 'true' : 'false';
        $display_counter = empty($count[$cate_sn]) ? "" : " ({$count[$cate_sn]})";
        $data[]          = "{ id:{$cate_sn}, pId:{$of_cate_sn}, name:'{$cate_title}{$display_counter}', url:'main.php?op=tad_link_cate_form&cate_sn={$cate_sn}', target:'_self', open:{$open} {$font_style}}";
    }
    $json = implode(',', $data);

    if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/ztree.php")) {
        redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/ztree.php";
    $ztree      = new ztree("link_tree", $json, "save_drag.php", "save_sort.php", "of_cate_sn", "cate_sn");
    $ztree_code = $ztree->render();
    $xoopsTpl->assign('ztree_code', $ztree_code);
}

//刪除tad_link_cate某筆資料資料
function delete_tad_link_cate($cate_sn = "")
{
    global $xoopsDB;
    //先刪除底下所有連結
    $sql = "delete from " . $xoopsDB->prefix("tad_link") . " where cate_sn='$cate_sn'";
    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

    $sql = "delete from " . $xoopsDB->prefix("tad_link_cate") . " where cate_sn='$cate_sn'";
    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op      = system_CleanVars($_REQUEST, 'op', '', 'string');
$cate_sn = system_CleanVars($_REQUEST, 'cate_sn', 0, 'int');
$link_sn = system_CleanVars($_REQUEST, 'link_sn', 0, 'int');

switch ($op) {
    /*---判斷動作請貼在下方---*/
    //替換資料
    case "replace_tad_link_cate":
        replace_tad_link_cate();
        header("location: {$_SERVER['PHP_SELF']}");
        exit;
        break;

    //新增資料
    case "insert_tad_link_cate":
        $cate_sn = insert_tad_link_cate();
        header("location: {$_SERVER['PHP_SELF']}");
        exit;
        break;

    //更新資料
    case "update_tad_link_cate":
        update_tad_link_cate($cate_sn);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;
        break;
    //輸入表格
    case "tad_link_cate_form":
        list_tad_link_cate($cate_sn);
        tad_link_cate_form($cate_sn);
        break;

    //刪除資料
    case "delete_tad_link_cate":
        delete_tad_link_cate($cate_sn);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;
        break;

    //預設動作
    default:
        list_tad_link_cate();
        break;

    /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
include_once 'footer.php';

<?php
/*-----------引入檔案區--------------*/
$xoopsOption['template_main'] = "tad_link_adm_main.tpl";
include_once "header.php";
include_once "../function.php";
$isAdmin = true;
/*-----------function區--------------*/
//列出所有tad_link資料
function list_tad_link($cate_sn = "")
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig, $xoopsTpl, $g2p;

    // $cate_select = cate_select($cate_sn);
    // $xoopsTpl->assign('cate_select', $cate_select);

    $cate = get_tad_link_cate($cate_sn);

    $where_cate_sn = !empty($cate_sn) ? "where a.cate_sn='{$cate_sn}' order by a.link_sort, a.post_date desc" : "order by a.link_sort, a.post_date desc";

    $sql = "select a.*, b.cate_title from " . $xoopsDB->prefix("tad_link") . " as a left join " . $xoopsDB->prefix("tad_link_cate") . " as b on a.cate_sn=b.cate_sn {$where_cate_sn} ";
    //getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
    $PageBar = getPageBar($sql, 10, 10);
    $bar     = $PageBar['bar'];
    $sql     = $PageBar['sql'];
    $total   = $PageBar['total'];
    $result  = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);

    $i = 0;

    $data = array();
    while ($all = $xoopsDB->fetchArray($result)) {

        $data[$i] = $all;

        $i++;
    }
    get_jquery(true);

    $xoopsTpl->assign('cate_sn', $cate_sn);
    $xoopsTpl->assign('data', $data);
    $xoopsTpl->assign('cate', $cate);
    $xoopsTpl->assign('bar', $bar);
    if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php")) {
        redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/sweet_alert.php";
    $sweet_alert = new sweet_alert();
    $sweet_alert->render("delete_tad_link_cate_func", "main.php?op=delete_tad_link_cate&cate_sn=", 'cate_sn');
    $sweet_alert2 = new sweet_alert();
    $sweet_alert2->render("delete_tad_link_func", "main.php?op=delete_tad_link&cate_sn=$cate_sn&g2p=$g2p&link_sn=", 'link_sn');
}

//列出所有tad_link_cate資料
function list_tad_link_cate_tree($def_cate_sn = "")
{
    global $xoopsDB, $xoopsTpl;

    $sql    = "SELECT count(*),cate_sn FROM " . $xoopsDB->prefix("tad_link") . " GROUP BY cate_sn";
    $result = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);
    while (list($count, $cate_sn) = $xoopsDB->fetchRow($result)) {
        $cate_count[$cate_sn] = $count;
    }

    $path     = get_tad_link_cate_path($def_cate_sn);
    $path_arr = array_keys($path);
    $data[]   = "{ id:0, pId:0, name:'All', url:'main.php', target:'_self', open:true}";

    $sql    = "SELECT cate_sn,of_cate_sn,cate_title FROM " . $xoopsDB->prefix("tad_link_cate") . " ORDER BY cate_sort";
    $result = $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);
    while (list($cate_sn, $of_cate_sn, $cate_title) = $xoopsDB->fetchRow($result)) {
        $font_style      = $def_cate_sn == $cate_sn ? ", font:{'background-color':'yellow', 'color':'black'}" : '';
        $open            = in_array($cate_sn, $path_arr) ? 'true' : 'false';
        $display_counter = empty($cate_count[$cate_sn]) ? "" : " ({$cate_count[$cate_sn]})";
        $data[]          = "{ id:{$cate_sn}, pId:{$of_cate_sn}, name:'{$cate_title}{$display_counter}', url:'main.php?cate_sn={$cate_sn}', open: {$open} ,target:'_self' {$font_style}}";
    }

    $json = implode(",\n", $data);
    $cate_count = array();

    if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/ztree.php")) {
        redirect_header("index.php", 3, _MA_NEED_TADTOOLS);
    }
    include_once XOOPS_ROOT_PATH . "/modules/tadtools/ztree.php";
    $ztree      = new ztree("cate_tree", $json, "save_drag.php", "save_sort.php", "of_cate_sn", "cate_sn");
    $ztree_code = $ztree->render();
    $xoopsTpl->assign('ztree_code', $ztree_code);
    $xoopsTpl->assign('cate_count', $cate_count);

    return $data;
}

//tad_link_cate編輯表單
function tad_link_cate_form($cate_sn = "")
{
    global $xoopsDB, $xoopsUser, $xoopsTpl, $xoopsModule;
    include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

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

    $mod_id             = $xoopsModule->getVar('mid');
    $moduleperm_handler = xoops_getHandler('groupperm');
    $tad_link_post      = $moduleperm_handler->getGroupIds("tad_link_post", $cate_sn, $mod_id);

    $op = (empty($cate_sn)) ? "insert_tad_link_cate" : "update_tad_link_cate";

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

    //可上傳群組
    $SelectGroup_name = new XoopsFormSelectGroup("tad_link_post", "tad_link_post", true, $tad_link_post, 6, true);
    $SelectGroup_name->setExtra("class='form-control' id='tad_link_post'");
    $enable_post_group = $SelectGroup_name->render();
    $xoopsTpl->assign('enable_post_group', $enable_post_group);

}

//新增資料到tad_link_cate中
function insert_tad_link_cate()
{
    global $xoopsDB, $xoopsUser;

    $myts       = MyTextSanitizer::getInstance();
    $cate_title = $myts->addSlashes($_POST['cate_title']);
    $of_cate_sn = (int)$_POST['of_cate_sn'];
    $cate_sort  = (int)$_POST['cate_sort'];

    $sql = "insert into " . $xoopsDB->prefix("tad_link_cate") . "
    (`of_cate_sn` , `cate_title` , `cate_sort`)
    values('{$of_cate_sn}' , '{$cate_title}' , '{$cate_sort}')";
    $xoopsDB->query($sql) or web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $cate_sn = $xoopsDB->getInsertId();

    //有上層目錄，新增目錄時，而且在前台時($is_back=0) , 依上層權限
    // if ($of_cate_sn) {
    //     $catalog_up = getItem_Permissions($of_cate_sn, 'tad_link_post');
    // }
    //寫入權限
    saveItem_Permissions($_POST['tad_link_post'], $cate_sn, 'tad_link_post');
    return $cate_sn;
}

//更新tad_link_cate某一筆資料
function update_tad_link_cate($cate_sn = "")
{
    global $xoopsDB, $xoopsUser;

    $myts       = MyTextSanitizer::getInstance();
    $cate_title = $myts->addSlashes($_POST['cate_title']);
    $of_cate_sn = (int)$_POST['of_cate_sn'];
    $cate_sort  = (int)$_POST['cate_sort'];

    $sql = "update " . $xoopsDB->prefix("tad_link_cate") . " set
     `of_cate_sn` = '{$of_cate_sn}' ,
     `cate_title` = '{$cate_title}' ,
     `cate_sort` = '{$cate_sort}'
    where cate_sn='$cate_sn'";
    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);

    //有上層目錄，新增目錄時，而且在前台時($is_back=0) , 依上層權限
    // if ($of_cate_sn) {
    //     $catalog_up = getItem_Permissions($of_cate_sn, 'tad_link_post');
    // }
    //寫入權限
    saveItem_Permissions($_POST['tad_link_post'], $cate_sn, 'tad_link_post');
    return $cate_sn;
}

//取得tad_link_cate無窮分類列表

//刪除tad_link_cate某筆資料資料
function delete_tad_link_cate($cate_sn = "")
{
    global $xoopsDB;
    //先刪除底下所有連結
    $sql = "delete from " . $xoopsDB->prefix("tad_link") . " where cate_sn='$cate_sn'";
    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);

    $sql = "delete from " . $xoopsDB->prefix("tad_link_cate") . " where cate_sn='$cate_sn'";
    $xoopsDB->queryF($sql) or web_error($sql, __FILE__, __LINE__);
}

/*-----------執行動作判斷區----------*/
include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op      = system_CleanVars($_REQUEST, 'op', '', 'string');
$cate_sn = system_CleanVars($_REQUEST, 'cate_sn', 0, 'int');
$link_sn = system_CleanVars($_REQUEST, 'link_sn', 0, 'int');
$g2p     = system_CleanVars($_REQUEST, 'g2p', 1, 'int');

switch ($op) {
    /*---判斷動作請貼在下方---*/

    //新增資料
    case "insert_tad_link_cate":
        $cate_sn = insert_tad_link_cate();
        header("location: {$_SERVER['PHP_SELF']}?cate_sn=$cate_sn");
        exit;
        break;

    //更新資料
    case "update_tad_link_cate":
        update_tad_link_cate($cate_sn);
        header("location: {$_SERVER['PHP_SELF']}?cate_sn=$cate_sn");
        exit;
        break;
    //輸入表格
    case "tad_link_cate_form":
        list_tad_link_cate_tree($cate_sn);
        tad_link_cate_form($cate_sn);
        break;

    //刪除資料
    case "delete_tad_link_cate":
        delete_tad_link_cate($cate_sn);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //刪除資料
    case "delete_tad_link":
        delete_tad_link($link_sn);
        header("location: {$_SERVER['PHP_SELF']}?cate_sn=$cate_sn&g2p=$g2p");
        exit;

    //預設動作
    default:
        list_tad_link_cate_tree($cate_sn);
        list_tad_link($cate_sn);
        break;

        /*---判斷動作請貼在上方---*/
}

/*-----------秀出結果區--------------*/
include_once 'footer.php';

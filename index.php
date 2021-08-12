<?php
use Xmf\Request;
use XoopsModules\Tadtools\FancyBox;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tadtools\Ztree;
/*-----------引入檔案區--------------*/
require __DIR__ . '/header.php';
$xoopsOption['template_main'] = 'tad_link_index.tpl';
require_once XOOPS_ROOT_PATH . '/header.php';

$now_uid = $xoopsUser ? $xoopsUser->uid() : 0;
/*-----------function區--------------*/

//列出所有tad_link資料
function list_tad_link($show_cate_sn = '', $mode = '')
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig, $xoopsTpl, $xoopsUser, $now_uid;

    //判斷某人在哪些類別中有發表(post)的權利
    $post_cate_arr = chk_cate_power('tad_link_post');
    $xoopsTpl->assign('post_cate_arr', $post_cate_arr);
    // die(var_export($post_cate_arr));
    $show_num = empty($xoopsModuleConfig['show_num']) ? 10 : $xoopsModuleConfig['show_num'];
    $cate = get_tad_link_cate_all();

    $and_cate = empty($show_cate_sn) ? 'order by post_date desc' : "and cate_sn='$show_cate_sn' order by link_sort";

    //今天日期
    $today = date('Y-m-d');
    $now = time();

    $and_unable = ('batch' === $mode) ? '' : "and (unable_date='0000-00-00' or unable_date >='$today')";
    $sql = 'select * from ' . $xoopsDB->prefix('tad_link') . " where enable='1' $and_unable  $and_cate";
    $bar = '';
    if ('batch' !== $mode) {
        //Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        $PageBar = Utility::getPageBar($sql, $show_num, 10);
        $bar = $PageBar['bar'];
        $sql = $PageBar['sql'];
        $total = $PageBar['total'];
    }

    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $all_content = [];
    $i = 0;
    $myts = MyTextSanitizer::getInstance();
    while (false !== ($all = $xoopsDB->fetchArray($result))) {
        //以下會產生這些變數： $link_sn , $cate_sn , $link_title , $link_url , $link_desc , $link_sort , $link_counter , $unable_date , $uid , $post_date , $enable
        foreach ($all as $k => $v) {
            $$k = $v;
        }
        //避免截掉半個中文字
        $link_desc = nl2br(xoops_substr(strip_tags($link_desc), 0, 180));

        $thumb = get_show_pic($link_sn);
        $pic = get_show_pic($link_sn, 'big');

        $unable_time = strtotime($unable_date);
        $overdue = ($now > $unable_time and '0000-00-00' != $unable_date) ? true : false;

        $link_url = $myts->htmlSpecialChars($link_url);
        $link_title = $myts->htmlSpecialChars($link_title);
        $cate_title = $myts->htmlSpecialChars($cate_title);
        $link_desc = $myts->displayTarea($link_desc, 0, 0, 0, 0, 1);

        $all_content[$i]['link_sn'] = $link_sn;
        $all_content[$i]['pic'] = $pic;
        $all_content[$i]['thumb'] = $thumb;
        $all_content[$i]['cate_sn'] = $cate_sn;
        $all_content[$i]['cate_title'] = empty($cate_sn) ? '' : $cate[$cate_sn]['cate_title'];
        $all_content[$i]['link_title'] = $link_title;
        $all_content[$i]['link_url'] = $link_url;
        $all_content[$i]['link_desc'] = $link_desc;
        $all_content[$i]['link_counter'] = $link_counter;
        $all_content[$i]['overdue'] = $overdue;
        $all_content[$i]['uid'] = $uid;
        $i++;
    }

    $FormValidator = new FormValidator('#myForm', true);
    $FormValidator->render();

    $xoopsTpl->assign('get_tad_link_cate_options', get_tad_link_cate_options('', 'show', $show_cate_sn));
    $xoopsTpl->assign('all_content', $all_content);
    $xoopsTpl->assign('bar', $bar);

    $xoopsTpl->assign('next_op', 'insert_tad_link');
    $xoopsTpl->assign('pic', 'images/pic_thumb.png');
    $xoopsTpl->assign('show_cate_sn', $show_cate_sn);
    $xoopsTpl->assign('mode', $mode);
    $xoopsTpl->assign('cate', get_tad_link_cate($show_cate_sn));

    $xoopsTpl->assign('count', ++$i);

    $FancyBox = new FancyBox('.fancybox');
    $FancyBox->render();

    $path = get_tad_link_cate_path($show_cate_sn);
    $path_arr = array_keys($path);
    $sql = 'SELECT cate_sn,of_cate_sn,cate_title FROM ' . $xoopsDB->prefix('tad_link_cate') . ' ORDER BY cate_sort';
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    $count = tad_link_cate_count();
    $data[] = "{ id:0, pId:0, name:'All', url:'index.php', target:'_self', open:true}";
    while (list($cate_sn, $of_cate_sn, $cate_title) = $xoopsDB->fetchRow($result)) {
        $font_style = $show_cate_sn == $cate_sn ? ", font:{'background-color':'yellow', 'color':'black'}" : '';
        $open = in_array($cate_sn, $path_arr) ? 'true' : 'false';
        $display_counter = empty($count[$cate_sn]) ? '' : " ({$count[$cate_sn]})";
        $data[] = "{ id:{$cate_sn}, pId:{$of_cate_sn}, name:'{$cate_title}{$display_counter}', url:'index.php?cate_sn={$cate_sn}', target:'_self', open:{$open} {$font_style}}";
    }
    $json = implode(',', $data);

    $Ztree = new Ztree('link_tree', $json, '', '', 'of_cate_sn', 'cate_sn');
    $ztree_code = $Ztree->render();
    $xoopsTpl->assign('ztree_code', $ztree_code);

    if ($_SESSION['tad_link_adm'] or $post_cate_arr) {

        $SweetAlert2 = new SweetAlert();
        $SweetAlert2->render('delete_tad_link_func', "index.php?op=delete_tad_link&mode=batch&cate_sn={$show_cate_sn}&link_sn=", 'link_sn');
    }
}

//以流水號秀出某筆tad_link資料內容
function show_one_tad_link($link_sn = '')
{
    global $xoopsDB, $xoopsModule, $xoopsModuleConfig, $xoopsTpl, $xoopsUser, $now_uid;
    $push_url = $facebook_comments = '';
    $push_url = Utility::push_url($xoopsModuleConfig['use_social_tools']);
    $facebook_comments = Utility::facebook_comments($xoopsModuleConfig['facebook_comments_width'], 'tad_link', 'index.php', 'link_sn', $link_sn);

    $width = empty($xoopsModuleConfig['pic_width']) ? 400 : $xoopsModuleConfig['pic_width'];
    $width_div = $width + 10;

    if (empty($link_title) and empty($link_url)) {
        $all = get_tad_link($link_sn);
        foreach ($all as $k => $v) {
            $$k = $v;
        }
        $cate = get_tad_link_cate_all();
        $cate_title = $cate[$cate_sn]['cate_title'];
    }

    $myts = MyTextSanitizer::getInstance();
    $link_url = $myts->htmlSpecialChars($link_url);
    $link_title = $myts->htmlSpecialChars($link_title);
    $cate_title = $myts->htmlSpecialChars($cate_title);
    $link_desc = $myts->displayTarea($link_desc, 0, 0, 0, 0, 1);

    $pic = get_show_pic($link_sn, 'big');

    $xoopsTpl->assign('link_url', $link_url);
    $xoopsTpl->assign('link_title', $link_title);
    $xoopsTpl->assign('cate_title', $cate_title);
    $xoopsTpl->assign('pic', $pic);
    $xoopsTpl->assign('link_desc', $link_desc);
    $xoopsTpl->assign('link_sn', $link_sn);
    $xoopsTpl->assign('cate_sn', $cate_sn);
    $xoopsTpl->assign('uid', $uid);
    $xoopsTpl->assign('link_counter', $link_counter);
    $xoopsTpl->assign('facebook_comments', $facebook_comments);
    $xoopsTpl->assign('push_url', $push_url);
    $xoopsTpl->assign('op', 'show_one_tad_link');

    if ($_SESSION['tad_link_adm'] or $now_uid == $uid) {
        $SweetAlert2 = new SweetAlert();
        $SweetAlert2->render('delete_tad_link_func', 'index.php?op=delete_tad_link&link_sn=', 'link_sn');
    }
}

//新增資料到tad_link_cate中
function new_tad_link_cate($of_cate_sn = 0, $cate_title = '')
{
    global $xoopsDB, $xoopsUser;

    if (!$_SESSION['tad_link_adm']) {
        return;
    }
    $of_cate_sn = (int) $of_cate_sn;
    $myts = \MyTextSanitizer::getInstance();
    $cate_title = $myts->addSlashes($cate_title);
    $cate_sort = tad_link_cate_max_sort($of_cate_sn);

    $sql = 'insert into ' . $xoopsDB->prefix('tad_link_cate') . "
    (`of_cate_sn` , `cate_title` , `cate_sort`)
    values('{$of_cate_sn}' , '{$cate_title}' , '{$cate_sort}')";
    $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $cate_sn = $xoopsDB->getInsertId();

    return $cate_sn;
}

//新增資料到tad_link中
function insert_tad_link()
{
    global $xoopsDB, $xoopsUser;
    $myts = \MyTextSanitizer::getInstance();
    $link_title = $myts->addSlashes($_POST['link_title']);
    $link_url = $myts->addSlashes($_POST['link_url']);
    $link_desc = $myts->addSlashes($_POST['link_desc']);
    $new_cate = $myts->addSlashes($_POST['new_cate']);
    $unable_date = empty($_POST['unable_date']) ? '0000-00-00' : $myts->addSlashes($_POST['unable_date']);
    $enable = (int) $_POST['enable'];
    $cate_sn = (int) $_POST['cate_sn'];

    if (!empty($new_cate)) {
        $cate_sn = new_tad_link_cate($cate_sn, $new_cate);
    }

    $post_cate_arr = chk_cate_power('tad_link_post');
    if (!$_SESSION['tad_link_adm'] and !in_array($cate_sn, $post_cate_arr)) {
        return;
    }

    //取得使用者編號
    $uid = ($xoopsUser) ? $xoopsUser->getVar('uid') : '';

    $link_sort = tad_link_max_sort();

    //$now=date("Y-m-d H:i:s",xoops_getUserTimestamp(time()));

    $sql = 'insert into ' . $xoopsDB->prefix('tad_link') . "
    (`cate_sn` , `link_title` , `link_url` , `link_desc` , `link_sort` , `link_counter` , `unable_date` , `uid` , `post_date` , `enable`)
    values('{$cate_sn}' , '{$link_title}' , '{$link_url}' , '{$link_desc}' , '{$link_sort}' , 0 , '{$unable_date}' , '{$uid}' , now() , '{$enable}')";
    $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    //取得最後新增資料的流水編號
    $link_sn = $xoopsDB->getInsertId();

    get_pic($link_sn);

    return $link_sn;
}

//自動取得tad_link的最新排序
function tad_link_max_sort()
{
    global $xoopsDB;
    $sql = 'SELECT max(`link_sort`) FROM ' . $xoopsDB->prefix('tad_link');
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    list($sort) = $xoopsDB->fetchRow($result);

    return ++$sort;
}

//更新tad_link某一筆資料
function update_tad_link($link_sn = '')
{
    global $xoopsDB, $xoopsUser;
    $myts = \MyTextSanitizer::getInstance();
    $link_title = $myts->addSlashes($_POST['link_title']);
    $link_url = $myts->addSlashes($_POST['link_url']);
    $link_desc = $myts->addSlashes($_POST['link_desc']);
    $new_cate = $myts->addSlashes($_POST['new_cate']);
    $unable_date = empty($_POST['unable_date']) ? '0000-00-00' : $myts->addSlashes($_POST['unable_date']);
    $enable = (int) $_POST['enable'];
    $cate_sn = (int) $_POST['cate_sn'];

    if (!empty($new_cate)) {
        $cate_sn = new_tad_link_cate($cate_sn, $new_cate);
    }

    $post_cate_arr = chk_cate_power('tad_link_post');
    if (!$_SESSION['tad_link_adm'] and !in_array($cate_sn, $post_cate_arr)) {
        return;
    }

    //取得使用者編號
    $uid = ($xoopsUser) ? $xoopsUser->getVar('uid') : '';

    //$link_sort=tad_link_max_sort();

    //$now=date("Y-m-d H:i:s",xoops_getUserTimestamp(time()));

    $sql = 'update ' . $xoopsDB->prefix('tad_link') . " set
    `cate_sn` = '{$cate_sn}' ,
    `link_title` = '{$link_title}' ,
    `link_url` = '{$link_url}' ,
    `link_desc` = '{$link_desc}' ,
    `unable_date` = '{$unable_date}' ,
    `uid` = '{$uid}' ,
    `post_date` =now()
    where link_sn='$link_sn'";

    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    get_pic($link_sn);

    return $link_sn;
}

//批次刪除tad_link某筆資料資料
function delete_all_link($all_sn = '')
{
    global $xoopsDB, $now_uid;

    $and_uid = $_SESSION['tad_link_adm'] ? '' : "and uid='{$now_uid}'";
    $sql = 'delete from ' . $xoopsDB->prefix('tad_link') . " where link_sn in($all_sn) {$and_uid}";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
}

function go_url($link_sn)
{
    add_tad_link_counter($link_sn);
    $data = get_tad_link($link_sn);

    $myts = MyTextSanitizer::getInstance();
    $link_url = $myts->htmlSpecialChars($link_url);
    $force_mimetype_arr = ['.pdf' => 'application/pdf', '.mp3' => 'audio/mp3', '.mp4' => 'video/mp4'];
    $force_arr = array_keys($force_mimetype_arr);
    $ext = strtolower(substr($data['link_url'], -4));
    if (in_array($ext, $force_arr)) {
        $file_display = basename($data['link_url']);
        $pos = strpos($file_display, '#');
        if ($pos !== false) {
            $pos++;
            $file_display = substr($file_display, $pos);
        }
        header('Expires: 0');
        header('Content-Type: ' . $force_mimetype_arr[$ext]);
        if (preg_match("/MSIE ([0-9]\.[0-9]{1,2})/", $_SERVER['HTTP_USER_AGENT'])) {
            header('Content-Disposition: inline; filename="' . $file_display . '"');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
        } else {
            header('Content-Disposition: attachment; filename="' . $file_display . '"');
            header('Pragma: no-cache');
        }
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($data['link_url']));

        ob_clean();
        $handle = fopen($data['link_url'], 'rb');

        set_time_limit(0);
        while (!feof($handle)) {
            echo fread($handle, 4096);
            flush();
        }
        fclose($handle);
    } else {
        header("location:{$data['link_url']}");

    }
    exit;
}

//編輯表單
function tad_link_form($link_sn = '', $mode = '')
{
    global $xoopsTpl, $xoopsModuleConfig;

    $data = [];
    $next_op = 'insert_tad_link';
    $pic = 'images/pic_thumb.png';

    if (!empty($link_sn)) {
        $data = get_tad_link($link_sn);
        $next_op = 'update_tad_link';
        $pic = get_show_pic($link_sn);
    }

    if ('0000-00-00' == $data['unable_date']) {
        $data['unable_date'] = '';
    }

    // die(var_dump($data));
    $xoopsTpl->assign('get_tad_link_cate_options', get_tad_link_cate_options('', 'show', $data['cate_sn']));
    $xoopsTpl->assign('op', 'tad_link_form');
    $xoopsTpl->assign('next_op', $next_op);
    $xoopsTpl->assign('pic', $pic);
    $xoopsTpl->assign('link_sn', $data['link_sn']);
    $xoopsTpl->assign('link_title', $data['link_title']);
    $xoopsTpl->assign('link_url', $data['link_url']);
    $xoopsTpl->assign('link_desc', $data['link_desc']);
    $xoopsTpl->assign('unable_date', $data['unable_date']);
    $xoopsTpl->assign('uid', $data['uid']);
    $xoopsTpl->assign('mode', $mode);
}

/*-----------執行動作判斷區----------*/
$op = Request::getString('op');
$mode = Request::getString('mode');
$all_sn = Request::getInt('all_sn');
$cate_sn = Request::getInt('cate_sn');
$link_sn = Request::getInt('link_sn');

switch ($op) {
    //新增資料
    case 'insert_tad_link':
        $link_sn = insert_tad_link();
        header("location: {$_SERVER['PHP_SELF']}?op=$mode&cate_sn=$cate_sn");
        exit;

    //更新資料
    case 'update_tad_link':
        update_tad_link($link_sn);
        header("location: {$_SERVER['PHP_SELF']}?op=$mode&cate_sn=$cate_sn");
        exit;

    //重新抓圖
    case 'get_pic':
        get_pic($link_sn);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //刪除資料
    case 'delete_tad_link':
        delete_tad_link($link_sn);
        header("location: {$_SERVER['PHP_SELF']}?op=$mode&cate_sn=$cate_sn");
        exit;

    //批次刪除資料
    case 'delete_all_link':
        delete_all_link($all_sn);
        header("location: {$_SERVER['PHP_SELF']}?op=$mode&cate_sn=$cate_sn");
        exit;

    case 'go':
        go_url($link_sn);
        exit;

    case 'tad_link_form':
        tad_link_form($link_sn, $mode);
        break;

    //預設動作
    default:
        if (empty($link_sn)) {
            list_tad_link($cate_sn, $mode);
            $op = 'list_tad_link';
        } else {
            show_one_tad_link($link_sn);
            $op = 'show_one_tad_link';
        }
        break;
}

/*-----------秀出結果區--------------*/
$xoTheme->addStylesheet(XOOPS_URL . '/modules/tad_link/css/module.css');
$xoopsTpl->assign('toolbar', Utility::toolbar_bootstrap($interface_menu));
$xoopsTpl->assign('now_uid', $now_uid);
$xoopsTpl->assign('now_op', $op);
require_once XOOPS_ROOT_PATH . '/footer.php';

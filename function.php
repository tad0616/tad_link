<?php
define('_TADLINK_PIC_URL', XOOPS_URL . '/uploads/tad_link');
define('_TADLINK_PIC_PATH', XOOPS_ROOT_PATH . '/uploads/tad_link');
define('_TADLINK_THUMB_PIC_URL', XOOPS_URL . '/uploads/tad_link/thumbs');
define('_TADLINK_THUMB_PIC_PATH', XOOPS_ROOT_PATH . '/uploads/tad_link/thumbs');

//引入TadTools的函式庫
if (!file_exists(XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php")) {
    redirect_header("http://www.tad0616.net/modules/tad_uploader/index.php?of_cat_sn=50", 3, _TAD_NEED_TADTOOLS);
}
include_once XOOPS_ROOT_PATH . "/modules/tadtools/tad_function.php";
include_once "function_block.php";

/********************* 自訂函數 *********************/
//取得路徑
function get_tad_link_cate_path($the_cate_sn = "", $include_self = true)
{
    global $xoopsDB;

    $arr[0]['cate_sn']    = "0";
    $arr[0]['cate_title'] = "<i class='fa fa-home'></i>";
    $arr[0]['sub']        = get_tad_link_sub_cate(0);
    if (!empty($the_cate_sn)) {

        $tbl = $xoopsDB->prefix("tad_link_cate");
        $sql = "SELECT t1.cate_sn AS lev1, t2.cate_sn as lev2, t3.cate_sn as lev3, t4.cate_sn as lev4, t5.cate_sn as lev5, t6.cate_sn as lev6, t7.cate_sn as lev7
            FROM `{$tbl}` t1
            LEFT JOIN `{$tbl}` t2 ON t2.of_cate_sn = t1.cate_sn
            LEFT JOIN `{$tbl}` t3 ON t3.of_cate_sn = t2.cate_sn
            LEFT JOIN `{$tbl}` t4 ON t4.of_cate_sn = t3.cate_sn
            LEFT JOIN `{$tbl}` t5 ON t5.of_cate_sn = t4.cate_sn
            LEFT JOIN `{$tbl}` t6 ON t6.of_cate_sn = t5.cate_sn
            LEFT JOIN `{$tbl}` t7 ON t7.of_cate_sn = t6.cate_sn
            WHERE t1.of_cate_sn = '0'";
        $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
        while ($all = $xoopsDB->fetchArray($result)) {
            if (in_array($the_cate_sn, $all)) {
                //$main.="-";
                foreach ($all as $cate_sn) {
                    if (!empty($cate_sn)) {
                        if (!$include_self and $cate_sn == $the_cate_sn) {
                            break;
                        }
                        $arr[$cate_sn]        = get_tad_link_cate($cate_sn);
                        $arr[$cate_sn]['sub'] = get_tad_link_sub_cate($cate_sn);
                        if ($cate_sn == $the_cate_sn) {
                            break;
                        }
                    }
                }
                //$main.="<br>";
                break;
            }
        }
    }
    return $arr;
}

function get_tad_link_sub_cate($cate_sn = "0")
{
    global $xoopsDB;
    $sql         = "select cate_sn,cate_title from " . $xoopsDB->prefix("tad_link_cate") . " where of_cate_sn='{$cate_sn}'";
    $result      = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error() . "<br>$sql");
    $cate_sn_arr = "";
    while (list($cate_sn, $cate_title) = $xoopsDB->fetchRow($result)) {
        $cate_sn_arr[$cate_sn] = $cate_title;
    }
    return $cate_sn_arr;
}

//以流水號取得某筆tad_link_cate資料
function get_tad_link_cate($cate_sn = "")
{
    global $xoopsDB;
    if (empty($cate_sn)) {
        return;
    }
    $sql    = "select * from " . $xoopsDB->prefix("tad_link_cate") . " where cate_sn='$cate_sn'";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
    $data   = $xoopsDB->fetchArray($result);

    return $data;
}

//分類底下的連結數
function tad_link_cate_count()
{
    global $xoopsDB;
    $sql    = "select cate_sn,count(*) from " . $xoopsDB->prefix("tad_link") . " group by cate_sn";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
    while (list($cate_sn, $count) = $xoopsDB->fetchRow($result)) {
        $all[$cate_sn] = (int) ($count);
    }

    return $all;
}

//取得所有tad_link_cate分類選單的選項（模式 = edit or show,目前分類編號,目前分類的所屬編號）
function get_tad_link_cate_options($page = '', $mode = 'edit', $default_cate_sn = "0", $default_of_cate_sn = "0", $unselect_level = "", $start_search_sn = "0", $level = 0)
{
    global $xoopsDB, $xoopsModule;

    $count = tad_link_cate_count();

    $sql    = "select cate_sn,cate_title from " . $xoopsDB->prefix("tad_link_cate") . " where of_cate_sn='{$start_search_sn}' order by cate_sort";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());

    $prefix = str_repeat("&nbsp;&nbsp;", $level);
    $level++;

    $unselect = explode(",", $unselect_level);

    $main = "";
    while (list($cate_sn, $cate_title) = $xoopsDB->fetchRow($result)) {
        if ($mode == "edit") {
            $selected = ($cate_sn == $default_of_cate_sn) ? "selected=selected" : "";
            $selected .= ($cate_sn == $default_cate_sn) ? "disabled=disabled" : "";
            $selected .= (in_array($level, $unselect)) ? "disabled=disabled" : "";
        } else {
            if (is_array($default_cate_sn)) {
                $selected = in_array($cate_sn, $default_cate_sn) ? "selected=selected" : "";
            } else {
                $selected = ($cate_sn == $default_cate_sn) ? "selected=selected" : "";
            }
            $selected .= (in_array($level, $unselect)) ? "disabled=disabled" : "";
        }
        if ($page == "none" or empty($count[$cate_sn])) {
            $counter = "";
        } else {
            $w       = ($page == "admin") ? _MA_TADLINK_CATE_COUNT : _MD_TADLINK_CATE_COUNT;
            $counter = " (" . sprintf($w, $count[$cate_sn]) . ") ";
        }
        $main .= "<option value=$cate_sn $selected>{$prefix}{$cate_title}{$counter}</option>";
        $main .= get_tad_link_cate_options($page, $mode, $default_cate_sn, $default_of_cate_sn, $unselect_level, $cate_sn, $level);

    }

    return $main;
}

//連結內容格式化
function mk_big_content($link_sn = null, $click_mode = 'normal', $link_cate_title = "", $link_url = "", $cate_sn = "", $cate_title = "", $link_desc = "", $link_counter = "")
{
    global $xoopsModuleConfig, $isAdmin, $xoopsTpl;

}

//顯示圖片
function get_show_pic($link_sn, $mode = 'thumb')
{
    global $xoopsModuleConfig;
    $link = get_tad_link($link_sn);
    if ($mode == 'thumb') {
        $pic      = _TADLINK_THUMB_PIC_URL . "/{$link_sn}.jpg";
        $pic_path = _TADLINK_THUMB_PIC_PATH . "/{$link_sn}.jpg";
    } else {
        $pic      = _TADLINK_PIC_URL . "/{$link_sn}.jpg";
        $pic_path = _TADLINK_PIC_PATH . "/{$link_sn}.jpg";
    }

    if (file_exists($pic_path)) {
        return $pic;
    } else {
        get_pic($link_sn);
        if ($mode == 'thumb') {
            $empty = ($xoopsModuleConfig['direct_link']) ? "http://capture.heartrails.com/120x90/border?{$link['link_url']}" : XOOPS_URL . "/modules/tad_link/images/pic_thumb.png";
        } else {
            $empty = ($xoopsModuleConfig['direct_link']) ? "http://capture.heartrails.com/400x300/border?{$link['link_url']}" : XOOPS_URL . "/modules/tad_link/images/pic_big.png";
        }

        return $empty;
    }
}

//遠端擷取圖片
function get_pic($link_sn = '')
{
    if ($_FILES) {
        include_once XOOPS_ROOT_PATH . "/modules/tadtools/upload/class.upload.php";

        $handle = new upload($_FILES['pic'], 'zh_TW'); // 將上傳物件實體化
        if ($handle->uploaded) {
            // 如果檔案已經上傳到 tmp
            $handle->file_new_name_body = $link_sn; // 重新設定新檔名
            $handle->file_overwrite     = true;
            $handle->image_resize       = true; // 重設圖片大小
            $handle->image_x            = 400; // 設定寬度為 400 px
            $handle->image_ratio_y      = true; // 按比例縮放高度
            $handle->image_convert      = 'jpg';
            $handle->process(_TADLINK_PIC_PATH); // 檔案搬移到目的地
            $handle->clean(); // 若搬移成功，則釋放記憶體
        }
    } else {
        $link = get_tad_link($link_sn);
        copyemz("http://capture.heartrails.com/400x300/border?{$link['link_url']}", _TADLINK_PIC_PATH . "/{$link_sn}.jpg");
    }
    thumbnail(_TADLINK_PIC_PATH . "/{$link_sn}.jpg", _TADLINK_THUMB_PIC_PATH . "/{$link_sn}.jpg");
}

//複製檔案
function copyemz($file1, $file2)
{
    $contentx   = @vita_get_url_content($file1);
    $openedfile = fopen($file2, "w");
    fwrite($openedfile, $contentx);
    fclose($openedfile);
    if ($contentx === false) {
        $status = false;
    } else {
        $status = true;
    }

    return $status;
}

//遠端取得資料
function vita_get_url_content($url)
{
    if (function_exists('curl_init')) {
        $ch      = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);
    } elseif (function_exists('file_get_contents')) {
        $file_contents = file_get_contents($url);
    }

    return $file_contents;
}

//做縮圖
if (!function_exists('thumbnail')) {
    function thumbnail($filename = "", $thumb_name = "", $type = "image/jpeg", $width = "120")
    {

        ini_set('memory_limit', '50M');
        // Get new sizes
        list($old_width, $old_height) = getimagesize($filename);

        $percent = ($old_width > $old_height) ? round($width / $old_width, 2) : round($width / $old_height, 2);

        $newwidth  = ($old_width > $old_height) ? $width : $old_width * $percent;
        $newheight = ($old_width > $old_height) ? $old_height * $percent : $width;

        // Load
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        if ($type == "image/jpeg" or $type == "image/jpg" or $type == "image/pjpg" or $type == "image/pjpeg") {
            $source = imagecreatefromjpeg($filename);
            $type   = "image/jpeg";
        } elseif ($type == "image/png") {
            $source = imagecreatefrompng($filename);
            $type   = "image/png";
        } elseif ($type == "image/gif") {
            $source = imagecreatefromgif($filename);
            $type   = "image/gif";
        }

        // Resize
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $old_width, $old_height);
        //die($thumb_name);
        header("Content-type: image/png");
        imagepng($thumb, $thumb_name);

        return;
        exit;
    }
}

//新增tad_link計數器
function add_tad_link_counter($link_sn = '')
{
    global $xoopsDB, $xoopsModule;
    $sql = "update " . $xoopsDB->prefix("tad_link") . " set `link_counter`=`link_counter`+1 where `link_sn`='{$link_sn}'";
    $xoopsDB->queryF($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
}

//以流水號取得某筆tad_link資料
function get_tad_link($link_sn = "")
{
    global $xoopsDB;
    if (empty($link_sn)) {
        return;
    }
    $sql    = "select * from " . $xoopsDB->prefix("tad_link") . " where link_sn='$link_sn'";
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
    $data   = $xoopsDB->fetchArray($result);

    return $data;
}

//取得tad_link_cate所有資料陣列
function get_tad_link_cate_all()
{
    global $xoopsDB;
    $sql    = "select * from " . $xoopsDB->prefix("tad_link_cate");
    $result = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
    while ($data = $xoopsDB->fetchArray($result)) {
        $cate_sn            = (int) ($data['cate_sn']);
        $data_arr[$cate_sn] = $data;
    }

    return $data_arr;
}

//自動取得tad_link_cate的最新排序
function tad_link_cate_max_sort($of_cate_sn = '0')
{
    global $xoopsDB;
    $sql        = "select max(`cate_sort`) from " . $xoopsDB->prefix("tad_link_cate") . " where of_cate_sn='{$of_cate_sn}'";
    $result     = $xoopsDB->query($sql) or redirect_header($_SERVER['PHP_SELF'], 3, mysql_error());
    list($sort) = $xoopsDB->fetchRow($result);

    return ++$sort;
}

/********************* 預設函數 *********************/;

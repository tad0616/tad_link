<?php
xoops_loadLanguage('modinfo_common', 'tadtools');

define('_MI_TADLINK_NAME', '好站連結');
define('_MI_TADLINK_AUTHOR', '好站連結');
define('_MI_TADLINK_CREDITS', 'Michael');
define('_MI_TADLINK_DESC', '好站連結模組');
define('_MI_TADLINK_ADMENU1', '主管理介面');
define('_MI_TADLINK_ADMENU2', '分類設定');
define('_MI_TADLINK_ADMENU3', '權限設定');
define('_MI_TADLINK_TEMPLATE_DESC1', 'tad_link_index.html的樣板檔。');
define('_MI_TADLINK_BNAME1', '圖片連結');
define('_MI_TADLINK_BDESC1', '圖片連結(tad_link_show)');
define('_MI_TADLINK_BNAME2', '文字連結');
define('_MI_TADLINK_BDESC2', '文字連結(tad_link_all)');

define('_MI_TADLINK_SHOW_NUM', '一次顯示幾個連結');
define('_MI_TADLINK_SHOW_NUM_DESC', '首頁顯示連結的數量，作為分頁依據');
define('_MI_TADLINK_SHOW_FACEBOOK', '是否使用facebook留言系統工具');
define('_MI_TADLINK_SHOW_FACEBOOK_DESC', '設定在「連結的詳細頁面」是否出現facebook留言工具');
define('_MI_TADLINK_SHOW_PUSH', '是否秀出推文工具');
define('_MI_TADLINK_SHOW_PUSH_DESC', '設定在「連結的詳細頁面」是否秀出推文工具');
define('_MI_TADLINK_PIC_WIDTH', '大圖寬度');
define('_MI_TADLINK_PIC_WIDTH_DESC', '設定大圖的呈現寬度（上限為400）');
define('_MI_TADLINK_DIRECT_LINK', '直接連結縮圖？');
define('_MI_TADLINK_DIRECT_LINK_DESC', '當縮圖一直無法下載儲存時，是否使用遠端連線縮圖？選「是」速度較慢，但或許可以看得見縮圖。選「否」的話會以預設的縮圖替代之，速度較快，但看不到縮圖。');

define('_MI_TADLINK_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_TADLINK_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_TADLINK_BACK_2_ADMIN', '管理');

//help
define('_MI_TADLINK_HELP_OVERVIEW', '概要');

define('_MI_CAPTURE_FROM', '縮圖擷取來源');
define('_MI_CAPTURE_FROM_DESC', '120.115.2.78 為自架主機，可能會比較不穩');

define('_MI_TADLINK_NO_FUNCTION', 'No function exist');
define('_MI_TADLINK_FUNCTION_OK', 'Function is OK');

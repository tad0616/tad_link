<?php
$modversion = [];
global $xoopsConfig;

//---模組基本資訊---//
$modversion['name'] = _MI_TADLINK_NAME;
// $modversion['version'] = 3.5;
$modversion['version'] = $_SESSION['xoops_version'] >= 20511 ? '4.0.0-Stable' : '4.0';
$modversion['description'] = _MI_TADLINK_DESC;
$modversion['author'] = _MI_TADLINK_AUTHOR;
$modversion['credits'] = _MI_TADLINK_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(__DIR__);

//---模組狀態資訊---//
$modversion['release_date'] = '2024-12-12';
$modversion['module_website_url'] = 'https://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php'] = 5.4;
$modversion['min_xoops'] = '2.5.10';

//---paypal資訊---//
$modversion['paypal'] = [
    'business' => 'tad0616@gmail.com',
    'item_name' => 'Donation : ' . _MI_TAD_WEB,
    'amount' => 0,
    'currency_code' => 'USD',
];

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;

//---資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'] = ['tad_link_cate', 'tad_link'];

//---管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/index.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---使用者主選單設定---//
$modversion['hasMain'] = 1;

//---安裝設定---//
$modversion['onInstall'] = 'include/onInstall.php';
$modversion['onUpdate'] = 'include/onUpdate.php';
$modversion['onUninstall'] = 'include/onUninstall.php';

//---樣板設定---//
$modversion['templates'] = [
    ['file' => 'tad_link_index.tpl', 'description' => 'tad_link_index.tpl'],
    ['file' => 'tad_link_admin.tpl', 'description' => 'tad_link_admin.tpl'],
];

//---搜尋設定---//
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/tad_link_search.php';
$modversion['search']['func'] = 'tad_link_search';

//---區塊設定 (索引為固定值，若欲刪除區塊記得補上索引，避免區塊重複)---//
$modversion['blocks'] = [
    1 => [
        'file' => 'tad_link_show.php',
        'name' => _MI_TADLINK_BNAME1,
        'description' => _MI_TADLINK_BDESC1,
        'show_func' => 'tad_link_show',
        'template' => 'tad_link_block_show.tpl',
        'edit_func' => 'tad_link_show_edit',
        'options' => '10|1|1|0|new|1||0|3',
    ],
    2 => [
        'file' => 'tad_link_all.php',
        'name' => _MI_TADLINK_BNAME2,
        'description' => _MI_TADLINK_BDESC2,
        'show_func' => 'tad_link_all',
        'template' => 'tad_link_block_all.tpl',
        'edit_func' => 'tad_link_all_edit',
        'options' => '1||dropdown|1',
    ],
];

$modversion['config'] = [
    [
        'name' => 'show_num',
        'title' => '_MI_TADLINK_SHOW_NUM',
        'description' => '_MI_TADLINK_SHOW_NUM_DESC',
        'formtype' => 'textbox',
        'valuetype' => 'int',
        'default' => '10',
    ],
    [
        'name' => 'pic_width',
        'title' => '_MI_TADLINK_PIC_WIDTH',
        'description' => '_MI_TADLINK_PIC_WIDTH_DESC',
        'formtype' => 'textbox',
        'valuetype' => 'int',
        'default' => '400',
    ],
    [
        'name' => 'direct_link',
        'title' => '_MI_TADLINK_DIRECT_LINK',
        'description' => '_MI_TADLINK_DIRECT_LINK_DESC',
        'formtype' => 'yesno',
        'valuetype' => 'int',
        'default' => '0',
    ],
    [
        'name' => 'use_social_tools',
        'title' => '_MI_SOCIALTOOLS_TITLE',
        'description' => '_MI_SOCIALTOOLS_TITLE_DESC',
        'formtype' => 'yesno',
        'valuetype' => 'int',
        'default' => '1',
    ],
];

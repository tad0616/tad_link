<?php
$modversion = [];

//---模組基本資訊---//
$modversion['name'] = _MI_TADLINK_NAME;
$modversion['version'] = 2.7;
$modversion['description'] = _MI_TADLINK_DESC;
$modversion['author'] = _MI_TADLINK_AUTHOR;
$modversion['credits'] = _MI_TADLINK_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GNU GPL 2.0';
$modversion['license_url'] = 'www.gnu.org/licenses/gpl-2.0.html/';
$modversion['image'] = "images/logo_{$xoopsConfig['language']}.png";
$modversion['dirname'] = basename(__DIR__);

//---模組狀態資訊---//
$modversion['release_date'] = '2019-05-10';
$modversion['module_website_url'] = 'https://tad0616.net/';
$modversion['module_website_name'] = _MI_TAD_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://tad0616.net/';
$modversion['author_website_name'] = _MI_TAD_WEB;
$modversion['min_php'] = 5.4;
$modversion['min_xoops'] = '2.5.7';

//---paypal資訊---//
$modversion['paypal'] = [];
$modversion['paypal']['business'] = 'tad0616@gmail.com';
$modversion['paypal']['item_name'] = 'Donation : ' . _MI_TAD_WEB;
$modversion['paypal']['amount'] = 0;
$modversion['paypal']['currency_code'] = 'USD';

//---啟動後台管理界面選單---//
$modversion['system_menu'] = 1;

//---資料表架構---//
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
$modversion['tables'][1] = 'tad_link_cate';
$modversion['tables'][2] = 'tad_link';

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
$modversion['templates'] = [];
$i = 1;
$modversion['templates'][$i]['file'] = 'tad_link_index.tpl';
$modversion['templates'][$i]['description'] = 'tad_link_index.tpl';

$i++;
$modversion['templates'][$i]['file'] = 'tad_link_adm_main.tpl';
$modversion['templates'][$i]['description'] = 'tad_link_adm_main.tpl';

$i++;
$modversion['templates'][$i]['file'] = 'tad_link_form.tpl';
$modversion['templates'][$i]['description'] = 'tad_link_form.tpl';

$i++;
$modversion['templates'][$i]['file'] = 'tad_link_adm_power.tpl';
$modversion['templates'][$i]['description'] = 'tad_link_adm_power.tpl';

//---搜尋設定---//
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/tad_link_search.php';
$modversion['search']['func'] = 'tad_link_search';

//---區塊設定---//
$modversion['blocks'][1]['file'] = 'tad_link_show.php';
$modversion['blocks'][1]['name'] = _MI_TADLINK_BNAME1;
$modversion['blocks'][1]['description'] = _MI_TADLINK_BDESC1;
$modversion['blocks'][1]['show_func'] = 'tad_link_show';
$modversion['blocks'][1]['template'] = 'tad_link_block_show.tpl';
$modversion['blocks'][1]['edit_func'] = 'tad_link_show_edit';
$modversion['blocks'][1]['options'] = '10|1|1|0|new|1||0|3';

$modversion['blocks'][2]['file'] = 'tad_link_all.php';
$modversion['blocks'][2]['name'] = _MI_TADLINK_BNAME2;
$modversion['blocks'][2]['description'] = _MI_TADLINK_BDESC2;
$modversion['blocks'][2]['show_func'] = 'tad_link_all';
$modversion['blocks'][2]['template'] = 'tad_link_block_all.tpl';
$modversion['blocks'][2]['edit_func'] = 'tad_link_all_edit';
$modversion['blocks'][2]['options'] = '1||dropdown|1';

$i = 0;

$i++;
$modversion['config'][$i]['name'] = 'show_num';
$modversion['config'][$i]['title'] = '_MI_TADLINK_SHOW_NUM';
$modversion['config'][$i]['description'] = '_MI_TADLINK_SHOW_NUM_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '10';

$i++;
$modversion['config'][$i]['name'] = 'pic_width';
$modversion['config'][$i]['title'] = '_MI_TADLINK_PIC_WIDTH';
$modversion['config'][$i]['description'] = '_MI_TADLINK_PIC_WIDTH_DESC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '400';

$i++;
$modversion['config'][$i]['name'] = 'direct_link';
$modversion['config'][$i]['title'] = '_MI_TADLINK_DIRECT_LINK';
$modversion['config'][$i]['description'] = '_MI_TADLINK_DIRECT_LINK_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '0';

$i++;
$modversion['config'][$i]['name'] = 'facebook_comments_width';
$modversion['config'][$i]['title'] = '_MI_FBCOMMENT_TITLE';
$modversion['config'][$i]['description'] = '_MI_FBCOMMENT_TITLE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';

$i++;
$modversion['config'][$i]['name'] = 'use_social_tools';
$modversion['config'][$i]['title'] = '_MI_SOCIALTOOLS_TITLE';
$modversion['config'][$i]['description'] = '_MI_SOCIALTOOLS_TITLE_DESC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = '1';

$i++;
$modversion['config'][$i]['name'] = 'capture_from';
$modversion['config'][$i]['title'] = '_MI_CAPTURE_FROM';
$modversion['config'][$i]['description'] = '_MI_CAPTURE_FROM_DESC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = ['capture.heartrails.com' => 'capture.heartrails.com', '120.115.2.78' => '120.115.2.78'];
$modversion['config'][$i]['default'] = 'capture.heartrails.com';

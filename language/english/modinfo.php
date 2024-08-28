<?php
xoops_loadLanguage('modinfo_common', 'tadtools');
define('_MI_TADLINK_NAME', 'Tad Links');
define('_MI_TADLINK_AUTHOR', 'Tad');
define('_MI_TADLINK_CREDITS', 'Michael');
define('_MI_TADLINK_DESC', 'Tad Links Module');
define('_MI_TADLINK_ADMENU1', 'Management');
define('_MI_TADLINK_ADMENU2', 'Category');
define('_MI_TADLINK_ADMENU3', 'Permission');
define('_MI_TADLINK_TEMPLATE_DESC1', 'tad_link_index.html template file.');
define('_MI_TADLINK_BNAME1', 'New Links');
define('_MI_TADLINK_BDESC1', 'New Links (tad_link_show)');
define('_MI_TADLINK_BNAME2', 'Quick Links');
define('_MI_TADLINK_BDESC2', 'Quick Links (tad_link_all)');

define('_MI_TADLINK_SHOW_NUM', 'Links per Page');
define('_MI_TADLINK_SHOW_NUM_DESC', 'Number of links displayed on a page (pagination)');
define('_MI_TADLINK_SHOW_PUSH', 'Use Tweets Tools');
define('_MI_TADLINK_SHOW_PUSH_DESC', 'Set in the "Link detail page" whether to show Tweets Tools');
define('_MI_TADLINK_PIC_WIDTH', 'Picture width');
define('_MI_TADLINK_PIC_WIDTH_DESC', 'Set the width for a large image (upper limit is 400)');
define('_MI_TADLINK_DIRECT_LINK', 'Direct link thumbnail?');
define('_MI_TADLINK_DIRECT_LINK_DESC', 'If Thumbnail has not been created when adding the link, should we use a remote connection thumbnail? <br>Choose "Yes" is slow, but perhaps you can see thumbnail. <br>Choose "No", then will be pre-alternative set of thumbnails, faster, but you can not see thumbnail ');

define('_MI_TADLINK_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_TADLINK_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('_MI_TADLINK_BACK_2_ADMIN', 'Back to Administration of ');

//help
define('_MI_TADLINK_HELP_OVERVIEW', 'Overview');

define('_MI_CAPTURE_FROM', 'Thumbnail source');
define('_MI_CAPTURE_FROM_DESC', '120.115.2.78 may be more unstable');

define('_MI_TADLINK_NO_FUNCTION', 'No function exist');
define('_MI_TADLINK_FUNCTION_OK', 'Function is OK');

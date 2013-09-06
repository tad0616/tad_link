CREATE TABLE `tad_link_cate` (
  `cate_sn` smallint(5) unsigned NOT NULL auto_increment COMMENT '分類編號',
  `of_cate_sn` smallint(5) unsigned NOT NULL COMMENT '父分類',
  `cate_title` varchar(255) NOT NULL COMMENT '分類標題',
  `cate_sort` smallint(5) unsigned NOT NULL COMMENT '分類排序',
PRIMARY KEY (`cate_sn`)
) ENGINE=MyISAM;

CREATE TABLE `tad_link` (
  `link_sn` smallint(5) unsigned NOT NULL auto_increment COMMENT '連結編號',
  `cate_sn` smallint(5) unsigned NOT NULL COMMENT '所屬分類',
  `link_title` varchar(255) NOT NULL COMMENT '網站名稱',
  `link_url` varchar(255) NOT NULL COMMENT '網站連結',
  `link_desc` text NOT NULL COMMENT '網站描述',
  `link_sort` smallint(5) unsigned NOT NULL COMMENT '網站排序',
  `link_counter` smallint(5) unsigned NOT NULL COMMENT '人氣',
  `unable_date` date NOT NULL default '0000-00-00' COMMENT '下架日',
  `uid` smallint(5) unsigned NOT NULL COMMENT '發布者',
  `post_date` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '發布日期',
  `enable` enum('1','0') NOT NULL default '1' COMMENT '是否啟用',
PRIMARY KEY (`link_sn`)
) ENGINE=MyISAM;


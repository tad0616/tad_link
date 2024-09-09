<?php
//好站連結搜尋程式
function tad_link_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;
    if (is_array($queryarray)) {
        foreach ($queryarray as $k => $v) {
            $arr[$k] = $xoopsDB->escape($v);
        }
        $queryarray = $arr;
    } else {
        $queryarray = [];
    }
    $sql = 'SELECT `link_sn`,`link_title`,`link_url`,`post_date`, `uid` FROM ' . $xoopsDB->prefix('tad_link') . " WHERE enable='1'";
    if (0 != $userid) {
        $sql .= ' AND uid=' . $userid . ' ';
    }
    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " AND ((`link_title` LIKE '%{$queryarray[0]}%'  OR `link_desc` LIKE '%{$queryarray[0]}%' )";
        for ($i = 1; $i < $count; $i++) {
            $sql .= " $andor ";
            $sql .= "(`link_title` LIKE '%{$queryarray[$i]}%' OR  `link_desc` LIKE '%{$queryarray[$i]}%' )";
        }
        $sql .= ') ';
    }
    $sql .= 'ORDER BY  `post_date` DESC';
    $result = $xoopsDB->query($sql, $limit, $offset);
    $ret = [];
    $i = 0;
    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[$i]['image'] = 'images/mouse.png';
        $ret[$i]['link'] = 'index.php?link_sn=' . $myrow['link_sn'];
        $ret[$i]['title'] = empty($myrow['link_title']) ? $myrow['link_url'] : $myrow['link_title'];
        $ret[$i]['time'] = strtotime($myrow['post_date']);
        $ret[$i]['uid'] = $myrow['uid'];
        $i++;
    }

    return $ret;
}

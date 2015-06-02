<?php
//好站連結搜尋程式
function tad_link_search($queryarray, $andor, $limit, $offset, $userid) {
    global $xoopsDB;
    //處理許功蓋
    if (get_magic_quotes_gpc()) {
        foreach ($queryarray as $k => $v) {
            $arr[$k] = addslashes($v);
        }
        $queryarray = $arr;
    }
    $sql = "SELECT `link_sn`,`link_title`,`post_date`, `uid` FROM " . $xoopsDB->prefix("tad_link") . " WHERE enable='1'";
    if ($userid != 0) {
        $sql .= " AND uid=" . $userid . " ";
    }
    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " AND ((`link_title` LIKE '%{$queryarray[0]}%'  OR `link_desc` LIKE '%{$queryarray[0]}%' )";
        for ($i = 1; $i < $count; $i++) {
            $sql .= " $andor ";
            $sql .= "(`link_title` LIKE '%{$queryarray[$i]}%' OR  `link_desc` LIKE '%{$queryarray[$i]}%' )";
        }
        $sql .= ") ";
    }
    $sql .= "ORDER BY  `post_date` DESC";
    $result = $xoopsDB->query($sql, $limit, $offset);
    $ret    = array();
    $i      = 0;
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $ret[$i]['image'] = "images/mouse.png";
        $ret[$i]['link']  = "index.php?link_sn=" . $myrow['link_sn'];
        $ret[$i]['title'] = $myrow['link_title'];
        $ret[$i]['time']  = strtotime($myrow['post_date']);
        $ret[$i]['uid']   = $myrow['uid'];
        $i++;
    }

    return $ret;
}

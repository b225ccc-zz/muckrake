<?php

function highlightWords($string,$words) {
    foreach ( $words as $word ) {
        $string = str_ireplace($word, '<span class="help-inline">'.$word.'</span>', $string);
    }
    return $string;
}

function getTraps($where,$bool="AND",$low_limit,$high_limit) {

	$where_string = implode(" $bool ", $where);
        if ($where_string) { $where_string = "WHERE " . $where_string; }

    $query = "SELECT * FROM snmptt $where_string ORDER BY traptime DESC LIMIT $low_limit, $high_limit";
    //print $query . "<br />";
    $result = mysql_query($query);
    $num_results = mysql_numrows($result);
    // fetch all rows and store in $r array
    $r = array();
    while ($r[] = mysql_fetch_assoc($result));
    // for some reason this returns an extra, empty array element... pop it to delete
    array_pop($r);
    return $r;
}

function getUnknownTraps($where,$bool="AND",$low_limit,$high_limit) {

	$where_string = implode(" $bool ", $where);
        if ($where_string) { $where_string = "WHERE " . $where_string; }

    $query = "SELECT * FROM snmptt_unknown $where_string ORDER BY traptime DESC LIMIT $low_limit, $high_limit";
    //print $query . "<br />";
    $result = mysql_query($query);
    $num_results = mysql_numrows($result);
    // fetch all rows and store in $r array
    $r = array();
    while ($r[] = mysql_fetch_assoc($result));
    // for some reason this returns an extra, empty array element... pop it to delete
    array_pop($r);
    return $r;
}

function getTrapCount($where,$bool="AND") {

	$where_string = implode(" $bool ", $where);
        if ($where_string) { $where_string = "WHERE " . $where_string; }

    $query = "SELECT count(id) as count FROM snmptt $where_string";
    //print $query;
    $result = mysql_query($query);
    $count = mysql_fetch_assoc($result);
    return $count['count'];
}
function getUnknownTrapCount($where,$bool="AND") {

	$where_string = implode(" $bool ", $where);
        if ($where_string) { $where_string = "WHERE " . $where_string; }

    $query = "SELECT count(trapoid) as count FROM snmptt_unknown $where_string";
    //print $query;
    $result = mysql_query($query);
    $count = mysql_fetch_assoc($result);
    return $count['count'];
}
?>

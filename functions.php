<?php

function getTraps($where) {

	$where_string = implode(" AND ", $where);
        if ($where_string) { $where_string = "WHERE " . $where_string; }

    $query = "SELECT * FROM snmptt $where_string ORDER BY traptime DESC LIMIT 1000";
    //print $query;
    $result = mysql_query($query);
    $num_results = mysql_numrows($result);
    // fetch all rows and store in $r array
    $r = array();
    while ($r[] = mysql_fetch_assoc($result));
    // for some reason this returns an extra, empty array element... pop it to delete
    array_pop($r);
    return $r;

}

?>

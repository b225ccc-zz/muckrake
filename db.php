<?php

$username="snmptt_db_username";
$password="snmptt_db_password";
$database="snmptt";
mysql_connect('hostname',$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

?>

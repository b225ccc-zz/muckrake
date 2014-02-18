<?php
# vim: sw=4 sts=4:
#
#
# muckrake: snmptt web gui
#
# Copyright (C) 2014 Photobucket <btalley@photobucket.com>
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301 USA


echo "<html><head>";
echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\">";
echo "<script src=\"sorttable.js\"></script>";
echo "</head>";
echo "<body>";
echo "<h1>muckrake</h1>";

include 'db.php';
include 'functions.php';

$where = array();
if ($_GET['submit'] == "Submit") {
	if ($_GET['hostname_filter'] != '') {
		array_push($where, "hostname REGEXP '" . $_GET['hostname_filter'] . "'");
	}
	if ($_GET['trapoid_filter'] != '') {
		array_push($where, "trapoid REGEXP '" . $_GET['trapoid_filter'] . "'");
	}
	if ($_GET['desc_filter'] != '') {
		array_push($where, "formatline REGEXP '" . $_GET['desc_filter'] . "'");
	}
	if ($_GET['sev_filter'] != '') {
		array_push($where, "severity REGEXP '" . $_GET['sev_filter'] . "'");
	}
}

$traps = getTraps($where);

echo "<form name=\"input\" action=\"\" method=\"get\">";
echo "<table class=\"sortable\">
<tr>
<th></th>
<th>hostname</th>
<th>oid</th>
<th>desc</th>
<th>severity</th>
<th>traptime</th>
</tr>";
echo "
<tr>
<th></th>
<th><input type=\"text\" name=\"hostname_filter\" value=\"" . ($_GET['hostname_filter'] ?: '') .  "\"></th>
<th><input type=\"text\" name=\"trapoid_filter\" value=\"" . ($_GET['trapoid_filter'] ?: '') .  "\"></th>
<th><input type=\"text\" name=\"desc_filter\" value=\"" . ($_GET['desc_filter'] ?: '') .  "\"></th>
<th><input type=\"text\" name=\"sev_filter\" value=\"" . ($_GET['sev_filter'] ?: '') .  "\"></th>
<th></th>
</tr>";

print count($traps) . " traps";
$i = 1;
foreach ($traps as $item) {
	if ($i % 2 == 0) { $even = 'even'; } else { $even = ''; }
	print "<tr class=\"$even\"><td align=right>$i</td>";
	print "<td nowrap>" . $item['hostname'] . "</td>";
	print "<td nowrap>" . $item['trapoid'] . "</td>";
	print "<td>" . nl2br($item['formatline']) . "</td>";
	$severity = strtolower($item['severity']);
	print "<td nowrap class=\"$severity\">" . $item['severity'] . "</td>";
	print "<td align=right nowrap>" . $item['traptime'] . "</td>";

	print "</tr>";
	$i++;

}
echo "</table>";

echo "<input type=\"submit\" name=\"submit\" value=\"Submit\">";

echo "</html>";
?>

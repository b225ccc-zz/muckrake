<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>muckrake | traps</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar-fixed-top.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <b><a class="navbar-brand" href="./">muckrake</a></b>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Traps</a></li>
            <li><a href="unknown.php">Unknown Traps</a></li>
          </ul>
            <form class="navbar-form navbar-right" role="search" method="get" action="">
        <div class="form-group">
        <input type="text" class="form-control" placeholder="Search" name="f" value="<?php echo ($_GET['f'] ?: '') ?>"></th>
      </div>
      <button type="submit" class="btn btn-default" name="submit" value="Go">Go</button>&nbsp;&nbsp;&nbsp;
      </form>
    </div><!--/.nav-collapse -->
  </div>

    <div class="container-fluid">

<?php

include 'db.php';
include 'functions.php';

$pag = 25;

// get pagination limits
if ($_GET['p']) {
  $current_page = $_GET['p'];
  $upper_limit = $pag * $_GET['p'];
  $lower_limit = $upper_limit - $pag;
} else {
  $current_page = 1;
  $lower_limit = 0;
  $upper_limit = $pag;
}

// rebuild current uri string
$uri = '?';
if (!empty($_GET['f'])) { $uri .= "f=" . $_GET['f']; }

$where = array();
if (!empty($_GET['f'])) {
  array_push($where, "hostname REGEXP '" . $_GET['f'] . "'");
  array_push($where, "trapoid REGEXP '" . $_GET['f'] . "'");
  array_push($where, "formatline REGEXP '" . $_GET['f'] . "'");
  array_push($where, "severity REGEXP '" . $_GET['f'] . "'");
  $traps = getTraps($where,"OR",$lower_limit,$pag);
  $total_count = getTrapCount($where,"OR",0,100000000);
} else {
  $traps = getTraps($where,"AND",$lower_limit,$pag);
  $total_count = getTrapCount($where,"AND",0,100000000);
}

print "<div class=\"well well-sm\">Total number of traps in db matching filter: <span class=\"label label-success\">$total_count</span>";
print "<span class=\"pull-right\">Showing <span class=\"badge\">" . ($lower_limit+1) . " - " .($lower_limit+1+$pag). "</span></span></div>";

?>

<table class="table table-striped table-condensed table-hover">
<thead><tr>
<th>#</th>
<th>hostname</th>
<th>oid</th>
<th>desc</th>
<th>severity</th>
<th>traptime</th>
<th></th>
</tr>
              </thead>

              <tbody>

<?php


$i = 1;
foreach ($traps as $item) {
        print "<tr><td align=right>$i</td>";
        print "<td nowrap>" . $item['hostname'] . "</td>";
        print "<td nowrap>" . $item['trapoid'] . "</td>";
        print "<td>" . nl2br($item['formatline']) . "</td>";
        $severity = strtolower($item['severity']);

	//if ($severity == "normal") { $severity = 'danger'; }

        print "<td nowrap class=\"$severity\">";
	//print $item['severity'];

	if ($severity == "normal") { print "<span class=\"label label-info\">Normal</span>"; }
	elseif ($severity == "informational") { print "<span class=\"label label-info\">Info</span>"; }

	print "</td>";
        print "<td align=right nowrap>" . $item['traptime'] . "</td>";
        print "<td><a href=\"detail.php?id=" . $item['id'] . "\"><span class=\"glyphicon glyphicon-search\"></span></a>";
        print "</tr>";
        $i++;

}

?>
	</tbody>
	</table>

<!--
<span class="label label-default">Normal</span>
<span class="label label-primary">Primary</span>
<span class="label label-success">Success</span>
<span class="label label-info">Info</span>
<span class="label label-warning">Warning</span>
<span class="label label-danger">Danger</span>
<br />
-->
<div class="pull-right">
<ul class="pagination pagination-lg">
<?php
//build pagination block

// find first numbered page link
$first = $current_page - 2;
while ($first <= 0) {
	$first++;
}

// handle "previous" button
if ($current_page > 1) {
    $prev_uri = $uri . "&p=" . ($current_page-1);
    echo "<li><a href=\"$prev_uri\">&laquo;</a></li>";
} else {
    echo "<li class=\"disabled\"><a href=\"\">&laquo;</a></li>";
}

$num = $first;
for ($i=0;$i<5;$i++) {
	$new_uri = $uri . "&p=$num";
	if ($num == $current_page) {
		echo "<li class=\"active\"><a href=\"$new_uri\">$num</a></li>";
	} else {
		echo "<li><a href=\"$new_uri\">$num</a></li>";
	}
	$num++;
}
	$new_uri = $uri . "&p=$num";


$next_uri = $uri . "&p=" . ($current_page+1);
?>

  <li><a href="<?php echo $next_uri; ?>">&raquo;</a></li>
</ul>
</div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

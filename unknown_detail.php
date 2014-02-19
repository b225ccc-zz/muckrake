<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>muckrake | trap detail</title>

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
            <li><a href="#">Traps</a></li>
            <li class="active"><a href="unknown.php">Unknown Traps</a></li>
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

    <h3>Trap detail</h3>

<?php

include 'db.php';
include 'functions.php';


// rebuild current uri string
$uri = '?';
if (!empty($_GET['f'])) { $uri .= "f=" . $_GET['f']; }

$where = array();
if (!empty($_GET['id'])) {
  $details = getUnknownTrapDetail($_GET['id']);
?>
<div class="panel panel-info">
    <div class="panel-body">
      <p>
        <dl class="dl-horizontal">
          <dt>Hostname</dt>
          <dd><tt><?php echo $details['hostname']; ?></tt></dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Agent IP</dt>
          <dd><tt><?php echo $details['agentip']; ?></tt></dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Uptime</dt>
          <dd><tt><?php echo $details['uptime']; ?></tt></dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Trap time</dt>
          <dd><tt><?php echo $details['traptime']; ?></tt></dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Community</dt>
          <dd><tt><?php echo $details['community']; ?></tt></dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>OID</dt>
          <dd><tt><?php echo $details['trapoid']; ?></tt></dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Format line</dt>
          <!-- not sure why formatline has a "\'" at the beginning and end of the string
               strip that out -->
          <dd><tt><?php echo nl2br(str_replace('\\\'','',$details['formatline'])); ?></tt></dd>
        </dl>
      </p>
    </div>
</div>
<?php
} else {
  print "<div class=\"alert alert-danger\">No trap ID!</div>";
}

?>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

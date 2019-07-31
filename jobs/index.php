<?php

	//get the jobs list
	// load the diary class
	require_once("../config/db.php");	
	require_once("../classes/Jobs.php");
	$jobs = new Jobs();
	
	$get_jobs = array();
	$get_jobs = $jobs->getJobs();
	
	//print_r($get_jobs);
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Home of Remembrance Jobs List</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron-narrow.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header">
      <!--
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
        -->
        <h3 class="text-muted">Home of Remembrance - Jobs list</h3>
      </div>

      <div class="jumbotron">
        <h1>Jobs List</h1>
        <p class="lead">Below is a list of completed and to-complete jobs for the site.</p>
      </div>

      <div class="row marketing">
        <div class="col-lg-12">
          <div class="list-group">
			  <?php
			  	//loop through jobs
			  	foreach($get_jobs as $job)
			  	{
				  	?>
				  	<a href="#" class="list-group-item">
				  	<h4 class="list-group-item-heading"><?php echo($job['job']); ?></h4>
				  	<p class="list-group-item-text"><?php echo($job['description']); ?> </p>
				  	<?php if ($job['complete'] == 1) { ?><input type="checkbox" checked disabled/> <?php } ?>
				  	</a>
				  	<?php
			  	}
			  ?>		  
		  </div>
          
          
        </div>
      </div>

      <div class="footer">
        <p>&copy; Home of Remembrance 2014</p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>

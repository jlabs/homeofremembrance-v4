<?php

session_start();

if ($_SESSION['user_id'] == null)
{
	//if the person isn't logged in, then redirect to the homepage.
	header("location: frontdoor.php");
}

$pagename = basename($_SERVER['PHP_SELF']);
$pageTitle = "";

?>

<!DOCTYPE html>
<html>
  <head>
    <title> 
		<?php echo "Home of Remembrance - ".$pageTitle; ?>
    </title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    
    <link href="css/build/global.css" rel="stylesheet" type="text/css">

    <!--Google Font-->
    <!--used for headings-->
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Pacifico">
    <!--body text-->
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
	
	<!-- for the gallery -->
	<link rel="stylesheet" href="css/build/prettyPhoto.css" type="text/css" media="screen" charset="utf-8">
	
	<!-- expanding boxes from http://tympanus.net/codrops/2014/05/12/morphing-buttons-concept/ -->
	<link rel="stylesheet" type="text/css" href="css/build/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/build/component.css">
	<link rel="stylesheet" type="text/css" href="css/build/content.css">
	
	
	<link rel="stylesheet" type="text/css" href="css/build/normalize.css" />
	<link rel="stylesheet" type="text/css" href="css/build/cs-select.css" />
	<link rel="stylesheet" type="text/css" href="css/build/cs-skin-slide.css" />
	
  
  </head>
  
  <body>
  
    <!-- Static navbar -->
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">      
      	<div class="navbar-header">      
	        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-collapse">
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	          <span class="icon-bar"></span>
	        </button>      	
        	<a class="navbar-brand" href="#"></a>
        </div>        
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">          
              <li class="dropdown 
              	<?php
              		if($pagename=="frontdoor.php"||
	              		$pagename=="help.php"||
	              		$pagename=="contact.php")
              		{
              			echo "active";
              		}
              	?>">
	              	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Home <b class="caret"></b></a>
				  	<ul class="dropdown-menu">
				  		<li class="<?php if($pagename == "frontdoor.php"){echo "active";} ?>"><a href="frontdoor.php">Home</a></li>
	                	<li class="<?php if($pagename == "help.php"){echo "active";} ?>"><a href="#">Help</a></li>
		                <li class="<?php if($pagename == "contact.php"){echo "active";} ?>"><a href="#">Contact Us</a></li>
		                <li class="divider"></li>
		                <li><a href="frontdoor.php?logout">Logout</a></li>
					</ul>
				</li>
				
            <li class="<?php if($pagename=="my-life.php"){echo "active";} ?>"><a href="my-life.php">My Life</a></li>
            <li class="<?php if($pagename=="gallery.php"){echo "active";} ?>"><a href="gallery.php">Gallery</a></li>
			<li class="dropdown 
				<?php 
					if($pagename=="about-me.php"
						 ||$pagename=="bucketlist.php" 
						 ||$pagename=="time-capsule.php" 
						 ||$pagename=="vault.php" 
						 ||$pagename=="treasured-memories.php" 
						 ||$pagename=="details.php") 
						 {
						 	echo "active";
						 } 
				?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Profile <b class="caret"></b></a>
				<ul class="dropdown-menu" role="menu">
					<li class="<?php if($pagename == 'about-me.php') {echo "active";} ?>"><a href="about-me.php">About Me</a></li>
				    <li class="<?php if($pagename == "bucketlist.php") {echo "active";} ?>"><a href="bucketlist.php">My Bucket List</a></li>
				    <li class="<?php if($pagename == "time-capsule.php") {echo "active";} ?>"><a href="time-capsule.php">Time Capsule</a></li>
				    <li class="<?php if($pagename == "vault.php") {echo "active";} ?>"><a href="vault.php">Vault</a></li>
				    <li class="<?php if($pagename == "treasured-memories.php"){echo "active";} ?>"><a href="treasured-memories.php">Treasured Memories</a></li>
				    <li class="divider"></li>
				    <li><a href="details.php">Account Details</a></li>
				</ul>
				<li class="<?php if($pagename=="tree.php"){echo "active";} ?>"><a href="tree.php">Family Tree</a></li>
			</li>
			<li><a href="#"><?php echo $pageTitle; ?></a></li>
			<li><?php echo $page_action; ?></li>
          </ul>
          
          <ul class="nav navbar-nav navbar-right">
          	<li><a href="http://en.wikipedia.org/wiki/Software_testing#Alpha_testing" target="_blank">ALPHA</a></li>
          	<li class="<?php if ($pagename == "tell-us.php") echo "active"; ?>"><a href="tell-us.php">Tell us</a></li>
          	<!--<li class="<?php if ($pagename == "") echo "active"; ?>"><a href="jobs/">Jobs List</a></li>-->
          	<form class="navbar-form pull-left" method="post" action="search.php">
			  <input type="text" class="form-control" style="width: 200px;" name="SearchText">
			  <button type="submit" 
			  	class="btn btn-default" 
			  	data-toggle="tooltip" 
			  	data-placement="bottom" 
			  	title 
			  	data-original-title="Tooltip on the bottom">Search</button>
			</form>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

	<!-- block to drop the content below the nav bar-->
	<div style="height: 24px;"></div>
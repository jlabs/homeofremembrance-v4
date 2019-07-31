<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title></title>


    <link href="css/build/global.css" rel="stylesheet" type="text/css">

    <!--Google Font-->
    <!--used for headings-->
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Pacifico">
    <!--body text-->
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
    
    <!-- errors & messages --->
	<?php
	
		// show negative messages
		if ($login->errors) {
		    foreach ($login->errors as $error) {
		        echo "<div class='alert alert-danger'>".$error."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";    
		    }
		}
		
		// show positive messages
		if ($login->messages) {
		    foreach ($login->messages as $message) {
		        echo "<div class='alert alert-success'>".$message."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";
		    }
		}
	
	?>

      <form class="form-signin" method="post" action="frontdoor.php" name="loginform">
        <h2 class="form-signin-heading">Enter email</h2>
        <input type="text" 
        	class="form-control" 
        	placeholder="Your email" 
        	autofocus id="login_input_username" 
        	class="login_input" 
        	type="text" 
        	name="user_email" 
        	required >
<?php if (!isset($_GET['key'])) { ?>
	        <input type="password" 
	        	class="form-control" 
	        	placeholder="Password" 
	        	id="login_input_password" 
	        	class="login_input" 
	        	type="password" 
	        	name="user_password" 
	        	autocomplete="off" required>	        
<?php } elseif (isset($_GET['key']) && isset($_GET['p'])) { ?>
			<input name="key" type="hidden" value="<?php echo $_GET['key']; ?>"/>
	        <input name="p" type="hidden" value="<?php echo $_GET['p']; ?>"/>
<?php } ?>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-warning btn-block" 
        	type="submit"
        	name="login" 
        	value="Log in">Sign in</button>
        	<a href="register.php">Register new account</a>
      </form>
	  
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<?php @include("footer.php"); ?>
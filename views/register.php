<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.png">

    <title>Register</title>

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
if ($registration->errors) {
    foreach ($registration->errors as $error) {
        echo "<div class='alert alert-danger alert-dismissable'>".$error."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button></div>";  
    }
}

// show positive messages
if ($registration->messages) {
    foreach ($registration->messages as $message) {
        echo "<div class='alert alert-success alert-dismissable'>".$message."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button></div>";
    }
}

?>
<!-- errors & messages --->

<div class="register-form col-lg-4 col-lg-offset-4">
	<!-- register form -->
	<form method="post" action="register.php" name="registerform">   
	    <h2 class="form-signin-heading">Please fill in the below fields</h2>
	    <!-- the user name input field uses a HTML5 pattern check -->
	    <!--<div class="form-group">
		    <label for="login_input_username">Username (only letters and numbers, 2 to 64 characters)</label>
		    <input id="login_input_username" 
		    	class="form-control" 
		    	placeholder="Username" 
		    	type="text" 
		    	name="user_name" 
		    	required />
	    </div>-->
	    
	    <!-- the email input field uses a HTML5 email type check -->
	    <div class="form-group">
	    	<label for="">Your name</label>
	    	<input id="login_input_name"
	    		class="form-control" 
	    		type="text"
	    		placeholder="Your name"
	    		name="user_fullname"/>
	    </div>
	    
	    <div class="form-group">
		    <label for="login_input_email">eMail</label>    
		    <input id="login_input_email" 
		    	class="form-control" 
		    	placeholder="eMail address" 
		    	type="email" 
		    	name="user_email" 
		    	required />        
	    </div>
	    
	    <div class="form-group">
		    <label for="login_input_email">Date of birth</label>    
		    <input id="login_input_dob" 
		    	class="form-control" 
		    	placeholder="Date of birth" 
		    	type="date" 
		    	name="user_dob" 
		    	required />        
	    </div>
	    
	    <div class="form-group">
		    <label for="login_input_email">Place of birth</label>    
		    <input id="login_input_pob" 
		    	class="form-control" 
		    	placeholder="Place of birth" 
		    	type="text" 
		    	name="user_pob" 
		    	required />        
	    </div>
	    
	    <div class="form-group">
		    <label for="login_input_password_new">Password (min. 6 characters)</label>
		    <input id="login_input_password_new" 
		    	class="form-control" 
		    	type="password" 
		    	placeholder="Password" 
		    	name="user_password_new" 
		    	pattern=".{6,}" 
		    	required 
		    	autocomplete="off" />  	    
		    <label for="login_input_password_repeat">Repeat password</label>
		    <input id="login_input_password_repeat" 
		    	class="form-control" 
		    	type="password" 
		    	placeholder="Repeat of Password" 
		    	name="user_password_repeat" 
		    	pattern=".{6,}" 
		    	required 
		    	autocomplete="off" />  
	    </div>  
	    <div class="form-group">    
			    <input type="submit"  
			    	name="register" 
			    	value="Register" 
			    	class="btn btn-lg btn-warning btn-block" />
	    </div>
	    
	    <!-- backlink -->
	</form>
</div>



    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<?php @include("footer.php"); ?>
<?php 
	@include("header.php");

	$pageTitle = "About Me"; 
	
	require_once("config/db.php");	
	//require_once("classes/Search.php");
?>

<div class="container">

	<?php
		
	
		// show negative messages
		if ($bucketlist->errors) {
		    foreach ($bucketlist->errors as $error) {
		        echo "<div class='alert alert-danger'>".$error."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";    
		    }
		}
		
		// show positive messages
		if ($bucketlist->messages) {
		    foreach ($bucketlist->messages as $message) {
		        echo "<div class='alert alert-success'>".$message."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";
		    }
		}
	
	?>
      
hi

</div>


      
<?php @include("footer.php"); ?>
<?php 
	@include("header.php");
	$pageTitle = "Home of Remembrance - About Me"; 
	
	// load the diary class
	require_once("config/db.php");	
	require_once("classes/Memories.php");
	$memory = new Memory();

?>


<!-- header area-->
<div class="container">

    <!-- errors & messages --->
	<?php
	
		// show negative messages
		if ($memory->errors) {
		    foreach ($memory->errors as $error) {
		        echo "<div class='alert alert-danger'>".$error."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";    
		    }
		}
		
		// show positive messages
		if ($memory->messages) {
		    foreach ($memory->messages as $message) {
		        echo "<div class='alert alert-success'>".$message."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";
		    }
		}
	
	?>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
      	<div class="col-lg-6">
      		<div class="row">
      		
      		<!--Add page component if needed-->
      		
      		</div>
      	</div>
      	<div class="col-lg-6">
	      	<div class="dashboard">
	      		<div class="dashboardheading"><?php echo $_SESSION['user_firstname']; ?>'s Treasured Memories</div>
	      		<div class="dashboardsubheading">Page subtitle</div>
	      	</div>
      	</div>
      </div>
</div>


      
<!--Main content area-->
<div class="container">
	<div class="row">
	
<?php

$memories = array();
$memories = $memory->getMemories();

if (is_array($memories))
{
	if ($memories != "null" || $memories != "na")
	{	      		
		foreach ($memories as $row)
		{		      		
  		?>		      		

	
		<div class="col-lg-3">
			<div class="thumbnail">
				<img src="<?php echo $row['url']; ?>" data-src="holder.js/100%180" alt="">
				<div class="caption">
					<!--<h4>Title?</h4>-->
					<p>
						<?php echo $row['desc']; ?>
					</p>
				</div>
			</div>
		</div>
		
		<?php		      		
		      		}	      		
		  		}      	
		  	}
      	?>    		 	
	
	</div>
</div>
      

      
<?php @include("footer.php"); ?>
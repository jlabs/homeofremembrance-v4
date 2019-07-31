<?php 
	@include("header.php");
	$pageTitle = "Home of Remembrance - Tell Us"; 
	
	require_once("config/db.php");	
	require_once("classes/TellUs.php");
	$tellUS = new TellUs();
	$jobs = $tellUS->getJobs();
?>




<!-- header area-->
<div class="container">

    <!-- errors & messages --->
	<?php
	
		// show negative messages
		if ($tellUS->errors) {
		    foreach ($tellUS->errors as $error) {
		        echo "<div class='alert alert-danger alert-dismissable'>".$error."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button></div>";    
		    }
		}
		
		// show positive messages
		if ($tellUS->messages) {
		    foreach ($tellUS->messages as $message) {
		        echo "<div class='alert alert-success alert-dismissable'>".$message."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button></div>";
		    }
		}
	
	?>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
      	<div class="col-lg-4">
      		<div class="row">
      		
      		<!--Add page component if needed-->
      		
      		</div>
      	</div>
      	<!--
      	<div class="col-lg-8">
	      	<div class="dashboard">
	      		<div class="dashboardheading">Sup <?php echo $_SESSION['user_firstname']; ?>?</div>
	      		<div class="dashboardsubheading">Got something to tell us? Here's the place</div>
	      	</div>
      	</div>
      	-->
      </div>
</div>


      
<!--Main content area-->
<div class="container">
	<div class="row">
	
			<div class="col-lg-6 col-lg-offset-3">
				<div class="panel">
					<div class="panel-heading">
						Tell us something
					</div>
					<div class="panel-body">
						Seen something, or noticed something? Maybe just want to tell us how awesome the site is ... feel free to do so below.
					</div>
				</div>
				
				
				<div class="panel">
				  	<div class="panel-heading">
				  		Whatcha found?
				  	</div>
				  	<div class="panel-body">
					<form class="form-horizontal" role="form" method="post" action="tell-us.php" name="changeForm">
						<input type="hidden" value="" />
					  <div class="form-group">
					    <!--<label for="inputPassword1" class="col-lg-2 control-label">Text</label>-->
					    <div class="col-lg-12">
					      <textarea class="form-control" placeholder="What were you doing?" name="doing" rows="4" required></textarea>
					    </div>
					  </div>
					  <div class="form-group">
					    <div class="col-lg-12">
					      <button type="submit" class="btn btn-warning" name="send">Send</button>
					    </div>
					  </div>
					</form>
				  	</div>
			  	</div>

		</div>
		
		
		
		
		<div class="col-lg-6 col-lg-offset-3">
			<div class="panel">
				<div class="panel-heading">What we're working on</div>
				<div class="panel-body">
					<div class="list-group">
				
						<?php
							//get the entries
						
							if (!empty($jobs))
							{
								
								foreach($jobs as $job)
								{
									?>
									
									
										<a href="#" class="list-group-item">
									    	<h4 class="list-group-item-heading"><?php echo $job["job"]; ?></h4>
											<p class="list-group-item-text"><?php echo $job["description"]; ?></p>
											<input type="checkbox" <?php if ($job['complete'] == "1") echo "checked"; ?> disabled /> Done
										</a>
									
									
									<?php
								}
								
							}
						
						?>
					</div>
				
				
				
				
		
				
				
				</div>
			</div>
		</div>
	
	</div>
</div>
      

      
<?php @include("footer.php"); ?>
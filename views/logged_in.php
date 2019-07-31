<?php 
	@include("header.php");

	$pageTitle = "Home of Remembrance - About Me"; 
	
	// load the frontdoor class
	require_once("config/db.php");	
	require_once("classes/FrontDoor.php");
	$frontdoor = new FrontDoor();
	
	$diary = (array)$frontdoor->Diary();
	
	//$family = array();
	//$family = $frontdoor->Family();
?>


<!-- header area-->
<div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
      	<div class="col-lg-4">
      		<div class="row">
      		
      		<!--Add page component if needed-->
      		
      		</div>
      	</div>
      	<div class="col-lg-8">
	      	<div class="dashboard">
	      		<div class="dashboardheading">Hello <?php echo $_SESSION['user_firstname']; ?></div>
	      		<div class="dashboardsubheading">Welcome to the Home of Remembrance</div>
	      	</div>
      	</div>
      </div>
</div>


      
<!--Main content area-->
<div class="container">
	<div class="row">
	
		<div class="col-lg-3 col-md-3 col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-heading">Family Members</h3>
				</div>
				<div class="panel-body">
					<p>
					<?php 
					if ($_SESSION['family_id'] == 2)
					{
						//echo $family; 
						$family = $frontdoor->Family();
						echo $family;					
					}
					else
					{
						echo "It doesn't look like you're not registered to a Family yet.";
					}

					?>
					</p>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-heading">Diary</h3>
				</div>
				<div class="panel-body">
					<p>
					<?php 
						if ($diary['entry_text'] != "")
						{
							echo $diary['entry_text']; 
						} else {
							echo "Diary is currently empty";
						}							
					?>
					</p>
				</div>
			</div>
		</div>
		
		<div class="col-lg-3 col-md-3 col-sm-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-heading">Bucket List</h3>
				</div>
				<div class="panel-body">
					<p>
					<!-- list number of complete bucketlist items -->
					Placeholder for completed bucket list items.
					</p>
				</div>
			</div>
		</div>
	
	</div>
</div>
      

      
<?php @include("footer.php"); ?>
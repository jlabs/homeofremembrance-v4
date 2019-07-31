<?php 
	@include("header.php");

	$pageTitle = "About Me"; 
	
	require_once("config/db.php");	
	require_once("classes/TimeCapsule.php");
	
	$timecapsule = new TimeCapsule();
	$timecapsule_items = array();
	$timecapsule_items = $timecapsule->getTimeCapsule();
?>


<!-- header area-->
<div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
      	<div class="col-lg-4">
		  	<div class="panel">
      			<div class="panel-heading">Add to your time capsule</div>
      			<div class="panel-body">
      				<form class="form-horizontal" role="form" enctype="multipart/form-data" method="post" action="time-capsule.php">
					  <div class="form-group">
					    <label for="" class="col-lg-4 control-label">Title</label>
					    <div class="col-lg-8">
					      <input type="text" class="form-control" id="inputFileName" placeholder="Enter a file name" name="title">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="" class="col-lg-4 control-label">Select a file</label>
					    <div class="col-lg-8">
						    <input type="file" id="inputPhotoFile" multiple accept='' name="item">
					    </div>
					  </div>
					  <div class="form-group">
					    <div class="col-lg-offset-4 col-lg-8">
					      <button type="submit" class="btn btn-warning col-lg-12" name="add_to_capsule">Add</button>
					    </div>
					  </div>
					</form>
      			</div>
      		</div>
      	</div>
      	<div class="col-lg-8">
	      	<div class="dashboard">
	      		<div class="dashboardheading"><?php echo $_SESSION['user_firstname']; ?>'s Time Capsule</div>
	      		<div class="dashboardsubheading">Number of time capsule items to go here</div>
	      	</div>
      	</div>
      </div>
</div>

<!--Main content area-->
<div class="container">	
		<div class="row">
			<?php
				if (is_array($timecapsule_items))
				{
					if ($timecapsule_items != "null" || $timecapsule_items != "na")
					{
						foreach($timecapsule_items as $row)
						{
							?>
								
							  <div class="col-lg-3">
							    <div class="thumbnail">
							      <img src="img/icons/file_icon.png" data-src="" alt="..." width="100px">
							      <div class="caption">
							        <h3><?php echo $row['title']; ?></h3>							        
							        <p><a href="#" class="btn btn-warning">Edit</a> <a href="#" class="btn btn-danger">Delete</a></p>
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
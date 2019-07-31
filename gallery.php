<?php 
	$page_action = '<button style="margin-top: 7px;" class="btn btn-warning" data-toggle="modal" data-target="#myModal">Upload to gallery</button>';
	

	@include("header.php");

	$pageTitle = "Home of Remembrance - About Me";

	// load the diary class
	require_once("config/db.php");	
	require_once("classes/Gallery.php");
	$gallery = new Gallery();
?>



<div style="margin-top: 12px;"></div>

<div class="container">


<!--
<form class="navbar-form navbar-left" role="search">
  <div class="form-group">
    <input type="text" class="form-control" placeholder="Search">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
-->



    <!-- errors & messages --->
	<?php
	
		// show negative messages
		if ($gallery->errors) {
		    foreach ($gallery->errors as $error) {
		        echo "<div class='alert alert-danger alert-dismissable'>".$error."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button></div>";    
		    }
		}
		
		// show positive messages
		if ($gallery->messages) {
		    foreach ($gallery->messages as $message) {
		        echo "<div class='alert alert-success alert-dismissable'>".$message."<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button></div>";
		    }
		}
	
	?>



      	
</div>


      
      <!--Main content area-->
      <div class="container">
      	<div class="row">
      	
      	
      	
      	<?php
      		
      		$gallery_images = array();
      		$gallery_images = $gallery->getGallery();
      		
      		if (is_array($gallery_images))
      		{
		  		if ($gallery_images != "null" || $gallery_images != "na")
		  		{	      		
		      		foreach ($gallery_images as $row)
		      		{		      		
			      		?>		      			
						  	
						  	<div class="col-lg-2">
							    <div class="thumbnail">
							    <a href="<?php echo $row['url']; ?>" 
							    	rel="prettyPhoto[pp_gal]" 
							    	title="<?php echo $row['title']; ?>"
							    	>
							      <img name="image" 
							      	data-src="" 
							      	width="153px" 
							      	height="153px" 
							      	src="<?php echo $row['url']; ?>" 
							      	data-toggle="modal" 
							      	data-target="#myModal"
							      	alt="<?php echo $row['title']; ?>">
							    </a>
							      <div class="caption">
							        <h4><?php echo $row['title']; ?></h4>
								    <form class="" role="form" method="post" action="gallery.php">
								    	<div class="form-group">
								    	
									    	<button class="btn btn-warning" type="submit" name="edit" disabled>Edit</button>							        			
											<button class="btn btn-danger" type="submit" name="delete">Delete</button>
											
											<p></p>
											
											<button class="btn btn-default" type="submit" name="profile">Make Profile Pic</button>
											
											<input type="hidden" name="image_id" value="<?php echo $row['image_id']; ?>">
											<input type="hidden" name="url" value="<?php echo $row['url']; ?>">
								    	</div>
								    	
								    	
								    	
									</form>
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
      
      
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload your images</h4>
      </div>
      <div class="modal-body">
        
        <form class="" enctype="multipart/form-data" action="gallery.php" name="ImageUpload" id="ImageUpload" method="post">
        	<div class="form-group">
				<label for="inputPhotoFile" class="col-lg-4 control-label">Select a photo</label>
				<div class="col-lg-8">
					<!--<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />-->
				    <input type="file" id="inputPhotoFile" multiple accept='image/*' name="image[]">
				    <!-- <p class="help-block">JPG is recommended</p> -->
				</div>
				</div>
				<div class="form-group">
				
				  <button type="submit" class="btn btn-warning" name="add_image">Add</button>
				
				</div>
        </form>

        
      </div>
      <!--
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      -->
    </div>
  </div>
</div>
<!-- /modal -->
      
      
<?php @include("footer.php"); ?>
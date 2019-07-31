<?php 
	$page_action = '<button style="margin-top: 7px;" class="btn btn-warning" data-toggle="modal" data-target="#myModal">Add to diary</button>';

	@include("header.php");

	$pageTitle = "Home of Remembrance - Diary";

	// load the diary class
	require_once("config/db.php");	
	require_once("classes/Diary.php");
	$diary = new Diary();
	
?>

	


<div class="container">

    <!-- errors & messages --->
	<?php
		$diary_entries = array();
		$diary_entries = $diary->getDiaryEntries();
	
	// show negative messages
	if ($diary_entries->errors) {
	    foreach ($diary_entries->errors as $error) {
	        echo "<div class='alert alert-danger'>".$error."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";    
	    }
	}
	
	// show positive messages
	if ($diary_entries->messages) {
	    foreach ($diary_entries->messages as $message) {
	        echo "<div class='alert alert-success'>".$message."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";
	    }
	}
	
	?>
	
	<?php
		date_default_timezone_set('GMT');
		$time = time(); 
		$date = date('Y-m-d H:i',$time);			      
	?>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
      	
			
			
			
			
			<div class="morph-button morph-button-inflow morph-button-inflow-1">
						<button type="button"><span>Add diary entry</span></button>
						<div class="morph-content">
							<div>
								<div class="content-style-form content-style-form-4">
									<h2 class="morph-clone">Add diary entry</h2>
									<form role="form" method="post" action="my-life.php" name="diaryEntryForm">
										<input type="hidden" value="<?php echo date("o\-m\-d H:i:s"); ?>" name="entry_datetime" required>
										<p><textarea class="" placeholder="Add your text here" name="entry_text" rows="3" required></textarea></p>
										<p><button type="submit" class="" name="add_entry">Add</button></p>
									</form>
								</div>
							</div>
						</div>
			</div><!-- morph-button -->
      	

		  	

      	</div>
      </div>
      
</div>



<div class="container">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
	
<?php 	
	if ($diary_entries != "null")
	{
		
		if (!empty($diary_entries))
		{
			
		foreach($diary_entries as $row)
		{
			?>
			
			<div class="panel">
				<!--Main content area-->
				<div class="panel-body">
					<p><?php echo $row['entry_text']; ?></p>
				</div>
				<div class="panel-footer">
					<small><?php echo $row['entry_datetime']; ?></small>
					<form class="pull-right" method="post" action="my-life.php">
						<button type="submit" name="delete" class="btn btn-danger btn-xs">Delete</button>
						<input type="hidden" name="diary_id" value="<?php echo $row['diary_id']; ?>">
					</form>
				</div>
			</div>
			 
			<?php
		}
		}
	}
?>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Add to your diary</h4>
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


<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#home" role="tab" data-toggle="tab">Text</a></li>
  <li><a href="#images" role="tab" data-toggle="tab">Image</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="home">
	  text input here
  </div>
  <div class="tab-pane" id="images">
	  image uploader
  </div>
</div>

        
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
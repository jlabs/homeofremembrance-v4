<?php 
	@include("header.php");

	$pageTitle = "About Me"; 
	
	require_once("config/db.php");	
	require_once("classes/BucketList.php");
	
	$bucketlist = new BucketList();
	$bucketlist_items = array();
	$bucketlist_items = $bucketlist->getBucketList();
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


      
      
      
      
<!-- morph-button -->
			
<div class="morph-button morph-button-inflow morph-button-inflow-1">
			<button type="button"><span>Add diary entry</span></button>
			<div class="morph-content">
				<div>
					<div class="content-style-form content-style-form-4">
						<h2 class="morph-clone">Add to bucketlist</h2>
						<form role="form" method="post" action="bucketlist.php">
							<p><textarea class="" placeholder="Add your text here" name="title" rows="3" required></textarea></p>
							<p><button type="submit" class="" name="add_entry">Add</button></p>
						</form>
					</div>
				</div>
			</div>
</div><!-- morph-button -->




<?php

$keys = array_keys($bucketlist_items);
$iterations = count($bucketlist_items[$keys[0]]);
$collapsecount = 0;

for($i = 0; $i < $iterations; $i++) {

    $data = array();
    
    $collapsecount++;
        
    foreach($bucketlist_items as $key => $value) {
        $data[$key] = $value[$i];
    }
    
    //if the bucketlist array contains bucketlists
    if (!empty($data['buckets']))
    {
    	//print_r($data['buckets']['title']);		
		
		//html for showing the bucketlist item	
		?>
		
		
<form class="" role="form" method="post" action="bucketlist.php">				
	<div class="panel-group" id="accordion">
	  <div class="panel panel-warning">
	    <div class="panel-heading">
	    <div class="pull-right" style="margin-top: -9px; margin-right: 5px;">
		      	<button class="btn btn-success"
		      	type="submit"
		      	name="edit"
		      	title="edit" 
				data-toggle="modal" 
				data-target="#editbucketModal" 
				onclick="bucketIDForEditModal(<?php echo $data['buckets']['bucket_id']; ?>)">Edit</button>
		      	
		      	
			  	<button class="btn btn-danger" type="submit" name="delete" title="Delete">X</button>
	      	</div>
	      <h4 class="panel-title" id="bucket_title<?php echo $data['buckets']['bucket_id']; ?>"><?php echo $data['buckets']['title']; ?></h4>
	      
	    </div>
	    <div class="panel-body">    	
	    	<input type="hidden" name="bucket_id" value="<?php echo $data['buckets']['bucket_id']; ?>">
	        <p id="bucket_body<?php echo $data['buckets']['bucket_id']; ?>"><?php echo $data['buckets']['body']; ?></p>
	        <p id="bucket_completed<?php echo $data['buckets']['bucket_id']; ?>"><?php if ($data['buckets']['completed']==1) echo "Completed";	?></p>
	    </div>      
		<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $collapsecount; ?>" style="padding:15px;">
		  Show Milestones
		</a>      
	    <!-- for default opened view use <div id="collapseOne" class="panel-collapse collapse in"> -->
	    <div id="collapse<?php echo $collapsecount; ?>" class="panel-collapse collapse">
	      <table class="table">		  
		  	<thead>
		  		<tr>
		  			<th>Milestone</th>
		  			<th>Completed</th>
		  		</tr>
		  	</thead>
		  	
		  	<tbody>
		
		
		<?php	
		
		
		//if milestones arent empty
		if (!empty($data['milestones']))
	    {	    	
		    //print_r($data['milestones']);
		    
		    $milestone_keys = array_keys($data['milestones']);
		    $milestone_count = count($milestone_keys);
		    //print_r($milestone_count);
		    
		    for($c = 0; $c < $milestone_count; $c++)
		    {
			    
			    ?>
			    <tr>
		  			<td>
		  				<p id="milestone_text<?php echo $data['milestones'][$c]['milestone_id']; ?>"><?php echo $data['milestones'][$c]['milestone']; ?></p>
		  				<p><button class="btn btn-success"
						      	type="submit"
						      	name="edit"
						      	title="edit" 
								data-toggle="modal" 
								data-target="#editMilestoneModal" 
								onclick="milestoneIDForEditModal(<?php echo $data['milestones'][$c]['milestone_id']; ?>)">Edit</button></p>
		  			</td>
		  			<td><?php if (!empty($data['milestones'][$c]['reached'])) { echo $data['milestones'][$c]['reached']; } else { echo 'Add Reached';  } ?></td>
		  		</tr>
			    <?php
		    } 
		}
		?>
		
		
			</tbody>
		  </table>
	    </div>
	    <!-- end of collapse -->
	    <div class="panel-footer">
			<button class="btn btn-warning" 
				data-toggle="modal" 
				data-target="#milestoneModal" 
				onclick="bucketIDForModal(<?php echo $data['buckets']['bucket_id']; ?>)">Add Milestone</button>
		</div>
	  </div> 
	</div>
</form>		
		
</br>	
		
		<?php
	}
}




?>

</div>




<!-- Editing a milestone modal -->
<div class="modal fade" id="editMilestoneModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit a milestone</h4>
      </div>
      
      <div class="modal-body">
        
        <form class="" action="bucketlist.php" name="editMilestone" id="editMilestone" method="post">
        	<div class="form-group">
				<label for="" class="col-lg-4 control-label">What did you do?</label>
				<div class="col-lg-8">
				    <textarea name="milestone_text" cols="40" rows="5" id="milestone_edittext"></textarea>
				</div>
        	</div>
			<div class="form-group">				
				<button type="submit" class="btn btn-warning" name="milestone_edit">Save</button>				
			</div>
				<input type="text" id="milestone_id" name="milestone_id" />
        </form>

        
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      
    </div>
  </div>
</div>
<!-- /modal -->





<!-- Edit bucketlist item modal -->
<div class="modal fade" id="editbucketModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit bucketlist <?php echo $bucket_id; ?></h4>
      </div>
      <div class="modal-body">
        
        <form class="form-horizontal" action="bucketlist.php" name="" id="" method="post">
         <div class="form-group">
         	<label class="control-label col-lg-4">Title</label>
         	<div class="col-lg-8">
	         	<input type="text" name="title" id="bucket_edittitle" />
         	</div>
         </div>
         <div class="form-group">
         	<label class="control-label col-lg-4">Body</label>
         	<div class="col-lg-8">
         		<textarea cols="40" rows="5" id="bucket_editbody" name="body">body text here</textarea>
         	</div>
         </div>
         <div class="form-group">
         	<div class="col-lg-8 col-lg-offset-4">
         		<div class="checkbox">
         			<label>
         				<input type="checkbox" name="completed" id="bucket_editcompleted" />
         			</label>
         		</div>
         	</div>
         </div>
         <div class="form-group">
         	<div class="col-lg-8 col-lg-offset-4">
         		<button type="submit" class="btn btn-warning" name="save">Save</button>
         	</div>
         </div>
					
		 <input type="text" id="bucketIDModal" name="bucket_id"/>

        </form>

        
      </div>
      
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      
      
    </div>
  </div>
</div>
<!-- /modal -->


<!-- Adding a milestone modal -->
<div class="modal fade" id="milestoneModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Add a milestone <?php echo $bucket_id; ?></h4>
      </div>
      <div class="modal-body">
        
        <form class="" action="bucketlist.php" name="addMilestone" id="addMilestone" method="post">
        	<div class="form-group">
				<label for="" class="col-lg-4 control-label">What did you do?</label>
				<div class="col-lg-8">
				    <textarea name="milestone_text" cols="40" rows="5"></textarea>
				</div>
			</div>
			<div class="form-group">				
				  <button type="submit" class="btn btn-warning" name="milestone_add">Add</button>				
			</div>				
				
				<input type="text" id="bucketIDModal" name="milestone_bucketid"/>
        </form>

        
      </div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      
    </div>
  </div>
</div>
<!-- /modal -->








      
<?php @include("footer.php"); ?>
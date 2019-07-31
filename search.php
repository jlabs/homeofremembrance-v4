<?php 
	@include("header.php");

	$pageTitle = "Results"; 
	
	require_once("config/db.php");	
	require_once("classes/Search.php");
	
	$search = new Search();
	
?>

<div class="container">

	<?php
		
	
		// show negative messages
		if ($search->errors) {
		    foreach ($search->errors as $error) {
		        echo "<div class='alert alert-danger'>".$error."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";    
		    }
		}
		
		// show positive messages
		if ($search->messages) {
		    foreach ($search->messages as $message) {
		        echo "<div class='alert alert-success'>".$message."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";
		    }
		}
	
	?>
<div class="row">
<?php

	$results = array();
	$results = $search->GetPeopleResults();
	
	if (!empty($results) && $results != "not found")
	{
		//print_r($results);
	
		foreach($results as $value)
		{
			//echo "<p>".$value['user_firstname']." ".$value['user_surname']."</p>";
			
			?>
			



  <div class="col-sm-3">
    <div class="thumbnail">
      <img data-src="holder.js/300x300" src="http://placekitten.com/g/300/300" alt="...">
      <div class="caption">
        <h3><?php echo $value['user_firstname']." ".$value['user_surname']; ?></h3>
        <p>...</p>
        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p>
      </div>
    </div>
  </div>


			
			<?php
		}
	}
	else
	{
		echo "Sorry, nothing found";
	}

?>
</div>

</div>


      
<?php @include("footer.php"); ?>
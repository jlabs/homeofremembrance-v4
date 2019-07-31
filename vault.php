<?php 
	@include("header.php");

	$pageTitle = "Home of Remembrance - About Me"; 
	
	require_once("config/db.php");	
	require_once("classes/Vault.php");
	
	$vault = new Vault();
?>


<!-- header area-->
<div class="container">

    <!-- errors & messages --->
	<?php
		$vault_details = (array)$vault->getVault();		
	
		// show negative messages
		if ($vault->errors) {
		    foreach ($vault->errors as $error) {
		        echo "<div class='alert alert-danger'>".$error."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";    
		    }
		}
		
		// show positive messages
		if ($vault->messages) {
		    foreach ($vault->messages as $message) {
		        echo "<div class='alert alert-success'>".$message."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";
		    }
		}
	
	?>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
      	<div class="col-lg-8 col-lg-offset-4">
	      	<div class="dashboard">
	      		<div class="dashboardheading"><?php echo $_SESSION['user_firstname']; ?>'s Vault</div>
	      		<div class="dashboardsubheading">Page subtitle</div>
	      	</div>
      	</div>
      </div>
</div>


      
<!--Main content area-->
<div class="container">
	<div class="row">
		<div class="col-lg-6 col-lg-offset-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<form class="form-horizontal" 
						role="form" 
						method="post" 
						action="vault.php"
						enctype="multipart/form-data">
					  <div class="form-group">
					    <label for="inputEmail1" 
					    	class="col-lg-3 control-label">
					    	Doctor Name
					    </label>
					    <div class="col-lg-9">
					      <input name="doctor" 
					      	type="text" 
					      	class="form-control" 
					      	id="inputEmail1" 
					      	placeholder="Doctors Name" 
					      	value="<?php echo $vault_details['doctor_name']; ?>">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="inputEmail1" 
					    	class="col-lg-3 control-label">
					    	Doctors Contact
					    </label>
					    <div class="col-lg-9">
					      <input name="doctor_contact" 
					      	type="text" 
					      	class="form-control" 
					      	id="inputEmail1" 
					      	placeholder="Doctors Contact" 
					      	value="<?php echo $vault_details['doctor_contact']; ?>">
					    </div>
					  </div>
					  
					  <div class="form-group">
					  	<label for="" 
					  		class="col-lg-3 control-label">
					  		Wedding Certificate
					  	</label>
						<div class="col-lg-9">	  
							  <input name="wedding_cert" 
							  	type="file" 
							  	id="wedding_cert"
							  	title="blah">
							  	<a class="btn btn-danger btn-xs" href="vault.php?delete=wc">DELETE</a>
							  	<small><label for="wedding_cert"><?php echo $vault_details['wedding_cert_filename']; ?></label></small>
						</div>
					  </div>
					  <div class="form-group">
					  	<label for="exampleInputFile" 
					  		class="col-lg-3 control-label">
					  		Birth Certificate
					  	</label>
					  	<div class="col-lg-9">
					  		<input name="birth_cert" 
					  			id="birth_cert"
					  			type="file" id="exampleInputFile">
					  			<a class="btn btn-danger btn-xs" href="vault.php?delete=bc">DELETE</a>
					  			<small>
					  				<label for="birth_cert"><?php echo $vault_details['birth_cert_filename']; ?></label>
					  			</small>
					  	</div>
					  </div>
					  <div class="form-group">
					  	<label for="exampleInputFile" 
					  		class="col-lg-3 control-label">
					  		Insurance Details
					  	</label>
					  	<div class="col-lg-9">
					  		<input name="insurance" 
					  			type="file" 
					  			id="insurance">
					  			<a class="btn btn-danger btn-xs" href="vault.php?delete=i">DELETE</a>
					  			<small>
					  				<label for="insurance"><?php echo $vault_details['insurance_filename']; ?></label>
					  			</small>
					  			
					  	</div>
					  </div>					  

					  <div class="form-group">
					    <label for="inputEmail1" 
					    	class="col-lg-3 control-label">
					    		Funeral Arrangements
					    </label>
					    <div class="col-lg-9">
					    	<textarea name="funeral" 
					    		class="form-control" 
					    		rows=""><?php echo $vault_details['funeral_arrangements'];?></textarea>
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="inputEmail1" class="col-lg-3 control-label">Final Resting Place</label>
					    <div class="col-lg-9">
					      <input name="resting" type="" class="form-control" id="inputEmail1" placeholder="Email" value="<?php echo $vault_details['resting_place']; ?>">
					    </div>
					  </div>

					  <div class="form-group">
					    <label for="inputEmail1" class="col-lg-3 control-label">Will Information</label>
					    <div class="col-lg-9">
					      <input name="will" type="" class="form-control" id="inputEmail1" placeholder="Email" value="<?php echo $vault_details['will']; ?>">
					    </div>
					  </div>
					  
					  <div class="form-group">
					    <label for="inputEmail1" class="col-lg-3 control-label">Additional Information</label>
					    <div class="col-lg-9">
					      <textarea name="additional" class="form-control" rows=""><?php echo $vault_details['additional_info']; ?></textarea>					    
					    </div>
					  </div>

					  <div class="form-group">
					    <div class="col-lg-offset-3 col-lg-9">
					      <button type="submit" class="btn btn-warning col-lg-12" name="vault">Save</button>
					    </div>
					  </div>
					</form>	
				</div>
			</div>	
		</div>
	</div>
</div>
      

      
<?php @include("footer.php"); ?>
<?php 
	@include("header.php");
	
	$pageTitle = "About Me"; 
	
	//load the class
	require_once("config/db.php");	
	require_once("classes/AboutMe.php");
	$aboutme = new AboutMe();
	$aboutme_details = (array)$aboutme->getAboutMe();	
	$basic_details = (array)$aboutme->getBasicInfo();
?>

<div class="container">

    <!-- errors & messages --->
	<?php
			
	
		// show negative messages
		if ($aboutme->errors) {
		    foreach ($aboutme->errors as $error) {
		        echo "<div class='alert alert-danger'>".$error."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";    
		    }
		}
		
		// show positive messages
		if ($aboutme->messages) {
		    foreach ($aboutme->messages as $message) {
		        echo "<div class='alert alert-success'>".$message."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";
		    }
		}
	
	?>


      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
      	<div class="col-lg-4">
      		<div class="row">
      		      		      		
      		</div>
      	</div>
      	<!--
      	<div class="col-lg-8">
	      	<div class="dashboard">
	      		<div class="dashboardheading">About <?php echo $_SESSION['user_firstname']; ?></div>
	      		<div class="dashboardsubheading">A story about <?php echo $_SESSION['user_firstname']; ?> - Page to be changed</div>
	      	</div>
      	</div>
      	-->
      </div>
</div>

     
      <!--Main content area-->
      <div class="container">
      	<div class="row">
			
			<!-- show pic on tree page -->
			<a href="gallery.php">
			<div class="profilepiccropper img-thumbnail" style="background-image:url('<?php echo $basic_details['profile_img'] ?>')"></div>
			</a>
			<div class="overview">
				<h3><?php echo $basic_details['user_fullname']; ?></h3>
				<h4><?php echo $basic_details['date_of_birth']; ?></h4>
			</div>
      		
      		<div class="col-lg-6 col-lg-offset-3">
      			<div class="panel panel-default">
      				<div class="panel-body">
      					
      					     		
      					
	      				<form role="form" class="form-horizontal" method="post" action="about-me.php">
	      				
	      				<!-- add name, dob, place of birth -->
	      				
						  <div class="form-group">
						  	<label class="control-label col-lg-4">A bit about me</label>
						  	<div class="col-lg-8">
							    <input type="" 
							    	name="aboutme" 
							    	class="form-control" 
							    	id="inputBitAboutMe" 
							    	placeholder="A bit about me" 
							    	value="<?php echo $aboutme_details['about_me']; ?>">
						  	</div>
						  </div>

	      				
						  <div class="form-group">
							  <label class="control-label col-lg-4">I was born in</label>
							  <div class="col-lg-8">
							    <input type="" 
							    	name="born"
							    	class="form-control" 
							    	id="inputBornIn" 
							    	placeholder="I was born in" 
							    	value="<?php echo $aboutme_details['born']; ?>">
							  </div>
						  </div>
						  
						  <div class="form-group">
						  	<label class="control-label col-lg-4">My parents are</label>
						  	<div class="col-lg-8">
						    <input type="" 
						    	name="parents"
						    	class="form-control" 
						    	id="inputParentsAre" 
						    	placeholder="My parents are" 
						    	value="<?php echo $aboutme_details['parents']; ?>">
						  	</div>
						  </div>
						  
						  <div class="form-group">
						  	<label class="control-label col-lg-4">During my life I have lived in</label>
						  	<div class="col-lg-8">
						    <input type="" 
						    	name="lived"
						    	class="form-control" 
						    	id="inputLivedIn" placeholder="I have lived in" value="<?php echo $aboutme_details['lived']; ?>">
						  	</div>
						  </div>
						  
						  <div class="form-group">
						  	<label class="control-label col-lg-4">I was educated at</label>
						  	<div class="col-lg-8">
   						    <input type="" 
   						    	name="educated"
						    	class="form-control" 
						    	id="inputEducatedAt" 
						    	placeholder="I was educated at" 
						    	value="<?php echo $aboutme_details['educated']; ?>">
						  	</div>
						  </div>
						  
						  <div class="form-group">
						  	<label class="control-label col-lg-4">I am currently</label>
						  	<div class="col-lg-8">
						    <input type="" 
						    	name="currently"
						    	class="form-control" 
						    	id="inputIAmCurrently" 
						    	placeholder="I am currently" 
						    	value="<?php echo $aboutme_details['currently']; ?>">
						  	</div>
						  </div>	

						  <div class="form-group">
						  	<label class="control-label col-lg-4">I'm really into</label>
						  	<div class="col-lg-8">
						    <input type=""
						    	name="into" 
						    	class="form-control" 
						    	id="inputReallyInto" 
						    	placeholder="I'm really into" 
						    	value="<?php echo $aboutme_details['im_into']; ?>">
						  	</div>
						  </div>						  

						  <div class="form-group">
						  	<label class="control-label col-lg-4">But I don't like</label>
						  	<div class="col-lg-8">
						    <input type="" 
						    	name="dontlike"
						    	class="form-control" 
						    	id="inputDontLike" 
						    	placeholder="But I don't like" 
						    	value="<?php echo $aboutme_details['dont_like']; ?>">
						  	</div>
						  </div>
						  						  		
						  <button type="submit" class="btn btn-warning" name="frm_aboutme">Update</button>
			  						  
						</form>
      				</div>
      			</div>
      		</div>

      	
      	</div>
      </div>
      

      
<?php @include("footer.php"); ?>
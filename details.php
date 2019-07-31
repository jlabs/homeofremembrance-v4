<?php 
	$pageTitle = "Home of Remembrance - My Detail"; 
	@include("header.php");	
	
	require_once("config/db.php");	
	require_once("classes/Details.php");
	$details = new Details();
	$person_details = (array)$details->getDetails();
?>

<div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
      	<div class="col-lg-4">
      		<div class="row">
      		
      		
      		
      		</div>
      	</div>
      	<div class="col-lg-8">
	      	<div class="dashboard">
	      		<div class="dashboardheading">About <?php echo $_SESSION['user_firstname']; ?></div>
	      		<div class="dashboardsubheading">A story about <?php echo $_SESSION['user_firstname']; ?></div>
	      	</div>
      	</div>
      </div>
</div>
      
      <!--Main content area-->
      <div class="container">
      	<div class="row">  
      	    		
      		<div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">
	      		<div class="panel">
	      			<div class="panel-body">
		      			<form class="form-horizontal" role="form" action="details.php" method="post">
						  <div class="form-group">
						    <label for="inputEmail1" class="col-lg-4 control-label">First name</label>
						    <div class="col-lg-8">
						      <input type="text" 
						      	class="form-control" 
						      	id="user_firstname" 
						      	name="user_firstname"
						      	placeholder="Firstname" 
						      	value="<?php echo $person_details['user_firstname']; ?>">
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword1" class="col-lg-4 control-label">Surname</label>
						    <div class="col-lg-8">
						      <input type="text" 
						      	class="form-control" 
						      	id="user_surname" 
						      	name="user_surname"
						      	placeholder="Surname"
						      	value="<?php echo $person_details['user_surname']; ?>">
						    </div>
						  </div>
						  <div class="form-group">
						    <div class="col-lg-offset-4 col-lg-8">
						      <button type="submit" class="btn btn-warning col-lg-12" name="updateDetails">Update</button>
						    </div>
						  </div>
						</form>
	      			</div>
	      		</div>
      		</div>
      	
      	</div>
      </div>
      
      <div class="container">
      	<div class="row">
      		 <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2">
	      		<div class="panel">
		      		<div class="panel-body">
		      			<form class="form-horizontal" role="form" method="post" action="details.php">
						  <div class="form-group">
						    <label for="inputEmail1" class="col-lg-4 control-label">Email</label>
						    <div class="col-lg-8">
						      <input type="email" 
						      	name="mail"
						      	class="form-control" 
						      	id="inputEmail1" 
						      	placeholder="Email">
						    </div>
						  </div>
						  <div class="form-group">
						    <label for="inputPassword1" class="col-lg-4 control-label">Password</label>
						    <div class="col-lg-8">
						      <input type="password" name="pwd" class="form-control" id="inputPassword1" placeholder="Password">
						    </div>
						  </div>
						  <div class="form-group">
						    <div class="col-lg-offset-4 col-lg-8">
						      <button name="emailpass" type="submit" class="btn btn-warning col-lg-12" disabled>Update</button>
						    </div>
						  </div>
						</form>
					</div>
	      		</div>
      		</div>

      	</div>
      </div>
      

      
<?php @include("footer.php"); ?>
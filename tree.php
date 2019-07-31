<?php 
	$pageTitle = "Home of Remembrance - Family Tree";
	@include("header.php"); 
	
	require_once("config/db.php");	
	require_once("classes/Tree.php");
	
	$tree = new Tree();
	$show_tree = array();
	$show_tree = $tree->getTree();
	$get_tree_owner = $tree->getTreeOwner();
?>



<!-- header area-->
<div class="container">

<?php
if ($get_tree_owner == "owner")
{
?>
<!-- nav bar header to add people only visible to person who made tree -->
<form class="navbar-form" role="form" method="post" action="tree.php">
  	<div class="form-group">
  		<label class="control-label">Name</label>
    	<input type="text" class="form-control" name="person_name" placeholder="First and Last name">
	</div>
	<div class="form-group">
		<label class="control-label">Email</label>
		<input type="email" class="form-control" placeholder="Leave blank if not known" name="person_mail">
	</div>
	<div class="form-group">
		<label class="control-label">Relation to you</label>
		<select class="form-control" name="relation">
				<option>grandmother</option>
				<option>grandfather</option>
				<option>mother</option>
				<option>father</option>
				<option>brother</option>
				<option>sister</option>
				<option>daughter</option>
				<option>son</option>
		</select>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-warning" name="add_root" style="margin-top:25px;">Add</button>
		<input type="hidden" name="tree_id" value="<?php echo $_SESSION['tree_id']; ?>">
	</div>
</form>	
<?php
}
?>


<?php
	// show negative messages
	if ($tree->errors) {
	    foreach ($tree->errors as $error) {
	        echo "<div class='alert alert-danger'>".$error."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";    
	    }
	}
	
	// show positive messages
	if ($tree->messages) {
	    foreach ($tree->messages as $message) {
	        echo "<div class='alert alert-success'>".$message."<button type='button' class='close' aria-hidden='true'>&times;</button></div>";
	    }
	}

?>

      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
      	<div class="col-lg-4">
      		<div class="row">
      		<!--
      		<?php
      			if (!empty($show_tree))
      			{
      		?>
      		-->
      			<! add root panel -->
      			<!--
      			<div class="panel">
      				<div class="panel-heading">Add a root</div>
  					<div class="panel-body">
  		
		      			<form class="form-horizontal" role="form" method="post" action="tree.php">
		      				<div class="form-group">
		      					<label class="col-lg-4 control-label">Name</label>
		      					<div class="col-lg-8">
		      						<input type="text" class="form-control" name="person_name" placeholder="First and Last name please">
		      					</div>
		      				</div>
		      				
		      				<div class="form-group">
		      					<label class="col-lg-4 control-label">eMail</label>
		      					<div class="col-lg-8">
		      						<input type="email" class="form-control" placeholder="Leave blank if not known" name="person_mail">
		      					</div>	
		      				</div>
		      				<div class="form-group">
		      					<label class="col-lg-4 control-label">Relation to you</label>
		      					<div class="col-lg-8">
				      				<select class="form-control" name="relation">
									  <option>grandmother</option>
									  <option>grandfather</option>
									  <option>mother</option>
									  <option>father</option>
									  <option>brother</option>
									  <option>sister</option>
		  							  <option>daughter</option>
									  <option>son</option>
									</select>
		      					</div>
		      				</div>
		      				<div class="form-group">
		      					<div class="col-lg-8 col-lg-offset-4">
		      						<button type="submit" class="btn btn-warning col-lg-12" name="add_root">Add</button>
		      						<input type="hidden" name="tree_id" value="<?php echo $_SESSION['tree_id']; ?>">
		      					</div>
		      				</div>
		      			</form>
		      			
  					</div>
      			</div>
      			<?php
      				}
      			?>-->
      		</div>
      	</div>
      	
      	<!--
      	<div class="col-lg-8">
	      	<div class="dashboard">
	      		<div class="dashboardheading"><?php echo $_SESSION['user_firstname']; ?>'s Family Tree</div>
	      		<div class="dashboardsubheading">Page subtitle</div>
	      	</div>
      	</div>
      	-->
      </div>
</div>


      
<!--Main content area-->
<div class="container">
	<div class="row">



	
<?php
	$grandparents = array();
	$parents = array();
	$siblings = array();
	$children = array();
	
	if (!empty($show_tree))
	{	
		foreach($show_tree as $row)
		{ 
			$user_id = $row['user_id']; 
			$get_root = $tree->getRoot($user_id);
			
			if ($row['family_status'] == "grandfather" || $row['family_status'] == "grandmother")
			{
				$grandparents[] = $get_root.";".$row['family_status'].";".$user_id;
			} 
			elseif ($row['family_status'] == "father" || $row['family_status'] == "mother") 
			{
				$parents[] = $get_root.";".$row['family_status'].";".$user_id;
			} 
			elseif ($row['family_status'] == "brother" || $row['family_status'] == "sister") 
			{
				$siblings[] = $get_root.";".$row['family_status'].";".$user_id;
			}
			elseif ($row['family_status'] == "son" || $row['family_status'] == "daughter")
			{
				$children[] = $get_root.";".$row['family_status'].";".$user_id;
			}
			
		}
		
		
	} 
	else 
	{
		?> 
		<div class="alert alert-info">
			<p><h3>Looks like you don't have a family tree ... yet.</h3></p>
			<p>Don't worry though, you can plant a new tree by <a class="text-info" href="tree.php?plant_tree=true">clicking here</a></p> 
		</div>
		<?php 	
	}
?>

<?php if (!empty($grandparents)) { ?>
<div class="col-lg-8 col-lg-offset-2">
	<div class="panel">
		<div class="panel-heading"><h2>Grandparents</h2></div>
		<div class="panel-body">
			<ul class="list-inline">
				<?php
					//for each person in array echo the html
					foreach($grandparents as $person)
					{
						$person_split = split(";", $person);
						
				?>
					<li>
						<h3>
						
						<?php
							if ($get_tree_owner == "owner") 
							{
								echo "<a href=details.php?edit=".$person_split[2].">";
							}
							else
							{
								echo "<a href=details.php?person=".$person_split[2].">";
							}
								
						?>
						
							<!-- <a href="details.php?edit=<?php echo $person_split[2]; ?>"> -->
								<?php echo $person_split[0]; ?> 
							</a>
							<small>
								<?php echo $person_split[1]; ?>
							</small>
						</h3>
					</li>
					<!-- edit form goes to the details page to update all the information -->
					
				<?php
					//end of for each
					}
				?>				
			</ul>
		</div>
	</div>
</div>
<?php } ?>

<!--
<?php if (!empty($parents)) { ?>
<div class="col-lg-8 col-lg-offset-2">
	<div class="panel">
		<div class="panel-heading"><h2>Parents</h2></div>
		<div class="panel-body">
			<ul class="list-inline">
				<?php
					//for each person in array echo the html
					foreach($parents as $person)
					{
						$person_split = split(";", $person);
						
				?>
					<li><h3><?php echo $person_split[0]; ?> <small><?php echo $person_split[1]; ?></small></h3></li>
					<a href="">edit</a>
	
				<?php
					//end of for each
					}
				?>				
			</ul>
		</div>
	</div>
</div>
<?php } ?>
-->

<?php if (!empty($parents)) { ?>
<div class="col-lg-8 col-lg-offset-2">
	<div class="panel">
		<div class="panel-heading"><h2>Parents</h2></div>
		<div class="panel-body">
			<ul class="list-inline">
				<?php
					//for each person in array echo the html
					foreach($parents as $person)
					{
						$person_split = split(";", $person);
						
				?>
					<li><h3><?php echo $person_split[0]; ?> <small><?php echo $person_split[1]; ?></small></h3></li>
					<a href="">edit</a>
	
				<?php
					//end of for each
					}
				?>				
			</ul>
		</div>
	</div>
</div>
<?php } ?>

<?php if (!empty($siblings)) { ?>
<div class="col-lg-8 col-lg-offset-2">
	<div class="panel">
		<div class="panel-heading"><h2>Siblings</h2></div>
		<div class="panel-body">
			<ul class="list-inline">
				<?php
					//for each person in array echo the html
					foreach($siblings as $person)
					{
						$person_split = split(";", $person);
						
				?>
					<li><h3><?php echo $person_split[0]; ?> <small><?php echo $person_split[1]; ?></small></h3></li>	
				<?php
					//end of for each
					}
				?>				
			</ul>
		</div>
	</div>
</div>
<?php } ?>

<?php if (!empty($children)) { ?>
<div class="col-lg-8 col-lg-offset-2">
	<div class="panel">
		<div class="panel-heading"><h2>Children</h2></div>
		<div class="panel-body">
			<ul class="list-inline">
				<?php
					//for each person in array echo the html
					foreach($children as $person)
					{
						$person_split = split(";", $person);
						
				?>
					<li><h3><?php echo $person_split[0]; ?> <small><?php echo $person_split[1]; ?></small></h3></li>
					<form class="form-horizontal" role="form" method="post" action="tree.php">
						<div class="form-group">
							edit
						</div>

					</form>

				<?php
					//end of for each
					}
				?>				
			</ul>
		</div>
	</div>
</div>
<?php } ?>
		
	
	</div>
</div>
            
<?php @include("footer.php"); ?>
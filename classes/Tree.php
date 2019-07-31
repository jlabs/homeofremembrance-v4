<?php

class Tree
{
	
    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {
    	if ($_GET['add_new'] == "true")
    	{
    		//add person to tree
    		$tree_id = $_GET['tree_id'];
    	}
    	
    	if ($_GET['plant_tree'] == "true")
    	{
	    	//create a tree
	    	$this->plantTree();
    	}
    	if (isset($_POST['add_root']))
    	{
	    	$this->addRoot();
    	}
    	
    	if ($_GET['join'] != "")
    	{
	    	$this->addRootToTree();
    	}
    }
    
    public function getTree()
    {
    	//db object
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        //select qry
        $person_treeID = $this->db_connection->query("SELECT tree_id FROM people WHERE	user_id = ".$_SESSION['user_id']."");
        
        while ($treeID = $person_treeID->fetch_assoc())
        {
        	$tree_id = $treeID['tree_id']; 
        }   
                       
        $get_tree = $this->db_connection->query("SELECT user_id, family_status FROM roots WHERE tree_id = $tree_id");
                // if this user exists
        if ($get_tree->num_rows >= 1) {
            
            $roots = array();
            while ($root = $get_tree->fetch_assoc())
            {
                $roots[] = $root;
                                
                if ($root["user_id"] == $_SESSION['user_id'])
                {
	                if ($root["family_status"] == "owner")
	                {
		                $_SESSION['tree_id'] = $tree_id;
	                }
                }
            }
            
            //if the current user is the owner, let them know.

            
            return $roots;
                            
        } else {
        	//$this->errors[] = "Sorry, no tree found";
            return null;
        }	    
    }
    
    public function getTreeOwner()
    {
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    $get_tree = $this->db_connection->query("SELECT status FROM tree WHERE user_id = ".$_SESSION['user_id']."");
	    $result = $get_tree->fetch_object();
	    $get_tree = $result->status;
		return $get_tree;
    }
    
    public function getRoot($user_id)
    {	
        $get_root = $this->db_connection->query("SELECT user_fullname FROM people WHERE user_id = ".$user_id."");
        $root_result = $get_root->fetch_object();
        //$person_firstname = $root_result->user_firstname;
        //$person_surname = $root_result->user_surname;
        //$person_fullname = $person_firstname . " " . $person_surname;
        $person_fullname = $root_result->user_fullname;
        return $person_fullname;        
    }
    
    public function addPerson($blankEmail,$alreadyExists)
    {
    	$this->theEmail = "";
    	
	    if ($blankEmail == true)
	    {
		    $this->theEmail = "generic@homeofremembrance.com";
	    }
    }
    
    public function addRoot()
    {
    	$this->relation = $_POST['relation'];    	
		$this->name = $_POST['person_name'];
		$newID = "";
		$status = "";
		$person_added = false;
		$this->tree_id = $_SESSION["tree_id"];
		
		//create temp profile pic
		$this->profile_img_width = rand(1,10)."00";
		$this->profile_img_height = rand(1,10)."00";
		$this->temp_profile_img = "http://placekitten.com/g/" . $this->profile_img_width . "/".$this->profile_img_height."";
		//$this->messages[] = $this->temp_profile_img;
    	
		require_once("libraries/password_compatibility_library.php");
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);	

		// add profile pic from placekitten http://placekitten.com/g/100/200
		// randomise first number then add 2 00's and make the url
		// for generic account

		//if the email is empty
    	if ($_POST['person_mail'] == "")
    	{
    		$this->messages[] = "No email specified, we'll create a generic one. Don't worry, you can change this at a later date";
	    	//using generic email
	    	
	    	$this->email = "generic@homeofremembrance.com";
	    	$this->password = password_hash("generic", PASSWORD_DEFAULT);
	    	$this->dob = "1970-01-01";
	    	$this->pob = "local";
	    	$this->is_registered = 0;
	    	$this->user_firstname = "NULL";
	    	$this->user_surname = "NULL";
	    	
	    	
	        $query_new_user_insert = $this->db_connection->query(
	        	"INSERT INTO people 
	        		(
	        			user_password_hash, 
	        			user_email, 
	        			user_fullname, 
	        			user_firstname, 
	        			user_surname, 
	        			date_of_birth, 
	        			place_of_birth, 
	        			is_registered, 
	        			tree_id,
	        			profile_img,
	        			family_id,
	        			privacy
	        		) 
	        	VALUES 
	        		(
	        		'" . $this->password . "', 
	        		'" . $this->email . "',
	        		'" . $this->name . "',
	        		'" . $this->user_firstname . "',
	        		'" . $this->user_surname . "',
	        		'" . $this->dob . "',
	        		'" . $this->pob . "',
	        		'" . $this->is_registered . "',
	        		'" . $this->tree_id . "',
	        		'" . $this->temp_profile_img . "',
	        		2,
	        		'private')"
            );
            
            $newID = $this->db_connection->insert_id;
            
            if ($query_new_user_insert) 
            {
            	$this->messages[] = "The person has been added";
            	$newID = $this->db_connection->insert_id;
            	//add root
            	$person_added = true;
            }
            else
            {
	            $this->errors[] = "Could not insert the person";
	            $this->errors[] = $mysqli->error;
	            $this->errors[] = "password ".$this->password;
	            $this->errors[] = "email ".$this->email;
	            $this->errors[] = "name ".$this->name;
	            $this->errors[] = "firstname ".$this->user_firstname;
	            $this->errors[] = "surname ".$this->user_surname;
	            $this->errors[] = "dob ".$this->dob;
	            $this->errors[] = "pob ".$this->pob;
	            $this->errors[] = "registered ".$this->is_registered;
	            $this->errors[] = "tree_id ".$this->tree_id;
	            $this->errors[] = "profile img ".$this->temp_profile_img;
	            $this->errors[] = $query_new_user_insert;
	        }
	        
	        $status = "inactive";
	    }
	    else
	    {
		    //check they're not already registered
	    	$this->email = $this->db_connection->real_escape_string(htmlentities($_POST['person_mail'], ENT_QUOTES));
	    	
	    	$already_registered = $this->db_connection->query("SELECT user_id, user_email FROM people WHERE user_email = '".$this->email."'");
			
			//if they are already registered emailed them
			if ($already_registered->num_rows >= 1)
			{
			
				//add root
				$result = $already_registered->fetch_object();				
				
				$this->messages[] = "They're already registered. We've emailed them to let them know";				
				//sendEmail("true", $result->user_email, $result->user_id, $_SESSION['tree_id']);
				$this->sendEmail("true",$result->user_email,$result->user_id, $_SESSION['tree_id']);
				$status = "pending";
				$newID = $result->user_id;
				//$newid
			}
			else
			{
			//as they aren't registered, make a generic account using the given email and email the details
				$this->messages[] = "Not found that email. We'll register and email for you";

		    	$this->password = password_hash("generic", PASSWORD_DEFAULT);
		    	$this->dob = "1970-01-01";
		    	$this->pob = "local";
		    	$this->is_registered = 0;
		    	$this->user_firstname = "NULL";
		    	$this->user_surname = "NULL";
		    	
		        $query_new_user_insert = $this->db_connection->query(
		        	"INSERT INTO people 
		        		(
		        			user_password_hash, 
		        			user_email, 
		        			user_fullname, 
		        			user_firstname, 
		        			user_surname, 
		        			date_of_birth, 
		        			place_of_birth, 
		        			is_registered, 
		        			tree_id,
		        			profile_img,
		        			family_id,
		        			privacy
		        		) 
		        	VALUES 
		        		(
		        		'" . $this->password . "', 
		        		'" . $this->email . "',
		        		'" . $this->name . "',
		        		'" . $this->user_firstname . "',
		        		'" . $this->user_surname . "',
		        		'" . $this->dob . "',
		        		'" . $this->pob . "',
		        		'" . $this->is_registered . "',
		        		'" . $this->tree_id . "',
		        		'" . $this->temp_profile_img . "',
		        		2,
		        		'private')"
	            );
	            
	            $newID = $this->db_connection->insert_id;

				
				if ($query_new_user_insert) 
	            {
	            	//send the email
	            		            	
	            	$this->messages[] = "The person has been added";
					$this->sendEmail("false", $this->email, $newID, $_SESSION['tree_id']);
					$person_added = true;
	            }
	            else
	            {
		            $this->errors[] = "Something went wrong";
		        }
		        
		        $status = "pending";
			}
			//add a root with pending status
			
	    }
	    
	    if ($person_added == true)
	    {
		    //get the current tree
		    $get_treeID = $this->db_connection->query("
		    	SELECT tree_id FROM tree WHERE user_id = ".$_SESSION['user_id']."
		    ");
		    $tree_result = $get_treeID->fetch_object();
		    $treeID = $tree_result->tree_id;
		    
		    //add the root
		    $add_new_root = $this->db_connection->query("
		    	INSERT INTO roots 
		    		(tree_id, user_id, user_status, family_status) 
		    	VALUES 
		    		('".$treeID."', '".$newID."', '".$status."', '".$this->relation."')
		    ");
		    
		    $this->messages[] = "Added the person as a pending root";
		}
    }
    
    public function plantTree()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $plant_tree = $this->db_connection->query("
        	INSERT INTO tree 
        		(user_id, status) 
        	VALUES 
        		(".$_SESSION['user_id'].",'owner')
        	");
        $treeID = $this->db_connection->insert_id;
        $first_root = $this->db_connection->query("
        	INSERT INTO roots 
        		(tree_id,user_id,user_status,family_status) 
        	VALUES 
        		($treeID,".$_SESSION['user_id'].",'live','owner')
        	");
		$update_person = $this->db_connection->query("UPDATE people SET tree_id = $treeID WHERE user_id = ".$_SESSION['user_id']."");
		//go to the tree page

        //$this->messages[] = "Tree planted, you can now extend it's roots";
        
        //header('Location: tree.php');
    }
    
    public function sendEmail($is_registered,$their_email,$their_id, $tree_id)
    {
    	// $is_registered is if they are already registered, send an invite email to the tree
    
	    $req_email = "admin@homeofremembrance.com";
	    
   		require_once("libraries/password_compatibility_library.php");

				
		$to = "adams.j.6385@gmail.com";				
		$subject = "Home of Remembrance Invite";				
		$headers = "From: " . strip_tags($req_email) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($req_email) . "\r\n";
		//$headers .= "CC: susan@example.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		if ($is_registered == "true")
		{
			$message = '<html><body>';
			$message .= '<h1>Hello, World!</h1>';
			$message .= "<p>You're invited to a family tree</p>";
			$message .= "<p>Click on the following link to join the family tree</p>";
			$message .= "<a href='http://homeofremembrance.com/tree.php?join=$tree_id&person=$their_id'>Link</a>";
			$message .= '</body></html>';
		}
		else
		{
			//next job to send the invite link
			// create key to register with
			// key to have hash of user_id, tree_id
			$key = password_hash($their_email, PASSWORD_DEFAULT);
			
			
			$message = '<html><body>';
			$message .= '<h1>Hello, World!</h1>';
			$message .= "<p>You're invited to a Home of Remembrance</p>";
			$message .= "<a href='http://homeofremembrance.com/frontdoor.php?key=$key&p=$their_id'>Link</a>";
			//$message .= "<p>The password is <b>generic</b></p>";
			$message .= '</body></html>';
		}
		
		
		//mail($to, $subject, $message, $headers);
		
		$this->messages[] = $message;
    }
    
    public function addRootToTree()
    {
	    $tree_id = $_GET['join'];
	    $user_id = $_GET['person'];
	    
	    //$this->messages[] = "family id = ".$tree_id;
	    //$this->messages[] = "you are ".$user_id;
	    
	    //check the get user_id matches the current session
	    if ($_SESSION['user_id'] == $user_id)
	    {
		    //update the root
		    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		    
		    $update_root = $this->db_connection->query("
		    	UPDATE 
		    		roots 
		    	SET 
		    		user_status = 'active' 
		    	WHERE user_id = '$user_id'
		    ");
		    
	    }
	    else
	    {
	    	$this->errors[] = "non-matching id";
		    return;
	    }
	    
    }
}

?>
<?php

class TimeCapsule
{
    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {
        if (isset($_POST["add_to_capsule"])) 
        {
            $this->addTimeCapsule();
        	$messages[] = "added the item to your time capsule";
        }    	
    }
    
    public function getTimeCapsule()
    {
   	    // create a database connection, using the constants from config/db.php (which we loaded in index.php)
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    $get_timecapsule = $this->db_connection->query("SELECT 
										* 
									FROM 
										time_capsule 
									WHERE 
										user_id = " . $_SESSION['user_id'] . "
									");
	    if ($get_timecapsule->num_rows >= 1) {
	    
	    	$timecapsule = array();
			
			while($timecapsule_item = $get_timecapsule->fetch_assoc())
	        {
	           	$timecapsule[] = $timecapsule_item;
			}
	        return $timecapsule;
	        
	    } else {
	        return "na";
	    }
    }
    
    private function addTimeCapsule()
    {
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) 
		{		
	        $this->user_id = $_SESSION['user_id']; 
	        $this->title = $_POST['title'];
	        
	        //$thedate = getdate(date("U"));
	        //$thefulldate = $thedate[year]."-".$thedate[mon]."-".$thedate[mday];
	        
	        $this->encoded_username = md5($this->user_id);
	        $path = "people/".$this->encoded_username."/timecapsule/";
	        $filename = $_FILES['item']['name'];	 
	        $full_filepath = $path.$filename;  
	        
	        
	        if ($_FILES['item']['error'] == 1)
	        {
		        $this->errors[] = "Woah! Way too big";
		        return;
	        }     
	        	        
	        if (!file_exists($path))
	        {
		        mkdir($path,0777,true);
		        $this->messages[] = "Folder didn't exist, so it's been created";
	        }
	        
	        if (file_exists($full_filepath))
	        {
		        $this->errors[] = "File already exists";
	        } else {
		        if(move_uploaded_file($_FILES['item']['tmp_name'], $full_filepath))
		        {
		        	if($_FILES['item']['error'] == 0)
		        	{
			        	$this->messages[] = "Item added successfully";
			    	
				    	//add code to add the info to the db
				    	$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
				    	$get_gallery = $this->db_connection->query("
				    		INSERT INTO time_capsule (user_id, url, title, filename) VALUES (
				    			'".$this->user_id."',
				    			'".$full_filepath."',
				    			'".$this->title."',
				    			'".$filename."')");	
		        	}
		        	else 
		        	{
			        	$this->errors[] = "Couldn't insert information into the database for some reason";	
		        	}			    	
		        } else {
			        $this->errors[] = "File could not be stored";
		        }
	        }	        
	    } else {
	        $this->errors[] = "Could not connect";
        }
    }

}

?>
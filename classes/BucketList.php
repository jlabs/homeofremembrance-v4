<?php

class BucketList
{	
    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {
        if (isset($_POST["add_entry"])) 
        {
            $this->addBucketList();
        }
        if (isset($_POST['delete']))
        {
	        $this->deleteBucketList();
	    }
	    if (isset($_POST['save']))
	    {
		    $this->updateBucketList();
	    }
	    if (isset($_POST['milestone_add']))
	    {
		    $this->addMileStone();
	    }
	    if (isset($_POST['milestone_edit']))
	    {
		    $this->editMileStone();
	    }
    }
    
    public function getMileStone($bucketid)
    {
	    //$this->messages[] = "getting the milestones for bucket_id ".$bucketid." and user_id ".$_SESSION['user_id'];
	 	
	 	$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);   
	    $get_milestones = $this->db_connection->query("
	    							SELECT 
										* 
									FROM 
										milestones 
									WHERE 
										user_id = " . $_SESSION['user_id'] . "
									AND
										bucket_id = " . $bucketid . "
									");
		if ($get_milestones->row_nums >= 0)
		{
			$miletones = array();
			
			while($milestone = $get_milestones->fetch_assoc())
			{
				$miletones[] = $milestone;
				//$this->messages[] = "added the milestone ".$milestone['milestone'];
			}
			
			return $miletones;
		} 
		else 
		{
			$this->errors[] = "couldn't find any milestones";	
		}
    }
    
    public function addMileStone()
    {
	    //add a milestone for the bucket list
	    
	    //get bucketlist item id
	    
	    //$this->messages[] = "adding to the bucket " . $this->bucketIDModal;
	    
	    //add the milestone
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) 
		{
	        $this->user_id = $_SESSION['user_id'];
	        $this->bucket_id = $_POST['milestone_bucketid'];
	        
	        $qry_addmilestone = $this->db_connection->query("
	        	INSERT INTO 
	        		milestones 
	        			(bucket_id,user_id,milestone) 
				VALUES (
					'" . $this->bucket_id . "',
					'" . $this->user_id . "', 
					'" . $_POST['milestone_text'] . "')"); 
	        if ($qry_addmilestone) {
                $this->messages[] = "Item added";
                //$this->entry_added = true;
            } else {

                $this->errors[] = "Entry could not be added.";
            }
        } else {
	        $this->errors[] = "Could not connect";
        }
	    
    }
    
    public function editMileStone()
    {
	    //edit a milestone
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) 
		{
	        $this->user_id = $_SESSION['user_id'];
			$this->milestone_id = $_POST['milestone_id'];
	        $this->title = $_POST['title'];
	        $this->body = $_POST['body'];
	        
	        if ($_POST['completed'] == "on")
	        {
		        $this->completed = 1;
	        } else {
		        $this->completed = 0;
	        }
	        
	        $query_update_bucketlist = $this->db_connection->query("
	        	UPDATE 
	        		bucketlist 
	        	SET 
	        		title = '".$this->title."', 
	        		body = '".$this->body."', 
					completed = ".$this->completed." 
	        	WHERE 
	        		bucket_id = ".$this->bucket_id."
	        	AND
	        		user_id = ".$this->user_id."
	        ");
	        if ($query_update_bucketlist) {
                $this->messages[] = "Item saved";
            } else {
                $this->errors[] = $_POST['title'];
            }
        } else {
	        $this->errors[] = "Could not connect";

		}
    }
    
    public function getBucketList()
    {
   	    	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    $get_bucketlist = $this->db_connection->query("SELECT 
										* 
									FROM 
										bucketlist 
									WHERE 
										user_id = " . $_SESSION['user_id'] . "
									");
	    if ($get_bucketlist->num_rows >= 0) {
				
			$bucketlist = array();
			$bucketlist_milestones = array();
	        
	        while($bucketlist_item = $get_bucketlist->fetch_assoc())
	        {
	            $bucketlist[] = $bucketlist_item;
	            //$this->messages[] = $bucketlist_item['bucket_id'];
	            
	            $bucketlist_milestones[] = $this->getMileStone($bucketlist_item['bucket_id']);
	            //$this->messages[] = $bucketlist_milestones['milestone'];
	        }
	        
	        //get the bucketlist id
	        
	        //get milestones
	        //$this->getMileStone()
	        
	        $data = array("buckets" => $bucketlist, "milestones" => $bucketlist_milestones);
	        
	        return $data;
	        
	    } else {
	        return "na";
	    }
	
    }
    
    private function addBucketList()
    {
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) 
		{
	        $this->user_id = $_SESSION['user_id'];
	        
	        $query_add_bucketlist = $this->db_connection->query("
	        	INSERT INTO bucketlist (user_id, title) 
				VALUES (
					'" . $this->user_id . "', 
					'" . $_POST['title'] . "')"); 
	        if ($query_add_bucketlist) {
                $this->messages[] = "Item added";
                $this->entry_added = true;
            } else {

                $this->errors[] = "Entry could not be added.";
            }
        } else {
	        $this->errors[] = "Could not connect";
        }
    }
    
    private function deleteBucketList()
    {
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) 
		{
	        $this->user_id = $_SESSION['user_id'];
	        $this->bucket_id = $_POST['bucket_id'];
	        
	        $query_delete_bucketlist = $this->db_connection->query("
	        	DELETE FROM bucketlist WHERE user_id ='".$this->user_id."' AND bucket_id ='".$this->bucket_id."'
	        ");
	        if ($query_delete_bucketlist) {
	        	//get the file path
	        	
	        	//delete the file
	        	//unlink(/*file path*/);
                $this->messages[] = "Item removed";
            } else {

                $this->errors[] = "Entry could not be deleted.";
            }
        } else {
	        $this->errors[] = "Could not connect";

		}
    }
    
    private function updateBucketList()
    {
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) 
		{
	        $this->user_id = $_SESSION['user_id'];
	        $this->bucket_id = $_POST['bucket_id'];
	        $this->title = $_POST['title'];
	        $this->body = $_POST['body'];
	        
	        if ($_POST['completed'] == "on")
	        {
		        $this->completed = 1;
	        } else {
		        $this->completed = 0;
	        }
	        
	        $query_update_bucketlist = $this->db_connection->query("
	        	UPDATE 
	        		bucketlist 
	        	SET 
	        		title = '".$this->title."', 
	        		body = '".$this->body."', 
					completed = ".$this->completed." 
	        	WHERE 
	        		bucket_id = ".$this->bucket_id."
	        	AND
	        		user_id = ".$this->user_id."
	        ");
	        if ($query_update_bucketlist) {
                $this->messages[] = "Item saved";
            } else {
                $this->errors[] = $_POST['title'];
            }
        } else {
	        $this->errors[] = "Could not connect";

		}
    }
}

?>
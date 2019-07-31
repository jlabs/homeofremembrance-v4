<?php

class TellUS
{

    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {
        if (isset($_POST["send"])) 
        {
            $this->addChange();

        }
        if (isset($_POST['delete']))
        {
	        //$this->deleteChange();
        }
    }
    
    private function addChange()
    {
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) 
		{
	        // escapin' this, additionally removing everything that could be (html/javascript-) code
	        $this->entry_text = $this->db_connection->real_escape_string(htmlentities($_POST['doing'], ENT_QUOTES));    
	        $this->user_id = $_SESSION['user_id']; 	        
	        
	        $qryAddChange = $this->db_connection->query("INSERT INTO tell_us (user_id, text) VALUES ('" . $this->user_id . "','" . $this->entry_text . "')");
	        
	        if ($qryAddChange) {
                $this->messages[] = "Thankyou for your suggestion.";
            } else {
                $this->errors[] = "Entry could not be added.";                
            }
        } else {
	        $this->errors[] = "Could not connect";
        }
    }
    
    private function deleteChange()
    {
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) 
		{
	        $this->user_id = $_SESSION['user_id'];
	        $this->diary_id = $_POST['diary_id'];
	        
	        $query_delete_bucketlist = $this->db_connection->query("
	        	DELETE FROM diary WHERE user_id ='".$this->user_id."' AND diary_id ='".$this->diary_id."'
	        ");
	        if ($query_delete_bucketlist) {
                $this->messages[] = "Item removed";
            } else {

                $this->errors[] = "Entry could not be deleted.";
            }
        } else {
	        $this->errors[] = "Could not connect";

		}

    }

	public function getChanges()
    {
			// create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $get_diary = $this->db_connection->query("SELECT 
            											diary_id, entry_text, entry_datetime 
            										FROM 
            											diary 
            										WHERE 
            											user_id = " . $_SESSION['user_id'] . "
            										ORDER BY
            											entry_datetime DESC, diary_id ASC");
            // if this user exists
            if ($get_diary->num_rows >= 1) {

                // get result row (as an object)           
                //$result = $get_diary->fetch_object();
				
				$entries = array();
                
                while($entry = $get_diary->fetch_assoc())
                {
	                $entries[] = $entry;
                }
                return $entries;
                
            } else {
	            return "na";
            }
    }
    
    public function getJobs()
    {
	    // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $get_jobs = $this->db_connection->query("SELECT job_id, job, description, complete FROM jobs ");
            $jobslist = array();
            if ($get_jobs->num_rows >= 1) {

                // get result row (as an object)           
                //$result = $get_diary->fetch_object();
				
				
                
                while($jobitem = $get_jobs->fetch_assoc())
                {
	                $jobslist[] = $jobitem;
                }
                return $jobslist;
                
            } else {
	            return "na";
            }
	    
    }

}

?>
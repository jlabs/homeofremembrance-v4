<?php

class Jobs
{

    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {
        
    }

	public function getJobs()
    {
			// create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $get = $this->db_connection->query("SELECT 
            											job, description, complete 
            										FROM 
            											jobs 
            										ORDER BY
            											complete ASC");
            // if this user exists
            if ($get->num_rows >= 1) {

                // get result row (as an object)           
                //$result = $get_diary->fetch_object();
				
				$jobs = array();
                
                while($job = $get->fetch_assoc())
                {
	                $jobs[] = $job;
                }
                return $jobs;
                
            } else {
	            return null;
            }
    }

}

?>
<?php

class Search
{
    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {	    
		if (isset($_POST['SearchText']))
		{				
			$this->GetPeopleResults();
		}
    }
    
    public function GetPeopleResults()
    {
    	$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno)
		{

			$this->searchfor = $_POST['SearchText'];		
			$this->messages[] = "searching for ".$this->searchfor;
			
            $get_peopleresults = $this->db_connection->query("SELECT 
											user_firstname, user_surname 
										FROM 
											people
										WHERE
											user_firstname LIKE '%".$this->searchfor."%'");
            // if this user exists
            if ($get_peopleresults->num_rows >= 1) {
            	            	
            	$results = array();
            	
            	while ($result = $get_peopleresults->fetch_assoc())
            	{
	            	$results[] = $result;
            	}
            	
            	return $results;
            } else {
	            return "not found";
            }
		}
    }
    
    
}

?>
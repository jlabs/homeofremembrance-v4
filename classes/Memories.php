<?php

class Memory
{

    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {
    	
    }
    
	public function getMemories()
    {
			// create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $get_memories = $this->db_connection->query("SELECT 
            											* 
            										FROM 
            											memories 
            										WHERE 
            											user_id = " . $_SESSION['user_id'] . "
            										");
            // if this user exists
            if ($get_memories->num_rows >= 1) {

                // get result row (as an object)           
                //$result = $get_diary->fetch_object();
				
				$memories = array();
                
                while($memory = $get_memories->fetch_assoc())
                {
	                $memories[] = $memory;
                }
                return $memories;
                
            } else {
	            return "na";
            }
    }

}

?>
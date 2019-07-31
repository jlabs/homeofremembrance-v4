<?php

class FrontDoor
{
    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {

    }
    
    public function Diary()
    {
    	$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno)
		{
			$this->user_id = $_SESSION['user_id'];
			
            $get_diary = $this->db_connection->query("SELECT 
											entry_text, entry_datetime 
										FROM 
											diary 
										WHERE 
											user_id = " . $_SESSION['user_id'] . "
										ORDER BY
											entry_datetime DESC");
            // if this user exists
            if ($get_diary->num_rows >= 1) {
            	$diary = $get_diary->fetch_object();
            	return $diary;
            } else {
	            return "no";
            }
		}
    }
    
    public function Family()
    {
    	$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno)
		{
			$this->user_id = $_SESSION['user_id'];
			$this->family_id = $_SESSION['family_id'];
			$get_family = $this->db_connection->query("SELECT COUNT(family_id) AS countfamily FROM people WHERE family_id = ".$this->family_id."");
            // if this user exists
            if ($get_family->num_rows >= 1) {
            	echo $get_family->fetch_object()->countfamily;
            } else {
	            return "no";
            }
		}
    }
    
    public function BucketList()
    {
    	//needs updating
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno)
		{
			$this->user_id = $_SESSION['user_id'];
			$get_family = $this->db_connection->query("SELECT COUNT(family_id) AS countfamily FROM people WHERE family_id = ".$this->family_id."");
            // if this user exists
            if ($get_family->num_rows >= 1) {
            	echo $get_family->fetch_object()->countfamily;
            } else {
	            return "no";
            }
		}
    }
}

?>
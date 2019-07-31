<?php

class Diary
{

    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {
    	$this->messages[] = "constructor loaded";
    
        if (isset($_POST["add_entry"])) 
        {
        	$messages[] = "adding the diary";
            $this->addDiaryEntry();

        }
        if (isset($_POST['delete']))
        {
	        $this->deleteDiaryEntry();
        }
    }
    
    private function addDiaryEntry()
    {
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) 
		{
	        // escapin' this, additionally removing everything that could be (html/javascript-) code
	        $this->entry_text = $this->db_connection->real_escape_string(htmlentities($_POST['entry_text'], ENT_QUOTES));    
	        $this->entry_datetime = $this->db_connection->real_escape_string(htmlentities($_POST['entry_datetime'], ENT_QUOTES)); 
	        
	        //$this->entry_text = $_POST['entry_text'];    
	        //$this->entry_datetime = $_POST['entry_datetime']; 
	        $this->user_id = $_SESSION['user_id']; 
	        
	        $query_add_diaryentry = $this->db_connection->query("
	        	INSERT INTO diary (user_id, entry_datetime, entry_text) 
				VALUES (
					'" . $this->user_id . "', 
					'" . $this->entry_datetime. "', 
					'" . $this->entry_text . "')");
	        if ($query_add_diaryentry) {
                $this->messages[] = "Diary entry added.";
                $this->entry_added = true;
            } else {

                $this->errors[] = "Entry could not be added.";
            }
        } else {
	        $this->errors[] = "Could not connect";
        }
    }
    
    private function deleteDiaryEntry()
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

	public function getDiaryEntries()
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
	            return null;
            }
    }

}

?>
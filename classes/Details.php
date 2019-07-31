<?php

class Details
{
    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {
    	if (isset($_POST['updateDetails']))
    	{
	    	$messages[] = "Updating details";
	    	$this->updateDetails();
    	}
    	
    	if (isset($_POST['emailpass']))
    	{
	    	$this->emailPwd();
    	}
    }
    
    public function getDetails()
    {
   	    // create a database connection, using the constants from config/db.php (which we loaded in index.php)
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    $get_details = $this->db_connection->query("SELECT 
										user_firstname, user_surname 
									FROM 
										people 
									WHERE 
										user_id = " . $_SESSION['user_id'] . "
									");
	    if ($get_details->num_rows >= 1) {
			$person_details = $get_details->fetch_object();
	        return $person_details;
	    } else {
	        return "na";
	    }
    }
    
    public function updateDetails()
    {
	    $user_firstname = $_POST['user_firstname'];
	    $user_surname = $_POST['user_surname'];
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    $update_sql = $this->db_connection->query("UPDATE people SET user_firstname = '".$_POST['user_firstname']."',user_surname='".$_POST['user_surname']."' WHERE user_id = ".$_SESSION['user_id']."");
	    $_SESSION['user_firstname'] = $_POST['user_firstname'];
	    $this->messages[] = "Details updated";
    }
    
    public function emailPwd()
    {
	    $this->pwd = $_POST['pwd'];
	    $this->mail = $_POST['mail'];
	    $this->user_id = $_SESSION['user_id'];
	    
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    
	    $this->user_password_hash = password_hash($this->user_password, PASSWORD_DEFAULT);
	    
	    $qry_update = $this->db_connection->query("
	    	UPDATE people SET user_password_hash = '".$this->pwd."', user_email = '".$this->mail."' WHERE user_id = ".$this->user_id."
	    ");
	    
	    if ($qry_update)
	    {
		    
	    }
    }
}

?>
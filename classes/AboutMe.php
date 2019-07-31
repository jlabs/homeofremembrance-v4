<?php

class AboutMe
{
	
    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {
    	if (isset($_POST['frm_aboutme']))
    	{
	    	//$this->messages[] = "Updating aboutme";
	    	$this->updateAboutMe();
    	}
    }
    
    public function getAboutMe()
    {
	    	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $get_aboutme = $this->db_connection->query("SELECT 
            											* 
            										FROM 
            											about_me 
            										WHERE 
            											user_id = " . $_SESSION['user_id'] . "
            										");
            // if this user exists
            if ($get_aboutme->num_rows == 1) {
                
                $aboutme_details = $get_aboutme->fetch_object();
                //$this->messages[] = "Data found";
                return $aboutme_details;
                
            } else {
            	//$this->errors[] = "Sorry, no details found";
            	// create blank about_me row
            	$qry_new_aboutme = $this->db_connection->query("
            		INSERT INTO 
            			about_me 
            				(about_me_id,user_id,born,parents,lived,educated,currently,im_into,dont_like,about_me) 
            		VALUES 
            			(
            				NULL,'".$_SESSION['user_id']."','','','','','','','',''
            			)
            	");
            	if ($qry_new_aboutme)
            	{
		            $this->messages[] = "Added empty details for you to fill in.";
            	} else {
	            	$this->errors[] = "Couldn't create empty data";
            	}
	            //return "na";
            }	    
    }
    
    public function getBasicInfo()
    {
	    //get the name and dob from people table
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    $get_basics = $this->db_connection->query("SELECT 
            											date_of_birth, user_fullname, profile_img
            										FROM 
            											people 
            										WHERE 
            											user_id = " . $_SESSION['user_id'] . "
            										");
        if ($get_basics->num_rows == 1)
        {
	        $basic_details = $get_basics->fetch_object();
	        return $basic_details;
        }
    }
    
    public function updateAboutMe()
    {
    	//$this->messages[] = "Getting the posted info";
    	if ($_POST['aboutme'] == "")
    	{
	    	$this->errors[] = "About me is empty :(";
    	}
	    
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) 
		{
	    	//set vars to post vars
		    $this->born = $_POST['born'];
		    $this->parents = $_POST['parents'];
		    $this->lived = $_POST['lived'];
		    $this->educated = $_POST['educated'];
		    $this->currently = $_POST['currently'];
		    $this->into = $_POST['into'];
		    $this->dontlike = $_POST['dontlike'];
		    $this->aboutme = $_POST['aboutme'];
		    
		    $this->userid = $_SESSION['user_id'];
	        
	        $qry_upd_aboutme = $this->db_connection->query("
	        	UPDATE 
	        		about_me 
	        	SET 
	        		born = '".$this->born."', 
	        		parents = '".$this->parents."', 
	        		lived = '".$this->lived."', 
	        		educated = '".$this->educated."', 
	        		currently = '".$this->currently."', 
	        		im_into = '".$this->into."', 
	        		dont_like = '".$this->dontlike."', 
	        		about_me = '".$this->aboutme."' 
	        	WHERE 
	        	user_id = ".$this->userid."");
	        if ($qry_upd_aboutme) {
                $this->messages[] = "Wuhey! We've updated your details";
            } else {
                $this->errors[] = "Sorry, something happened. Use the Report link on the top of this page to let us know ";
            }
        } else {
	        $this->errors[] = "Could not connect";

		}

    }
}

?>
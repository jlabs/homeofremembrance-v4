<?php

/**
 * handles the user login/logout/session
 * @author Panique <panique@web.de>
 */
class Login
{
    // database connection
    private $db_connection = null;
    private $user_name = "";
    private $user_email = "";
    private $user_password_hash = "";
    private $user_is_logged_in = false;

    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session
        session_start();

        // check the possible login actions:
        // 1. logout (happen when user clicks logout button)
        // 2. login via session data (happens each time user opens a page on your php project AFTER he has sucessfully logged in via the login form)
        // 3. login via post data, which means simply logging in via the login form. after the user has submit his login/password successfully, his
        //    logged-in-status is written into his session data on the server. this is the typical behaviour of common login scripts.

        // if user tried to log out
        if (isset($_GET["logout"])) {

            $this->doLogout();
        }
        // if user has an active session on the server
        elseif (!empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)) {

            $this->loginWithSessionData();
        }
        // if user just submitted a login form
        elseif (isset($_POST["login"])) {

            $this->loginWithPostData();
        }
        
        /*
        if (isset($_GET['key']))
        {
	        $this->loginfromInvite();
        }
        */
    }

    /**
     * log in with session data
     */
    private function loginWithSessionData()
    {
        // set logged in status to true, because we just checked for this:
        // !empty($_SESSION['user_name']) && ($_SESSION['user_logged_in'] == 1)
        // when we called this method (in the constructor)
        $this->user_is_logged_in = true;
    }
    
    public function loginFromInvite()
    {
	    $this->key = $_GET['key'];
	    //$this->messages[] = $key;
	    //take the last number off of $key
	    $this->user_id = $_GET['p'];
	    //read the rest of the key
	    
	    // $this->key is the email address
	    $this->key = password_verify($key);
	    
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    $this->user_email = $this->db_connection->real_escape_string($_POST['user_email']);
	    
	    //check the post email matches the key
	    if ($this->user_email == $key)
	    {		    
		    $checklogin = $this->db_connection->query("
                	SELECT 
                		user_id, user_name, user_email, user_password_hash, user_firstname, family_id, tree_id 
                	FROM 
                		people 
                	WHERE 
                		user_email = '" . $this->key . "'
                		AND
                		user_id = '" . $this->user_id ."'");

                // if this user exists
                if ($checklogin->num_rows == 1) 
                {

                    // get result row (as an object)
                    $result_row = $checklogin->fetch_object();

                    // using PHP 5.5's password_verify() function to check if the provided passwords fits to the hash of that user's password
                    //if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {

                        // write user data into PHP SESSION [a file on your server]
                        $_SESSION['user_id'] = $result_row->user_id;
                        //$_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_email'] = $result_row->user_email;
                        $_SESSION['user_firstname'] = $result_row->user_firstname;
                        $_SESSION['family_id'] = $result_row->family_id;
                        $_SESSION['tree_id'] = $result_row->tree_id;
                        $_SESSION['user_logged_in'] = 1;                        
                        
                        // set the login status to true
                        $this->user_is_logged_in = true;

                    //} else {

                        //$this->errors[] = "Wrong password. Try again.";
                    //}

                } 
                else 
                {

                    $this->errors[] = "This user does not exist.";
                }
                
	    }
	    else 
	    {
		    $this->errors[] = "Sorry, your email doesn't match the invite";
	    }
    }

    /**
     * log in with post data
     */
    private function loginWithPostData()
    {
    	//invite link is frontdoor.php?key=$2y$10$WNHiFacjCXTEFB5PmTn0UOu3jsoyZbYet.f/qX/gUi9cST21aTnqq&p=47
    	//if (isset($_GET['key']) && !empty($_GET['key']))
    	if (isset($_POST['key']) && isset($_POST['p']))
    	{
    		$this->messages[] = "You have key!";
	    	//$this->loginFromInvite();
    	}
    	else 
    	{   
    		$this->messages[] = "No key set";
	        // if POST data (from login form) contains non-empty user_name and non-empty user_password
	        if (!empty($_POST['user_email']) && !empty($_POST['user_password'])) 
	        {
	
	            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
	            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	            // if no connection errors (= working database connection)
	            if (!$this->db_connection->connect_errno) 
	            {
	
	                // escape the POST stuff
	                $this->user_email = $this->db_connection->real_escape_string($_POST['user_email']);
	                // database query, getting all the info of the selected user
	                $checklogin = $this->db_connection->query("
	                	SELECT 
	                		user_id, user_name, user_email, user_password_hash, user_firstname, family_id, tree_id 
	                	FROM 
	                		people 
	                	WHERE 
	                		user_email = '" . $this->user_email . "';");
	                			
	                // if this user exists
	                if ($checklogin->num_rows == 1) 
	                {
	
	                    // get result row (as an object)
	                    $result_row = $checklogin->fetch_object();
	
	                    // using PHP 5.5's password_verify() function to check if the provided passwords fits to the hash of that user's password
	                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) 
	                    {
	
	                        // write user data into PHP SESSION [a file on your server]
	                        $_SESSION['user_id'] = $result_row->user_id;
	                        //$_SESSION['user_name'] = $result_row->user_name;
	                        $_SESSION['user_email'] = $result_row->user_email;
	                        $_SESSION['user_firstname'] = $result_row->user_firstname;
	                        $_SESSION['family_id'] = $result_row->family_id;
	                        $_SESSION['tree_id'] = $result_row->tree_id;
	                        $_SESSION['user_logged_in'] = 1;	                        
	                        
	                        // set the login status to true
	                        $this->user_is_logged_in = true;
	
	                    } 
	                    else 
	                    {
	
	                        $this->errors[] = "Wrong password. Try again.";
	                    }
	
	                } 
	                else 
	                {	
	                    $this->errors[] = "This user does not exist.";
	                }
	
	            } 
	            else 
	            {
	                $this->errors[] = "Database connection problem.";
	            }
	
	        } 
	        elseif (empty($_POST['user_name'])) 
	        {
	
	            $this->errors[] = "Username field was empty.";
	
	        } 
	        elseif (empty($_POST['user_password'])) 
	        {
	
	            $this->errors[] = "Password field was empty.";
	        }
        }
    }
    

    /**
     * perform the logout
     */
    public function doLogout()
    {
        $_SESSION = array();
        session_destroy();
        $this->user_is_logged_in = false;
        $this->messages[] = "You have been logged out.";

    }

    /**
     * simply return the current state of the user's login
     * @return boolean user's login status
     */
    public function isUserLoggedIn()
    {
        return $this->user_is_logged_in;
    }
}

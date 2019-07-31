<?php

/**
 * handles the user registration
 * @author Panique <panique@web.de>
 */
class Registration
{
    // database connection
    private $db_connection = null;
    private $user_name = "";
    private $user_email = "";
    private $user_password = "";
    private $user_password_hash = "";

    public $registration_successful = false;
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

        if (isset($_POST["register"]))
        {
            $this->registerNewUser();
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities, and creates a new user in the database if
     * everything is fine
     */
    private function registerNewUser()
    {
    	//$_POST['user_name'] = $_POST['user_email'];
    	/*
    	if (empty($_POST['user_name'])) {

            $this->errors[] = "Empty Username";

        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {

            $this->errors[] = "Empty Password";

        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {

            $this->errors[] = "Password and password repeat are not the same";

        } elseif (strlen($_POST['user_password_new']) < 6) {

            $this->errors[] = "Password has a minimum length of 6 characters";

        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {

            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";

        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {

            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";

        } elseif (empty($_POST['user_email'])) {

            $this->errors[] = "Email cannot be empty";

        } elseif (strlen($_POST['user_email']) > 64) {

            $this->errors[] = "Email cannot be longer than 64 characters";

        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {

            $this->errors[] = "Your email address is not in a valid email format";

        } elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
        */
    	
        
        if (empty($_POST['user_fullname'])) {

            $this->errors[] = "Empty Name";

        } elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) {

            $this->errors[] = "Empty Password";

        } elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) {

            $this->errors[] = "Password and password repeat are not the same";

        } elseif (strlen($_POST['user_password_new']) < 6) {

            $this->errors[] = "Password has a minimum length of 6 characters";

        } elseif (empty($_POST['user_email'])) {

            $this->errors[] = "Email cannot be empty";

        } elseif (strlen($_POST['user_email']) > 64) {

            $this->errors[] = "Email cannot be longer than 64 characters";

        } elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {

            $this->errors[] = "Your email address is not in a valid email format";

        } elseif (!empty($_POST['user_fullname'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {

            // TODO: the above check is redundant, but from a developer's perspective it makes clear
            // what exactly we want to reach to go into this if-block

            // creating a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escapin' this, additionally removing everything that could be (html/javascript-) code
				//$this->user_name = $this->db_connection->real_escape_string(htmlentities($_POST['user_name'], ENT_QUOTES));
                $this->user_email = $this->db_connection->real_escape_string(htmlentities($_POST['user_email'], ENT_QUOTES));
                $this->user_fullname = $this->db_connection->real_escape_string(htmlentities($_POST['user_fullname'], ENT_QUOTES));
                $this->user_dob = $this->db_connection->real_escape_string(htmlentities($_POST['user_dob'], ENT_QUOTES));
                $this->user_pob = $this->db_connection->real_escape_string(htmlentities($_POST['user_pob'], ENT_QUOTES));
				$this->user_password = $_POST['user_password_new'];
				$this->is_registered = "1";

                // crypt the user's password with the PHP 5.5's password_hash() function, results in a 60 character hash string
                // the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using PHP 5.3/5.4, by the password hashing
                // compatibility library                
                $this->user_password_hash = password_hash($this->user_password, PASSWORD_DEFAULT);

                // check if user already exists
                $query_check_user_name = $this->db_connection->query("SELECT user_email FROM people WHERE user_email = '" . $this->user_email . "';");

                if ($query_check_user_name->num_rows == 1) {

                    $this->errors[] = "Sorry, that email address is already taken. Please choose another one.";

                } else {
                	$fullname = split(" ", $this->user_fullname);
                	$this->user_firstname = $fullname[0];
                	$this->user_surname = $fullname[1];
            

                    // write new users data into database
                    $query_new_user_insert = $this->db_connection->query(
                    	"INSERT INTO people 
                    		(
                    			user_password_hash, 
                    			user_email, 
                    			user_fullname, 
                    			user_firstname, 
                    			user_surname, 
                    			date_of_birth, 
                    			place_of_birth, 
                    			is_registered,
                    			family_id
                    		) 
                    	VALUES 
                    		(
                    		'" . $this->user_password_hash . "', 
                    		'" . $this->user_email . "',
                    		'" . $this->user_fullname . "',
                    		'" . $this->user_firstname . "',
                    		'" . $this->user_surname . "',
                    		'" . $this->user_dob . "',
                    		'" . $this->user_pob . "',
                    		'" . $this->is_registered . "',
                    		2)"
                    );

                    if ($query_new_user_insert) {

                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                        $this->registration_successful = true;
                        header('Location: details.php');

                    } else {

                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                        $this->errors[] = $this->user_dob;
                        $this->errors[] = $this->user_pob;
                        $this->errors[] = $this->user_email;
                        $this->errors[] = $this->user_fullname;
                        $this->errors[] = $this->user_password_hash;
                        $this->errors[] = $this->is_registered;
                    }
                }

            } else {

                $this->errors[] = "Sorry, no database connection.";

            }

        } else {

            $this->errors[] = "An unknown error occurred.";

        }

    }

}
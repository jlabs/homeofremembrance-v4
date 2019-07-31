<?php

class Vault
{
    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {
    	if (isset($_POST['vault']))
    	{
	    	$this->updateVault();
    	}
    	
    	if (isset($_GET['delete']))
    	{
	    	//$this->messages[] = "deleting something";
	    	$this->deleteFile();
    	}
    }
    
    public function getVault()
    {
   	    // create a database connection, using the constants from config/db.php (which we loaded in index.php)
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    $get_vault = $this->db_connection->query("SELECT 
										* 
									FROM 
										vault 
									WHERE 
										user_id = " . $_SESSION['user_id'] . "
									");
	    if ($get_vault->num_rows >= 1) {
			$vault_details = $get_vault->fetch_object();
	        return $vault_details;
	    } else {
	    	//create empty vault
	    	$qry_create_vault = $this->db_connection->query("
				INSERT INTO 
					vault 
						(
							vault_id,
							user_id,
							doctor_name,
							doctor_contact,
							funeral_arrangements,
							resting_place,
							will,
							additional_info,
							wedding_cert_url,
							birth_cert_url, 
							insurance_url, 
							wedding_cert_filename, 
							birth_cert_filename, 
							insurance_filename
						) 
				VALUES 
					(
						NULL, 
						'".$_SESSION['user_id']."', 
						'', 
						'', 
						'', 
						'', 
						'', 
						'', 
						'', 
						'', 
						'', 
						'', 
						'', 
						''
					)
	    	");
	    	if ($qry_create_vault)
	    	{
		    	$this->messages[] = "Empty vault created for you";
	    	} else {
		    	$this->errors[] = "nope";
	    	}
	        return;
	    }
    }
    
    public function updateVault()
    {    	
    	$this->user_id = $_SESSION['user_id'];
	    //get post
	    $this->doctor = $_POST['doctor'];
	    $this->doctor_contact = $_POST['doctor_contact'];
	    $this->funeral = $_POST['funeral'];
	    $this->resting = $_POST['resting'];
	    $this->will = $_POST['will'];
	    $this->additional = $_POST['additional'];
	    
	    if ($_FILES['wedding_cert']['name'] != '' || $_FILES['birth_cert']['name'] != '' || $_FILES['insurance']['name'] != '')	 
	    {
	        $this->encoded_username = md5($this->user_id);
	        $path = "people/".$this->encoded_username."/vault/";
	        
	        //make folder if not exist
	        if (!file_exists($path))
	        {
		        mkdir($path,0777,true);
	        }
	        
	        if ($_FILES['wedding_cert']['error'] == 1)
	        {
		        $this->errors[] = "Wedding cert too big";
		        return;
	        } else {
		    	$this->wedding_cert_filename = $_FILES['wedding_cert']['name'];
		    	$this->wedding_cert_filepath = $path.$this->wedding_cert_filename;
		    	
			    if (move_uploaded_file($_FILES['wedding_cert']['tmp_name'], $this->wedding_cert_filepath))
			    {
				    if($_FILES['wedding_cert']['error'] == 0)
				    {
					    $this->messages[] = "wedding cert moved";
				    } else {
					    $this->errors[] = "couldn't move file";
				    }
			    }
	        }
	        
	        if ($_FILES['birth_cert']['error'] == 1)
	        {
		        $this->errors[] = "Birth cert too big";
		        return;
	        } else {
		        $this->birth_cert_filename = $_FILES['birth_cert']['name'];
		        $this->birth_cert_filepath = $path.$this->birth_cert_filename;
		        
		        if (move_uploaded_file($_FILES['birth_cert']['tmp_name'], $this->birth_cert_filepath))
			    {
				    if($_FILES['birth_cert']['error'] == 0)
				    {
					    $this->messages[] = "birth cert moved";
				    } else {
					    $this->errors[] = "couldn't move file";
				    }
			    }
	        } 
	        
	        if ($_FILES['insurance']['error'] == 1)
	        {
		        $this->errors[] = "Insurance cert too big";
		        return;
	        } else {
		        $this->insurance_filename = $_FILES['insurance']['name'];
		        $this->insurance_filepath = $path.$this->insurance_filename;
		        
		        if (move_uploaded_file($_FILES['insurance']['tmp_name'], $this->insurance_filepath))
			    {
				    if($_FILES['insurance']['error'] == 0)
				    {
					    $this->messages[] = "insurance moved";
				    } else {
					    $this->errors[] = "couldn't move file";
				    }
			    }
	        }    
 
	    }   
	    	    
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    $qry_update_vault = $this->db_connection->query("
	    	UPDATE 
	    		vault 
	    	SET 
	    		doctor_name = '".$this->doctor."',
	    		doctor_contact = '".$this->doctor_contact."',
	    		funeral_arrangements = '".$this->funeral."',
	    		resting_place = '".$this->resting."',
	    		will = '".$this->will."',
	    		additional_info = '".$this->additional."',
	    		wedding_cert_url = '".$this->wedding_cert_filepath."',
	    		birth_cert_url = '".$this->birth_cert_filepath."',
	    		insurance_url = '".$this->insurance_filepath."',
	    		wedding_cert_filename = '".$this->wedding_cert_filename."',
	    		birth_cert_filename = '".$this->birth_cert_filename."',
	    		insurance_filename = '".$this->insurance_filename."'
	    	WHERE
	    		user_id = ".$this->user_id."
	    ");
	    
	    if ($qry_update_vault)
	    {
		    $this->messages[] = "done";
	    } else {
		    $this->erros[] = "no";
	    }
    }
    
    public function deleteFile()
    {
    	$this->user_id = $_SESSION['user_id'];
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
	    $fileToDelete = $_GET['delete'];
	    
	    if ($fileToDelete == "wc")
	    {
		    $this->messages[] = "deleting wedding cert";
		    $qry_get_wc = $this->db_connection->query("
		    	SELECT wedding_cert_url FROM vault WHERE user_id = ".$this->user_id."
		    ");
		    if ($qry_get_wc->num_rows >= 1)
		    {
			    $url = (array)$qry_get_wc->fetch_object();
			    
			    if (unlink($url['wedding_cert_url']))
			    {
				    //update sql
				    $qry_delete_wc = $this->db_connection->query("
				    	UPDATE vault SET wedding_cert_url = '', wedding_cert_filename = '' WHERE user_id = ".$this->user_id."	
				    ");
				    if ($qry_delete_wc)
				    {
					    $this->messages[] = "updated vault";
				    } else {
					    $this->errors[] = "couldn't update vault";
				    }
			    } else {
				    $this->errors[] = "couldn't delete file";
			    }
		    } else {
			    $this->errors[] = "couldn't find vault";
		    }
	    }
	    
	    if ($fileToDelete == "bc")
	    {
		    //$this->messages[] = "deleting birth cert";
		    $this->messages[] = "deleting wedding cert";
		    $qry_get_bc = $this->db_connection->query("
		    	SELECT birth_cert_url FROM vault WHERE user_id = ".$this->user_id."
		    ");
		    if ($qry_get_bc->num_rows >= 1)
		    {
			    $url = (array)$qry_get_bc->fetch_object();
			    
			    if (unlink($url['birth_cert_url']))
			    {
				    //update sql
				    $qry_delete_bc = $this->db_connection->query("
				    	UPDATE vault SET birth_cert_url = '', birth_cert_filename = '' WHERE user_id = ".$this->user_id."	
				    ");
				    if ($qry_delete_bc)
				    {
					    $this->messages[] = "updated vault";
				    } else {
					    $this->errors[] = "couldn't update vault";
				    }
			    } else {
				    $this->errors[] = "couldn't delete file";
			    }
		    } else {
			    $this->errors[] = "couldn't find vault";
		    }

	    }
	    
	    if ($fileToDelete == "i")
	    {
		    //$this->messages[] = "deleting insurance";
		    $this->messages[] = "deleting wedding cert";
		    $qry_get_i = $this->db_connection->query("
		    	SELECT insurance_url FROM vault WHERE user_id = ".$this->user_id."
		    ");
		    if ($qry_get_i->num_rows >= 1)
		    {
			    $url = (array)$qry_get_i->fetch_object();
			    
			    if (unlink($url['insurance_url']))
			    {
				    //update sql
				    $qry_delete_i = $this->db_connection->query("
				    	UPDATE vault SET insurance_url = '', insurance_filename = '' WHERE user_id = ".$this->user_id."	
				    ");
				    if ($qry_delete_i)
				    {
					    $this->messages[] = "updated vault";
				    } else {
					    $this->errors[] = "couldn't update vault";
				    }
			    } else {
				    $this->errors[] = "couldn't delete file";
			    }
		    } else {
			    $this->errors[] = "couldn't find vault";
		    }

	    }
    }
}

?>
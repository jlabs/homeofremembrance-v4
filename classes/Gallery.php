<?php

class Gallery
{

    // collection of error messages
    public $errors = array();
    // collection of success / neutral messages
    public $messages = array();

    public function __construct()
    {
        if (isset($_POST["add_image"])) 
        {
            $this->addGalleryImage();
        	$messages[] = "added the image to your gallery";

        }
        if (isset($_POST['delete']))
        {
	        $this->deleteGalleryImage();
	    }
	    if (isset($_POST['profile']))
        {
	        $this->setProfilePic();
	    }
    }
    
    private function setProfilePic()
    {
    	$this->url = $_POST['url'];
    
    	
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno)
		{
			$update_sql = $this->db_connection->query("
				UPDATE 
					people 
				SET 
					profile_img = '".$this->url."'
				WHERE 
					user_id = ".$_SESSION['user_id']."
				");
		}
		
		$this->messages[] = "profile pic updated";
		
		//$this->messages[] = $this->url;
		
    }
    
    private function addGalleryImage()
    {
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) 
		{		
	        $this->user_id = $_SESSION['user_id']; 
	        //$this->title = $_POST['title'];
	        
	        $this->encoded_username = md5($this->user_id);
	        $path = "people/".$this->encoded_username."/gallery/";	         
	        
	        $extensions = array("jpeg","jpg","png");
	       
			if (!file_exists($path))
	        {
		        mkdir($path,0777,true);
		        //$this->messages[] = "Created folder";
	        }
	        
	        $image_count = count($_FILES['image']['tmp_name']);
	       
	        
	        if(count($_FILES['image'])) {
				foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) 
				{
				    					
					$file_name = $_FILES['image']['name'][$key];
					$file_size = $_FILES['image']['size'][$key];
					$file_tmp = $_FILES['image']['tmp_name'][$key];
					$file_type = $_FILES['image']['type'][$key];
					$file_error = $_FILES['image']['error'][$key];
					
					$full_filepath = $path.$file_name; 
					
					//check the file type
					$file_ext = explode("." , $file_name);
					$file_ext = end($file_ext);
					$file_ext = strtolower(end(explode(".", $file_name)));
					if (in_array($file_ext, $extensions) === false)
					{
						$this->errors[] = "Sorry, that file type isn't allowed";
					}
					
					//clean up the file name
					$spaces = array("_","&20");
					$file_title = explode(".", $file_name);
					$name = array_shift($file_title);
					$name = str_replace($spaces, " ", $name);
										
					//check if the file is too big as specified by php.ini
			        if ($file_error == 1)
			        {
				        $this->errors[] = "Woah! Way too big";
				        return;
			        }
			        
			        if (file_exists($full_filepath))
			        {
				        $this->errors[] = "File already exists";
				        return;
			        } 
			        else 
			        {
				        if(move_uploaded_file($file_tmp, $full_filepath))
				        {
				        	if($_FILES['image']['error'][$key] == 0)
				        	{
					        	//$this->messages[] = "Image added successfully";
					    	
						    	//add code to add the info to the db
						    	$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
						    	$get_gallery = $this->db_connection->query("
						    		INSERT INTO gallery (user_id, url, title, filename) VALUES (
						    			'".$this->user_id."',
						    			'".$full_filepath."',
						    			'".$name."',
						    			'".$file_name."')");	
				        	}			    	
				        } 
				        else 
				        {
					        $this->errors[] = "File could not be stored. Key = ".$key.
					        	". Path = ".$full_filepath.
					        	". tmp_name = ".$file_tmp.
					        	". error = ".$file_error;
				        }
			        }     					
				}
				
				if ($image_count == "1")
				{
					$this->messages[] = $image_count." image uploaded";	
				}
				else
				{
					$this->messages[] = $image_count." images uploaded";
				}
			}
	    } else {
	        $this->errors[] = "Could not connect";
        }
    }

	public function getGallery()
    {
			// create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $get_gallery = $this->db_connection->query("SELECT image_id, url, title FROM gallery WHERE user_id = " . $_SESSION['user_id'] . "");
            // if this user exists
            if ($get_gallery->num_rows >= 1) {

                // get result row (as an object)           
                //$result = $get_diary->fetch_object();
				
				$images = array();
                
                while($image = $get_gallery->fetch_assoc())
                {
	                $images[] = $image;
                }
                return $images;
                
            } else {
	            return "na";
            }
    }
    
    private function deleteGalleryImage()
    {
	    $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->connect_errno) 
		{
	        $this->user_id = $_SESSION['user_id'];
	        $this->image_id = $_POST['image_id'];
	        
	        $query_select_image = $this->db_connection->query("SELECT url FROM gallery WHERE image_id = '".$this->image_id."'");
	        if ($query_select_image->num_rows >= 1)
	        {
	            $found_image = (array)$query_select_image->fetch_object();

		        //$this->messages[] = $found_image['url'];
		        if (unlink($found_image['url']))
		        {
					$query_delete_image = $this->db_connection->query("
		        		DELETE FROM gallery WHERE user_id ='".$this->user_id."' AND image_id ='".$this->image_id."'
						");
					if ($query_delete_image) {
		        		//delete the image from the server
						$this->messages[] = "Image deleted";
					} else {
	                	$this->errors[] = "Entry could not be deleted.";
					}   
		        } else {
			        $this->errors[] = "couldn't remove the image";
		        }
	        } else {
		        $this->errors[] = "File not found";
	        }
	        
        } else {
	        $this->errors[] = "Could not connect";

		}

    }

}

?>
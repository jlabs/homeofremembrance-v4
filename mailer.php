<?php

	    $req_email = "sp@m.com";
	    
				
		$to = "rinaldi13jess@gmail.com";				
		$subject = "spam spam spam";				
		$headers = "From: " . strip_tags($req_email) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($req_email) . "\r\n";
		//$headers .= "CC: susan@example.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		$message = '<html><body>';
		$message .= '<h1>Hello, Jess-car</h1>';
		$message .= "<p>Love wu! xxxxxxxxxxxxx/p>";
		$message .= '</body></html>';

		mail($to, $subject, $message, $headers);

?>